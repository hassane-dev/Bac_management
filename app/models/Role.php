<?php
require_once __DIR__ . '/../../config/database.php';

class Role {
    private $conn;
    private $table = 'roles';
    private $pivot_table = 'roles_accreditations';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY nom_role ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function findById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = 'INSERT INTO ' . $this->table . ' (nom_role) VALUES (:nom_role)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nom_role', $data['nom_role']);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET nom_role = :nom_role WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom_role', $data['nom_role']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        // Note: ON DELETE CASCADE will handle the pivot table
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    /**
     * Get all permission IDs associated with a role
     * @param int $role_id
     * @return array An array of integer IDs
     */
    public function getPermissions($role_id) {
        $query = 'SELECT id_accreditation FROM ' . $this->pivot_table . ' WHERE id_role = :role_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();

        // Fetch as a flat array and cast all values to integers for consistency
        $ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        return array_map('intval', $ids);
    }

    /**
     * Update the permissions for a specific role
     * @param int $role_id
     * @param array $permission_ids
     * @return bool
     */
    public function updatePermissions($role_id, $permission_ids = []) {
        // Start a transaction to ensure atomicity
        $this->conn->beginTransaction();

        try {
            // 1. Delete all existing permissions for this role
            $delete_query = 'DELETE FROM ' . $this->pivot_table . ' WHERE id_role = :role_id';
            $stmt_delete = $this->conn->prepare($delete_query);
            $stmt_delete->bindParam(':role_id', $role_id);
            $stmt_delete->execute();

            // 2. Insert the new permissions
            if (!empty($permission_ids)) {
                $insert_query = 'INSERT INTO ' . $this->pivot_table . ' (id_role, id_accreditation) VALUES (:role_id, :id_accreditation)';
                $stmt_insert = $this->conn->prepare($insert_query);
                $stmt_insert->bindParam(':role_id', $role_id);

                foreach ($permission_ids as $permission_id) {
                    // Use bindValue inside a loop, not bindParam
                    $stmt_insert->bindValue(':id_accreditation', $permission_id);
                    $stmt_insert->execute();
                }
            }

            // If everything is fine, commit the transaction
            $this->conn->commit();
            return true;

        } catch (Exception $e) {
            // If something goes wrong, roll back the transaction
            $this->conn->rollBack();
            // Optionally log the error: error_log($e->getMessage());
            return false;
        }
    }
}
