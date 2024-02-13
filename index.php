<?php

declare(strict_types=1);

require_once 'configs.php';
//require_once ROOT . 'classes/Animal.php';
//require_once ROOT . 'classes/Cat.php';
//require_once ROOT . 'classes/Calculator.php';
//require_once ROOT . 'classes/ValueObject.php';
require_once ROOT . 'vendor/autoload.php';



clientCode(new LuxeTaxi);


$credentials = [
    'facebook' => [
        'login' => 'john_smith',
        'pass' => '******'
    ],
    'instagram' => [
        'login' => 'john_smith_insta',
        'pass' => '******'
    ]
];

$socials = $_POST['socials']; // ['facebook', 'instagram']
$content = $_POST['content'];

foreach ($socials as $social) {
    $poster = match ($social) {
        'instagram' => new InstagramPoster($credentials[$socials]['login'], $credentials[$socials]['pass']),
        default => new FacebookPoster($credentials[$socials]['login'], $credentials[$socials]['pass'])
    };

    clientCode($poster, $content);
}