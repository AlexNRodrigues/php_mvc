<?php
namespace Repositories;

use Config\Database;
use Models\User;
use Interfaces\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_CLASS, User::class);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(User::class);
    }

    public function save($user) {
        if ($user->id) {
            // Atualizar usuário existente
            $stmt = $this->db->prepare("UPDATE users SET name = :name, email = :email WHERE id = :id");
            $stmt->execute(['name' => $user->name, 'email' => $user->email, 'id' => $user->id]);
        } else {
            // Criar novo usuário
            $stmt = $this->db->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
            $stmt->execute(['name' => $user->name, 'email' => $user->email]);
            $user->id = $this->db->lastInsertId();
        }
        return $user;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}