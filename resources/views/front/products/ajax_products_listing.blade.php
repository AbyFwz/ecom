<div class="tab-pane  active" id="blockView">
    <ul class="thumbnails">
        @foreach ($categoryProducts as $prod)
            <li class="span3">
                <div class="thumbnail">
                    <a href="{{ url('/product/'.$prod['id']) }}">
                        <?php $product_image_path = 'img/product/small/'.$prod['main_image'] ?>
                        @if (!empty($prod['main_image']) && file_exists($product_image_path))
                            <img src="{{ asset($product_image_path) }}" alt="" style="max-width: 150px;"/>                                    
                        @else
                            <img src="{{ asset('img/product/small/no-image.jpg') }}" alt=""  style="max-width: 150px;"/>                                    
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{ $prod['product_name'] }} {{ $prod['id'] }}</h5>
                        <p>
                            @if (!empty($prod['brand_id']))
                                {{ $prod['brand']['name'] }}
                            @endif
                        </p>
                        <h4 style="text-align:center">
                            <a class="btn" href="{{ url('/product/'.$prod['id']) }}"> <i class="icon-zoom-in"></i></a> 
                            <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> 
                            <a class="btn btn-primary" href="#">Rp.{{$prod['product_price']}}</a>
                        </h4>
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    <hr class="soft"/>
</div>