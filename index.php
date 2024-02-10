<?php

declare(strict_types=1);

require_once 'configs.php';
require_once ROOT . 'classes/Animal.php';
require_once ROOT . 'classes/Cat.php';
//require_once ROOT . 'classes/Calculator.php';
//require_once ROOT . 'classes/ValueObject.php';
require_once ROOT . 'interfaces/Deliver.php';
require_once ROOT . 'interfaces/Format.php';
require_once ROOT . 'classes/ByEmail.php';
require_once ROOT . 'classes/BySms.php';
require_once ROOT . 'classes/ToConsole.php';
require_once ROOT . 'classes/Raw.php';
require_once ROOT . 'classes/WithDate.php';
require_once ROOT . 'classes/WithDateAndDetails.php';
require_once ROOT . 'classes/Logger.php';
require_once ROOT . 'vendor/autoload.php';


$logger = new Logger(new Raw(), new BySms());
$logger->log('Emergency error! Please fix me!');