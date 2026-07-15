<?php

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../../config/Database.php';

class AuthController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->connect();

        $this->userModel = new User($this->db);
    }

    // ==========================
    // REGISTER
    // ==========================
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $username = trim($_POST['username']);
            $email    = trim($_POST['email']);
            $plainPassword = $_POST['password'];
            $nomorHp = trim($_POST['nomor_hp'] ?? '');
            $alamat = trim($_POST['alamat'] ?? '');

            if ($username == "" || $email == "" || $plainPassword == "" || $nomorHp == "" || $alamat == "") {
                $error = "Semua field wajib diisi.";
                require_once __DIR__ . '/../views/register.php';
                return;
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Format email tidak valid.";
                require_once __DIR__ . '/../views/register.php';
                return;
            }

            if (strlen($plainPassword) < 6) {
                $error = "Password minimal 6 karakter.";
                require_once __DIR__ . '/../views/register.php';
                return;
            }

            if ($this->userModel->emailExists($email)) {
                $error = "Email sudah terdaftar.";
                require_once __DIR__ . '/../views/register.php';
                return;
            }

            $password = password_hash($plainPassword, PASSWORD_DEFAULT);

            // Simpan ke database
            $this->userModel->register($username, $email, $password, $nomorHp, $alamat);

            // Setelah register pindah ke login
            header("Location: index.php?page=login");
            exit();
        }

        require_once __DIR__ . '/../views/register.php';
    }

    // ==========================
    // LOGIN
    // ==========================
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email    = trim($_POST['email']);
            $password = trim($_POST['password']);

            $user = $this->userModel->login($email);

            if ($user) {

                if (password_verify($password, $user['password'])) {

                    $_SESSION['id_user'] = $user['id_user'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];

                    if ($user['role'] == 'admin') {

                        header("Location: index.php?page=dashboard_admin");

                    } else {

                        header("Location: index.php?page=home");

                    }

                    exit();

                } else {

                    $error = "Password salah!";

                }

            } else {

                $error = "Email tidak ditemukan!";

            }

        }

        require_once __DIR__ . '/../views/login.php';
    }

    // ==========================
    // LOGOUT
    // ==========================
    public function logout()
    {
        session_destroy();

        header("Location: index.php?page=login");

        exit();
    }
}
