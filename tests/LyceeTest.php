<?php

use PHPUnit\Framework\TestCase;

class LyceeTest extends TestCase
{
    private $pdo;
    private $lycee;

    protected function setUp(): void
    {
        $this->pdo = new PDO('sqlite::memory:');
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec("CREATE TABLE lycees (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            nom_lycee TEXT NOT NULL,
            ville TEXT NOT NULL,
            code_lycee TEXT NOT NULL UNIQUE,
            contact TEXT,
            directeur TEXT
        )");

        // Inject the PDO test instance into the model
        $this->lycee = new Lycee($this->pdo);
    }

    public function testCreateLycee()
    {
        $data = [
            'nom_lycee' => 'Lycée Alpha',
            'ville' => 'Capital City',
            'code_lycee' => 'L001',
            'contact' => '123456789',
            'directeur' => 'John Doe'
        ];
        $id = $this->lycee->create($data);
        $this->assertIsNumeric($id);

        $stmt = $this->pdo->prepare("SELECT * FROM lycees WHERE id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->assertEquals($data['nom_lycee'], $result['nom_lycee']);
        $this->assertEquals($data['code_lycee'], $result['code_lycee']);
    }

    public function testGetAllLycees()
    {
        $data1 = ['nom_lycee' => 'Lycée Alpha', 'ville' => 'City A', 'code_lycee' => 'L001', 'contact' => '111', 'directeur' => 'Dir A'];
        $data2 = ['nom_lycee' => 'Lycée Beta', 'ville' => 'City B', 'code_lycee' => 'L002', 'contact' => '222', 'directeur' => 'Dir B'];
        $this->lycee->create($data1);
        $this->lycee->create($data2);

        $lycees = $this->lycee->getAll();
        $this->assertCount(2, $lycees);
    }

    public function testGetLyceeById()
    {
        $data = [
            'nom_lycee' => 'Lycée Gamma',
            'ville' => 'Capital City',
            'code_lycee' => 'L003',
            'contact' => '987654321',
            'directeur' => 'Jane Smith'
        ];
        $id = $this->lycee->create($data);
        $lycee = $this->lycee->getById($id);

        $this->assertIsArray($lycee);
        $this->assertEquals($data['nom_lycee'], $lycee['nom_lycee']);
    }

    public function testUpdateLycee()
    {
        $data = [
            'nom_lycee' => 'Lycée Delta',
            'ville' => 'Metroville',
            'code_lycee' => 'L004',
            'contact' => '555555555',
            'directeur' => 'Director X'
        ];
        $id = $this->lycee->create($data);

        $updatedData = [
            'nom_lycee' => 'Lycée Delta Updated',
            'ville' => 'Metroville Central',
        ];
        $this->lycee->update($id, $updatedData);

        $lycee = $this->lycee->getById($id);
        $this->assertEquals($updatedData['nom_lycee'], $lycee['nom_lycee']);
        $this->assertEquals($updatedData['ville'], $lycee['ville']);
    }

    public function testDeleteLycee()
    {
        $data = [
            'nom_lycee' => 'Lycée Epsilon',
            'ville' => 'Tech City',
            'code_lycee' => 'L005',
            'contact' => '101010101',
            'directeur' => 'Director Y'
        ];
        $id = $this->lycee->create($data);

        $this->lycee->delete($id);
        $lycee = $this->lycee->getById($id);
        $this->assertFalse($lycee);
    }

    protected function tearDown(): void
    {
        $this->pdo = null;
    }
}