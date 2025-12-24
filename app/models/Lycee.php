<?php
require_once __DIR__ . '/../../config/database.php';

class Lycee {
    private $conn;
    private $table = 'lycees';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY nom ASC';
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
        $query = 'INSERT INTO ' . $this->table . ' (nom, ville, code, contact, directeur) VALUES (:nom, :ville, :code, :contact, :directeur)';
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $nom = htmlspecialchars(strip_tags($data['nom']));
        $ville = htmlspecialchars(strip_tags($data['ville']));
        $code = htmlspecialchars(strip_tags($data['code']));
        $contact = htmlspecialchars(strip_tags($data['contact']));
        $directeur = htmlspecialchars(strip_tags($data['directeur']));

        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':directeur', $directeur);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET nom = :nom, ville = :ville, code = :code, contact = :contact, directeur = :directeur WHERE id = :id';
        $stmt = $this->conn->prepare($query);

        // Sanitize data
        $nom = htmlspecialchars(strip_tags($data['nom']));
        $ville = htmlspecialchars(strip_tags($data['ville']));
        $code = htmlspecialchars(strip_tags($data['code']));
        $contact = htmlspecialchars(strip_tags($data['contact']));
        $directeur = htmlspecialchars(strip_tags($data['directeur']));

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':ville', $ville);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':contact', $contact);
        $stmt->bindParam(':directeur', $directeur);

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
