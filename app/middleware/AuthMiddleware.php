<?php

class AuthMiddleware
{
    public static function checkLogin()
    {
        if (!isset($_SESSION['id_user'])) {
            header("Location: index.php?page=login");
            exit();
        }
    }

    public static function admin()
    {
        self::checkLogin();

        if ($_SESSION['role'] != 'admin') {
            header("Location: index.php?page=dashboard_user");
            exit();
        }
    }

    public static function user()
    {
        self::checkLogin();

        if ($_SESSION['role'] != 'user') {
            header("Location: index.php?page=dashboard_admin");
            exit();
        }
    }
}