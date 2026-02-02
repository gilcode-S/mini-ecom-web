<?php

namespace App\Service\Admin;


use App\Models\Admin;
use App\Models\AdminsRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Image;
use Intervention\Image\ImageManager;

class AdminService
{
    public function login($data)
    {
        $admin = Admin::where('email', $data['email'])->first();

        if ($admin) {
            if ($admin->status == 0) {
                return "Inactive";
            }

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password'], 'status' => 1])) {
                // remember me functionality
                if (!empty($data['remember'])) {
                    setcookie('email', $data['email'], time() + 3600);
                    setcookie('password', $data['password'], time() + 3600);
                } else {
                    setcookie('email', "");
                    setcookie('password', "");
                }

                return "success";
            } else {
                return "Invalid Password";
            }
        } else {
            return "Email not Found";
        }
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
        if ($profileImage) {
            $profile_image_path = 'admin/images/photos/' . $profileImage;

            if (file_exists(public_path($profile_image_path))) {
                unlink(public_path($profile_image_path));
            }
            // update admin image field to empty
            Admin::where('id', $adminId)->update(['image' => null]);
            return ['status' => true, "message" => 'Profile image deleted successfully'];
        }
        return ['status' => false, "message" => 'Profile image not found'];
    }


    //  admin service for subadmins
    public function subadmins()
    {
        $subadmins = Admin::where('role', 'subadmin')->get();
        return $subadmins;
    }

    public function updateSubadminStatus($data)
    {
        $status = ($data['status'] == "Active") ? 0 : 1;
        Admin::where('id', $data['subadmin_id'])->update(['status' => $status]);
        return $status;
    }

    public function addEditSubadminRequest($request)
    {
        $data = $request->all();

        if (!empty($data['id'])) {
            $subadmindata = Admin::findOrFail($data['id']);
            $message = "Subadmin updated successfully";
        } else {
            $subadmindata = new Admin();
            $message = "Subadmin added successfully";
            $subadmindata->role = 'subadmin';
            $subadmindata->status = 1;
        }

        // ===== IMAGE =====
        if ($request->hasFile('image')) {
            $image_tmp = $request->file('image');

            if ($image_tmp->isValid()) {
                $manager = new ImageManager(new Driver());
                $image = $manager->read($image_tmp);

                $imageName = rand(111, 999999) . '.' . $image_tmp->getClientOriginalExtension();
                $image->save(public_path('admin/images/photos/' . $imageName));

                $subadmindata->image = $imageName;
            }
        } elseif (!empty($data['current_image'])) {
            $subadmindata->image = $data['current_image'];
        }

        // ===== FIELDS =====
        $subadmindata->name = $data['name'];
        $subadmindata->mobile = $data['mobile'];

        if (empty($data['id'])) {
            $subadmindata->email = $data['email'];
        }

        if (!empty($data['password'])) {
            $subadmindata->password = bcrypt($data['password']);
        }

        $subadmindata->save();

        // ✅ ALWAYS RETURN
        return ['message' => $message];
    }


    public function updateRole($request) 
    {
        $data = $request->all();
        //remove existing roles
        AdminsRole::where('subadmin_id', $data['subadmin_id'])->delete();

        // assign new roles
        foreach($data as $key => $value){
            if(!is_array($value)) continue;

            $view = isset($value['view']) ? $value['view'] : 0;
            $edit = isset($value['edit']) ? $value['edit'] : 0;
            $full = isset($value['full']) ? $value['full'] : 0;

            AdminsRole::insert([
                'subadmin_id' => $data['subadmin_id'],
                'module' => $key,
                'view_access' => $view,
                'edit_access' => $edit,
                'full_access' => $full,
            ]);

        }

        return ['message' => "Subadmin roles account updated success"];
    }
}
