<?php
require_once __DIR__ . '/../../config/database.php';

class Matiere {
    private $conn;
    private $table = 'matieres';
    private $pivot_table = 'matieres_series';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    // CRUD for Matieres
    public function getAll() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY nom_matiere ASC';
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
        $query = 'INSERT INTO ' . $this->table . ' (nom_matiere) VALUES (:nom_matiere)';
        $stmt = $this->conn->prepare($query);
        $nom_matiere = htmlspecialchars(strip_tags($data['nom_matiere']));
        $stmt->bindParam(':nom_matiere', $nom_matiere);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET nom_matiere = :nom_matiere WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $nom_matiere = htmlspecialchars(strip_tags($data['nom_matiere']));
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom_matiere', $nom_matiere);
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

    // Pivot table logic
    public function getBySerie($serie_id) {
        $query = 'SELECT m.nom_matiere, ms.coefficient, ms.type, ms.id
                  FROM ' . $this->pivot_table . ' ms
                  JOIN ' . $this->table . ' m ON ms.id_matiere = m.id
                  WHERE ms.id_serie = :serie_id
                  ORDER BY m.nom_matiere ASC';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':serie_id', $serie_id);
        $stmt->execute();
        return $stmt;
    }

    public function assignToSerie($data) {
        $query = 'INSERT INTO ' . $this->pivot_table . ' (id_serie, id_matiere, coefficient, type) VALUES (:id_serie, :id_matiere, :coefficient, :type)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_serie', $data['id_serie']);
        $stmt->bindParam(':id_matiere', $data['id_matiere']);
        $stmt->bindParam(':coefficient', $data['coefficient']);
        $stmt->bindParam(':type', $data['type']);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateInSerie($pivot_id, $data) {
        $query = 'UPDATE ' . $this->pivot_table . ' SET coefficient = :coefficient, type = :type WHERE id = :pivot_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pivot_id', $pivot_id);
        $stmt->bindParam(':coefficient', $data['coefficient']);
        $stmt->bindParam(':type', $data['type']);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function detachFromSerie($pivot_id) {
        $query = 'DELETE FROM ' . $this->pivot_table . ' WHERE id = :pivot_id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pivot_id', $pivot_id);
        if($stmt->execute()) {
            return true;
        }
        return false;
    }
}
