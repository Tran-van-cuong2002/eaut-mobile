<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\Admin\CategoryController; 
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Models\Order;
use App\Models\OrderDetail;

// ==========================================
// 1. GIAO DIỆN KHÁCH HÀNG (CLIENT)
// ==========================================

// Trang chủ
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Chi tiết sản phẩm
Route::get('/san-pham/{id}', function ($id) {
    $product = Product::findOrFail($id);
    return view('client.detail', compact('product'));
})->name('product.detail');

// Lọc danh mục sản phẩm
Route::get('/danh-muc/{id}', function (Request $request, $id) {
    $categories = Category::all();
    $current_category = Category::findOrFail($id);
    $query = Product::where('category_id', $id)->where('is_active', true);
    if ($request->filled('min_price')) $query->where('price', '>=', $request->min_price);
    if ($request->filled('max_price')) $query->where('price', '<=', $request->max_price);
    
    // Sorting
    $sort = $request->get('sort', 'new');
    switch ($sort) {
        case 'price_asc': $query->orderBy('price', 'asc'); break;
        case 'price_desc': $query->orderBy('price', 'desc'); break;
        default: $query->latest(); break;
    }
    
    $products = $query->paginate(9)->withQueryString();
    return view('client.index', compact('categories', 'products', 'current_category'));
})->name('category.show');

// --- GIỎ HÀNG ---
Route::get('/cart', function () { return view('client.cart'); })->name('cart');

Route::get('/cart/add/{id}', function ($id) {
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);
    if(isset($cart[$id])) { $cart[$id]['quantity']++; } 
    else {
        $cart[$id] = [
            "name" => $product->name, "quantity" => 1,
            "price" => $product->price, "image" => $product->image ?? 'default.jpg'
        ];
    }
    session()->put('cart', $cart);
    return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!');
})->name('cart.add');

Route::post('/cart/update', function (Request $request) {
    if($request->id && $request->quantity !== null){
        $cart = session()->get('cart');
        if($request->quantity <= 0) unset($cart[$request->id]);
        else $cart[$request->id]["quantity"] = $request->quantity;
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Đã cập nhật số lượng!');
    }
    return redirect()->back();
})->name('cart.update');

Route::get('/cart/remove/{id}', function ($id) {
    $cart = session()->get('cart');
    if(isset($cart[$id])) { unset($cart[$id]); session()->put('cart', $cart); }
    return redirect()->back()->with('success', 'Đã xóa sản phẩm!');
})->name('cart.remove');

// --- TÌM KIẾM ---
Route::get('/search', function (Request $request) {
    $keyword = $request->input('keyword');
    $categories = Category::all();
    $query = Product::where('name', 'LIKE', '%' . $keyword . '%')->where('is_active', true);
    if ($request->filled('min_price')) $query->where('price', '>=', $request->min_price);
    if ($request->filled('max_price')) $query->where('price', '<=', $request->max_price);
    
    // Sorting
    $sort = $request->get('sort', 'new');
    switch ($sort) {
        case 'price_asc': $query->orderBy('price', 'asc'); break;
        case 'price_desc': $query->orderBy('price', 'desc'); break;
        default: $query->latest(); break;
    }
    
    $products = $query->paginate(9)->withQueryString();
    return view('client.index', compact('categories', 'products', 'keyword'));
})->name('search');

Route::get('/search/suggest', function (Request $request) {
    $keyword = $request->input('keyword');
    if (empty($keyword)) return response()->json([]);
    $products = Product::where('name', 'LIKE', '%' . $keyword . '%')->take(5)->get();
    return response()->json($products);
})->name('search.suggest');

// --- THANH TOÁN ---
Route::get('/checkout', function () {
    $cart = session()->get('cart');
    if(!$cart || count($cart) == 0) {
        return redirect()->route('home')->with('error', 'Giỏ hàng của bạn đang trống!');
    }
    return view('client.checkout');
})->name('checkout');

Route::post('/checkout/process', function (Request $request) {
    $cart = session('cart');
    if (!$cart || empty($cart)) {
        return redirect()->route('checkout')->with('error', 'Giỏ hàng trống!');
    }

    // Tính tổng tiền
    $total = 0;
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // 1. Tạo đơn hàng và gán vào biến $order
    $order = Order::create([
        'user_id'        => Auth::check() ? Auth::id() : null, // <--- ĐÃ THÊM: Rất quan trọng để biết đơn của user nào!
        'customer_name'  => $request->fullname,
        'customer_phone' => $request->phone,
        'address'        => $request->address ?? '',
        'note'           => $request->note ?? '',
        'payment_method' => $request->payment_method ?? 'COD', 
        'total_price'    => $total,
        'status'         => 'pending'
    ]);

    // 2. Ép lưu dữ liệu giỏ hàng vào bảng order_details bằng DB::table
    foreach ($cart as $id => $item) {
        DB::table('order_details')->insert([
            'order_id'     => $order->id, 
            'product_id'   => $id,
            'product_name' => $item['name'],
            'price'        => $item['price'],
            'quantity'     => $item['quantity'],
            'created_at'   => now(),
            'updated_at'   => now()
        ]);
    }

    // Xóa giỏ hàng
    session()->forget('cart');
    
    return redirect()->route('home')->with('success', '🎉 Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm nhất.');
})->name('checkout.process');


// --- TRA CỨU ĐƠN HÀNG DÀNH CHO KHÁCH VÃNG LAI ---
Route::get('/tra-cuu-don-hang', [App\Http\Controllers\HomeController::class, 'trackOrder'])->name('track.order');


// ==========================================
// 2. XÁC THỰC & ADMIN & NGƯỜI DÙNG
// ==========================================
Route::get('/login', function () { return view('client.login'); })->name('login');
Route::get('/register', function () { return view('client.register'); })->name('register');

Route::get('/forgot-password', function () {
    return "<h3 style='text-align:center; margin-top:50px;'>Trang quên mật khẩu đang được phát triển.</h3><div style='text-align:center;'><a href='/login'>Quay lại trang Đăng nhập</a></div>";
})->name('forgot-password');

Route::post('/login', function (Request $request) {
    $credentials = $request->only('password');
    $login_info = $request->input('login_info');
    $fieldType = filter_var($login_info, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone'; 
    $credentials[$fieldType] = $login_info;
    if (Auth::attempt($credentials)) {
        return (Auth::user()->role == 1) ? redirect()->route('admin.dashboard') : redirect()->route('home');
    }
    return back()->withErrors(['login_info' => 'Sai thông tin đăng nhập!']);
});

// ĐÃ SỬA: Hỗ trợ cả GET và POST để tránh lỗi MethodNotAllowedHttpException
Route::match(['get', 'post'], '/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout');

// --- ROUTE BẢO MẬT CHO NGƯỜI DÙNG ĐÃ ĐĂNG NHẬP (PROFILE & ĐƠN HÀNG) ---
// Chỗ này bắt buộc phải đăng nhập mới được vào xem
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // ĐÃ THÊM: Route dành riêng để hiển thị danh sách lịch sử đơn hàng của người dùng đang đăng nhập
    Route::get('/my-orders', [App\Http\Controllers\HomeController::class, 'userOrders'])->name('user.orders');
});

// --- ROUTE ADMIN ---
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Route xuất file CSV doanh thu
    Route::get('/dashboard/export', [DashboardController::class, 'export'])->name('dashboard.export');
    
    // Quản lý Danh mục
    Route::resource('categories', CategoryController::class);
    
    // Quản lý Sản phẩm
    Route::resource('products', ProductController::class);
    
    // Quản lý Đơn hàng
    Route::get('orders/export', [OrderController::class, 'export'])->name('orders.export');
    Route::post('orders/{id}/confirm-payment', [OrderController::class, 'confirmPayment'])->name('orders.confirmPayment');
    Route::resource('orders', OrderController::class)->only(['index', 'show', 'update']);
    
    // Quản lý Người dùng
    Route::resource('users', UserController::class)->except(['create', 'store']);
});