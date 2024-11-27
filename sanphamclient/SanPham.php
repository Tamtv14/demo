<?php
class SanPham
{

    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function getAllSanPham()
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();
        }
    }

    public function getDetailSanPham($id)
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc FROM san_phams
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
                WHERE san_phams.id = :id';

            $stmt = $this->conn->prepare($sql);
            $stmt->execute([':id' => $id]);

            return $stmt->fetch();
        } catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();
        }
    }


    public function getListAnhSanPham($id)
    {

        try {
            $sql = 'SELECT * FROM hinh_anhs WHERE san_pham_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();
        }
    }

    public function getBinhLuanFromSanPham($id)
    {
        try {
            $sql = 'SELECT binh_luans.*, tai_khoans.ho_ten, tai_khoans.anh_dai_dien
                    FROM binh_luans
                    INNER JOIN tai_khoans ON binh_luans.tai_khoan_id = tai_khoans.id
                    WHERE binh_luans.san_pham_id = :id';

            $stmt = $this->conn->prepare($sql);

            $stmt->execute([':id' => $id]);

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi: ' . $e->getMessage();
        }
    }

    public function getListSanPhamDanhMuc($danh_muc_id)
    {
        try {
            $sql = 'SELECT san_phams.*, danh_mucs.ten_danh_muc
            FROM san_phams
            INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id
            WHERE san_phams.danh_muc_id = ' . $danh_muc_id;

            $stmt = $this->conn->prepare($sql);

            $stmt->execute();

            return $stmt->fetchAll();
        } catch (Exception $e) {
            echo 'Lỗi' . $e->getMessage();
        }
    }
   
    public function searchProducts($keyword, $category = null)
{
    try {
        // Xây dựng câu SQL cơ bản
        $sql = "SELECT san_phams.*, danh_mucs.ten_danh_muc 
                FROM san_phams 
                INNER JOIN danh_mucs ON san_phams.danh_muc_id = danh_mucs.id 
                WHERE 1=1"; // Sử dụng 1=1 để dễ dàng thêm điều kiện

        // Thêm điều kiện từ khóa nếu có
        if (!empty($keyword)) {
            $sql .= " AND (san_phams.ten_san_pham LIKE :keyword 
                      OR san_phams.mo_ta LIKE :keyword 
                      OR danh_mucs.ten_danh_muc LIKE :keyword)";
        }

        // Thêm điều kiện danh mục nếu có
        if (!empty($category)) {
            $sql .= " AND san_phams.danh_muc_id = :category";
        }

        $stmt = $this->conn->prepare($sql);

        // Gán giá trị cho tham số
        $params = [];
        if (!empty($keyword)) {
            $params[':keyword'] = '%' . $keyword . '%';
        }
        if (!empty($category)) {
            $params[':category'] = $category;
        }
        var_dump("$keyword,$category");
        die();

        $stmt->execute($params);

        return $stmt->fetchAll();
    } catch (Exception $e) {
        echo 'Lỗi: ' . $e->getMessage();
        return [];
    }
    $sql .= " LIMIT 50"; // Thêm giới hạn để tránh quá nhiều kết quả

var_dump($sql, $params); // Xem câu truy vấn và tham số

}

    
      
   
  
}
