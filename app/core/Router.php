<?php
class Router {
    private $controller = 'Login';
    private $method = 'index';
    private $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Load controller
        $controllerPath = ROOT_PATH . 'app/controllers/' . ucfirst($url[0]) . 'Controller.php';
        
        if (file_exists($controllerPath)) {
            $this->controller = ucfirst($url[0]);
            unset($url[0]);
        }

        require_once ROOT_PATH . 'app/controllers/' . $this->controller . 'Controller.php';

        // Instanciar el controlador (guardamos el nombre de cadena original)
        $controllerString = $this->controller;
        $controllerClass = $controllerString . 'Controller';
        $controllerInstance = new $controllerClass();

        // Check method
        if (isset($url[1])) {
            if (method_exists($controllerInstance, $url[1])) {
                $this->method = $url[1];
                unset($url[1]);
            }
        }

        $this->params = array_values($url);

        // Inyectar contexto útil al propio controlador para que lo pase a las vistas
        $controllerInstance->controllerName = $controllerString;
        $controllerInstance->actionName = $this->method;
        $controllerInstance->routeParams = $this->params;
        $controllerInstance->fullUrl = $_SERVER['REQUEST_URI'] ?? null;

        // Reemplazar el controlador en la propiedad y ejecutar
        $this->controller = $controllerInstance;

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    private function parseUrl() {
        if (isset($_GET['url'])) {
            return explode('/', filter_var($_GET['url'], FILTER_SANITIZE_URL));
        }
        return ['login'];
    }
}
?>
