<?php
require_once ROOT_PATH . 'app/models/User.php';

class LoginController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        if ($this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }
        $this->view('login/login');
    }

    public function register() {
        // Registro deshabilitado: redirigir a la página de login
        if ($this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        header('Location: ' . BASE_URL . 'login');
        exit;
    }

    public function show() {
        if ($this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $errors = [];
        $success = $_SESSION['success_message'] ?? '';
        unset($_SESSION['success_message']);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                $errors[] = 'Usuario y contraseña son requeridos';
            } elseif (!$this->userModel->login($username, $password)) {
                $errors[] = 'Usuario o contraseña incorrectos';
            } else {
                header('Location: ' . BASE_URL . 'dashboard');
                exit;
            }
        }

        $this->view('login/login', ['errors' => $errors, 'success' => $success]);
    }

    public function logout() {
        $this->userModel->logout();
        header('Location: ' . BASE_URL . 'login');
        exit;
    }
}
?>
