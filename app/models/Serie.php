<?php
require_once __DIR__ . '/../../config/database.php';

class Serie {
    private $conn;
    private $table = 'series';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY nom_serie ASC';
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
        $query = 'INSERT INTO ' . $this->table . ' (nom_serie, description) VALUES (:nom_serie, :description)';
        $stmt = $this->conn->prepare($query);

        $nom_serie = htmlspecialchars(strip_tags($data['nom_serie']));
        $description = isset($data['description']) ? htmlspecialchars(strip_tags($data['description'])) : '';

        $stmt->bindParam(':nom_serie', $nom_serie);
        $stmt->bindParam(':description', $description);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET nom_serie = :nom_serie, description = :description WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        $nom_serie = htmlspecialchars(strip_tags($data['nom_serie']));
        $description = isset($data['description']) ? htmlspecialchars(strip_tags($data['description'])) : '';

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom_serie', $nom_serie);
        $stmt->bindParam(':description', $description);

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
}
