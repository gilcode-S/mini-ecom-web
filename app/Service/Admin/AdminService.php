<?php

namespace App\Service\Admin;

use Illuminate\Support\Facades\Auth;

class AdminService
{
    public function login($data)
    {
        if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
            // set cookies for both email and pass
            if (!empty($data['remember'])) {
                setcookie('email', $data['email'], time() + 3600);
                setcookie('password', $data['password'], time() + 3600);
            } else {
                setcookie('email', "");
                setcookie('password', "");
            }

            $loginStatus = 1;
        } else {
            $loginStatus = 0;
        }

        return $loginStatus;
    }
}
