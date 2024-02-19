<?php

use Core\Router;

//Router::add('users/{id:\d+}/edit', [
//     'controller', # class
//     'action', # controller::method
//     'method' # HTTP
//]);


Router::get('users/{id:\d+}/edit')->controller(\App\Controllers\UsersController::class)->action('edit');
//Router::get('articles/hello-world')->controller(\App\Controllers\UsersController::class)->action('edit');
Router::get('articles/{slug:.+}')->controller(\App\Controllers\UsersController::class)->action('edit');

