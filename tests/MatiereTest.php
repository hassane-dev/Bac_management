<?php

use PHPUnit\Framework\TestCase;

class MatiereTest extends TestCase
{
    private $pdo;
    private $matiere;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE matieres (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_matiere TEXT NOT NULL UNIQUE
        )");

        $this->matiere = new Matiere($this->pdo);
    }

    public function testCreateMatiere()
    {
        $id = $this->matiere->create(['nom_matiere' => 'Mathématiques']);
        $this->assertIsNumeric($id);

        $stmt = $this->pdo->prepare("SELECT * FROM matieres WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Mathématiques', $result['nom_matiere']);
    }

    public function testGetAllMatieres()
    {
        $this->matiere->create(['nom_matiere' => 'Physique']);
        $this->matiere->create(['nom_matiere' => 'Chimie']);

        $matieres = $this->matiere->getAll();
        $this->assertCount(2, $matieres);
    }

    public function testGetMatiereById()
    {
        $id = $this->matiere->create(['nom_matiere' => 'Philosophie']);
        $matiere = $this->matiere->getById($id);

        $this->assertIsArray($matiere);
        $this->assertEquals('Philosophie', $matiere['nom_matiere']);
    }

    public function testUpdateMatiere()
    {
        $id = $this->matiere->create(['nom_matiere' => 'Histoire']);
        $this->matiere->update($id, ['nom_matiere' => 'Histoire-Géographie']);

        $matiere = $this->matiere->getById($id);
        $this->assertEquals('Histoire-Géographie', $matiere['nom_matiere']);
    }

    public function testDeleteMatiere()
    {
        $id = $this->matiere->create(['nom_matiere' => 'Anglais']);
        $this->matiere->delete($id);

        $matiere = $this->matiere->getById($id);
        $this->assertFalse($matiere);
    }

    public function testGetAllMatieresNotInSerie()
    {
        // 1. Setup: Create series and matieres
        $this->pdo->exec("CREATE TABLE series (id INTEGER PRIMARY KEY, nom_serie TEXT)");
        $this->pdo->exec("CREATE TABLE matieres_series (id_serie INTEGER, id_matiere INTEGER)");

        $this->pdo->exec("INSERT INTO series (id, nom_serie) VALUES (1, 'Série D')");

        $mathId = $this->matiere->create(['nom_matiere' => 'Mathématiques']);
        $physId = $this->matiere->create(['nom_matiere' => 'Physique']);
        $frId = $this->matiere->create(['nom_matiere' => 'Français']);

        // 2. Assign some matieres to the serie
        $this->pdo->exec("INSERT INTO matieres_series (id_serie, id_matiere) VALUES (1, $mathId)");
        $this->pdo->exec("INSERT INTO matieres_series (id_serie, id_matiere) VALUES (1, $physId)");

        // 3. Call the method and assert
        $unassigned = $this->matiere->getMatieresNotInSerie(1);

        $this->assertCount(1, $unassigned);
        $this->assertEquals('Français', $unassigned[0]['nom_matiere']);
    }


    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}