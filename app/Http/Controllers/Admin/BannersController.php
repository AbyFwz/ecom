<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;

class BannersController extends Controller
{
    public function banners(){
        $banners = Banner::get()->toArray();
        return view('admin.banners.banners')->with(compact('banners'));
    }
}
