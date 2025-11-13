<?php
class Controller {
    public function view($view, $data = []) {
        $viewPath = VIEWS_PATH . $view . '.php';
        if (file_exists($viewPath)) {
            extract($data);
            include $viewPath;
        } else {
            die("View not found: " . $view);
        }
    }

    protected function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    protected function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: ' . BASE_URL . 'login');
            exit;
        }
    }

    protected function getCurrentUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    protected function getCurrentUsername() {
        return $_SESSION['username'] ?? null;
    }
}
?>
