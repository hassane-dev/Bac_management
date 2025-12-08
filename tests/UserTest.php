<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/User.php';
require_once __DIR__ . '/../app/models/Role.php';
require_once __DIR__ . '/../config/database.php';

class UserTest extends TestCase
{
    private $db;
    private $userModel;
    private $roleModel;
    private static $testRoleId;
    private static $testUserId;

    public function setUp(): void
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->userModel = new User();
        $this->roleModel = new Role();

        // Ensure the database is clean before each test
        $this->db->exec("DELETE FROM utilisateurs");
        $this->db->exec("DELETE FROM roles");

        // Create a test role
        $roleData = ['nom_role' => 'Test Role'];
        self::$testRoleId = $this->roleModel->create($roleData);
    }

    public function testCreateUser()
    {
        $userData = [
            'nom' => 'Doe',
            'prenom' => 'John',
            'email' => 'john.doe@example.com',
            'nom_utilisateur' => 'johndoe',
            'mot_de_passe' => 'password123',
            'id_role' => self::$testRoleId,
            'statut' => 'actif'
        ];

        $result = $this->userModel->create($userData);
        $this->assertTrue($result);

        $user = $this->userModel->findByUsername('johndoe');
        $this->assertEquals('john.doe@example.com', $user['email']);
        self::$testUserId = $user['id']; // Save for other tests
    }

    public function testFindByUsername()
    {
        $this->testCreateUser(); // Ensure a user exists
        $user = $this->userModel->findByUsername('johndoe');
        $this->assertIsArray($user);
        $this->assertEquals('johndoe', $user['nom_utilisateur']);
    }

    public function testCheckCredentials()
    {
        $this->testCreateUser(); // Ensure a user exists
        $user = $this->userModel->checkCredentials('johndoe', 'password123');
        $this->assertIsArray($user);

        $user = $this->userModel->checkCredentials('johndoe', 'wrongpassword');
        $this->assertFalse($user);
    }

    public function testUpdateUser()
    {
        $this->testCreateUser();
        $updatedData = [
            'nom' => 'DoeUpdated',
            'prenom' => 'JohnUpdated',
            'email' => 'john.doe.updated@example.com',
            'nom_utilisateur' => 'johndoe_updated',
            'mot_de_passe' => '', // No password change
            'id_role' => self::$testRoleId,
            'statut' => 'inactif'
        ];

        $result = $this->userModel->update(self::$testUserId, $updatedData);
        $this->assertTrue($result);

        $user = $this->userModel->findById(self::$testUserId);
        $this->assertEquals('DoeUpdated', $user['nom']);
        $this->assertEquals('inactif', $user['statut']);
    }

    public function testDeleteUser()
    {
        $this->testCreateUser();
        $result = $this->userModel->delete(self::$testUserId);
        $this->assertTrue($result);

        $user = $this->userModel->findById(self::$testUserId);
        $this->assertFalse($user);
    }

    public function tearDown(): void
    {
        // Clean up the database
        $this->db->exec("DELETE FROM utilisateurs");
        $this->db->exec("DELETE FROM roles");
        $this->db = null;
    }
}
