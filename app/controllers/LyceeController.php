<?php
require_once __DIR__ . '/../models/Lycee.php';
require_once __DIR__ . '/AuthController.php';

class LyceeController {

    public function index() {
        AuthController::checkAuth();
        $lyceeModel = new Lycee();
        $lycees = $lyceeModel->getAll();
        require_once __DIR__ . '/../views/lycees/index.php';
    }

    public function create() {
        AuthController::checkAuth();
        require_once __DIR__ . '/../views/lycees/create.php';
    }

    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lyceeModel = new Lycee();
            if ($lyceeModel->create($_POST)) {
                header('Location: /lycees');
                exit;
            } else {
                echo "Error creating lycee.";
            }
        }
    }

    public function edit($id) {
        AuthController::checkAuth();
        $lyceeModel = new Lycee();
        $lycee = $lyceeModel->findById($id);
        require_once __DIR__ . '/../views/lycees/edit.php';
    }

    public function update($id) {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $lyceeModel = new Lycee();
            if ($lyceeModel->update($id, $_POST)) {
                header('Location: /lycees');
                exit;
            } else {
                echo "Error updating lycee.";
            }
        }
    }

    public function delete($id) {
        AuthController::checkAuth();
        $lyceeModel = new Lycee();
        if ($lyceeModel->delete($id)) {
            header('Location: /lycees');
            exit;
        } else {
            echo "Error deleting lycee.";
        }
    }
}
