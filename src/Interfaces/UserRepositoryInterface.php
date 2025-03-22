<?php
namespace Interfaces;

interface UserRepositoryInterface {
    public function findAll();
    public function findById($id);
    public function save($user);
    public function delete($id);
}