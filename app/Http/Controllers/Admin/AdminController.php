<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Auth;
use Session;
use Validator;
use Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function settings(Request $request)
    {
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function chkCurrentPassword(Request $request)
    {
        $data = $request->all();
        // echo '<pre>'; print_r($data); die;
        // echo '<pre>'; print_r(Auth::guard('admin')->user()->password); die;
        if (Hash::check($data['current_pwd'],Auth::guard('admin')->user()->password)) {
            echo 'true';
        } else {
            echo 'false';
        }
    }

    public function updateCurrentPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // Check if current password is correct
            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password'=>bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'Password has been updated sucessfully!');
                } else {
                    Session::flash('error_message', 'Password doesnt match');
                }                
            } else {
                Session::flash('error_message', 'Your current password is incorrect');
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request)
    {
        return view('admin.update_admin_details');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];

            $customMessages = [
                'email.required' => 'Email is required',
                'email.email' => 'Valid email is required',
                'password.required' => 'Password is required',
            ];

            $this->validate($request, $rules, $customMessages);

            if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                return redirect('admin/dashboard');
            }else{
                Session::flash('error_message', 'Invalid Email or Password');
                return redirect()->back();
            }
        }
        return view('admin.admin_login');
    }

    public function logout()
    {
        Session::flash('success_message', 'Logout Successfull!');
        Auth::guard('admin')->logout();
        return redirect('/admin');
    }
}
