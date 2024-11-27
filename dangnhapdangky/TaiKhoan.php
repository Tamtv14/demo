<?php
class TaiKhoan {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    public function checkLogin($email, $mat_khau) {
        try {
            $sql = 'SELECT * FROM tai_khoan WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($mat_khau, $user['mat_khau'])) {
                $_SESSION['user'] = $user;
                return $user;
            }
            return 'Đăng nhập sai thông tin mật khẩu hoặc tài khoản';
        } catch (Exception $e) {
            error_log('Lỗi đăng nhập: ' . $e->getMessage());
            return false;
        }
    }

    public function getTaiKhoanFromEmail($email) {
        if (!is_string($email)) {
            return false;
        }

        try {
            $sql = 'SELECT * FROM tai_khoan WHERE email = :email';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':email' => $email]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Lỗi lấy thông tin tài khoản: ' . $e->getMessage());
            return false;
        }
    }

    public function getAllTaiKhoan($vai_tro) {
        try {
            $sql = 'SELECT * FROM tai_khoan WHERE vai_tro = :vai_tro';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':vai_tro' => $vai_tro]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Lỗi lấy danh sách tài khoản: ' . $e->getMessage());
            return [];
        }
    }

    public function insertTaiKhoan($email, $password, $vai_tro) {
        try {
            $sql = 'INSERT INTO tai_khoan (email, mat_khau, vai_tro) VALUES (:email, :password, :vai_tro)';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':email' => $email,
                ':password' => $password,
                ':vai_tro' => $vai_tro
            ]);
        } catch (Exception $e) {
            error_log('Lỗi thêm tài khoản: ' . $e->getMessage());
            return false;
        }
    }

    public function getDetailTaiKhoan($id) {
        try {
            $sql = 'SELECT * FROM tai_khoan WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            error_log('Lỗi lấy chi tiết tài khoản: ' . $e->getMessage());
            return false;
        }
    }

    public function updateTaiKhoan($id, $ho_ten, $email, $so_dien_thoai, $trang_thai) {
        try {
            $sql = 'UPDATE tai_khoan SET ho_ten = :ho_ten, email = :email, 
                    so_dien_thoai = :so_dien_thoai, trang_thai = :trang_thai 
                    WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai,
                ':trang_thai' => $trang_thai
            ]);
        } catch (Exception $e) {
            error_log('Lỗi cập nhật tài khoản: ' . $e->getMessage());
            return false;
        }
    }

    public function updateKhachHang($id, $ho_ten, $email, $so_dien_thoai, $ngay_sinh, $gioi_tinh, $dia_chi, $trang_thai) {
        try {
            $sql = 'UPDATE tai_khoan SET ho_ten = :ho_ten, email = :email, 
                    so_dien_thoai = :so_dien_thoai, ngay_sinh = :ngay_sinh,
                    gioi_tinh = :gioi_tinh, dia_chi = :dia_chi, trang_thai = :trang_thai 
                    WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':ho_ten' => $ho_ten,
                ':email' => $email,
                ':so_dien_thoai' => $so_dien_thoai,
                ':ngay_sinh' => $ngay_sinh,
                ':gioi_tinh' => $gioi_tinh,
                ':dia_chi' => $dia_chi,
                ':trang_thai' => $trang_thai
            ]);
        } catch (Exception $e) {
            error_log('Lỗi cập nhật khách hàng: ' . $e->getMessage());
            return false;
        }
    }

    public function resetPassword($id, $password) {
        try {
            $sql = 'UPDATE tai_khoan SET mat_khau = :password WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':password' => $password
            ]);
        } catch (Exception $e) {
            error_log('Lỗi đặt lại mật khẩu: ' . $e->getMessage());
            return false;
        }
    }
}