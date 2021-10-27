@section('content')
<div class="kt-login-v1__wrapper">
	<div class="kt-login-v1__container">
		<h3 class="kt-login-v1__title">
			{{ __('Sign To Account') }}
		</h3>

		<!--begin::Form-->
		<form class="kt-login-v1__form kt-form" method="POST" action="{{ route('login') }}" autocomplete="off" id="kt_login_form">
			@csrf
			<div class="form-group">
				<input class="form-control  @error('email') is-invalid @enderror" type="email" placeholder="{{ __('E-Mail Address') }}" name="email"  value="{{ old('email') }}" autocomplete="off">
				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			
			<div class="form-group">
				<input class="form-control  @error('password') is-invalid @enderror" type="password" placeholder="{{ __('Password') }}" name="password" autocomplete="off">
				@error('password')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>
			<div class="kt-login-v1__actions">
				@if (Route::has('password.request'))
					<a href="{{ route('password.request') }}" class="kt-login-v1__forgot">
						{{ __('Forgot Your Password?') }}
					</a>
				@endif
				<button type="submit" class="btn btn-pill btn-elevate" id="kt_login_submit">{{ __('Sign In') }}</button>
			</div>
		</form>

		<!--end::Form-->

	
	</div>
</div>
@endsection