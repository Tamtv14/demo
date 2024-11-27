<?php
class LienHeModel {
    private $conn;

    public function __construct() {
        $this->conn = connectDB();
    }

    // Thêm liên hệ mới
    public function addLienHe($email, $noi_dung, $ngay_tao, $trang_thai) {
        try {
            $sql = "INSERT INTO lien_hes (email, noi_dung, ngay_tao, trang_thai) 
                    VALUES (:email, :noi_dung, :ngay_tao, :trang_thai)";
            
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':email' => $email,
                ':noi_dung' => $noi_dung,
                ':ngay_tao' => $ngay_tao,
                ':trang_thai' => $trang_thai
            ]);
        } catch (PDOException $e) {
            error_log("Lỗi Database: " . $e->getMessage());
            return false;
        }
    }

    // Lấy danh sách tất cả liên hệ
    public function getAllLienHe() {
        try {
            $sql = "SELECT * FROM lien_hes ORDER BY ngay_tao DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Lỗi Database: " . $e->getMessage());
            return [];
        }
    }

    // Cập nhật trạng thái liên hệ
    public function updateTrangThai($id, $trang_thai) {
        try {
            $sql = "UPDATE lien_hes SET trang_thai = :trang_thai WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([
                ':id' => $id,
                ':trang_thai' => $trang_thai
            ]);
        } catch (PDOException $e) {
            error_log("Lỗi Database: " . $e->getMessage());
            return false;
        }
    }

    // Xóa liên hệ
    public function deleteLienHe($id) {
        try {
            $sql = "DELETE FROM lien_hes WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Lỗi Database: " . $e->getMessage());
            return false;
        }
    }
}
