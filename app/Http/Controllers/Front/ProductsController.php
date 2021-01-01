<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Session;

class ProductsController extends Controller
{
    public function listing($url)
    {
        $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
        if ($categoryCount>0) {
            $categoryDetails = Category::catDetails($url);
            // echo "<pre>"; print_r($categoryDetails); die;
            $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1)->get()->toArray();
            // echo "<pre>"; print_r($categoryProducts); die;
            return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts'));
        } else {
            abort(404);
        }   
    }

    public function detail($id)
    {
        $productDetails = Product::with('category', 'brand', 'attributes')->find($id)->toArray();
        return view('front.products.detail')->with(compact('productDetails'));
    }
}
