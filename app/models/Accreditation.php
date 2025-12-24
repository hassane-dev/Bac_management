<?php
require_once __DIR__ . '/../../config/database.php';

class Accreditation {
    private $conn;
    private $table = 'accreditations';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    /**
     * Get all available permissions
     * @return PDOStatement
     */
    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY nom_permission ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    /**
     * Create a new permission
     * @param array $data expects ['nom_permission' => '...', 'description' => '...']
     * @return string|false The ID of the created permission or false on failure
     */
    public function create($data) {
        $query = 'INSERT INTO ' . $this->table . ' (nom_permission, description) VALUES (:nom_permission, :description)';
        $stmt = $this->conn->prepare($query);

        // Sanitize and bind parameters
        $nom_permission = htmlspecialchars(strip_tags($data['nom_permission']));
        $description = isset($data['description']) ? htmlspecialchars(strip_tags($data['description'])) : '';

        $stmt->bindParam(':nom_permission', $nom_permission);
        $stmt->bindParam(':description', $description);

        if($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    /**
     * Find a permission by its ID
     * @param int $id
     * @return array|false
     */
    public function findById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
