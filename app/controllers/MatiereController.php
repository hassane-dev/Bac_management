<?php
require_once __DIR__ . '/../models/Matiere.php';
require_once __DIR__ . '/../models/Serie.php';
require_once __DIR__ . '/AuthController.php';

class MatiereController {

    // CRUD for matieres
    public function index() {
        AuthController::checkAuth();
        $matiereModel = new Matiere();
        $matieres = $matiereModel->getAll();
        require_once __DIR__ . '/../views/matieres/index.php';
    }

    public function create() {
        AuthController::checkAuth();
        require_once __DIR__ . '/../views/matieres/create.php';
    }

    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matiereModel = new Matiere();
            if ($matiereModel->create($_POST)) {
                header('Location: /matieres');
                exit;
            } else {
                echo "Error creating matiere.";
            }
        }
    }

    public function edit($id) {
        AuthController::checkAuth();
        $matiereModel = new Matiere();
        $matiere = $matiereModel->findById($id);
        require_once __DIR__ . '/../views/matieres/edit.php';
    }

    public function update($id) {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matiereModel = new Matiere();
            if ($matiereModel->update($id, $_POST)) {
                header('Location: /matieres');
                exit;
            } else {
                echo "Error updating matiere.";
            }
        }
    }

    public function delete($id) {
        AuthController::checkAuth();
        $matiereModel = new Matiere();
        if ($matiereModel->delete($id)) {
            header('Location: /matieres');
            exit;
        } else {
            echo "Error deleting matiere.";
        }
    }

    // Pivot table logic
    public function manage($serie_id) {
        AuthController::checkAuth();
        $serieModel = new Serie();
        $serie = $serieModel->findById($serie_id);

        if (!$serie) {
            http_response_code(404);
            echo "Serie not found";
            return;
        }

        $matiereModel = new Matiere();
        $assigned_matieres = $matiereModel->getBySerie($serie_id);
        $all_matieres = $matiereModel->getAll();

        require_once __DIR__ . '/../views/matieres/manage.php';
    }

    public function assign($serie_id) {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $matiereModel = new Matiere();
            $_POST['id_serie'] = $serie_id;
            if ($matiereModel->assignToSerie($_POST)) {
                header('Location: /matieres/manage/' . $serie_id);
                exit;
            } else {
                echo "Error assigning matiere.";
            }
        }
    }

    public function detach($pivot_id) {
        AuthController::checkAuth();
        // We need to know which serie we were on to redirect back.
        // A more robust app might store this in the session or a hidden form field.
        // For now, we'll redirect to the main series page.
        $matiereModel = new Matiere();
        if ($matiereModel->detachFromSerie($pivot_id)) {
            // A better redirect would be back to the manage page, but we don't have the serie_id here.
            header('Location: /series');
            exit;
        } else {
            echo "Error detaching matiere.";
        }
    }
}
