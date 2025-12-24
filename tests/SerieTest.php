<?php

use PHPUnit\Framework\TestCase;

class SerieTest extends TestCase
{
    private $pdo;
    private $serie;
    private $matiere;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Required tables
        $this->pdo->exec("CREATE TABLE series (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_serie TEXT NOT NULL UNIQUE,
            description TEXT
        )");
        $this->pdo->exec("CREATE TABLE matieres (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_matiere TEXT NOT NULL UNIQUE
        )");
        $this->pdo->exec("CREATE TABLE matieres_series (
            id_serie INTEGER,
            id_matiere INTEGER,
            coefficient REAL NOT NULL,
            est_facultatif INTEGER NOT NULL DEFAULT 0,
            PRIMARY KEY (id_serie, id_matiere),
            FOREIGN KEY (id_serie) REFERENCES series(id),
            FOREIGN KEY (id_matiere) REFERENCES matieres(id)
        )");

        // We need an instance of Serie and Matiere for testing relations
        $this->serie = new Serie($this->pdo);
        $this->matiere = new Matiere($this->pdo);
    }

    public function testCreateSerie()
    {
        $id = $this->serie->create(['nom_serie' => 'Série A4', 'description' => 'Lettres']);
        $this->assertIsNumeric($id);

        $stmt = $this->pdo->prepare("SELECT * FROM series WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals('Série A4', $result['nom_serie']);
    }

    public function testGetAllSeries()
    {
        $this->serie->create(['nom_serie' => 'Série C', 'description' => 'Maths']);
        $this->serie->create(['nom_serie' => 'Série D', 'description' => 'Sciences']);

        $series = $this->serie->getAll();
        $this->assertCount(2, $series);
    }

    public function testGetSerieById()
    {
        $id = $this->serie->create(['nom_serie' => 'Série G2', 'description' => 'Gestion']);
        $serie = $this->serie->getById($id);

        $this->assertIsArray($serie);
        $this->assertEquals('Série G2', $serie['nom_serie']);
    }

    public function testUpdateSerie()
    {
        $id = $this->serie->create(['nom_serie' => 'Serie B', 'description' => 'Economie']);
        $this->serie->update($id, ['nom_serie' => 'Série B', 'description' => 'Économie et Social']);

        $serie = $this->serie->getById($id);
        $this->assertEquals('Économie et Social', $serie['description']);
    }

    public function testDeleteSerie()
    {
        $id = $this->serie->create(['nom_serie' => 'Série F1', 'description' => 'Technique']);
        $this->serie->delete($id);

        $serie = $this->serie->getById($id);
        $this->assertFalse($serie);
    }

    public function testAssignAndGetMatieresForSerie()
    {
        // 1. Create a Serie and some Matieres
        $serieId = $this->serie->create(['nom_serie' => 'Série D', 'description' => 'Sciences Nat']);
        $mathId = $this->matiere->create(['nom_matiere' => 'Mathématiques']);
        $physId = $this->matiere->create(['nom_matiere' => 'Physique-Chimie']);
        $svtId = $this->matiere->create(['nom_matiere' => 'SVT']);

        // 2. Prepare assignment data
        $matieresData = [
            $mathId => ['coefficient' => 4, 'est_facultatif' => 0],
            $physId => ['coefficient' => 5, 'est_facultatif' => 0],
            $svtId => ['coefficient' => 2, 'est_facultatif' => 1]
        ];

        // 3. Assign them
        $this->serie->assignMatieres($serieId, $matieresData);

        // 4. Retrieve and verify
        $assignedMatieres = $this->serie->getMatieresBySerieId($serieId);

        $this->assertCount(3, $assignedMatieres);

        // Check details for one matiere
        $found = false;
        foreach ($assignedMatieres as $m) {
            if ($m['id_matiere'] == $physId) {
                $found = true;
                $this->assertEquals('Physique-Chimie', $m['nom_matiere']);
                $this->assertEquals(5, $m['coefficient']);
                $this->assertEquals(0, $m['est_facultatif']);
            }
        }
        $this->assertTrue($found, "Matiere 'Physique-Chimie' was not found in assigned list.");
    }

    public function testUpdateAssignedMatieres()
    {
        // 1. Initial setup
        $serieId = $this->serie->create(['nom_serie' => 'Série A4', 'description' => 'Lettres']);
        $frId = $this->matiere->create(['nom_matiere' => 'Français']);
        $philoId = $this->matiere->create(['nom_matiere' => 'Philosophie']);

        $initialAssignments = [
            $frId => ['coefficient' => 5, 'est_facultatif' => 0],
            $philoId => ['coefficient' => 4, 'est_facultatif' => 0]
        ];
        $this->serie->assignMatieres($serieId, $initialAssignments);

        // 2. Update assignments: change one, remove one, add one
        $histId = $this->matiere->create(['nom_matiere' => 'Histoire-Géo']);
        $updatedAssignments = [
            $frId => ['coefficient' => 6, 'est_facultatif' => 0], // Update coef
            $histId => ['coefficient' => 3, 'est_facultatif' => 0] // Add new
            // Philo is removed
        ];
        $this->serie->assignMatieres($serieId, $updatedAssignments);

        // 3. Verify
        $finalMatieres = $this->serie->getMatieresBySerieId($serieId);
        $this->assertCount(2, $finalMatieres);

        $foundFr = false;
        $foundHist = false;
        foreach ($finalMatieres as $m) {
            if ($m['id_matiere'] == $frId) {
                $foundFr = true;
                $this->assertEquals(6, $m['coefficient']);
            }
            if ($m['id_matiere'] == $histId) {
                $foundHist = true;
                $this->assertEquals(3, $m['coefficient']);
            }
        }
        $this->assertTrue($foundFr, "Updated matiere was not found.");
        $this->assertTrue($foundHist, "New matiere was not added.");
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}