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
        if ($this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'dashboard');
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $passwordConfirm = $_POST['password_confirm'] ?? '';

            if (empty($username)) {
                $errors[] = 'El nombre de usuario es requerido';
            } elseif (strlen($username) < 3) {
                $errors[] = 'El nombre de usuario debe tener al menos 3 caracteres';
            } elseif ($this->userModel->usernameExists($username)) {
                $errors[] = 'El nombre de usuario ya está registrado';
            }

            if (empty($email)) {
                $errors[] = 'El email es requerido';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errors[] = 'El email no es válido';
            } elseif ($this->userModel->emailExists($email)) {
                $errors[] = 'El email ya está registrado';
            }

            if (empty($password)) {
                $errors[] = 'La contraseña es requerida';
            } elseif (strlen($password) < 6) {
                $errors[] = 'La contraseña debe tener al menos 6 caracteres';
            } elseif ($password !== $passwordConfirm) {
                $errors[] = 'Las contraseñas no coinciden';
            }

            if (empty($errors)) {
                if ($this->userModel->register($username, $email, $password)) {
                    $_SESSION['success_message'] = 'Registro exitoso. Por favor inicia sesión.';
                    header('Location: ' . BASE_URL . 'login/show');
                    exit;
                } else {
                    $errors[] = 'Error al registrar el usuario';
                }
            }
        }

        $this->view('login/register', ['errors' => $errors]);
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
