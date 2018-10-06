@extends('layout.login')

@section('content')
	<!-- Start login-form Area -->
	<section class="login-form-area relative">
		<div class="container-fluid">
			<div class="row equal align-items-center fullscreen">
				<sider-component></sider-component>
				<div class="col-lg-4 offset-lg-2 signup-form">
					<login-component></login-component>
				</div>
				<a class="primary-btn white-btn signup-btn" href="{{url('/register')}}">Registrarse</a>
			</div>
		</div>	
	</section>
	<!-- End login-form Area -->
@endsection

