<?php
session_start();

// Base URL
// Ajustado al nombre de la carpeta del proyecto en htdocs (singular: formulario)
define('BASE_URL', 'http://localhost/formulario/');

// Root Path
define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');

// Views Path
// Apunta al directorio de vistas dentro de la carpeta app (app/view/)
define('VIEWS_PATH', ROOT_PATH . 'app/view/');

// Include Database Connection
require_once ROOT_PATH . 'config/database.php';
?>
