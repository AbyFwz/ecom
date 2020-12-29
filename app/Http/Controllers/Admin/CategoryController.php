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
        $categories = Category::with('section', 'parentcategory')->get();
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
            $categoryData = array();
            $getCategories = array();
            $message = "Category added successfully!";
        } else {
            $title = "Edit Category";
            $categoryData = Category::where('id', $id)->first();
            $categoryData = json_decode(json_encode($categoryData), true);
            $getCategories = Category::with('subcategories')->where(['parent_id' => 0, 'section_id' => $categoryData['section_id']])->get();
            $getCategories = json_decode(json_encode($getCategories), true);
            // echo "<pre>"; print_r($category); die;
            $category = Category::find($id);
            $message = "Category updated successfully!";
        }
        
        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'url' => 'required',
                'section_id' => 'required',
                'category_image' => 'mimes:jpeg,jpg,png,gif,svg'
            ];
            $customMessages = [
                'category_name.required' => 'Name is required',
                'category_name.alpha' => 'Valid name is required',
                'url.required' => 'URL is required',
                'section_id_required' => 'Section is required',
                // 'category_image.required' => 'Category image is required',
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
                    $imagePath = 'img/category/'.$imageName;
                    // Upload the image
                    Image::make($image_tmp)->save($imagePath);

                    $category->category_image = $imageName;
                }
            }

            if (empty($data['category_discount'])) {
                $data['category_discount'] = 0;
            }
            if (empty($data['description'])) {
                $data['description'] = "";
            }
            if (empty($data['meta_title'])) {
                $data['meta_title'] = "";
            }
            if (empty($data['meta_description'])) {
                $data['meta_description'] = "";
            }
            if (empty($data['meta_keywords'])) {
                $data['meta_keywords'] = "";
            }

            $category->parent_id = $data['parent_id'];
            $category->section_id = $data['section_id'];
            $category->category_name = $data['category_name'];
            $category->category_discount = $data['category_discount'];
            $category->description = $data['description'];
            $category->url = $data['url'];
            $category->meta_title = $data['meta_title'];
            $category->meta_description = $data['meta_description'];
            $category->meta_keywords = $data['meta_keywords'];
            $category->status = 1;
            $category->save();

            Session::flash('success_message', $message);
            return redirect('admin/categories');
        }

        // Get All Sections
        $getSections = Section::get();

        return view('admin.categories.add_edit_category')->with(compact('title', 'getSections', 'categoryData', 'getCategories'));
    }

    public function appendCategoryLevel(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $getCategories = Category::with('subcategories')->where(['section_id' => $data['section_id'], 'parent_id' => 0, 'status' => 1])->get();
            $getCategories = json_decode(json_encode($getCategories), true);
            // echo "<pre>"; print_r($getCategories); die;
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deleteCategoryImage($id)
    {
        // Get Category Image
        $categoryImage = Category::select('category_image')->where('id', $id)->first();

        // Get Category Image Path
        $category_image_path = 'img/category/';

        // Delete Category Image from folder if exists
        if (file_exists($category_image_path.$categoryImage->category_image)) {
            unlink($category_image_path.$categoryImage->category_image);
        }

        // Delete image from table
        Category::where('id', $id)->update(['category_image'=>'']);

        $message = "Category image has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteCategory($id)
    {
        // Check Parent Category
        $parentCheck = Category::where(['parent_id'=>$id])->get();
        $parentCheck = json_decode(json_encode($parentCheck),true);
        // echo "<pre>"; print_r($category); die;
        if (!empty($parentCheck)) {
            $message = "Parent cannot deleted!";
            Session::flash('error_message', $message);
            return redirect()->back();    
        }
        
        // Delete Category
        Category::where('id', $id)->delete();

        $message = "Category has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }
}
