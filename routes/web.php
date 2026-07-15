<?php

require_once "app/controllers/AuthController.php";
require_once "app/controllers/ProductController.php";
require_once "app/controllers/DashboardController.php";
require_once "app/controllers/CartController.php";
require_once "app/controllers/AdminController.php";
require_once "app/controllers/ReviewController.php";
require_once "app/controllers/ProfileController.php";

$auth = new AuthController();
$product = new ProductController();
$dashboard = new DashboardController();
$cart = new CartController();
$admin = new AdminController();
$review = new ReviewController();
$profile = new ProfileController();

$page = isset($_GET['page'])
    ? $_GET['page']
    : (isset($_SESSION['id_user'])
        ? (($_SESSION['role'] ?? 'user') == 'admin' ? 'dashboard_admin' : 'home')
        : 'login');

switch ($page) {

    // AUTH
    case "login":
        $auth->login();
        break;

    case "register":
        $auth->register();
        break;

    case "logout":
        $auth->logout();
        break;

    // DASHBOARD
    case "dashboard_admin":
        $dashboard->admin();
        break;

    case "dashboard_user":
        $dashboard->user();
        break;

    // ADMIN PRODUK
    case "products":
        $product->index();
        break;

    case "product_create":
        $product->create();
        break;

    case "product_edit":
        $product->edit();
        break;

    case "product_delete":
        $product->delete();
        break;

    // ADMIN KATEGORI
    case "admin_categories":
        $admin->categories();
        break;

    case "admin_category_create":
        $admin->categoryCreate();
        break;

    case "admin_category_edit":
        $admin->categoryEdit();
        break;

    case "admin_category_delete":
        $admin->categoryDelete();
        break;

    // ADMIN PESANAN
    case "admin_orders":
        $admin->orders();
        break;

    case "admin_order_detail":
        $admin->orderDetail();
        break;

    case "admin_order_status":
        $admin->orderStatus();
        break;

    case "admin_payments":
        $admin->payments();
        break;

    case "admin_payment_status":
        $admin->paymentStatus();
        break;

    // ADMIN USER, STOK, LAPORAN
    case "admin_users":
        $admin->users();
        break;

    case "admin_user_role":
        $admin->userRole();
        break;

    case "admin_user_delete":
        $admin->userDelete();
        break;

    case "admin_stock":
        $admin->stock();
        break;

    case "admin_stock_update":
        $admin->stockUpdate();
        break;

    case "admin_reports":
        $admin->reports();
        break;

    // USER PRODUK
    case "home":
        $product->home();
        break;

    case "detail":
        $product->detail();
        break;

    // KERANJANG & CHECKOUT
    case "cart":
        $cart->index();
        break;

    case "cart_add":
        $cart->add();
        break;

    case "cart_update":
        $cart->update();
        break;

    case "cart_remove":
        $cart->remove();
        break;

    case "checkout":
        $cart->checkout();
        break;

    case "checkout_success":
        $cart->success();
        break;

    case "order_history":
        $cart->history();
        break;

    case "order_track":
        $cart->track();
        break;

    case "payment_proof":
        $cart->proof();
        break;

    case "profile":
        $profile->index();
        break;

    case "profile_update":
        $profile->update();
        break;

    case "review_create":
        $review->create();
        break;

    default:
        header("Location:index.php?page=home");
        exit;
        break;
}
