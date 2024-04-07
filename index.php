<?php
// globala initieringar !
require_once (dirname(__FILE__) . "/utils/Router.php");


// $dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
// $dotenv->load();

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/pages/index.php';
});
$router->addRoute('/product', function () {
    require __DIR__ . '/pages/product.php';
});




$router->dispatch();
?>