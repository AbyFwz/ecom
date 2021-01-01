<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Banner;
use Session;

class BannersController extends Controller
{
    public function banners(){
        Session::put('page', 'banners');
        $title = "Banners";
        $banners = Banner::get()->toArray();
        // echo "<pre>"; print_r($banners); die;
        return view('admin.banners.banners')->with(compact('title', 'banners'));
    }

    public function addEditBanner(Request $request, $id = null)
    {
        if ($id = "") {
            $banner = new Banner;
            $title = "Add Banner";
            $message = "Banner add successfully";
        } else {
            $banner = Banner::find($id);
            $title = "Edit Banner";
            $message = "Banner upload successfully";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $banner->link = $data['link'];
            $banner->title = $data['title'];
            $banner->alt = $data['alt'];
        }
        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }

    public function updateBannerStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'id'=>$data['banner_id']]);
        }
    }

    public function deleteBannerImage($id)
    {
        // Get Product Image
        $bannerImage = Banner::select('image')->where('id', $id)->first();

        // Get Product Image Path
        $image_path = 'img/banner/';

        // Delete Products Image from folder if exists
        if (file_exists($image_path.$bannerImage->image)) {
            unlink($image_path.$bannerImage->image);
        }

        // Delete image from table
        Banner::where('id', $id)->delete();

        $message = "Banner images has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }
}
