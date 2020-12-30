<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Product;

class IndexController extends Controller
{
    public function index(){
        //Get Featured Items
        $featuredItemsCount = Product::where('is_featured','Yes')->where('status', 1)->count();
        $featuredItems = Product::where('is_featured','Yes')->where('status', 1)->get()->toArray();
        $featuredItemsChunk = array_chunk($featuredItems, 4);

        //Get New Products
        $newProducts = Product::orderBy('id','Desc')->limit(6)->get()->toArray();
        // echo "<pre>"; print_r($newProducts); die;
        $page_name = "Index";
        return view('front.index')->with(compact('page_name','featuredItemsChunk','featuredItemsCount', 'newProducts'));
    }
}
