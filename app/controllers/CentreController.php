<?php

require_once __DIR__ . '/../models/Centre.php';

class CentreController
{
    private $centreModel;

    public function __construct(PDO $pdo)
    {
        $this->centreModel = new Centre($pdo);
    }

    /**
     * Affiche la liste de tous les centres.
     */
    public function index()
    {
        $centres = $this->centreModel->getAll();
        require __DIR__ . '/../views/centres/index.php';
    }

    /**
     * Affiche le formulaire de création d'un centre.
     */
    public function create()
    {
        require __DIR__ . '/../views/centres/create.php';
    }

    /**
     * Enregistre un nouveau centre dans la base de données.
     */
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom_centre' => $_POST['nom_centre'],
                'code_centre' => $_POST['code_centre'],
                'ville' => $_POST['ville'],
                'capacite' => $_POST['capacite']
            ];
            $this->centreModel->create($data);
            header('Location: /centres');
            exit;
        }
    }

    /**
     * Affiche le formulaire de modification d'un centre.
     * @param int $id L'ID du centre.
     */
    public function edit(int $id)
    {
        $centre = $this->centreModel->getById($id);
        if (!$centre) {
            // Gérer le cas où le centre n'est pas trouvé (par exemple, afficher une page 404)
            header('HTTP/1.0 404 Not Found');
            echo "Centre non trouvé.";
            exit;
        }
        require __DIR__ . '/../views/centres/edit.php';
    }

    /**
     * Met à jour un centre dans la base de données.
     * @param int $id L'ID du centre.
     */
    public function update(int $id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom_centre' => $_POST['nom_centre'],
                'code_centre' => $_POST['code_centre'],
                'ville' => $_POST['ville'],
                'capacite' => $_POST['capacite']
            ];
            $this->centreModel->update($id, $data);
            header('Location: /centres');
            exit;
        }
    }

    /**
     * Supprime un centre de la base de données.
     * @param int $id L'ID du centre.
     */
    public function destroy(int $id)
    {
        // La suppression via GET n'est pas idéale pour des raisons de sécurité (CSRF),
        // mais nous suivons la simplicité de l'architecture actuelle.
        // Dans une application réelle, cela devrait être une requête POST/DELETE.
        $this->centreModel->delete($id);
        header('Location: /centres');
        exit;
    }
}
