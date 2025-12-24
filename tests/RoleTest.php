<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Role.php';
require_once __DIR__ . '/../app/models/Accreditation.php';
require_once __DIR__ . '/../config/database.php';

class RoleTest extends TestCase
{
    private $db;
    private $roleModel;
    private $accreditationModel;

    // We will use instance variables, not static, to ensure test isolation.
    private $testRoleId;
    private $perm1Id;
    private $perm2Id;

    /**
     * This method is called before each test.
     */
    public function setUp(): void
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->roleModel = new Role();
        $this->accreditationModel = new Accreditation();

        // Clean up tables to ensure a predictable state
        $this->db->exec("DELETE FROM roles_accreditations");
        $this->db->exec("DELETE FROM accreditations");
        $this->db->exec("DELETE FROM roles");

        // Create fresh data for each test and cast IDs to int
        $this->perm1Id = (int)$this->accreditationModel->create(['nom_permission' => 'manage_users']);
        $this->perm2Id = (int)$this->accreditationModel->create(['nom_permission' => 'manage_settings']);
        $this->testRoleId = (int)$this->roleModel->create(['nom_role' => 'Test Role']);
    }

    /**
     * This method is called after each test.
     */
    public function tearDown(): void
    {
        $this->db = null;
    }

    public function testCreateRole()
    {
        $role = $this->roleModel->findById($this->testRoleId);
        $this->assertEquals('Test Role', $role['nom_role']);
    }

    public function testGetPermissionsInitiallyEmpty()
    {
        $assignedPermissions = $this->roleModel->getPermissions($this->testRoleId);
        $this->assertIsArray($assignedPermissions);
        $this->assertCount(0, $assignedPermissions);
    }

    public function testUpdateAndGetPermissions()
    {
        // 1. Assign two permissions
        $permissionsToAssign = [$this->perm1Id, $this->perm2Id];
        $result = $this->roleModel->updatePermissions($this->testRoleId, $permissionsToAssign);
        $this->assertTrue($result);

        // 2. Get the permissions and verify
        $assignedPermissions = $this->roleModel->getPermissions($this->testRoleId);
        $this->assertCount(2, $assignedPermissions);
        $this->assertContains($this->perm1Id, $assignedPermissions);
        $this->assertContains($this->perm2Id, $assignedPermissions);
    }

    public function testUpdatePermissionsRemovesOldOnes()
    {
        // 1. Start with two permissions assigned
        $this->roleModel->updatePermissions($this->testRoleId, [$this->perm1Id, $this->perm2Id]);

        // 2. Update to a new set of permissions (only one)
        $newPermissions = [$this->perm2Id];
        $result = $this->roleModel->updatePermissions($this->testRoleId, $newPermissions);
        $this->assertTrue($result);

        // 3. Verify that the old permission is gone and the new one remains
        $assignedPermissions = $this->roleModel->getPermissions($this->testRoleId);
        $this->assertCount(1, $assignedPermissions);
        $this->assertNotContains($this->perm1Id, $assignedPermissions);
        $this->assertContains($this->perm2Id, $assignedPermissions);
    }

    public function testUpdatePermissionsToEmpty()
    {
        // 1. Start with two permissions assigned
        $this->roleModel->updatePermissions($this->testRoleId, [$this->perm1Id, $this->perm2Id]);

        // 2. Update to an empty set of permissions
        $result = $this->roleModel->updatePermissions($this->testRoleId, []);
        $this->assertTrue($result);

        // 3. Verify that all permissions have been removed
        $assignedPermissions = $this->roleModel->getPermissions($this->testRoleId);
        $this->assertCount(0, $assignedPermissions);
    }
}
