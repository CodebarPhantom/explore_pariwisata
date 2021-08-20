@extends('layouts.auth')

@section('title')
    {{ __('Reset Password') }} | {{ config('app.name') }}
@endsection

@section('header')
    {{ __('Reset Password') }}
@endsection

@section('content')


<div class="kt-login-v1__wrapper">
	<div class="kt-login-v1__container">
		<h3 class="kt-login-v1__title">
			{{ __('Reset Password') }}
		</h3>
		@include('layouts.inc.alert')

		<!--begin::Form-->
		<form class="kt-login-v1__form kt-form" method="POST" action="{{ route('password.update') }}" autocomplete="off" id="kt_login_form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
			<div class="form-group">
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email"  placeholder="{{ __('E-Mail Address') }}" readonly autofocus>
				@error('email')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
            </div>
            <div class="form-group">				
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="{{ __('Password') }}" minlength="8">


                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror  
            </div>
            <div class="form-group">				
                <input type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('Confirm Password') }}" minlength="8">        
			</div>
			<div class="kt-login-v1__actions">				
				<button type="submit" class="btn btn-pill btn-elevate w-100" id="kt_login_submit">{{ __('Reset Password') }}</button>
			</div>
		</form>

		<!--end::Form-->

	
	</div>
</div>
@endsection
