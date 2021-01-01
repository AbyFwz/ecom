<?php use App\Banner;
$getBanners = Banner::getBanners();
// echo "pre>"; print_R($getBanners); die;
?>
@if(isset($page_name) && $page_name=="index")
<div id="carouselBlk">
	<div id="myCarousel" class="carousel slide">
		<div class="carousel-inner">
			@foreach($getBanners as $key => $banner)
			<div class="item @if($key==0) active @endif">
				<div class="container">
					<a @if(!empty($banner['link'])) href="{{ url($banner['link']) }}" @else 
					href="javascript:void(0)" @endif><img style="width:100%" src="{{ asset('img/banner_images/'.$banner['image']) }}" alt="{{$banner['alt'] }}" title="{{ $banner['title'] }}" /></a>
			</div>
			@endforeach
		</div>
		<a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
		<a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
	</div>
</div>
@endif