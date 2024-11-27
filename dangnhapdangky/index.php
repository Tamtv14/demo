<?php
session_start();
// Require file Common
require_once './commons/env.php'; // Khai báo biến môi trường
require_once './commons/function.php'; // Hàm hỗ trợ

// Require toàn bộ file Controllers
// require_once './controllers/TaiKhoanController.php';
require_once './controllers/HomeController.php';
require_once './controllers/TaiKhoanController.php';
require_once './controllers/LienHeController.php';
require_once './controllers/TinTucController.php';
require_once './controllers/SanPhamController.php';
require_once './controllers/DonHangController.php';

// Require toàn bộ file Models
require_once './models/SanPham.php';
require_once './models/TaiKhoan.php';
require_once './models/GioHang.php';
require_once './models/LienHe.php';
require_once './models/TinTuc.php';
require_once './models/DonHang.php';


// Route
$act = $_GET['act'] ?? '/';
// var_dump($_GET['act']);die();

// Để bảo bảo tính chất chỉ gọi 1 hàm Controller để xử lý request thì mình sử dụng match

match ($act) {
    // Trang chủ
    '/' => (new HomeController())->home(),
    // Trường hợp đặc biệt
//route trang thai binh luan
// 'update-trang-thai-binh-luan' => (new SanPhamController())->updateTrangThaiBinhLuan(),


    'chi-tiet-san-pham' => (new HomeController())->chiTietSanPham(),
    // Base URL/?act=dnah-sach-san-pham
    'them-gio-hang' => (new HomeController())->addGioHang(),
    'gio-hang' => (new HomeController())->gioHang(),
    // 'xoa-san-pham-gio-hang' 

    // +
    'login' => (new HomeController())->formLogin(),
    'check-login' => (new HomeController())->postLogin(),
    'logout' => (new HomeController())->Logout(),
    'dangky' => (new HomeController())->formAddDangky(),
    'check-dangky' => (new HomeController())->postAddDangKy(),

   

//tin tuc
'danh-sach-tin-tuc' => (new TinTucController())->danhSachTinTuc(),
    'chi-tiet-tin-tuc' => (new TinTucController())->detailTinTuc(),

    'list-tai-khoan' => (new TaiKhoanController())->danhSach(),
    'form-them' => (new TaiKhoanController())->formAdd(),
    'them' => (new TaiKhoanController())->postAdd(),
//
'form-them-lien-he' => (new LienHeController())->formAdd(), // Hiển thị form thêm liên hệ
'them-lien-he' => (new LienHeController())->postAdd(),      // Xử lý thêm liên hệ

//search
'search' => (new SanPhamController())->searchSanPham(),
//
'don-hang' => (new DonHangController())->donHang(),
'chi-tiet-don-hang' => (new DonHangController())->chiTietDonHang(),

};