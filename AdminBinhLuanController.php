<?php
class AdminBinhLuanController
{
    public $conn;

    public function __construct()
    {
        $this->conn = new AdminBinhLuan();
    }

    public function danhSachBinhLuan()
    {
        // Lấy toàn bộ danh sách bình luận
        $listBinhLuan = $this->conn->getAllBinhLuan();

        require_once './views/binhluan/danh_sach.php';
    }

    public function formEditBinhLuan()
    {
        $id = $_GET['id_binh_luan'];
        $binhLuan = $this->conn->getDetailBinhLuan($id);
        if ($binhLuan) {
            require_once './views/binhluan/editBinhLuan.php';
        } else {
            header('location: ' . BASE_URL_ADMIN . '?act=binh-luan');
            exit();
        }
    }
    //     public function getBinhLuanList()
// {

    // }


    public function postEditBinhLuan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];
            $noi_dung = $_POST['noi_dung'];
            $trang_thai = $_POST['trang_thai'];

            $errors = [];
            if (empty($noi_dung)) {
                $errors['noi_dung'] = 'Nội dung không được để trống';
            }

            if (empty($errors)) {
                $this->conn->updateBinhLuan($id, $noi_dung, $trang_thai);
                header('location: ' . BASE_URL_ADMIN . '?act=binh-luan');
                exit();
            } else {
                $binhLuan = [
                    'id' => $id,
                    'noi_dung' => $noi_dung,
                    'trang_thai' => $trang_thai
                ];
                require_once './views/binhluan/editBinhLuan.php';
            }
        }
    }

    public function xoaBinhLuan() {
        $id = $_GET['id_binh_luan'];
        $binhLuan = $this->conn->getDetailBinhLuan($id);

        if ($binhLuan) {
            $this->conn->deleteBinhLuan($id);
        }
        header('location: ' . BASE_URL_ADMIN . '?act=binh-luan');
        exit();
    }
    // public function deleteBinhLuan()
    // {
    //     if (isset($_GET['id_binh_luan']) && is_numeric($_GET['id_binh_luan'])) {
    //         $id = $_GET['id_binh_luan'];
    //         $result = $this->xoaBinhLuan($id);
    //         if ($result) {
    //             // Xóa bình luận thành công
    //             header('location: ' . BASE_URL_ADMIN . '?act=binh-luan');
    //             exit();
    //         } else {
    //             // Xóa bình luận thất bại
    //             echo "Xóa bình luận thất bại!";
    //         }
    //     } else {
    //         // ID bình luận không hợp lệ hoặc không được cung cấp
    //         echo "ID bình luận không hợp lệ hoặc không tồn tại!";
    //     }
    // }
    

    public function updataTrangThaiBinhLuan()
    {
        $id_binh_luan = $_POST['id_binh_luan'];
        $name_view = $_POST['name_view'];
        $binhLuan = $this->conn->getDetailBinhLuan($id_binh_luan);

        if ($binhLuan) {
            $trang_thai_update = '';
            if ($binhLuan['trang_thai'] == 1) {
                $trang_thai_update = 2;
            } else {
                $trang_thai_update = 1;
            }
            $status = $this->conn->updataTrangThaiBinhLuan($id_binh_luan, $trang_thai_update);
            if ($status) {
                if ($name_view == 'detail_khach') {
                    header('location: ' . BASE_URL_ADMIN . '?act=chi-tiet-khach-hang&id_khach_hang=' . $binhLuan['tai_khoan_id']);
                    exit();
                } else {
                    header('location: ' . BASE_URL_ADMIN . '?act=binh-luan&id_san_pham=' . $binhLuan['san_pham_id']);
                    exit();
                }
            }
        }
    }
}