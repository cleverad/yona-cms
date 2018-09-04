<?php
chdir(dirname(__DIR__));

\define('BASE_PATH', __DIR__ . '/../');
\define('MODULES_PATH', __DIR__ . '/../src/modules');
\define('APP_PATH', __DIR__ . '/../src/app');

// Autoloader for Composer packages
require_once BASE_PATH . 'vendor/autoload.php';

$dotenv = new \Dotenv\Dotenv(BASE_PATH);
$dotenv->load();

\defined('APPLICATION_ENV') ||
\define('APPLICATION_ENV', getenv('APPLICATION_ENV') ?: 'production');

\define('IMAGES_SERVER', getenv('IMAGE_SERVER'));
\define('STATIC_SERVER', getenv('STATIC_SERVER'));

//Debug
if (APPLICATION_ENV !== 'production') {
    $debug = new \Phalcon\Debug();
    $debug->listen();
}

// Application class
require_once APP_PATH . '/KernelManager.php';
$manager = new \Application\KernelManager($_ENV);

require_once APP_PATH . '/Front/Kernel.php';
$manager->setKernel(new \Application\Front\Kernel());

$manager->handle();
