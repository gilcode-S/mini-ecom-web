<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DetailRequest;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\PasswordRequest;
use App\Models\Admin;
use App\Service\Admin\AdminService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;


class AdminController extends Controller
{
    //protect adminservice by injection
    protected $adminService;

    // inject admin service FN
    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    // verify password FN
    public function verifyPassword(Request $request)
    {
       $data = $request->all();
       return $this->adminService->verifyPassword($data);
    }

    // update password
    public function updatePassword(PasswordRequest $request)
    {
        if($request->isMethod('post'))
            {
                $data = $request->input();

                $pwdStatus = $this->adminService->updatePassword($data);
                if($pwdStatus['status'] == "success"){
                    return redirect()->back()->with('success_message', $pwdStatus['message']);
                } else {
                    return redirect()->back()->with('error_message', $pwdStatus['message']);
                }
            }
    }

    public function editDetails()
    {
        Session::put('page', 'update-details');
        return view('admin.update-details');
    }

    public function updateDetails(DetailRequest $request)
    {
         Session::put('page', 'update-details');
        if ($request->isMethod('post')) {
            $this->adminService->updateDetails($request);
            return redirect()->back()->with('success_message', 'Admin details updated successfully');
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        Session::put('page', 'dashboard');
        return view('admin.dashboard');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.login');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LoginRequest $request)
    {
        //
        $data = $request->all();


        $loginStatus = $this->adminService->login($data);

        if ($loginStatus == 1) {
            return redirect()->route('dashboard.index');
        } else {
            return redirect()->back()->with('error message', 'invalid Email or Password');
        }
        // if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
        //     return redirect('admin/dashboard');
        // } else {
        //     return redirect()->back()->with('error message', 'invalid Email or Password');
        // }
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        //
        Session::put('page', 'update-password');
        return view('admin.update-password', [
            'email' => auth('admin')->user()->email
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        //
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
