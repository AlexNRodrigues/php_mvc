<?php
namespace Repositories;

use Config\Database;
use Models\Professor;
use Interfaces\ProfessorRepositoryInterface;

class ProfessorRepository implements ProfessorRepositoryInterface {
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
    }

    public function authenticate($numero, $senha) {
        $stmt = $this->db->prepare("SELECT * FROM professores WHERE numero = :numero AND senha = :senha");
        
        // $stmt->execute(['numero' => $numero]);
        // $user = $stmt->fetch(PDO::FETCH_ASSOC);
        // if ($user && password_verify($password, $user['password'])) {
        //     return $user;
        // }

        $stmt->execute(['numero' => $numero, 'senha' => $senha]);

        return $stmt->fetchObject(Professor::class);
    }

    public function findAll() {
        $stmt = $this->db->query("SELECT * FROM professores");
        return $stmt->fetchAll(\PDO::FETCH_CLASS, Professor::class);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM professores WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetchObject(Professor::class);
    }

    public function save($user) {
        if ($user->id) {
            // Atualizar usuário existente
            $stmt = $this->db->prepare("UPDATE professores SET name = :name, email = :email WHERE id = :id");
            $stmt->execute(['name' => $user->name, 'email' => $user->email, 'id' => $user->id]);
        } else {
            // Criar novo usuário
            $stmt = $this->db->prepare("INSERT INTO professores (name, email) VALUES (:name, :email)");
            $stmt->execute(['name' => $user->name, 'email' => $user->email]);
            $user->id = $this->db->lastInsertId();
        }
        return $user;
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM professores WHERE id = :id");
        $stmt->execute(['id' => $id]);
    }
}