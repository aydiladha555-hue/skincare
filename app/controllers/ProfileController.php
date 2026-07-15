<?php

require_once __DIR__ . "/../../config/Database.php";
require_once __DIR__ . "/../models/User.php";

class ProfileController
{
    private $userModel;

    public function __construct()
    {
        $database = new Database();
        $this->userModel = new User($database->connect());
    }

    private function requireLogin()
    {
        if (!isset($_SESSION['id_user'])) {
            header("Location:index.php?page=login");
            exit;
        }
    }

    private function uploadProfilePhoto($oldPhoto = "")
    {
        if (empty($_FILES['foto_profil']['name'])) {
            return $oldPhoto;
        }

        if ($_FILES['foto_profil']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Upload foto profil gagal.");
        }

        if ($_FILES['foto_profil']['size'] > 2 * 1024 * 1024) {
            throw new Exception("Ukuran foto profil maksimal 2MB.");
        }

        $imageInfo = getimagesize($_FILES['foto_profil']['tmp_name']);
        if ($imageInfo === false) {
            throw new Exception("Foto profil harus berupa gambar.");
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'];
        if (!in_array($imageInfo['mime'], $allowedTypes)) {
            throw new Exception("Foto profil hanya boleh JPG, PNG, atau WEBP.");
        }

        $folder = "uploads/profiles/";
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $extension = image_type_to_extension($imageInfo[2], false);
        $fileName = "profil_" . time() . "_" . bin2hex(random_bytes(4)) . "." . $extension;

        if (!move_uploaded_file($_FILES['foto_profil']['tmp_name'], $folder . $fileName)) {
            throw new Exception("Foto profil tidak bisa disimpan.");
        }

        if ($oldPhoto && is_file($folder . $oldPhoto)) {
            unlink($folder . $oldPhoto);
        }

        return $fileName;
    }

    public function index()
    {
        $this->requireLogin();
        $user = $this->userModel->getById($_SESSION['id_user']);
        require "app/views/profile/index.php";
    }

    public function update()
    {
        $this->requireLogin();

        $user = $this->userModel->getById($_SESSION['id_user']);
        if (!$user) {
            header("Location:index.php?page=logout");
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header("Location:index.php?page=profile");
            exit;
        }

        try {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $nomorHp = trim($_POST['nomor_hp'] ?? '');
            $alamat = trim($_POST['alamat'] ?? '');
            $passwordBaru = trim($_POST['password'] ?? '');

            if ($username === '' || $email === '' || $nomorHp === '' || $alamat === '') {
                throw new Exception("Nama, email, nomor HP, dan alamat wajib diisi.");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new Exception("Format email tidak valid.");
            }

            if ($this->userModel->emailExistsExcept($email, $_SESSION['id_user'])) {
                throw new Exception("Email sudah digunakan akun lain.");
            }

            if ($passwordBaru !== '' && strlen($passwordBaru) < 6) {
                throw new Exception("Password baru minimal 6 karakter.");
            }

            $fotoProfil = $this->uploadProfilePhoto($user['foto_profil'] ?? '');

            $this->userModel->updateProfile([
                'id_user' => $_SESSION['id_user'],
                'username' => $username,
                'email' => $email,
                'nomor_hp' => $nomorHp,
                'alamat' => $alamat,
                'foto_profil' => $fotoProfil,
                'password' => $passwordBaru !== '' ? password_hash($passwordBaru, PASSWORD_DEFAULT) : ''
            ]);

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;

            header("Location:index.php?page=profile&success=1");
            exit;
        } catch (Exception $e) {
            $error = $e->getMessage();
            $user = array_merge($user, [
                'username' => $_POST['username'] ?? $user['username'],
                'email' => $_POST['email'] ?? $user['email'],
                'nomor_hp' => $_POST['nomor_hp'] ?? $user['nomor_hp'],
                'alamat' => $_POST['alamat'] ?? $user['alamat']
            ]);
            require "app/views/profile/index.php";
        }
    }
}
