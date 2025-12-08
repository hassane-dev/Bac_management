<?php
require_once __DIR__ . '/../../config/database.php';

class Setting {
    private $conn;
    private $table = 'parametres';

    public function __construct() {
        $database = new Database();
        $this->conn = $database->connect();
    }

    public function getAll() {
        $query = 'SELECT cle, valeur FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $settings = [];
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $settings[$row['cle']] = $row['valeur'];
        }
        return $settings;
    }

    public function update($data) {
        $query = 'UPDATE ' . $this->table . ' SET valeur = :valeur WHERE cle = :cle';

        try {
            $this->conn->beginTransaction();
            foreach ($data as $cle => $valeur) {
                $stmt = $this->conn->prepare($query);
                $stmt->bindParam(':valeur', $valeur);
                $stmt->bindParam(':cle', $cle);
                $stmt->execute();
            }
            $this->conn->commit();
            return true;
        } catch (Exception $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function seed() {
        $defaults = [
            'nom_pays' => 'Default Country',
            'nombre_langues' => '1',
            'langue_1' => 'Francais',
            'langue_2' => 'Arabe',
            'annee_bac' => date('Y'),
            'seuil_admission' => '10',
            'seuil_second_tour' => '9.5',
            'logo_officiel' => '',
            'signature' => '',
            'cachet' => '',
            'qr_code' => ''
        ];

        foreach ($defaults as $cle => $valeur) {
            $stmt_check = $this->conn->prepare('SELECT id FROM ' . $this->table . ' WHERE cle = :cle');
            $stmt_check->bindParam(':cle', $cle);
            $stmt_check->execute();

            if($stmt_check->rowCount() == 0) {
                $stmt_insert = $this->conn->prepare('INSERT INTO ' . $this->table . ' (cle, valeur) VALUES (:cle, :valeur)');
                $stmt_insert->bindParam(':cle', $cle);
                $stmt_insert->bindParam(':valeur', $valeur);
                $stmt_insert->execute();
            }
        }
    }
}
