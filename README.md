# 📱 EAUT-MOBILE - Hệ Thống Bán Linh Kiện Điện Thoại

Đây là bài tập lớn học phần **Chuyên đề tốt nghiệp 1 (Laravel Framework)** do nhóm sinh viên trường Đại học Công nghệ Đông Á (EAUT) thực hiện. Dự án là một website thương mại điện tử chuyên cung cấp các linh kiện, phụ kiện điện thoại với đầy đủ tính năng cho người dùng và quản trị viên.

## 👥 Thành viên nhóm 
1. Trần Văn Cường (Trưởng nhóm / Fullstack)
2. [Tên thành viên thứ 2] (Điền tên vào đây)

---

## ✨ Chức năng nổi bật

### 🛒 Dành cho Khách hàng & Khách vãng lai:
- Khám phá, tìm kiếm và lọc linh kiện điện thoại theo giá/danh mục.
- Thêm, sửa, xóa sản phẩm trong Giỏ hàng (sử dụng Session).
- Đặt hàng nhanh không cần tạo tài khoản (Dành cho khách vãng lai).
- **Tra cứu trạng thái đơn hàng** qua số điện thoại hoặc mã đơn.
- Đăng nhập, đăng ký, quản lý hồ sơ và lịch sử mua hàng.

### ⚙️ Dành cho Quản trị viên (Admin):
- **Bảng điều khiển (Dashboard):** Thống kê tổng quan đơn hàng, doanh thu, người dùng.
- **Quản lý kho:** Thêm, sửa, xóa danh mục và sản phẩm linh kiện.
- **Quản lý đơn hàng:** Duyệt đơn, cập nhật trạng thái giao hàng.
- **Xuất báo cáo:** Hỗ trợ xuất danh sách đơn hàng và doanh thu ra file CSV.
- **Quản lý tài khoản:** Phân quyền người dùng, khóa/mở tài khoản.

---

## 🚀 Hướng dẫn Cài đặt & Chạy dự án (Localhost)

Dự án yêu cầu máy tính của bạn đã cài đặt sẵn **PHP (>= 8.1)**, **Composer**, và **MySQL** (XAMPP/Laragon).

**Bước 1: Clone mã nguồn về máy**
```bash
git clone [https://github.com/Tran-van-cuong2002/eaut-mobile.git](https://github.com/Tran-van-cuong2002/eaut-mobile.git)
cd eaut-mobile  

Bước 2: Cài đặt các thư viện (Dependencies)

Bash
composer install
Bước 3: Cấu hình biến môi trường (.env)

Copy file .env.example và đổi tên thành .env

Bash
cp .env.example .env
Mở file .env và cấu hình kết nối CSDL MySQL của bạn:

Đoạn mã
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ten_database_cua_ban
DB_USERNAME=root
DB_PASSWORD=
Bước 4: Tạo Key bảo mật cho ứng dụng

Bash
php artisan key:generate
Bước 5: Chạy Migration (Tạo các bảng trong Database)

Bash
php artisan migrate
Bước 6: Khởi chạy Server

Bash
php artisan serve
Truy cập dự án tại trình duyệt qua đường dẫn: http://localhost:8000

🔒 Tài khoản test Admin (Dành cho Giảng viên)
Email: admin@eaut.edu.vn

Mật khẩu: 123456

Dự án được xây dựng bằng Laravel MVC & Bootstrap 5.