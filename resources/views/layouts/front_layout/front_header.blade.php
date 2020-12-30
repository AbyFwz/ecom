<?php
 use App\Section;
 $getSection = Section::get();
?>

<div id="header"> 
	<div class="container">
		<div id="welcomeLine" class="row">
			<div class="span6">Welcome!<strong> User</strong></div>
			<div class="span6">
				<div class="pull-right">
					<a href="product_summary.html"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ 3 ] Items in your cart </span> </a>
				</div>
			</div>
		</div>
		<!-- Navbar ================================================== -->
		<section id="navbar">
            <div class="navbar">
              <div class="navbar-inner">
                <div class="container">
                  <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                  </a>
                  <a class="brand" href="{{ url('/') }}">Localhost</a>
                  <div class="nav-collapse">
                    <ul class="nav">
                      <li class="active"><a href="{{ url('/') }}">Home</a></li>
                      @foreach($getSection as $sec)
                        @if(count($sec['categories'])>0)
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown">{{$sec['name'] }} <b class="caret"></b></a>
                          <ul class="dropdown-menu">
                            <li class="divider"></li>
                            @foreach ($sec['categories'] as $cat)
                              <li class="nav-header"><a href="{{ url($cat['url']) }}">{{ $cat['category_name'] }}</a></li>
                              @foreach ($cat['subcategories'] as $subcat)
                                <li><a href="{{ url($subcat['url']) }}">{{ $subcat['category_name'] }}</a></li>
                              @endforeach
                            @endforeach
                          </ul>
                        </li>
                        @endif
                      @endforeach
                      {{-- <li><a href="#">About</a></li> --}}
                    </ul>
                    {{-- <form class="navbar-search pull-left" action="#">
                      <input type="text" class="search-query span2" placeholder="Search"/>
                    </form> --}}
                    <ul class="nav pull-right">
                      <li><a href="#">Contact</a></li>
                      <li class="divider-vertical"></li>
                      <li><a href="#">Login</a></li>
                    </ul>
                  </div><!-- /.nav-collapse -->
                </div>
              </div><!-- /navbar-inner -->
            </div><!-- /navbar -->
          </section>
	</div>
</div>