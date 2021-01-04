<?php
    use App\Section;
    $getSection = Section::get();
?>
<div id="sidebar" class="span3">
    <div class="well well-small"><a id="myCart" href="product_summary.html"><img src="{{ asset('img/front/ico-cart.png') }}" alt="cart">3 Items in your cart</a></div>
    <ul id="sideManu" class="nav nav-tabs nav-stacked">
        @foreach($getSection as $sec)
            @if(count($sec['categories'])>0)
                <li class="subMenu"><a>{{ $sec['name'] }}</a>
                @foreach($sec['categories'] as $cat)
                    <ul> 
                        <li><a href="{{ url('/'.$cat['url']) }}"><i class="icon-chevron-right"></i><strong>{{ $cat['category_name'] }}</strong></a></li>
                        @foreach ($cat['subcategories'] as $subcat)
                        <li><a href="{{ url('/'.$subcat['url']) }}"><i class="icon-chevron-right"></i>{{$subcat['category_name'] }}</a></li>
                        @endforeach
                    </ul>
                @endforeach
                </li>
            @endif
        @endforeach
    </ul>
    <br/>
    <div class="thumbnail">
        <img src="{{ asset('img/front/payment_methods.png') }}" title="Payment Methods" alt="Payments Methods">
        <div class="caption">
            <h5>Payment Methods</h5>
        </div>
    </div>
</div>