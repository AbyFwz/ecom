<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.admin_dashboard');
    }

    public function login(Request $request)
    {
        echo $password = Hash::make('1234');
        echo "<br>";
        echo $password = Hash::make('1234'); die;
        return view('admin.admin_login');
    }
}
