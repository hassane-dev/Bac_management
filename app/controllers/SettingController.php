<?php
require_once __DIR__ . '/../models/Setting.php';
require_once __DIR__ . '/AuthController.php';

class SettingController {

    public function index() {
        AuthController::checkAuth();
        $settingModel = new Setting();
        $settingModel->seed(); // Ensure default settings exist
        $settings = $settingModel->getAll();
        require_once __DIR__ . '/../views/settings/index.php';
    }

    public function update() {
        AuthController::checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $settingModel = new Setting();

            // Handle text inputs
            if ($settingModel->update($_POST)) {
                 // Handle file uploads
                $uploadDir = __DIR__ . '/../../public/uploads/settings/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $filesToUpdate = [];
                foreach ($_FILES as $key => $file) {
                    if ($file['error'] == UPLOAD_ERR_OK) {
                        $fileName = uniqid() . '-' . basename($file['name']);
                        $targetFile = $uploadDir . $fileName;
                        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
                            $filesToUpdate[$key] = '/uploads/settings/' . $fileName;
                        }
                    }
                }

                if (!empty($filesToUpdate)) {
                    $settingModel->update($filesToUpdate);
                }

                header('Location: /setting');
            } else {
                echo "Error updating settings.";
            }
        }
    }
}