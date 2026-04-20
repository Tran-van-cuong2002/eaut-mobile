<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str; // BẮT BUỘC thêm dòng này để dùng hàm tạo Slug

class CategoryController extends Controller
{
    // 1. Hiển thị danh sách và Xử lý tìm kiếm
    public function index(Request $request) {
        $query = Category::query();

        // Nếu người dùng có nhập từ khóa tìm kiếm
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Tìm theo tên danh mục (có chứa từ khóa)
            $query->where('name', 'like', '%' . $search . '%');
        }

        // Lấy dữ liệu mới nhất, phân trang (10 mục/trang) và GIỮ LẠI từ khóa trên URL khi chuyển trang
        $categories = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.categories.index', compact('categories'));
    }

    // 2. Hiển thị form thêm mới
    public function create() {
        return view('admin.categories.create');
    }

    // 3. Lưu dữ liệu thêm mới
    public function store(Request $request) {
        $request->validate(['name' => 'required|unique:categories|max:255'], [
            'name.required' => 'Vui lòng nhập tên danh mục',
            'name.unique' => 'Tên danh mục này đã tồn tại',
        ]);

        // SỬA TẠI ĐÂY: Lấy toàn bộ dữ liệu và thêm slug trước khi lưu
        $data = $request->all();
        $data['slug'] = Str::slug($request->name); 

        Category::create($data); 
        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục thành công!');
    }

    // 4. Hiển thị form chỉnh sửa
    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // 5. Cập nhật dữ liệu
    public function update(Request $request, $id) {
        $category = Category::findOrFail($id);
        $request->validate(['name' => 'required|max:255|unique:categories,name,'.$id]);

        // SỬA TẠI ĐÂY: Cập nhật lại cả slug nếu người dùng đổi tên danh mục
        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật thành công!');
    }

    // 6. Xóa danh mục
    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Đã xóa danh mục!');
    }
}