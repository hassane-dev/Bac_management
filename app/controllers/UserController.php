<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/AuthController.php';

class UserController {

    public function index() {
        AuthController::checkAuth();
        $userModel = new User();
        $users = $userModel->getAll();
        require_once __DIR__ . '/../views/users/index.php';
    }

    public function create() {
        AuthController::checkAuth();
        $roleModel = new Role();
        $roles = $roleModel->getAll();
        require_once __DIR__ . '/../views/users/create.php';
    }

    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            if ($userModel->create($_POST)) {
                 header('Location: /users');
            } else {
                echo "Error creating user.";
            }
        }
    }

    public function edit($id) {
        AuthController::checkAuth();
        $userModel = new User();
        $user = $userModel->findById($id);
        $roleModel = new Role();
        $roles = $roleModel->getAll();
        require_once __DIR__ . '/../views/users/edit.php';
    }

    public function update($id) {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            if ($userModel->update($id, $_POST)) {
                 header('Location: /users');
            } else {
                 echo "Error updating user.";
            }
        }
    }

    public function delete($id) {
        AuthController::checkAuth();
        $userModel = new User();
        if ($userModel->delete($id)) {
            header('Location: /users');
        } else {
            echo "Error deleting user.";
        }
    }
}