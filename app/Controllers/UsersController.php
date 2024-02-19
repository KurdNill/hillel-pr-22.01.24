<?php

namespace App\Controllers;

use Core\Controller;

class UsersController extends Controller
{
    public function edit(int $id): array
    {
        return $this->response(body: ['id' => $id]);
    }
}