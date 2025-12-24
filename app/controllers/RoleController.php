<?php
require_once __DIR__ . '/../models/Role.php';
require_once __DIR__ . '/../models/Accreditation.php';
require_once __DIR__ . '/AuthController.php';

class RoleController {

    /**
     * Display a listing of the roles.
     */
    public function index() {
        AuthController::checkAuth();
        $roleModel = new Role();
        $roles = $roleModel->getAll();
        require_once __DIR__ . '/../views/roles/index.php';
    }

    /**
     * Show the form for creating a new role.
     */
    public function create() {
        AuthController::checkAuth();
        require_once __DIR__ . '/../views/roles/create.php';
    }

    /**
     * Store a newly created role in storage.
     */
    public function store() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['nom_role'])) {
            $roleModel = new Role();
            if ($roleModel->create($_POST)) {
                header('Location: /roles');
                exit;
            } else {
                // Handle error
                echo "Error: Could not create the role.";
            }
        } else {
            // Redirect back if data is invalid
            header('Location: /roles/create');
            exit;
        }
    }

    /**
     * Show the form for editing the specified role.
     * @param int $id The role ID
     */
    public function edit($id) {
        AuthController::checkAuth();
        $roleModel = new Role();
        $role = $roleModel->findById($id);

        if (!$role) {
            http_response_code(404);
            echo "Role not found.";
            return;
        }

        $accreditationModel = new Accreditation();
        $all_permissions = $accreditationModel->getAll();
        $assigned_permissions = $roleModel->getPermissions($id);

        require_once __DIR__ . '/../views/roles/edit.php';
    }

    /**
     * Update the specified role in storage.
     * @param int $id The role ID
     */
    public function update($id) {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $roleModel = new Role();

            // Update role name
            $roleData = ['nom_role' => $_POST['nom_role']];
            $roleModel->update($id, $roleData);

            // Update permissions
            $permission_ids = isset($_POST['permissions']) ? $_POST['permissions'] : [];
            $roleModel->updatePermissions($id, $permission_ids);

            header('Location: /roles');
            exit;
        }
    }

    /**
     * Remove the specified role from storage.
     * @param int $id The role ID
     */
    public function delete($id) {
        AuthController::checkAuth();
        $roleModel = new Role();
        if ($roleModel->delete($id)) {
            header('Location: /roles');
            exit;
        } else {
            // Handle error
            echo "Error: Could not delete the role.";
        }
    }
}
