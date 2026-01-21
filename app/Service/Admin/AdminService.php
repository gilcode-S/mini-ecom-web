<?php

namespace App\Service\Admin;

use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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

    // verify password service FN
    public function verifyPassword($data)
    {
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            return 'true';
        } else {
            return 'false';
        }
    }

    public function updatePassword($data)
    {
        // check current password
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            // check if new password and confirm password match
            if ($data['new_pwd'] == $data['confirm_pwd']) {
                Admin::where('email', Auth::guard('admin')->user()->email)->update(['password' => bcrypt($data['confirm_pwd'])]);
                $status = "success";
                $message = "Password updated successfully";
            } else {
                $status = "error";
                $message = "New password and confirm password do not match Please try again";
            }
        } else {
            $status = "error";
            $message = "Your current password is incorrect Please try again";
        }

        return ['status' => $status, 'message' => $message];
    }
}
