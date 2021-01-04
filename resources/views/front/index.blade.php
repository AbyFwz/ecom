@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <div class="well well-small">
    @if(count($featuredItemsChunk)>0)
        <h4>Featured Products <small class="pull-right">{{$featuredItemsCount}} featured products</small></h4>
        <div class="row-fluid">
            <div id="featured" @if($featuredItemsCount>4) class="carousel slide" @endif>
                <div class="carousel-inner">
                    @foreach($featuredItemsChunk as $key => $featuredItem)
                        <div class="item @if($key==1) active @endif">
                            <ul class="thumbnails">
                                @foreach($featuredItem as $item)
                                <li class="span3">
                                    <div class="thumbnail">
                                        <i class="tag"></i>
                                        <?php $product_image_path = 'img/product/small/'.$item['main_image']; ?> 
                                        <a href="product_details.html">
                                        @if(!empty($item['main_image']) && file_exists($product_image_path))
                                            <img src="{{ asset($product_image_path) }}" alt="">
                                        @else
                                            <img src="{{ asset('img/product/small/no-image.jpg') }}" alt="">
                                        @endif
                                        </a>
                                        <div class="caption">
                                            <h5>{{ $item['product_name']}}</h5>
                                            <h4><a class="btn" href="{{ url('/product/'.$item['id']) }}">VIEW</a>
                                            <span class="pull-right">Rp.{{ $item['product_price'] }}</span></h4>    
                                        </div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
                <!-- <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#featured" data-slide="next">›</a> -->
            </div>
        </div>
    @endif
    </div>
    <h4>Latest Products </h4>
    <ul class="thumbnails">
        @foreach($newProducts as $product)
        <li class="span3">
            <div class="thumbnail">
                <a  href="product_details.html">
                <?php $product_image_path = 'img/product/small/'.$product['main_image']; ?> 
                    @if(!empty($product['main_image']) && file_exists($product_image_path))
                        <img style="max-width: 160px" src="{{ asset($product_image_path) }}" alt="">
                    @else
                        <img style="max-width: 160px" src="{{ asset('img/product/small/no-image.jpg') }}" alt="">
                    @endif
                </a>                        
                <div class="caption">
                    <h5>{{ $product['product_name'] }}</h5>
                    <p>
                        {{ $product['product_code'] }} ({{ $product['product_color'] }})
                    </p>
                    
                    <h4 style="text-align:center"><a class="btn" href="{{ url('/product/'.$item['id']) }}"> <i class="icon-zoom-in"></i></a> <a class="btn" href="{{ url('/product/'.$item['id']) }}">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">Rs.1000</a></h4>
                </div>
            </div>
        </li>
        @endforeach
    </ul>
</div>
@endsection