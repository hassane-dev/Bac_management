<?php
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/SettingController.php';
require_once __DIR__ . '/../app/controllers/RoleController.php';

$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$segments = explode('/', trim($request_uri, '/'));

// Simple router
switch ($segments[0]) {
    case '':
    case 'dashboard':
        session_start();
        if (isset($_SESSION['user_id'])) {
            $pageTitle = 'Dashboard';
            $viewPath = '../app/views/dashboard.php';
            ob_start();
            include $viewPath;
            $content = ob_get_clean();
            include '../app/views/layouts/main.php';
        } else {
            header('Location: /login');
        }
        break;
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;
    case 'logout':
        $controller = new AuthController();
        $controller->logout();
        break;
    case 'users':
        $controller = new UserController();
        $method = $segments[1] ?? 'index';
        $param = $segments[2] ?? null;
        if (method_exists($controller, $method)) {
            $controller->$method($param);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
        break;
    case 'roles':
        $controller = new RoleController();
        $method = $segments[1] ?? 'index';
        $param = $segments[2] ?? null;
        if (method_exists($controller, $method)) {
            $controller->$method($param);
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
        break;
    case 'setting':
        $controller = new SettingController();
        $method = $segments[1] ?? 'index';
        if (method_exists($controller, $method)) {
            $controller->$method();
        } else {
            http_response_code(404);
            echo "404 Not Found";
        }
        break;
    default:
        // This is necessary to serve static files from the public directory
        if (file_exists(__DIR__ . '/' . $segments[0])) {
            return false;
        }
        http_response_code(404);
        echo "404 Not Found";
        break;
}
