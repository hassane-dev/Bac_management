<?php
require_once __DIR__ . '/../../config/database.php';

class Role {
    private $conn;
    private $table = 'roles';

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
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getPermissions($role_id) {
        $query = 'SELECT a.nom_permission FROM accreditations a JOIN roles_accreditations ra ON a.id = ra.id_accreditation WHERE ra.id_role = :role_id';
        $stmt = $this.conn->prepare($query);
        $stmt->bindParam(':role_id', $role_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
