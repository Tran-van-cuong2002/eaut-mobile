<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. Danh sách sản phẩm (ĐÃ THÊM LOGIC TÌM KIẾM VÀ LỌC)
    public function index(Request $request) {
        // Bắt đầu query, nạp sẵn quan hệ category để tránh lỗi N+1 query
        $query = Product::with('category');

        // Xử lý tìm kiếm theo tên hoặc ID (mã sản phẩm)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('id', $search); // Nếu bạn có cột 'sku', có thể đổi 'id' thành 'sku'
            });
        }

        // Xử lý lọc theo danh mục
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        // Lấy dữ liệu, phân trang và giữ nguyên URL query (search, category_id) khi chuyển trang
        $products = $query->latest()->paginate(10)->withQueryString();
        
        // Lấy toàn bộ danh mục để đổ ra ô Select "Lọc theo danh mục" ngoài View
        $categories = Category::all();

        return view('admin.products.index', compact('products', 'categories'));
    }

    // 2. Form thêm mới
    public function create() {
        $categories = Category::all();
        // Lấy danh sách ảnh đã có, loại bỏ trùng lặp
        $existingImages = Product::whereNotNull('image')->where('image', '!=', '')->distinct()->pluck('image');
        
        return view('admin.products.create', compact('categories', 'existingImages'));
    }

    // 3. Lưu sản phẩm mới
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required',
            'image_upload' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        // Loại bỏ image_selector và image_upload ra khỏi data insert
        $data = $request->except(['image_upload', 'image_selector']); 
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Xử lý logic ảnh với 1 menu lựa chọn
        if ($request->image_selector === 'upload') {
            if ($request->hasFile('image_upload')) {
                $data['image'] = $request->file('image_upload')->store('products', 'public');
            }
        } else {
            // Nếu chọn ảnh có sẵn từ thư viện
            $data['image'] = $request->image_selector;
        }

        Product::create($data);
        return redirect()->route('admin.products.index')->with('success', 'Đã thêm sản phẩm thành công!');
    }

    // 4. Form chỉnh sửa
    public function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        // Lấy danh sách ảnh đã có cho form sửa
        $existingImages = Product::whereNotNull('image')->where('image', '!=', '')->distinct()->pluck('image');
        
        return view('admin.products.edit', compact('product', 'categories', 'existingImages'));
    }

    // 5. Cập nhật sản phẩm
    public function update(Request $request, $id) {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category_id' => 'required',
            'image_upload' => 'nullable|image|mimes:jpg,png,jpeg,webp|max:2048'
        ]);

        $data = $request->except(['image_upload', 'image_selector']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        // Xử lý cập nhật ảnh với 1 menu lựa chọn
        if ($request->image_selector === 'upload') {
            if ($request->hasFile('image_upload')) {
                // Chỉ xóa ảnh cũ khỏi server nếu không có sản phẩm nào khác đang dùng nó
                $isUsedElsewhere = Product::where('id', '!=', $product->id)->where('image', $product->image)->exists();
                if ($product->image && !$isUsedElsewhere) {
                    Storage::disk('public')->delete($product->image);
                }
                $data['image'] = $request->file('image_upload')->store('products', 'public');
            }
        } else {
            // Nếu đổi sang ảnh cũ khác, xem ảnh hiện tại có ai dùng không để dọn rác
            $isUsedElsewhere = Product::where('id', '!=', $product->id)->where('image', $product->image)->exists();
            if ($product->image && $product->image != $request->image_selector && !$isUsedElsewhere) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->image_selector;
        }

        $product->update($data);
        return redirect()->route('admin.products.index')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    // 6. Xóa sản phẩm
    public function destroy($id) {
        $product = Product::findOrFail($id);
        
        // KIỂM TRA: Chỉ xóa file vật lý nếu không có sản phẩm nào khác dùng chung ảnh này
        $isUsedElsewhere = Product::where('id', '!=', $product->id)->where('image', $product->image)->exists();
        if ($product->image && !$isUsedElsewhere) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Đã xóa sản phẩm!');
    }
}