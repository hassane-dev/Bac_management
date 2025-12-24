<?php
require_once __DIR__ . '/../models/Serie.php';
require_once __DIR__ . '/AuthController.php';

class SerieController {

    public function index() {
        AuthController::checkAuth();
        $serieModel = new Serie();
        $series = $serieModel->getAll();
        require_once __DIR__ . '/../views/series/index.php';
    }

    public function create() {
        AuthController::checkAuth();
        require_once __DIR__ . '/../views/series/create.php';
    }

    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serieModel = new Serie();
            if ($serieModel->create($_POST)) {
                header('Location: /series');
                exit;
            } else {
                echo "Error creating serie.";
            }
        }
    }

    public function edit($id) {
        AuthController::checkAuth();
        $serieModel = new Serie();
        $serie = $serieModel->findById($id);
        require_once __DIR__ . '/../views/series/edit.php';
    }

    public function update($id) {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $serieModel = new Serie();
            if ($serieModel->update($id, $_POST)) {
                header('Location: /series');
                exit;
            } else {
                echo "Error updating serie.";
            }
        }
    }

    public function delete($id) {
        AuthController::checkAuth();
        $serieModel = new Serie();
        if ($serieModel->delete($id)) {
            header('Location: /series');
            exit;
        } else {
            echo "Error deleting serie.";
        }
    }
}
