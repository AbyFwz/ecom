@extends('layouts.front_layout.front_layout')
@section('content')
<div class="span9">
    <ul class="breadcrumb">
		<li><a href="{{ url('/') }}">Home</a> <span class="divider">/</span></li>
		<li class="active">Login</li>
    </ul>
	<h3 style="text-align: center"> Login / Register</h3>	
    <hr class="soft"/>
    @if(Session::has('error_message'))
        <div class="alert alert-danger" role="alert">
            {{ Session::get('error_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif(Session::has('success_message'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success_message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
	
	<div class="row">
		<div class="span4">
			<div class="well">
                <h5>CREATE YOUR ACCOUNT</h5><br>
                <form action="{{ url('/register') }}" method="POST">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="inputEmail0">Name</label>
                        <div class="controls">
                            <input class="span3" name="name" type="text" id="name" placeholder="Name" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail0">Mobile</label>
                        <div class="controls">
                        <input class="span3" name="mobile" type="text" id="mobile" placeholder="Mobile" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail0">E-mail address</label>
                        <div class="controls">
                        <input class="span3" name="email" type="email" id="email" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputEmail0">Password</label>
                        <div class="controls">
                        <input class="span3" name="password" type="password" id="password" placeholder="Password" required>
                        </div>
                    </div>
                    <div class="controls">
                        <button type="submit" class="btn block">Create Your Account</button>
                    </div>
                </form>
		    </div>
		</div>
		<div class="span1"> &nbsp;</div>
		<div class="span4">
			<div class="well">
                <h5>ALREADY REGISTERED ?</h5>
                <form action="{{ url('/login') }}" method="POST">
                    @csrf
                    <div class="control-group">
                        <label class="control-label" for="inputEmail1">Email</label>
                        <div class="controls">
                            <input class="span3" name="email" type="email" id="email" placeholder="Email">
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label" for="inputPassword1">Password</label>
                        <div class="controls">
                            <input type="password" class="span3" name="password" id="password" placeholder="Password">
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="controls">
                            <button type="submit" class="btn">Sign in</button> 
                            <a href="forgetpass.html">Forget password?</a>
                        </div>
                    </div>
                </form>
		    </div>
		</div>
	</div>	
</div>
@endsection