@extends('admin.layouts.login')

@section('content')
<!--begin::Head-->

<!--end::Head-->

<!--begin::Body-->
<!--<div class="kt-login__body">-->

    <!--begin::Signin-->
    <!--<div class="kt-login__form">-->
    <!--    <div class="kt-login__title">-->
    <!--        <h3>Sign In</h3>-->
    <!--    </div>-->
    <div class="login-signin">
					<div class="text-center mb-10 mb-lg-20">
						<h2 class="font-weight-bold">Sign In</h2>
						<p class="text-muted font-weight-bold">Enter your username and password</p>
					</div>
	@if (\Session::has('msg'))
    <div class="alert alert-danger">
      
            {!! \Session::get('msg') !!}
        
    </div>
	@endif
        <!--begin::Form-->
        
        <form class="kt-form" action="{{ route('admin.login') }}" method="POST" novalidate="novalidate" id="kt_login_form">
            @csrf
            <div class="form-group">
                <!--<input class="form-control @error('email') is-invalid @enderror" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>-->
                <input class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('email') is-invalid @enderror" type="text" placeholder="Username" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus />
							
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <!--<input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Password" required autocomplete="current-password">-->
                <input class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('password') is-invalid @enderror" type="Password" placeholder="Password" name="password" required autocomplete="current-password" />
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
                	<div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">
							<div class="checkbox-inline">
								<label class="checkbox m-0 text-muted font-weight-bold">
									<input type="checkbox" name="remember" />
									<span></span>
									Remember me
								</label>
							</div>
							
						</div>
            </div>
            <!--begin::Action-->
            
            <div class="kt-login__actions">
                @if (Route::has('admin.password.request'))
                    <!--<a href="{{ route('admin.password.request') }}"  class="kt-link kt-login__link-forgot" id="kt_login_forgot">-->
                    <!--    Forgot Password ?-->
                    <!--</a>-->
                @endif

                <!-- 
				href="{{ route('admin.password.request') }}" 
				
				<div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>

                    <label class="form-check-label" for="remember">
                        {{ __('Remember Me') }}
                    </label>
                </div> -->
                <button  class="btn btn-primary btn-pill shadow-sm py-4 px-9 font-weight-bold">Sign
                    In</button>
            </div>
            <!--end::Action-->
        </form>
        <!--end::Form-->
		</div>
    <!--</div>-->
    <!--end::Signin-->
	
	<!--<div class="kt-login__forgot">
	 <div class="alert success-message" role="alert" style="display:none;">Password Reset Request has been sent. Please check your mail.</div>
                            <div class="kt-login__head">
                                <h3 class="kt-login__title">Forgotten Password ?</h3>
                                <div class="kt-login__desc">Enter your email to reset your password:</div>
                            </div>
                            <div class="kt-login__form">
                                <form class="kt-form" action="{{ route('admin.password.email') }}" id="reset-form" method="POST">
                                    <div class="form-group">
                                        <input class="form-control @error('email') is-invalid @enderror" type="text" placeholder="Email" name="email" id="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                    </div>
                                    <div class="kt-login__actions">
                                       <button type="submit" class="btn btn-outline-brand btn-pill btn-elevate" style=" height: 55px;">
                                    {{ __('Send Password Reset Link') }}
										</button>
                                    </div>
                                </form>
                            </div>
                        </div>-->
</div>
<!--end::Body-->
@endsection
@push('scripts')
<script>
   $('#reset-form').on('submit', function(e){
	  // console.log('test');
       e.preventDefault();
       $this = $(this);

       $.ajax({
           headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
           type: 'POST',
           dataType: 'JSON',
           data: $this.serialize(),
           url : $this.attr('action'),
           success: function(response){   
		   console.log(response);
               if(response.error){
                   $('.success-message').html(response.error).show().addClass("alert alert-danger");
                 
               } else {
                   setTimeout(function(){
                   $('.success-message').html('Password Reset Request has been sent. Please check your mail').show().addClass("alert alert-success"); 
                   },3000);
               }
           },
           error: function(response) {
               $('.success-message').html("Something went wrorng!!. Please try again").show();
           }
       }); 
   }) 
</script>
@endpush