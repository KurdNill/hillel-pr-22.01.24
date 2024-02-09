<?php

declare(strict_types=1);

require_once 'configs.php';
require_once ROOT . 'classes/Animal.php';
require_once ROOT . 'classes/Cat.php';
//require_once ROOT . 'classes/Calculator.php';
//require_once ROOT . 'classes/ValueObject.php';
require_once ROOT . 'vendor/autoload.php';

$opts = [
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
$dsn = "mysql:host=mysql_db;dbname=php_advanced";
$pdo = new PDO($dsn, 'root', 'secret', $opts);

$name = "Test";
$phone = '333555';

$query = $pdo->prepare("SELECT * FROM `parks`");
$query->execute();
