<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Hiển thị danh sách
    public function index()
    {
        $categories = Category::orderBy('id', 'desc')->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Mở form Thêm mới
    public function create()
    {
        return view('admin.categories.create');
    }

    // Xử lý lưu dữ liệu Thêm mới vào Database
    public function store(Request $request)
    {
        // Bắt lỗi: Bắt buộc phải nhập tên
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Thêm danh mục mới thành công!');
    }

    // Mở form Sửa
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    // Xử lý cập nhật dữ liệu Sửa vào Database
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Vui lòng nhập tên danh mục.',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.categories.index')->with('success', 'Cập nhật danh mục thành công!');
    }

    // Xử lý Xóa
    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Xóa danh mục thành công!');
    }
}