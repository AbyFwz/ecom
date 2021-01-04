<?php use App\Cart; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active"> SHOPPING CART</li>
    </ul>
	<h3>  
        SHOPPING CART [ <small>
            @if (!empty(Auth::check()))
                {{ Cart::where('user_id', Auth::user()->id)->count() }}
            @else 
                @if (!empty(Cart::where('session_id', Session::get('session_id'))->count()))
                {{ Cart::where('session_id', Session::get('session_id'))->count() }} 
                @else
                    0
                @endif
            @endif Item(s) 
        </small>]
        <a href="{{ url('/') }}" class="btn btn-large pull-right">
            <i class="icon-arrow-left"></i> Continue Shopping 
        </a>
    </h3>	
	<hr class="soft"/>
	@if (!Auth::check())
    <table class="table table-bordered">
		<tr>
            <th> I AM ALREADY REGISTERED  </th>
        </tr>
		 <tr> 
            <td>
                <form class="form-horizontal" action="{{ url('/login') }}" method="POST">
                    <div class="control-group">
                        <label class="control-label" for="email">Email</label>
                        <div class="controls">
                            <input type="email" name="email" id="email" placeholder="Username">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword1">Password</label>
                        <div class="controls">
                            <input type="password" id="inputPassword1" placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Sign in</button> OR <a href="register.html" class="btn">Register Now!</a>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <a href="forgetpass.html" style="text-decoration:underline">Forgot password ?</a>
                        </div>
                    </div>
                </form>
            </td>
		  </tr>
	</table>  
    @endif		
			
	<table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Quantity/Update</th>
                <th>Price</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php $totalPrice = 0; ?>
            @foreach ($userCartItems as $item)
                <?php 
                    $attrPrice = Cart::getProductAttrPrice($item['product_id'], $item['size']); 
                    $totalPrice = $totalPrice + ($attrPrice * $item['quantity']);
                ?>
                <tr>
                    <td> 
                        @if (!empty($item['product']['main_image']))
                            <img width="60" src="{{ asset('img/product/small/'.$item['product']['main_image']) }}" alt="Product"/>
                        @else
                            <img width="60" src="{{ asset('img/product/small/no-image.jpg') }}" alt="Produc"/>
                        @endif
                    </td>
                    <td>
                        {{ $item['product']['product_name'] }}<br/>
                        Color : {{ $item['product']['product_color'] }}<br/>
                        Size : {{ $item['size'] }}
                    </td>
                    <td>
                    <div class="input-append">
                        <input class="span1" style="max-width:34px" placeholder="1" id="appendedInputButtons" size="16" type="text" name="quantity" value={{ $item['quantity'] }}>
                        <button class="btn" type="button">
                            <i class="icon-minus"></i>
                        </button>
                        <button class="btn" type="button">
                            <i class="icon-plus"></i>
                        </button>
                        <button class="btn btn-danger" type="button">
                            <i class="icon-remove icon-white"></i>
                        </button>				
                    </div>
                    </td>
                    <td>Rp.{{ $attrPrice }}</td>
                    <td>Rs.0.00</td>
                    <td>Rp.{{ $attrPrice * $item['quantity'] }}</td>
                </tr>
                
            @endforeach
            <tr>
                <td colspan="5" style="text-align:right">Total Price:	</td>
                <td> Rp. {{ $totalPrice }}</td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:right">Total Discount:	</td>
                <td> Rs.0.00</td>
            </tr>
            <tr>
                <td colspan="5" style="text-align:right"><strong>GRAND TOTAL (Rp. {{ $totalPrice }} - Rs.0) =</strong></td>
                <td class="label label-important" style="display:block"> <strong> Rp. {{ $totalPrice }} </strong></td>
            </tr>
        </tbody>
    </table>
		
		
    <table class="table table-bordered">
        <tbody>
            <tr>
                <td> 
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label"><strong> VOUCHERS CODE: </strong> </label>
                            <div class="controls">
                                <input type="text" class="input-medium" placeholder="CODE">
                                <button type="submit" class="btn"> ADD </button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
			
			<!-- <table class="table table-bordered">
			 <tr><th>ESTIMATE YOUR SHIPPING </th></tr>
			 <tr> 
			 <td>
				<form class="form-horizontal">
				  <div class="control-group">
					<label class="control-label" for="inputCountry">Country </label>
					<div class="controls">
					  <input type="text" id="inputCountry" placeholder="Country">
					</div>
				  </div>
				  <div class="control-group">
					<label class="control-label" for="inputPost">Post Code/ Zipcode </label>
					<div class="controls">
					  <input type="text" id="inputPost" placeholder="Postcode">
					</div>
				  </div>
				  <div class="control-group">
					<div class="controls">
					  <button type="submit" class="btn">ESTIMATE </button>
					</div>
				  </div>
				</form>				  
			  </td>
			  </tr>
            </table> -->		
	<a href="{{ url('/') }}" class="btn btn-large"><i class="icon-arrow-left"></i> Continue Shopping </a>
	<a href="#" class="btn btn-large pull-right">Next <i class="icon-arrow-right"></i></a>
	
</div>
@endsection