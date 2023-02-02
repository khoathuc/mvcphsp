<?php
    use app\controllers\SiteController;
    use app\controllers\AuthController;
use app\controllers\InfoController;
use app\core\Application;

    require_once __DIR__.'/../vendor/autoload.php';
    $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
    $dotenv->load();
    
    $config = [
        'db'=>[
            'dsn'=>$_ENV['DB_DSN'],
            'user'=>$_ENV['DB_USER'],
            'password'=>$_ENV['DB_PASSWORD'],
        ]
    ];
    $app = new Application(dirname(__DIR__), $config);
    $app->router->get('/PHPMVCFramework/src', [SiteController::class, 'home']);
    $app->router->get('/PHPMVCFramework/src/contact', [SiteController::class,'contact']);
    $app->router->post('/PHPMVCFramework/src/contact', [SiteController::class,'contactHandler']);
    $app->router->get('/PHPMVCFramework/src/login',[AuthController::class, 'login']);
    $app->router->post('/PHPMVCFramework/src/login',[AuthController::class, 'login']);
    $app->router->get('/PHPMVCFramework/src/register',[AuthController::class, 'register']);
    $app->router->post('/PHPMVCFramework/src/register',[AuthController::class, 'register']);
    $app->router->get('/PHPMVCFramework/src/info',[InfoController::class, 'info']);
    $app->router->post('/PHPMVCFramework/src/info',[InfoController::class, 'info']);
    $app->router->get('/PHPMVCFramework/src/logout',[AuthController::class, 'logout']);

    echo $app->run();