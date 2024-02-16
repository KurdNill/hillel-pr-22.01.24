<?php

declare(strict_types=1);

require_once 'configs.php';
//require_once ROOT . 'classes/Animal.php';
//require_once ROOT . 'classes/Cat.php';
//require_once ROOT . 'classes/Calculator.php';
//require_once ROOT . 'classes/ValueObject.php';
require_once ROOT . 'vendor/autoload.php';
require_once ROOT . 'classes/Contact.php';



$contact = new Contact();
$newContact = $contact->phone('000-555-000')
    ->name("John")
    ->surname("Surname")
    ->email("john@email.com")
    ->address("Some address")
    ->build();