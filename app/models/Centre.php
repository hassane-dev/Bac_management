<?php

class Centre
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * Crée un nouveau centre d'examen.
     * @param array $data Données du centre (nom_centre, code_centre, ville, capacite).
     * @return string L'ID du centre nouvellement créé.
     */
    public function create(array $data): string
    {
        $sql = "INSERT INTO centres (nom_centre, code_centre, ville, capacite) VALUES (:nom_centre, :code_centre, :ville, :capacite)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':nom_centre' => $data['nom_centre'],
            ':code_centre' => $data['code_centre'],
            ':ville' => $data['ville'],
            ':capacite' => $data['capacite']
        ]);
        return $this->pdo->lastInsertId();
    }

    /**
     * Récupère tous les centres d'examen.
     * @return array La liste des centres.
     */
    public function getAll(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM centres ORDER BY nom_centre ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Récupère un centre par son ID.
     * @param int $id L'ID du centre.
     * @return mixed Les données du centre ou false si non trouvé.
     */
    public function getById(int $id)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM centres WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Met à jour un centre d'examen.
     * @param int $id L'ID du centre à mettre à jour.
     * @param array $data Les nouvelles données.
     * @return bool True si la mise à jour a réussi, sinon false.
     */
    public function update(int $id, array $data): bool
    {
        $sql = "UPDATE centres SET nom_centre = :nom_centre, code_centre = :code_centre, ville = :ville, capacite = :capacite WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute([
            ':nom_centre' => $data['nom_centre'],
            ':code_centre' => $data['code_centre'],
            ':ville' => $data['ville'],
            ':capacite' => $data['capacite'],
            ':id' => $id
        ]);
    }

    /**
     * Supprime un centre d'examen.
     * @param int $id L'ID du centre à supprimer.
     * @return bool True si la suppression a réussi, sinon false.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->pdo->prepare("DELETE FROM centres WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
