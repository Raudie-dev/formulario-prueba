<?php
class Controller {
    public function view($view, $data = []) {
        $viewPath = VIEWS_PATH . $view . '.php';
        if (file_exists($viewPath)) {
            // Contexto por defecto disponible en todas las vistas
            $defaults = [
                'BASE_URL' => BASE_URL,
                'base_url' => BASE_URL,
                // callable para generar rutas a assets estáticos (public folder)
                'asset' => function($path) { return rtrim(BASE_URL, '/') . '/public/' . ltrim($path, '/'); },
                'current_controller' => $this->controllerName ?? null,
                'current_action' => $this->actionName ?? null,
                'route_params' => $this->routeParams ?? [],
                'full_url' => $this->fullUrl ?? null,
                'is_logged_in' => $this->isLoggedIn()
            ];

            // Extraer contexto y luego los datos específicos de la vista (datos de controlador)
            extract($defaults);
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
