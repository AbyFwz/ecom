<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Brand;
use Session;

class BrandController extends Controller
{
    public function brands()
    {
        $brands = Brand::get();
        return view('admin.brands.brands')->with(compact('brands'));
    }

    public function addEditBrand(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add Brand";
            $brand = new Brand;
            $message = "Brand has been added successfully";
        } else {
            $title = "Edit Brand";
            $brand = Brand::find($id);
            $message = "Brand has been updated successfully";
        }
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'brand_name' => 'required|regex:/^[\pL\s\u-]+$/u',
            ];
            $customMessages = [
                'brand_name.required' => 'Brand name is required',
                'brand_name.regex' => 'Valid brand name is required',
            ];
            $this->validate($request, $rules, $customMessages);

            $brand->name = $data['brand_name'];
            $brand->status = 1;
            $brand->save();

            Session::flash('success_message', $message);
            return redirect('admin/brands');
        }

        return view('admin.brands.add_edit_brand')->with(compact('title', 'brand'));
    }

    public function updateBrandStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Brand::where('id', $data['brand_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'id'=>$data['brand_id']]);
        }
    }

    public function deleteBrand($id)
    {
        // Delete brand
        Brand::where('id', $id)->delete();

        $message = "brand has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }
}
