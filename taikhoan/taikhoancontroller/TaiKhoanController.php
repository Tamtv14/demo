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
            $ho_ten = $_POST['ho_ten'];
            $email = $_POST['email'];
            $mat_khau = $_POST['mat_khau'];
            $vai_tro = $_POST['vai_tro'];

            $errors = [];

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

            // if (empty($vai_tro)) {
            //     $errors['vai_tro'] = 'Vai trò không được để trống';
            // } elseif ($vai_tro <= 1) {
            //     $errors['vai_tro'] = 'Chỉ có thể chọn vai trò < 1';
            // }


            if (empty($errors)) {
                $password = password_hash($mat_khau, PASSWORD_BCRYPT);
                $vai_tro = 2;
                $this->modelTaiKhoan->insertTaiKhoan($ho_ten, $email, $password, $vai_tro);
                header('Location: ' . BASE_URL);
                exit();
            } else {
                $_SESSION['errors'] = $errors;
                header('Location: ' . BASE_URL . '?act=form-them');
                exit();
            }
        }
    }
}