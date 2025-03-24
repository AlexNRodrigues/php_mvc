<?php
namespace Interfaces;

interface ProfessorRepositoryInterface {
    public function authenticate($numero, $senha);
    public function findAll();
    public function findById($id);
    public function save($user);
    public function delete($id);
}