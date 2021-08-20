@extends('layouts.auth')
@section('content')
<div class="kt-login-v1__wrapper">
	<div class="kt-login-v1__container">
		<h3 class="kt-login-v1__title">
			{{ __('Reset Password') }}
		</h3>
		@include('layouts.inc.alert')

		<!--begin::Form-->
		<form class="kt-login-v1__form kt-form" method="POST" action="{{ route('password.email') }}" autocomplete="off" id="kt_login_form">
			@csrf
			<div class="form-group">
				<input class="form-control  @error('email') is-invalid @enderror" type="email" placeholder="{{ __('E-Mail Address') }}" name="email"  value="{{ old('email') }}" autocomplete="off">
				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="kt-login-v1__actions">				
				<button type="submit" class="btn btn-pill btn-elevate w-100" id="kt_login_submit">{{ __('Send Password Reset Link') }}</button>
			</div>
		</form>

		<!--end::Form-->

	
	</div>
</div>
@endsection