<nav class="store-nav sticky-top">
    <div class="container user-nav">
        <a class="navbar-brand fw-bold" href="index.php?page=home">GlowCare</a>
        <div class="user-nav-links">
            <a href="index.php?page=home">Produk</a>
            <a href="index.php?page=cart">Keranjang</a>
            <a href="index.php?page=order_history">Riwayat</a>
            <a href="index.php?page=profile">Profil</a>
            <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'admin') { ?>
                <a href="index.php?page=dashboard_admin">Admin</a>
            <?php } ?>
            <?php if (isset($_SESSION['id_user'])) { ?>
                <span class="user-nav-name"><?= htmlspecialchars($_SESSION['username']); ?></span>
                <a class="nav-logout" href="index.php?page=logout">Logout</a>
            <?php } else { ?>
                <a class="nav-logout" href="index.php?page=login">Login</a>
            <?php } ?>
        </div>
    </div>
</nav>
