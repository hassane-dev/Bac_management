<?php
use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../app/models/Setting.php';
require_once __DIR__ . '/../config/database.php';

class SettingTest extends TestCase
{
    private $db;
    private $settingModel;

    public function setUp(): void
    {
        $database = new Database();
        $this->db = $database->connect();
        $this->settingModel = new Setting();

        // Ensure the database is clean before each test
        $this->db->exec("DELETE FROM parametres");
    }

    public function testSeed()
    {
        $this->settingModel->seed();
        $settings = $this->settingModel->getAll();

        $this->assertCount(11, $settings);
        $this->assertEquals('Default Country', $settings['nom_pays']);
        $this->assertEquals(date('Y'), $settings['annee_bac']);
    }

    public function testGetAll()
    {
        $this->settingModel->seed();
        $settings = $this->settingModel->getAll();

        $this->assertIsArray($settings);
        $this->assertArrayHasKey('nom_pays', $settings);
    }

    public function testUpdate()
    {
        $this->settingModel->seed();
        $newSettings = [
            'nom_pays' => 'New Country Name',
            'annee_bac' => '2025'
        ];

        $result = $this->settingModel->update($newSettings);
        $this->assertTrue($result);

        $settings = $this->settingModel->getAll();
        $this->assertEquals('New Country Name', $settings['nom_pays']);
        $this->assertEquals('2025', $settings['annee_bac']);
    }

    public function tearDown(): void
    {
        // Clean up the database
        $this->db->exec("DELETE FROM parametres");
        $this->db = null;
    }
}
