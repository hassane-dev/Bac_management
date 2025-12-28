<?php

use PHPUnit\Framework\TestCase;

class CentreTest extends TestCase
{
    private $pdo;
    private $centre;

    protected function setUp(): void
    {
        // Set up an in-memory SQLite database for testing
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Create the 'centres' table
        $this->pdo->exec("CREATE TABLE centres (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_centre TEXT NOT NULL,
            code_centre TEXT NOT NULL UNIQUE,
            ville TEXT NOT NULL,
            capacite INTEGER NOT NULL
        )");

        // We need an instance of the model to test
        // This assumes the model can be instantiated with a PDO object
        require_once __DIR__ . '/../app/models/Centre.php';
        $this->centre = new Centre($this->pdo);
    }

    public function testCreateCentre()
    {
        $data = [
            'nom_centre' => 'Centre Pilote',
            'code_centre' => 'C001',
            'ville' => 'Capital City',
            'capacite' => 500
        ];
        $id = $this->centre->create($data);
        $this->assertIsNumeric($id);

        $stmt = $this->pdo->prepare("SELECT * FROM centres WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($data['nom_centre'], $result['nom_centre']);
        $this->assertEquals($data['capacite'], $result['capacite']);
    }

    public function testGetAllCentres()
    {
        $this->centre->create(['nom_centre' => 'Centre A', 'code_centre' => 'CA', 'ville' => 'Ville A', 'capacite' => 100]);
        $this->centre->create(['nom_centre' => 'Centre B', 'code_centre' => 'CB', 'ville' => 'Ville B', 'capacite' => 200]);

        $centres = $this->centre->getAll();
        $this->assertCount(2, $centres);
    }

    public function testGetCentreById()
    {
        $data = ['nom_centre' => 'Centre C', 'code_centre' => 'CC', 'ville' => 'Ville C', 'capacite' => 300];
        $id = $this->centre->create($data);

        $centre = $this->centre->getById($id);

        $this->assertIsArray($centre);
        $this->assertEquals($data['nom_centre'], $centre['nom_centre']);
    }

    public function testUpdateCentre()
    {
        $data = ['nom_centre' => 'Centre D', 'code_centre' => 'CD', 'ville' => 'Ville D', 'capacite' => 400];
        $id = $this->centre->create($data);

        $updatedData = [
            'nom_centre' => 'Centre D Modifié',
            'code_centre' => 'CD-MOD',
            'ville' => 'Ville D Modifiée',
            'capacite' => 450
        ];
        $this->centre->update($id, $updatedData);

        $centre = $this->centre->getById($id);
        $this->assertEquals($updatedData['nom_centre'], $centre['nom_centre']);
        $this->assertEquals($updatedData['capacite'], $centre['capacite']);
    }

    public function testDeleteCentre()
    {
        $data = ['nom_centre' => 'Centre E', 'code_centre' => 'CE', 'ville' => 'Ville E', 'capacite' => 500];
        $id = $this->centre->create($data);

        $this->centre->delete($id);
        $centre = $this->centre->getById($id);

        $this->assertFalse($centre);
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}
