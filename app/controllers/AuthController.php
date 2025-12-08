<?php
session_start();
require_once __DIR__ . '/../models/User.php';

class AuthController {

    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userModel = new User();
            $user = $userModel->checkCredentials($_POST['username'], $_POST['password']);

            if ($user && $user['statut'] === 'actif') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_name'] = $user['nom_utilisateur'];
                $_SESSION['user_role'] = $user['id_role'];
                header('Location: /');
                exit;
            } else {
                $error = 'Invalid credentials or account inactive.';
                require_once __DIR__ . '/../views/auth/login.php';
            }
        } else {
            require_once __DIR__ . '/../views/auth/login.php';
        }
    }

    public function logout() {
        session_destroy();
        header('Location: /login');
        exit;
    }

    public static function checkAuth() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /login');
            exit;
        }
    }
}
