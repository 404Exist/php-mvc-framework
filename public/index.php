<?php
use App\Core\Application;
use App\Core\Facades\Route;
use App\Core\Support\DotEnv;

require_once __DIR__ . '/../vendor/autoload.php';

DotEnv::load(__DIR__ . '/../.env');
$app = new Application();

$app->route->get('/', 'home');
$app->route->get('/contact', function () {
    return view('contact');
});

$app->route->get('/login', [\App\Controllers\AuthController::class, 'login']);
$app->route->post('/login', [\App\Controllers\AuthController::class, 'login']);
$app->route->get('/register', [\App\Controllers\AuthController::class, 'register']);
$app->route->post('/register', [\App\Controllers\AuthController::class, 'register']);
$app->route->get('/logout', [\App\Controllers\AuthController::class, 'logout']);
$app->route->get('/profile', [\App\Controllers\AuthController::class, 'profile']);

$app->run();
