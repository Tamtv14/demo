<?php
class AdminBinhLuan
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    // Lấy toàn bộ bình luận
    // public function getAllBinhLuan()
    // {
    //     try {
    //         $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten 
    //                 FROM binh_luans 
    //                 JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id';
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute();
    //         return $stmt->fetchAll();
    //     } catch (Exception $e) {
    //         echo 'Lỗi: ' . $e->getMessage();
    //     }
    // }
    public function getAllBinhLuan()
    {
        try {
            $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten, san_phams.ten_san_pham 
                FROM binh_luans 
                JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
                JOIN san_phams ON binh_luans.san_pham_id = san_phams.id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }
    // Thêm mới một bình luận
    // public function insertBinhLuan($noi_dung, $id_nguoi_dung, $trang_thai)
    // {
    //     try {
    //         $sql = 'INSERT INTO binh_luans (noi_dung, id_nguoi_dung, trang_thai)
    //                 VALUES (:noi_dung, :id_nguoi_dung, :trang_thai)';

    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([
    //             ':noi_dung' => $noi_dung,
    //             ':id_nguoi_dung' => $id_nguoi_dung,
    //             ':trang_thai' => $trang_thai
    //         ]);

    //         return true;
    //     } catch (Exception $e) {
    //         echo 'Lỗi: ' . $e->getMessage();
    //     }
    // }

    // Lấy chi tiết một bình luận
    public function getDetailBinhLuan($id)
    {
        try {
            $sql = 'SELECT * FROM binh_luans WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    // Cập nhật một bình luận
    public function updateBinhLuan($id, $noi_dung, $trang_thai)
    {
        try {
            $sql = 'UPDATE binh_luans SET noi_dung = :noi_dung, trang_thai = :trang_thai  WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':noi_dung' => $noi_dung,
                ':trang_thai' => $trang_thai,
                ':id' => $id
            ]);

            return true;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    // Xóa một bình luận
    // public function deleteBinhLuan($id)
    // {
    //     try {
    //         $sql = 'DELETE FROM binh_luans WHERE id = :id';
    //         $stmt = $this->conn->prepare($sql);
    //         $stmt->execute([':id' => $id]);
    //         return true;
    //     } catch (Exception $e) {
    //         echo 'Lỗi: ' . $e->getMessage();
    //     }
    // }
    public function deleteBinhLuan($id)
    {
        try {
            $sql = 'DELETE FROM binh_luans WHERE id = :id';
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT); // Bảo vệ chống SQL Injection
            $stmt->execute();
            return true;
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
            return false;
        }
    }


    public function destroyBinhLuan($id)
    {
        try {
            $sql = 'DELETE FROM binh_luans WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':id' => $id
            ]);

            return true;
        } catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();
        }
    }

    public function updataTrangThaiBinhLuan($id, $trang_thai)
    {
        try {
            $sql = 'UPDATE binh_luans
                        SET
                            trang_thai = :trang_thai
                        WHERE id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([
                ':trang_thai' => $trang_thai,
                ':id' => $id
            ]);
            // lấy id sản phẩm vừa thêm
            return true;
        } catch (Exception $e) {
            echo "Lỗi" . $e->getMessage();
        }
    }
}