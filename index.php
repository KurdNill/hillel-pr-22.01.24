<?php

declare(strict_types=1);

require_once 'configs.php';
require_once ROOT . 'classes/Trait1.php';
require_once ROOT . 'classes/Trait2.php';
require_once ROOT . 'classes/Trait3.php';
require_once ROOT . 'classes/Test.php';

$test = new Test();
echo $test->getSum();