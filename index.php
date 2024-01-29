<?php

declare(strict_types=1);

require_once 'configs.php';
require_once ROOT . 'classes/Animal.php';
require_once ROOT . 'classes/Cat.php';
require_once ROOT . 'classes/Calculator.php';
require_once ROOT . 'classes/ValueObject.php';



$dsn = 'mysql:host=mysql;dbname=php_advanced';
$pdo = new PDO($dsn, 'root', 'secret');

var_dump($pdo);