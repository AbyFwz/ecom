<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Cart;
use Auth;
use Session;

class UsersController extends Controller
{
    public function loginRegister()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('front.users.login_register');
    }

    public function registerUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $userCount = User::where('email', $data['email'])->count();
            if ($userCount > 0) {
                $message = 'Email Already Exists!';
                Session::flash('error_message', $message);
                return redirect()->back();
            } else {
                // Register User
                $user = new User;
                $user->name = $data['name'];
                $user->mobile = $data['mobile'];
                $user->email = $data['email'];
                $user->password = bcrypt($data['password']);
                $user->status = 1;
                $user->save();

                if (Auth::attempt(['email'=>$data['email'], 'password'=>$data['password']])) {
                    echo "<pre>"; print_r(Auth::user()); die;
                }
            }
            
        }
    }

    public function loginUser(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            if (Auth::attempt(['email'=>$data['email'], 'password'=>$data['password'], 'status'=>1])) {
                if (!empty(Session::get('session_id'))) {
                    $user_id = Auth::user()->id;
                    $session_id = Session::get('session_id');
                    Cart::where('session_id', $session_id)->update(['user_id'=>$user_id]);
                }

                return redirect('/');
            } else {
                $message = 'Invalid username and password!';
                Session::flash('error_message', $message);
                return redirect()->back();
            }
        }
    }

    public function logoutUser(Request $request)
    {
        Auth::logout();
        return redirect('/login-register');
    }
}
