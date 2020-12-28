<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Section;
use Session;
use Image;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');
        $categories = Category::get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Category::where('id', $data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add Category";
            $category = new Category;
        } else {
            $title = "Edit Category";
        }
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'url' => 'required',
                'description' => 'required',
                'section_id' => 'required',
                'category_image' => 'mimes:jpeg,jpg,png,gif,svg'
            ];
            $customMessages = [
                'category_name.required' => 'Name is required',
                'category_name.alpha' => 'Valid name is required',
                'url.required' => 'URL is required',
                'description.required' => 'Description is required',
                'section_id_required' => 'Section is required',
                'category_image.image' => 'Valid image is required'
            ];
            $this->validate($request, $rules, $customMessages);


            // Upload category image
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    // Get extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = rand(111, 99999).'.'.$extension;
                    $imagePath = 'img/admin/admin_photos/'.$imageName;
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);

                    $category->category_image = $imageName;
                }
            }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->category_image = $data['category_image'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            Session::flash('success_message', 'Category add successfully!');
            return redirect('admin/categories');
        }

        // Get All Sections
        $getSections = Section::get();

        // Get Main Category
        $getCategory = Category::get();

        return view('admin.categories.add_edit_category')->with(compact('title', 'getSections', 'getCategory'));
    }
}
