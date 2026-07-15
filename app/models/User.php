<?php

class User
{
    private $conn;
    private $table = "users";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    // LOGIN
    public function login($email)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE email = :email";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":email", $email);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // REGISTER
    public function register($username, $email, $password, $nomorHp = "", $alamat = "")
    {
        $sql = "INSERT INTO users (username, email, password, nomor_hp, alamat, role)
                VALUES (:username, :email, :password, :nomor_hp, :alamat, 'user')";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":password", $password);
        $stmt->bindParam(":nomor_hp", $nomorHp);
        $stmt->bindParam(":alamat", $alamat);

        return $stmt->execute();
    }

    public function emailExists($email)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function getAll()
    {
        $stmt = $this->conn->query("SELECT id_user, username, email, nomor_hp, alamat, foto_profil, role, created_at FROM users ORDER BY id_user DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id_user=?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($data)
    {
        $fields = ['username=?', 'email=?', 'nomor_hp=?', 'alamat=?', 'foto_profil=?'];
        $params = [
            $data['username'],
            $data['email'],
            $data['nomor_hp'],
            $data['alamat'],
            $data['foto_profil']
        ];

        if (!empty($data['password'])) {
            $fields[] = 'password=?';
            $params[] = $data['password'];
        }

        $params[] = $data['id_user'];
        $stmt = $this->conn->prepare("UPDATE users SET " . implode(', ', $fields) . " WHERE id_user=?");
        return $stmt->execute($params);
    }

    public function emailExistsExcept($email, $id)
    {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM users WHERE email=? AND id_user!=?");
        $stmt->execute([$email, $id]);
        return (int) $stmt->fetchColumn() > 0;
    }

    public function updateRole($id, $role)
    {
        $stmt = $this->conn->prepare("UPDATE users SET role=? WHERE id_user=?");
        return $stmt->execute([$role, $id]);
    }

    public function delete($id)
    {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id_user=? AND role!='admin'");
        return $stmt->execute([$id]);
    }
}
