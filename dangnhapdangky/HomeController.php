<?php

class HomeController
{
    public $modelSanPham;

    public $modelTaiKhoan;
    public $modelGioHang;
    public $modelDangKy;
    public function __construct()
    {
        $this->modelSanPham = new SanPham();
        $this->modelTaiKhoan = new TaiKhoan();
        $this->modelGioHang = new GioHang();
    }

    public function home()
    {
        // echo 'Đây là home';
        $listSanPham = $this->modelSanPham->getAllSanPham();
        require_once './views/home.php';
    }


    public function chiTietSanPham()
    {
        $id = $_GET['id_san_pham'];
        $sanPham = $this->modelSanPham->getDetailSanPham($id);
        // var_dump($sanPham); die();
        $listAnhSanPham = $this->modelSanPham->getListAnhSanPham($id);
        // var_dump($listAnhSanPham); die();
        $listBinhLuan = $this->modelSanPham->getBinhLuanFromSanPham($id);

        $listSanPhamCungDanhMuc = $this->modelSanPham->getListSanPhamDanhMuc($sanPham['danh_muc_id']);
        // var_dump($listSanPhamCungDanhMuc); die;
        if ($sanPham) {
            require_once './views/detailSanPham.php';
        } else {
            header('location: ' . BASE_URL);
            exit();
        }
    }


    // login
    public function formLogin()
    {
        require_once './views/auth/formLogin.php';
        // require_once './base-xuong-thu-cung/views/auth/formLogin.php';

        deleteSessionError();
        exit();
    }



    public function postLogin()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            // Kiểm tra thông tin đăng nhập
            $user = $this->modelTaiKhoan->checkLogin($email, $password);

            if (is_array($user)) {
                // Lưu thông tin người dùng vào session
                $_SESSION['user_client'] = $user;  // Lưu toàn bộ thông tin người dùng vào session

                // Kiểm tra vai trò người dùng để chuyển hướng
                if ($user['vai_tro'] == 1) {
                    // Nếu là admin, chuyển đến trang quản trị
                    $_SESSION['user_admin'] = $user;  // Lưu thông tin admin
                    header('Location:' . BASE_URL_ADMIN);  // Chuyển đến trang quản trị
                    exit();
                } else {
                    // Nếu là khách hàng, chuyển đến trang chủ
                    header('Location:' . BASE_URL);  // Chuyển đến trang chủ
                    exit();
                }
            } else {
                // Lỗi đăng nhập
                $_SESSION['error'] = $user;
                $_SESSION['flash'] = true;
                header('Location:' . BASE_URL . '?act=login');
                exit();
            }
        }
    }






    public function Logout()
    {
        // Kiểm tra nếu người dùng là admin hoặc client
        if (isset($_SESSION['user_client'])) {
            // Đăng xuất người dùng client
            session_destroy();

            // Hiển thị thông báo và chuyển hướng về trang client
            echo "<script>
                    alert('Đăng xuất thành công');
                    window.location.href = '" . BASE_URL . "';
                  </script>";
            exit();
        } elseif (isset($_SESSION['user_admin'])) {
            // Đăng xuất người dùng admin
            session_destroy();

            // Hiển thị thông báo và chuyển hướng về trang admin
            echo "<script>
                    alert('Đăng xuất thành công');
                    window.location.href = '" . BASE_URL_ADMIN . "';
                  </script>";
            exit();
        } else {
            // Nếu không có session, chuyển hướng về trang chủ hoặc login
            header('Location: ' . BASE_URL);
            exit();
        }
    }



    public function addGioHang() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            return;
        }

        if (!isset($_SESSION['user_client'])) {
            header("Location:" . BASE_URL . '?act=login');
            exit();
        }

        $user = $_SESSION['user_client'];
        if (!isset($user['id'])) {
            $_SESSION['error'] = 'Không tìm thấy thông tin người dùng';
            header("Location:" . BASE_URL);
            exit();
        }

        $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
        if (!$gioHang) {
            $gioHangId = $this->modelGioHang->addGioHang($user['id']);
            if (!$gioHangId) {
                $_SESSION['error'] = 'Không thể tạo giỏ hàng';
                header("Location:" . BASE_URL);
                exit();
            }
            $gioHang = ['id' => $gioHangId];
        }

        $san_pham_id = filter_input(INPUT_POST, 'san_pham_id', FILTER_VALIDATE_INT);
        $so_luong = filter_input(INPUT_POST, 'so_luong', FILTER_VALIDATE_INT);

        if (!$san_pham_id || !$so_luong) {
            $_SESSION['error'] = 'Thông tin sản phẩm không hợp lệ';
            header("Location:" . BASE_URL);
            exit();
        }

        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        $updated = false;

        if ($chiTietGioHang) {
            foreach ($chiTietGioHang as $detail) {
                if ($detail['san_pham_id'] == $san_pham_id) {
                    $newSoLuong = $detail['so_luong'] + $so_luong;
                    $updated = $this->modelGioHang->updateSoLuong($gioHang['id'], $san_pham_id, $newSoLuong);
                    break;
                }
            }
        }

        if (!$updated) {
            $result = $this->modelGioHang->addDetailGioHang($gioHang['id'], $san_pham_id, $so_luong);
            if (!$result) {
                $_SESSION['error'] = 'Không thể thêm sản phẩm vào giỏ hàng';
                header("Location:" . BASE_URL);
                exit();
            }
        }

        header("Location:" . BASE_URL . '?act=gio-hang');
        exit();
    }
    
    public function gioHang() {
        if (!isset($_SESSION['user_client'])) {
            header("Location:" . BASE_URL . '?act=login');
            exit();
        }

        $user = $_SESSION['user_client'];
        if (!isset($user['id'])) {
            $_SESSION['error'] = 'Không tìm thấy thông tin người dùng';
            header("Location:" . BASE_URL);
            exit();
        }

        $gioHang = $this->modelGioHang->getGioHangFromUser($user['id']);
        if (!$gioHang) {
            $gioHangId = $this->modelGioHang->addGioHang($user['id']);
            if (!$gioHangId) {
                $_SESSION['error'] = 'Không thể tạo giỏ hàng';
                header("Location:" . BASE_URL);
                exit();
            }
            $gioHang = ['id' => $gioHangId];
        }

        $chiTietGioHang = $this->modelGioHang->getDetailGioHang($gioHang['id']);
        require_once './views/gioHang.php';
    }
}



