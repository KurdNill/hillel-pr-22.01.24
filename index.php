<?php

declare(strict_types=1);

require_once 'configs.php';
require_once ROOT . 'classes/Trait1.php';
require_once ROOT . 'classes/Trait2.php';
require_once ROOT . 'classes/Trait3.php';
require_once ROOT . 'classes/Test.php';
require_once ROOT . 'classes/User.php';



try {
    $user = new User();
    $user->setName('Nill');
    $user->setAge(17);
    echo $user->getName() . PHP_EOL;
    $user->setEmail();
} catch (Exception $exception) {
    echo $exception->getMessage() . PHP_EOL;
}
var_dump($user->getAll());