<?php

namespace App\Service\Admin;


use App\Models\Admin;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

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


    public function updateDetails($request)
    {

        $data = $request->all();
        $imageName = $data['current_image'] ?? null;

        // upload admin image
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {

                $manager = new ImageManager(new Driver());
                $image = $manager->read($image_tmp);

                $extension = $image_tmp->getClientOriginalExtension();
                $imageName = rand(111, 999999) . '.' . $extension;

                $image_path = public_path('admin/images/photos/' . $imageName);
                $image->save($image_path);
            }
        }

        // update admin details
        Admin::where('id', Auth::guard('admin')->user()->id)->update([
            'name'   => $data['name'],
            'mobile' => $data['mobile'],
            'image'  => $imageName,
        ]);
    }


    public function deleteProfileImage($adminId)
    {
        $profileImage = Admin::where('id', $adminId)->value('image');
        if($profileImage){
            $profile_image_path = 'admin/images/photos/' . $profileImage;

            if(file_exists(public_path($profile_image_path)))
                {
                    unlink(public_path($profile_image_path));   
                }
            // update admin image field to empty
            Admin::where('id', $adminId)->update(['image' => null]);
            return ['status' => true, "message" => 'Profile image deleted successfully'];
        }
        return ['status' => false, "message" => 'Profile image not found'];
    }
}


