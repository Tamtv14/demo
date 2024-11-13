<?php
class AdminTrangThaiDonHangController {
    private $model;

    public function __construct() {
        $this->model = new AdminTrangThaiDonHang();
    }

    // Hiển thị danh sách trạng thái đơn hàng
    public function danhSachTrangThai() {
        $listTrangThai = $this->model->getAllTrangThai();
        include './views/trangthaidonhang/danh-sach.php';
    }

    // Hiển thị form thêm trạng thái mới
    // public function formThemTrangThai() {
    //     include './views/trangthaidonhang/form-them.php';
    // }

    // // Thêm trạng thái mới
    // public function postThemTrangThai() {
    //     $tenTrangThai = $_POST['ten_trang_thai'];
    //     $this->model->addTrangThai($tenTrangThai);
    //     header('Location: ?act=trang-thai-don-hang');
    // }
    // Hiển thị form thêm trạng thái mới
    public function formThemTrangThai() {
        include './views/trangthaidonhang/form-them.php';
    }

    // Thêm trạng thái mới
    public function postThemTrangThai() {
        $tenTrangThai = $_POST['ten_trang_thai'];
        // Kiểm tra nếu tên trạng thái không rỗng
        if (!empty($tenTrangThai)) {
            $this->model->addTrangThai($tenTrangThai);
            header('Location: ?act=trang-thai-don-hang');
        } else {
            echo "Tên trạng thái không được để trống!";
        }
    }

    // Hiển thị form sửa trạng thái
    // Hiển thị form cập nhật trạng thái
    public function formSuaTrangThai() {
        $id = $_GET['id'] ?? 0;
        $model = new AdminTrangThaiDonHang();
        $trangThai = $model->getTrangThaiById($id);
        require './views/trangthaidonhang/form-cap-nhat.php';
    }

    // Cập nhật trạng thái
    public function postSuaTrangThai() {
        $id = $_POST['id'] ?? 0;
        $tenTrangThai = $_POST['ten_trang_thai'] ?? '';

        $model = new AdminTrangThaiDonHang();
        $model->updateTrangThai($id, $tenTrangThai);

        header('Location: ?act=trang-thai-don-hang');
    }

    // Xóa trạng thái
    public function xoaTrangThai() {
        $id = $_GET['id'] ?? 0;
        $model = new AdminTrangThaiDonHang();
        $model->deleteTrangThai($id);

        header('Location: ?act=trang-thai-don-hang');
    }
    // Thêm trạng thái mới (phương thức mới)
    public function themTrangThai() {
        $ten_trang_thai = $_POST['ten_trang_thai'] ?? '';

        if (!empty($ten_trang_thai)) {
            // Gọi model để thêm trạng thái
            $this->model->addTrangThai($ten_trang_thai);
            // echo "Thêm trạng thái thành công!";
            header('Location: ?act=trang-thai-don-hang');
        } else {
            echo "Tên trạng thái không được để trống.";
        }
    }
}
