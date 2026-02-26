# Hướng dẫn Triển khai & Cấu hình SignServer

Đây là hệ thống Client ký số dành cho Back Office của hệ thống RSSP do [Mobile-ID](https://mobile-id.vn/) cung cấp. Ứng dụng là sự kết hợp giữa hệ thống Backend bằng Laravel và bộ xử lý chữ ký số RSSP SDK.

---

## 1. Cấu hình RSSP SDK

Hệ thống yêu cầu file thực thi (`rssp_sdk.exe`) để xử lý giao tiếp và thực hiện quá trình ký số.

### Các bước thiết lập SDK:
1. Truy cập vào source code C# của dự án.
2. Tiến hành build project nằm trong thư mục `Release_Restful`.
3. Lấy file thực thi `rssp_sdk.exe` sau khi build thành công.
4. Đặt file này vào thư mục sau bên trong project Laravel:
   `app/private/rssp_sdk/`

### Cấu hình biến môi trường (.env)
Thêm các tham số sau vào file `.env` của hệ thống để chỉ định đường dẫn SDK:

```env
RSSP_SDK_DIRECTORY="app/private/rssp_sdk"
RSSP_SDK_NAME="rssp_sdk.exe"
```

---

## 2. Các lệnh Triển khai (Deployment)

Chạy tuần tự các lệnh sau trong terminal để cài đặt và khởi tạo cơ sở dữ liệu cho hệ thống:

### Bước 1: Cài đặt các thư viện phụ thuộc
```bash
composer install
```

### Bước 2: Chạy Database Migrations
*(Lệnh này sẽ tạo toàn bộ cấu trúc bảng cần thiết, bao gồm cả các bảng phân quyền roles và permissions)*
```bash
php artisan migrate
```

### Bước 3: Khởi tạo dữ liệu mẫu (Seeding)
*(Lệnh này sẽ tạo các role 'admin' và 'user', định nghĩa các quyền tương ứng, và gán quyền 'admin' cho tài khoản có ID là 1)*
```bash
php artisan db:seed
```

### Bước 4: Xóa bộ nhớ đệm (Clear Caches)
```bash
php artisan optimize:clear
```

---

## 3. Hướng dẫn sử dụng sau cài đặt

Sau khi hệ thống được deploy thành công, hãy thực hiện theo các bước sau để thiết lập luồng ký số:

1. **Đăng nhập quản trị:** Truy cập trang đăng nhập và sử dụng thông tin tài khoản mặc định:
   * **Tài khoản:** `admin`
   * **Mật khẩu:** `password`

2. **Cấu hình Owners:** Trong giao diện Admin, tiến hành cập nhật thông tin `owners` của hệ thống. (Lưu ý: Thông tin này được cung cấp riêng khi bạn cài đặt và đăng ký hệ thống RSSP của Mobile-ID).

3. **Tạo User & Cấu hình Chứng thư số:** * Tiến hành thêm mới các tài khoản User trên hệ thống.
   * Cập nhật thông tin `credential` (thông tin chứng thư số/xác thực) cho từng user, đảm bảo khớp với dữ liệu đã đăng ký trên hệ thống RSSP.

4. **Kiểm tra tính năng ký số:** Đăng xuất khỏi tài khoản admin, tiến hành đăng nhập lại bằng tài khoản User vừa tạo ở bước 3 và thực hiện thao tác upload file để thử nghiệm luồng ký số thực tế.
