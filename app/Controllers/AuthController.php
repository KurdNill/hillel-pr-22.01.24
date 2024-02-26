<?php

namespace App\Controllers;

use App\Models\User;
use Core\Controller;
use App\Validators\Auth\RegisterValidator;
use function Core\requestBody;

class AuthController extends Controller
{
    public function signUp()
    {
        $data = requestBody();
        $validator = new RegisterValidator();

        if ($validator->validate($data)) {
            $user = User::create([
                ...$data,
                'password' => password_hash($data['password'], PASSWORD_BCRYPT)
            ]);

            return $this->response(body: $user->toArray());
        }
        return $this->response(errors: $validator->getErrors());
    }

    public function signIn()
    {
//        $data = requestBody();
//        $validator = new AuthValidator();
//
//        if ($validator->validate($data)) {
//            $user = User::findBy('email', $data['email']) {
//                if (password_verify($data['password'], $user->password)) {
//                    $expiration = time() + 3600;
//                    $token = Token::create($user->id, $user->password, $expiration, 'localhost')
//
//            }
//            }
//        }
//        return $this->response(body: $data);
    }
}