<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\User;
use App\Product;
use App\Cart;
use Auth;
use Session;
use Validator;
use Hash;
use Image;

class AdminController extends Controller
{
    public function dashboard()
    {
        Session::put('page', 'dashboard');
        $infoUser = User::count();
        $infoProduct = Product::count();
        $infoCart = Cart::count();
        return view('admin.admin_dashboard')->with(compact('infoUser', 'infoProduct', 'infoCart'));
    }

    public function settings(Request $request)
    {
        Session::put('page', 'settings');
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
        Session::put('page', 'update-admin-details');
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre"; print_r($data); die;
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_mobile' => 'required|numeric',
                'admin_image' => 'mimes:jpeg,jpg,png,gif,svg'
            ];
            $customMessages = [
                'admin_name.required' => 'Name is required',
                'admin_name.alpha' => 'Valid name is required',
                'admin_mobile.required' => 'Mobile is required',
                'admin_mobile.numeric' => 'Valid mobile is required',
                'admin_image.image' => 'Valid image is required'
            ];
            $this->validate($request, $rules, $customMessages);

            // Upload image
            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    // Get extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = rand(111, 99999).'.'.$extension;
                    $imagePath = 'img/admin/admin_photos/'.$imageName;
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);
                } else if(!empty($data['current_admin_image'])){
                    $imageName = $data['current_admin_image'];
                } else {
                    $imageName = "";
                }
            }
            

            // Update admin details
            Admin::where('email', Auth::guard('admin')->user()->email)->update(['name'=>$data['admin_name'], 'mobile'=>$data['admin_mobile'], 'image'=>$imageName]);
            Session::flash('success_message', 'Admin details updated successfully!');
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }

    public function login(Request $request)
    {
        if(Auth::guard('admin')->check()){
            return redirect('/admin/dashboard');
        }
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
