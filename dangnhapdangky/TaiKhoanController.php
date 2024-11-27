<?php
class TaiKhoanController
{
    public $modelTaiKhoan;

    public function __construct()
    {
        $this->modelTaiKhoan = new TaiKhoan();
    }

    public function danhSach()
    {
        $listQuanTri = $this->modelTaiKhoan->getAllTaiKhoan(1);
        // Hiển thị danh sách quản trị viên hoặc thực hiện logic khác
        // require_once './views/taikhoan/quantri/listQuanTri.php';
    }

    public function formAdd()
    {
        require_once './views/auth/formDangKy.php';
        deleteSessionError();

    }

    public function postAdd()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy dữ liệu từ form
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $mat_khau = $_POST['mat_khau'];
    
            // Lưu lỗi
            $errors = [];
    
            // Kiểm tra các trường dữ liệu
            if (empty($ho_ten)) {
                $errors['ho_ten'] = 'Tên không được để trống';
            }
    
            if (empty($email)) {
                $errors['email'] = 'Email không được để trống';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Email không hợp lệ';
            }
    
            if (empty($mat_khau)) {
                $errors['mat_khau'] = 'Mật khẩu không được để trống';
            }
    
            // Nếu không có lỗi, thêm tài khoản mới
            if (empty($errors)) {
                // Mã hóa mật khẩu trước khi lưu vào cơ sở dữ liệu
                $password = password_hash($mat_khau, PASSWORD_BCRYPT);
    
                // Đặt vai trò mặc định là 2 (khách hàng)
                $vai_tro = 2;
    
                // Thêm tài khoản vào cơ sở dữ liệu
                $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $vai_tro);
    
                // Xóa lỗi nếu có và chuyển hướng về trang chính
                unset($_SESSION['errors']);
                header('Location: ' . BASE_URL); // Địa chỉ trang chuyển hướng sau khi đăng ký thành công
                exit();
            } else {
                // Lưu lỗi vào session để hiển thị trong form
                $_SESSION['errors'] = $errors;
    
                // Chuyển hướng về trang đăng ký
                header('Location: ' . BASE_URL . '?act=form-them');
                exit();
            }
        }
    }
    
}