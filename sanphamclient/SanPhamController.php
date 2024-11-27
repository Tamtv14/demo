<?php
class SanPhamController {
    private $model;

    public function __construct() {
        $this->model = new SanPham();
    }

    public function danhSachSanPham() {
        // Get filter parameters
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $category = isset($_GET['category']) ? (int)$_GET['category'] : null;
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'newest';
        
        // Items per page
        $limit = 12;
        
        // Get products
        $products = $this->model->getAllSanPham($page, $limit, $category, $sort);
        
        // Get categories for filter
        $categories = $this->model->getAllDanhMuc();
        
        // Calculate pagination
        $totalProducts = $this->model->getTotalSanPham($category);
        $totalPages = ceil($totalProducts / $limit);
        $currentPage = $page;
        
        // Load view
        require_once './views/sanpham/SanPham.php';
    }
    public function searchSanPham()
{
    // Lấy từ khóa và danh mục từ tham số GET
    $keyword = isset($_GET['keyword']) ? trim($_GET['keyword'], " ,") : '';
        $category = isset($_GET['category']) ? (int)$_GET['category'] : null;

    // Nếu cả từ khóa và danh mục đều rỗng, chuyển về trang chủ
    if (empty($keyword) && empty($category)) {
        header('Location: ' . BASE_URL);
        exit;
    }

    // Gọi model để tìm kiếm sản phẩm theo từ khóa và danh mục
    $products = $this->model->searchProducts($keyword, $category);

    // Truyền dữ liệu vào view để hiển thị
    require_once './views/sanpham/SearchResults.php';
}

    
    
}