<?php
class TaiKhoan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }


    public function checkLogin($email, $mat_khau)
    {
        try {
            $sql = 'SELECT * FROM tai_khoan WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['email' => $email]);
            $user = $stmt->fetch();

            if ($user && password_verify($mat_khau, $user['mat_khau'])) {
                if ($user['vai_tro'] == 1) { // Nếu vai trò là admin
                    // Lưu thông tin admin vào session
                    return $user; // Trả về thông tin admin
                } elseif ($user['vai_tro'] == 2) { // Nếu vai trò là khách hàng (client)
                    // Lưu thông tin người dùng vào session
                    return $user; // Trả về thông tin khách hàng
                }
            } else {
                return 'Đăng nhập sai thông tin mật khẩu hoặc tài khoản';
            }
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }



    public function getTaiKhoanFromEmail($email)
    {
        try {
            $sql = 'SELECT * FROM tai_khoan WHERE email = :email';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':email' => $email
            ]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    //// đăng ký 
    // Hàm thêm tài khoản vào database

    public function getAllTaiKhoan($vai_tro)
    {
        try {
            $sql = 'SELECT * FROM tai_khoan WHERE vai_tro = :vai_tro';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':vai_tro' => $vai_tro]);
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    public function insertTaiKhoan($ho_ten, $email, $password, $vai_tro)
    {
        try {
            $sql = 'INSERT INTO tai_khoan (ho_ten, email, mat_khau, vai_tro)
                VALUES (:ho_ten, :email, :password, :vai_tro)';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':password' => $password,
                ':vai_tro' => $vai_tro, // Sử dụng cột vai_tro thay vì vai_tro_id
            ]);

            return true;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }
    public function getDetailTaiKhoan($id)
    {
        try {
            $sql = 'SELECT * FROM tai_khoan WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }
}