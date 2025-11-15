<?php
session_start();

// Root Path
define('ROOT_PATH', dirname(dirname(__FILE__)) . '/');

// Load Composer autoload (if available) and load .env using phpdotenv
if (file_exists(ROOT_PATH . 'vendor/autoload.php')) {
	require_once ROOT_PATH . 'vendor/autoload.php';
	if (class_exists('Dotenv\\Dotenv')) {
		$dotenv = Dotenv\Dotenv::createImmutable(ROOT_PATH);
		// safeLoad evita excepción si no existe .env
		$dotenv->safeLoad();
	}
}

// Intentar obtener variables de entorno desde varias fuentes
$getEnvVar = function ($key) {
	$val = getenv($key);
	if ($val !== false && $val !== null && $val !== '') {
		return $val;
	}
	if (isset($_ENV[$key]) && $_ENV[$key] !== '') {
		return $_ENV[$key];
	}
	if (isset($_SERVER[$key]) && $_SERVER[$key] !== '') {
		return $_SERVER[$key];
	}
	return null;
};

$baseUrlEnv = $getEnvVar('BASE_URL');
if ($baseUrlEnv === null) {
	// Intentar leer sin comillas si existe en fichero .env
	$envFile = ROOT_PATH . '.env';
	if (file_exists($envFile)) {
		$contents = file_get_contents($envFile);
		if ($contents !== false) {
			if (preg_match('/^\s*BASE_URL\s*=\s*"?(.*?)"?\s*$/m', $contents, $m)) {
				$baseUrlEnv = $m[1];
				// asegurar que la variable esté en entorno
				putenv('BASE_URL=' . $baseUrlEnv);
				$_ENV['BASE_URL'] = $baseUrlEnv;
				$_SERVER['BASE_URL'] = $baseUrlEnv;
			}
		}
	}
}

// Base URL: primero intenta la variable de entorno, si no, usa el valor por defecto
define('BASE_URL', $baseUrlEnv ?: 'http://localhost/formularios/');

// Views Path
define('VIEWS_PATH', ROOT_PATH . 'app/view/');

// Include Database Connection
require_once ROOT_PATH . 'config/database.php';
?>
