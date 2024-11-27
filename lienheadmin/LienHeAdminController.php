<?php
class LienHeAdminController {
    private $model;

    public function __construct() {
        // Khởi tạo model
        $this->model = new LienHeModel();
    }

    // Hiển thị danh sách liên hệ
    public function danhSachLienHe() {
        // Lấy danh sách liên hệ từ model
        $contacts = $this->model->getAllLienHe();
        // Hiển thị view với dữ liệu
        require_once './views/lienhe/LienHe.php';
    }

    // Cập nhật trạng thái liên hệ
    public function updateStatus() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setError('Phương thức không hợp lệ.');
            return;
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        $trang_thai = filter_input(INPUT_POST, 'trang_thai', FILTER_VALIDATE_INT);

        if (!$id || !$trang_thai) {
            $this->setError('Dữ liệu không hợp lệ.');
            return;
        }

        if ($this->model->updateTrangThai($id, $trang_thai)) {
            $_SESSION['success'] = 'Cập nhật trạng thái thành công!';
        } else {
            $this->setError('Cập nhật trạng thái thất bại.');
        }
        header('Location: ' . BASE_URL_ADMIN . '?act=admin-lien-he');
    }

    // Xóa liên hệ
    public function delete() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->setError('Phương thức không hợp lệ.');
            return;
        }

        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
        
        if (!$id) {
            $this->setError('ID không hợp lệ.');
            return;
        }

        if ($this->model->deleteLienHe($id)) {
            $_SESSION['success'] = 'Xóa liên hệ thành công!';
        } else {
            $this->setError('Xóa liên hệ thất bại.');
        }
        header('Location: ' . BASE_URL_ADMIN . '?act=admin-lien-he');
    }

    // Thiết lập thông báo lỗi
    private function setError($message) {
        $_SESSION['error'] = $message;
    }
}
