<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use App\Cart;
use Session;
use Auth;

class ProductsController extends Controller
{
    public function listing($url, Request $request){
        if ($request->ajax()){
            $data = $request->all();
            echo "<pre>" ; print_r($data); die;
            $url = $data['url'];
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount>0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                
                // if sort option selected by user
                if (isset($_GET['sort']) && !empty(['sort'])) {
                    if($_GET['sort']=="product_latest"){
                        $categoryProducts->orderBy('id','Desc');
                    }else if($_GET['sort']=="product_name_A_z"){
                        $categoryProducts->orderBy('product_name','Asc');
                    }else if($_GET['sort']=="product_name_z_a"){
                        $categoryProducts->orderBy('product_name','Desc');
                    }else if($_GET['sort']=="price_lowest"){
                        $categoryProducts->orderBy('product_price','Asc');
                    }else if($_GET['sort']=="price_highest"){
                        $categoryProducts->orderBy('product_price','Desc');
                    }
                } else {
                    $categoryProducts->orderBy('id','Desc');
                }
                $categoryProducts = $categoryProducts->paginate(30);

                // echo "<pre>"; print_r($categoryProducts); die;
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            } else {
                abort(404);
            }  
        } else {
            $categoryCount = Category::where(['url'=>$url, 'status'=>1])->count();
            if ($categoryCount>0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])->where('status', 1);
                $categoryProducts = $categoryProducts->paginate(30);

                // echo "<pre>"; print_r($categoryProducts); die;
                return view('front.products.listing')->with(compact('categoryDetails', 'categoryProducts', 'url'));
            } else {
                abort(404);
            }  
        }
         
    }

    public function detail($id)
    {
        $productDetails = Product::with('category', 'brand', 'attributes', 'images')->find($id)->toArray();
        // dd($productDetails); die;
        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');
        $relatedProducts = Product::where('category_id', $productDetails['category']['id'])->where('status', 1)->where('id', '!=', $id)->limit(3)->inRandomOrder()->get()->toArray();
        // dd($relatedProducts); die;
        return view('front.products.detail')->with(compact('productDetails', 'total_stock', 'relatedProducts'));
    }

    public function getProductPrice(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $getProductPrice = ProductsAttribute::where(['product_id'=>$data['product_id'], 'size'=>$data['size']])->first();
            return $getProductPrice->price;
        }
    }

    public function addToCart(Request $request)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            // Check stock
            $getProductStock = ProductsAttribute::where(['product_id'=>$data['product_id'], 'size'=>$data['size']])->first()->toArray();
            // echo $getProductStock['stock']; die;
            // Will change to ajax function
            if ($getProductStock['stock'] < $data['quantity']) {
                $message = "Required Quantity is not Available!";
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            // Generate session
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            // Check product if exists
            if (Auth::check()) {
                // User is logged in
                $countProduct = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'user_id'=>Auth::user()->id])->count();    
            } else {
                // User is not logged in
                $countProduct = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id'=>Session::get('session_id')])->count();
            }
            
            $countProduct = Cart::where(['product_id'=>$data['product_id'], 'size'=>$data['size'], 'session_id'=> $session_id])->count();
            if ($countProduct > 0) {
                $message = 'Product already exists in your Cart!';
                Session::flash('error_message', $message);
                return redirect()->back();
            }

            if (Auth::check()) {
                $user_id = Auth::user()->id;
            } else {
                $user_id = 0;
            }

            // Save product in cart
            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->user_id = $user_id;
            $cart->save();

            $message = 'Product has been added Successfully';
            Session::flash('success_message', $message);
            return redirect()->back();
        }
    }

    public function cart()
    {
        $userCartItems = Cart::userCartItems();
        // echo "<pre>"; print_r($userCartItems); die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }
}
