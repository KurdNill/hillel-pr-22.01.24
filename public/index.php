<?php

declare(strict_types=1);
use Core\Router;
define('BASE_DIR', dirname(__DIR__));

require_once BASE_DIR . '/vendor/autoload.php';


try {
    die(Router::dispatch($_SERVER['REQUEST_URI']));
    //die(Router::dispatch('/users/12/edit?test=4'));
} catch (Exception $exception) {
    echo $exception->getMessage();
}