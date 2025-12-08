<?php
require_once __DIR__ . '/../../config/database.php';

class User {
    private $conn;
    private $table = 'utilisateurs';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll() {
        $query = 'SELECT u.id, u.nom, u.prenom, u.email, u.nom_utilisateur, r.nom_role, u.statut FROM ' . $this->table . ' u LEFT JOIN roles r ON u.id_role = r.id ORDER BY u.date_creation DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function findByUsername($username) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE nom_utilisateur = :username LIMIT 0,1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $query = 'SELECT id, nom, prenom, email, nom_utilisateur, id_role, statut FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = 'INSERT INTO ' . $this->table . ' (nom, prenom, email, nom_utilisateur, mot_de_passe, id_role, statut) VALUES (:nom, :prenom, :email, :nom_utilisateur, :mot_de_passe, :id_role, :statut)';
        $stmt = $this->conn->prepare($query);

        $password_hash = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);

        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':nom_utilisateur', $data['nom_utilisateur']);
        $stmt->bindParam(':mot_de_passe', $password_hash);
        $stmt->bindParam(':id_role', $data['id_role']);
        $stmt->bindParam(':statut', $data['statut']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function update($id, $data) {
        $query = 'UPDATE ' . $this->table . ' SET nom = :nom, prenom = :prenom, email = :email, nom_utilisateur = :nom_utilisateur, id_role = :id_role, statut = :statut';

        if (!empty($data['mot_de_passe'])) {
            $query .= ', mot_de_passe = :mot_de_passe';
        }

        $query .= ' WHERE id = :id';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':nom_utilisateur', $data['nom_utilisateur']);
        $stmt->bindParam(':id_role', $data['id_role']);
        $stmt->bindParam(':statut', $data['statut']);

        if (!empty($data['mot_de_passe'])) {
             $password_hash = password_hash($data['mot_de_passe'], PASSWORD_BCRYPT);
             $stmt->bindParam(':mot_de_passe', $password_hash);
        }

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

    public function checkCredentials($username, $password) {
        $user = $this->findByUsername($username);
        if ($user && password_verify($password, $user['mot_de_passe'])) {
            return $user;
        }
        return false;
    }
}