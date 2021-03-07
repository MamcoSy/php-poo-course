<?php

use Mamco\Router\Route;
use Mamco\Router\Router;

require_once '../vendor/autoload.php';

$router = new Router();

$router->register( new Route( 'home', '/', [
    '_callback' => function () {
        echo 'hello';
    },
] ) );

$router->process( $_SERVER['REQUEST_URI'] );
