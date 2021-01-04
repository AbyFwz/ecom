<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\Category;
use App\Section;
use App\Brand;
use App\ProductsAttribute;
use App\ProductsImage;
use Session;
use Image;

class ProductsController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');
        $products = Product::with(['category', 'section'])->get();
        // $products = json_decode(json_encode($products), true);
        // echo "<pre>"; print_r($products); die;
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            productsAttribute::where('id', $data['product_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'product_id'=>$data['product_id']]);
        }
    }

    public function addEditProduct(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "Add Product";
            $product = new Product;
            $productData = array();
            $message = "Product added successfully!";
        } else {
            $title = "Edit Product";
            $productData = Product::find($id);
            $productData = json_decode(json_encode($productData), true);
            // echo "<pre>"; print_r($productData); die;
            $product = Product::where('id', $id)->first();
            // echo "<pre>"; print_r($product); die;
            $message = "Product updated successfully!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            $rules = [
                'category_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',
            ];
            $customMessages = [
                'category_id.required' => 'Category is required',
                'product_name.required' => 'Product Name is required',
                'product_name.alpha' => 'Valid product name is required',
                'product_code.required' => 'Product code is required',
                'product_code.alpha' => 'Valid product code is required',
                'product_price.required' => 'Product price is required',
                'product_price.numeric' => 'Valid product price is required',
                'product_color.required' => 'Product color is required',
                'product_color.alpha' => 'Valid product color is required',
            ];
            $this->validate($request, $rules, $customMessages);

            if (empty($data['product_discount'])) {
                $data['product_discount'] = 0;
            }
            if (empty($data['fabric'])) {
                $data['fabric'] = "";
            }
            if (empty($data['sleeve'])) {
                $data['sleeve'] = "";
            }
            if (empty($data['pattern'])) {
                $data['pattern'] = "";
            }
            if (empty($data['fit'])) {
                $data['fit'] = "";
            }
            if (empty($data['occasion'])) {
                $data['occasion'] = "";
            }
            if (empty($data['meta_title'])) {
                $data['meta_title'] = "";
            }
            if (empty($data['meta_keywords'])) {
                $data['meta_keywords'] = "";
            }
            if (empty($data['meta_description'])) {
                $data['meta_description'] = "";
            }

            // Upload main image
            if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    // Get name
                    $imageName = $image_tmp->getClientOriginalName();
                    // Get extension
                    $extension = $image_tmp->getClientOriginalExtension();
                    // Generate new image name
                    $imageName = $imageName.'-'.rand(111, 99999).'.'.$extension;

                    // Define save path
                    $largeImagePath = 'img/product/large/'.$imageName;
                    $mediumImagePath = 'img/product/medium/'.$imageName;
                    $smallImagePath = 'img/product/small/'.$imageName;

                    if (!empty($product->main_image)) {
                        // Check if exists
                        if (file_exists('img/product/small/'.$product->main_image)) {
                            unlink('img/product/small/'.$product->main_image);
                        }
                        if (file_exists('img/product/medium/'.$product->main_image)) {
                            unlink('img/product/medium/'.$product->main_image);
                        }
                        if (file_exists('img/product/large/'.$product->main_image)) {
                            unlink('img/product/large/'.$product->main_image);
                        }
                    }

                    // Upload the image
                    Image::make($image_tmp)->save($largeImagePath);
                    Image::make($image_tmp)->resize(520, 600)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(260, 300)->save($smallImagePath);

                    $product->main_image = $imageName;
                }
            }
            


            // Upload product video
            if ($request->hasFile('product_video')) {
                $video_tmp = $request->file('product_video');
                if ($video_tmp->isValid()) {
                    // Get name
                    $videoName = $video_tmp->getClientOriginalName();
                    // Get extension
                    $extension = $video_tmp->getClientOriginalExtension();
                    // Generate new name
                    $videoName = $videoName.'-'.rand(111, 99999).'.'.$extension;

                    // Video path
                    $video_path = 'videos/product/';

                    if (!empty($product->product_video)) {
                        // Check if exists
                        if (file_exists($video_path.$product->product_video)) {
                            unlink($video_path.$product->product_video);
                        }
                    }

                    // Move video to folder
                    $video_tmp->move($video_path, $videoName);
                    $product->product_video = $videoName;
                }
            }

            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->wash_care = $data['wash_care'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            $product->meta_title = $data['meta_title'];
            $product->meta_keywords = $data['meta_keywords'];
            $product->meta_description = $data['meta_description'];
            if(!empty($data['is_featured'])){
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();

            Session::flash('success_message', $message);
            return redirect('admin/products');
        }
        
        // Filter Arrays
        $fabricArray = array('Cotton', 'Polyester', 'Woold');
        $sleeveArray = array('Full Sleeve', 'Half Sleeve', 'Short Sleeve', 'Sleeveless');
        $patternArray = array('Checked', 'Plain', 'Printed', 'Self', 'Solid');
        $fitArray = Array('Regular', 'Slim');
        $occasionArray = array('Casual', 'Formal');

        // Section with Categories and Sub Categories
        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories), true);
        // echo "<pre>"; print_r($categories); die;

        // Get all brands
        $brands = Brand::where('status', 1)->get();
        $brands = json_decode(json_encode($brands), true);

        return view('admin.products.add_edit_product')->with(compact('title', 'fabricArray', 'sleeveArray', 'patternArray', 'fitArray', 'occasionArray', 'categories', 'productData', 'brands'));
    }

    public function deleteProductImage($id)
    {
        // Get Product Image
        $productImage = Product::select('main_image')->where('id', $id)->first();

        // Get Product Image Path
        $small_image_path = 'img/product/small/';
        $medium_image_path = 'img/product/medium/';
        $large_image_path = 'img/product/large/';

        // Delete Category Image from folder if exists
        if (file_exists($small_image_path.$productImage->main_image)) {
            unlink($small_image_path.$productImage->main_image);
        }
        if (file_exists($medium_image_path.$productImage->main_image)) {
            unlink($medium_image_path.$productImage->main_image);
        }
        if (file_exists($large_image_path.$productImage->main_image)) {
            unlink($large_image_path.$productImage->main_image);
        }

        // Delete image from table
        Product::where('id', $id)->update(['main_image'=>'']);

        $message = "Product image has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteProductVideo($id)
    {
        // Get Product Image
        $productVideo = Product::select('product_video')->where('id', $id)->first();

        // Get Product Image Path
        $product_video_path = 'videos/product/';

        // Delete Category Image from folder if exists
        if (file_exists($product_video_path.$productVideo->product_video)) {
            unlink($product_video_path.$productVideo->product_video);
        }

        // Delete image from table
        Product::where('id', $id)->update(['product_video'=>'']);

        $message = "Product video has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function deleteProduct($id)
    {
        // Delete Category
        Product::where('id', $id)->delete();

        $message = "Category has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addAttributes(Request $request, $id)
    {
        $title = "Products Attributes";
        $productData = Product::select('id', 'product_name', 'product_code', 'product_price', 'product_color', 'main_image')->with('attributes')->find($id);
        $productData = json_decode(json_encode($productData), true);
        // echo "<pre>"; print_r($productData); die;
        if ($request->isMethod('post')){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {
                    $attrCountSKU = ProductsAttribute::where(['sku'=>$value])->count();
                    if ($attrCountSKU>0) {
                        $message = 'SKU Already exists. Please add another SKU';
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attrCountSize = ProductsAttribute::where(['size'=>$value])->count();
                    if ($attrCountSize>0) {
                        $message = 'Size Already exists. Please add another Size';
                        Session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();


                }
            }

            $message = "Product Attributes has been added successfully!";
            Session::flash('success_message', $message);
            return redirect()->back();
        }
        return view('admin.products.add_attributes')->with(compact('title', 'productData'));
    }

    public function editAttributes(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attr) {
                if (!empty($attr)) {
                    ProductsAttribute::where(['id'=>$data['attrId'][$key]])->update(['price'=>$data['price'][$key], 'stock'=>$data['stock'][$key]]);
                }
            }
            $message = "Product Attributes has been updated successfully!";
            Session::flash('success_message', $message);
            return redirect()->back();
        }
    }

    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'attribute_id'=>$data['attribute_id']]);
        }
    }

    public function deleteAttribute($id)
    {
        // Delete Attribute
        ProductsAttribute::where('id', $id)->delete();

        $message = "Attribute has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }

    public function addImages(Request $request, $id)
    {
        $title = 'Add Images';

        if ($request->isMethod('post')) {
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                foreach ($images as $key => $image) {
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);

                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111, 999999).time().".".$extension;

                    // Define save path
                    $largeImagePath = 'img/product/large/'.$imageName;
                    $mediumImagePath = 'img/product/medium/'.$imageName;
                    $smallImagePath = 'img/product/small/'.$imageName;

                    // Upload the image
                    Image::make($image_tmp)->save($largeImagePath);
                    Image::make($image_tmp)->resize(520, 600)->save($mediumImagePath);
                    Image::make($image_tmp)->resize(260, 300)->save($smallImagePath);

                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();
                }
                $message = "Images has been added successfully!";
                Session::flash('success_message', $message);
                return redirect()->back();
            }
        }

        $productData = Product::with('images')->select('id', 'product_name', 'product_code', 'product_color', 'main_image')->where(['id'=>$id])->first();
        $productData = json_decode(json_encode($productData), true);
        // echo "<pre>"; print_r($productData); die;
        return view('admin.products.add_images')->with(compact('title', 'productData'));
    }

    public function updateImageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            product::where('id', $data['image_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status, 'image_id'=>$data['image_id']]);
        }
    }

    public function deleteImage($id)
    {
        // Get Product Image
        $productImage = ProductsImage::select('image')->where('id', $id)->first();

        // Get Product Image Path
        $small_image_path = 'img/product/small/';
        $medium_image_path = 'img/product/medium/';
        $large_image_path = 'img/product/large/';

        // Delete Products Image from folder if exists
        if (file_exists($small_image_path.$productImage->image)) {
            unlink($small_image_path.$productImage->image);
        }
        if (file_exists($medium_image_path.$productImage->image)) {
            unlink($medium_image_path.$productImage->image);
        }
        if (file_exists($large_image_path.$productImage->image)) {
            unlink($large_image_path.$productImage->image);
        }

        // Delete image from table
        ProductsImage::where('id', $id)->delete();

        $message = "Product images has been deleted successfully!";
        Session::flash('success_message', $message);
        return redirect()->back();
    }
}