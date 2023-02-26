<?php 
declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

session_start();

define('VIEW_PATH', __DIR__ . '/App/Views');

//phpdotenv package, so ve can have .env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

use App\Classes\Router;
use App\Classes\Application;

$router = new Router();
//register paths
$router->get('',               [App\Controllers\HomeController::class, 'index']);
$router->get('/',               [App\Controllers\HomeController::class, 'index']);
$router->post('/delete',               [App\Controllers\HomeController::class, 'delete']);

$router->get('/add-product',   [App\Controllers\AddproductController::class, 'index']);
$router->post('/add-product',  [App\Controllers\AddproductController::class, 'create']);

// Application is main object for whole project. Initialize it with some settings
(new Application(/* router, array, array */
    $router, 
    [
        'uri' => $_SERVER['REQUEST_URI'], 
        'method' => $_SERVER['REQUEST_METHOD']
    ],
    [
        'DB_HOST' => $_ENV['DB_HOST'], 
        'DB_PORT' => $_ENV['DB_PORT'], 
        'DB_DATABASE' => $_ENV['DB_DATABASE'], 
        'DB_USER' => $_ENV['DB_USER'], 
        'DB_PASS' => $_ENV['DB_PASS']
    ]
))->run();