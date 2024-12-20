<?php

namespace App;

use PDO;

class Users
{
    public DB $db;
    public function __construct(){
        $this->db = new DB();
    }
    public function login($email, $password){
        $stmt = $this->db->pdo->prepare("SELECT * FROM users WHERE email= :email");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function register($name, $email,$password): mixed
    {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "SELECT * FROM users WHERE email = '$email'";
        $stmt = $this->db->pdo->prepare($query);
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return false;
        }
        $stmt = $this->db->pdo->prepare("INSERT INTO users (full_name, email, password) VALUES (:name, :email, :password)");
        $stmt->execute([
            'email' => $email,
            'password' => $password,
            'name' => $name
        ]);
        return $this->getUserById($this->db->pdo->lastInsertId());
    }
    public function getUserById(int $id)
    {
        $stmt = $this->db->pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute([
            'id' => $id,
        ]);
        return $stmt->fetch();
    }
    public function setTelegramId(int $id,int $telegramId): void
    {
        $query = "UPDATE users SET telegram_id = :telegramId WHERE id = :id";
        $stmt = $this->db->pdo->prepare($query);
        $stmt->execute([
            'id' => $id,
            'telegramId' => $telegramId
        ]);
    }

}