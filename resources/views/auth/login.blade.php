@extends('layouts.empty', ['paceTop' => true])

@section('title', 'Login')

@section('content')
<!-- begin login -->
<div class="login bg-black animated fadeInDown">
	<!-- begin brand -->
	<div class="login-header">
		<div class="brand">
			<span class="logo"></span> <b>S O P</b>
			<small>Sistema de Operatividad Política</small>
		</div>
		<div class="icon">
			<i class="fa fa-lock"></i>
		</div>
	</div>
	<!-- end brand -->
	<!-- begin login-content -->
	@if (session('errors'))
	<div class="alert alert-success">
		{{ session('errors') }}
	</div>
	@endif
	<div class="login-content">
		<form action="{{ route('loginsop') }}" method="post" class="margin-bottom-0">
			@csrf
			<div class="form-group m-b-20">
				<input id="email" type="email" placeholder="Usuario"
					class="form-control form-control-lg inverse-mode{{ $errors->has('email') ? ' is-invalid' : '' }}"
					name="email" value="{{ old('email') }}" required autofocus>
			</div>
			<div class="form-group m-b-20">
				<input id="password" type="password" placeholder="Contraseña"
					class="form-control form-control-lg inverse-mode{{ $errors->has('password') ? ' is-invalid' : '' }}"
					name="password" required>
			</div>
			<div class="login-buttons">
				<button type="submit" class="btn btn-success btn-block btn-lg">Iniciar</button>
			</div>
		</form>
	</div>
	<!-- end login-content -->
</div>
<!-- end login -->

@endsection

<style>
	.fa-lock:before {
		color: black;
	}
</style>