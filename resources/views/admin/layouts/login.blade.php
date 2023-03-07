
<!DOCTYPE html>

<html lang="en" >
    <!--begin::Head-->
    <head>
        <meta charset="utf-8"/>
        <title>Log In</title>
        <meta name="description" content="Login page example"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>

        <!--begin::Fonts-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700"/>        <!--end::Fonts-->


                    <!--begin::Page Custom Styles(used by this page)-->
                             <link href="{{ asset('assets/css/pages/login/classic/login-6.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
                           
                            
                        <!--end::Page Custom Styles-->

        <!--begin::Global Theme Styles(used by all pages)-->
                    <link href="{{ asset('assets/plugins/global/plugins.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.css?v=7.0.6') }}" rel="stylesheet" type="text/css"/>
                    <link href="{{ asset('assets/css/style.bundle.css?v=7.0.6')}}" rel="stylesheet" type="text/css"/>

                <!--end::Global Theme Styles-->

        <!--begin::Layout Themes(used by all pages)-->

<!-- <link href="assets/css/themes/layout/header/base/light.css?v=7.0.6" rel="stylesheet" type="text/css"/>
<link href="assets/css/themes/layout/header/menu/light.css?v=7.0.6" rel="stylesheet" type="text/css"/> -->
 
<link href="{{ asset('assets/css/themes/layout/brand/dark.css?v=7.0.6')}}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('assets/css/themes/layout/aside/dark.css?v=7.0.6')}}" rel="stylesheet" type="text/css"/>        <!--end::Layout Themes-->

        <link rel="shortcut icon" href="{{ asset('assets/media/logos/favicon.png')}}"/>

            </head>
    <!--end::Head-->

    <!--begin::Body-->
    <body  id="kt_body"  class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading"  >

    	<!--begin::Main-->
	<div class="d-flex flex-column flex-root">
		<!--begin::Login-->
<div class="login login-6 login-signin-on login-signin-on d-flex flex-row-fluid" id="kt_login">
	<div class="d-flex flex-column flex-lg-row flex-row-fluid text-center" style="background-image: url({{ asset('assets/media/bg/bg-3.jpg')}});">
		<!--begin:Aside-->
		<div class="d-flex w-100 flex-center p-15" style="background:#2f3f4e;">
			<div class="login-wrapper">
				<!--begin:Aside Content-->
				<div class="text-dark-75">
				<a href="index.php" class="brand-logo">
			<img alt="Logo" src="{{ asset('assets/media/logos/logo1.png')}}" style="width: 200px;">
		</a>
					<h3 class="mb-8 mt-22 font-weight-bold" style="color:#f2ab40 !important;">JOIN OUR GREAT COMMUNITY</h3>
					<!--<p class="mb-15 text-muted font-weight-bold" style="color:#fff !important;">-->
					<!--	Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum orci erat, ullamcorper.-->
					<!--</p>-->
					<!--<button type="button" id="kt_login_signup" class="btn btn-outline-primary btn-pill py-4 px-9 font-weight-bold">Get An Account</button>-->
				</div>
				<!--end:Aside Content-->
			</div>
		</div>
		<!--end:Aside-->

		<!--begin:Divider-->
		<div class="login-divider">
			<div></div>
		</div>
		<!--end:Divider-->

		<!--begin:Content-->
		<div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden">
		    <div class="login-wrapper">
		     @yield('content')
			<!--<div class="login-wrapper">-->
				<!--begin:Sign In Form-->
			<!--	<div class="login-signin">-->
			<!--		<div class="text-center mb-10 mb-lg-20">-->
			<!--			<h2 class="font-weight-bold">Sign In</h2>-->
			<!--			<p class="text-muted font-weight-bold">Enter your username and password</p>-->
			<!--		</div>-->
			<!--		<form class="form text-left" id="kt_login_signin_form">-->
			<!--			<div class="form-group py-2 m-0">-->
			<!--				<input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="text" placeholder="Username" name="username" autocomplete="off" />-->
			<!--			</div>-->
			<!--			<div class="form-group py-2 border-top m-0">-->
			<!--				<input class="form-control h-auto border-0 px-0 placeholder-dark-75" type="Password" placeholder="Password" name="password" />-->
			<!--			</div>-->
			<!--			<div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">-->
			<!--				<div class="checkbox-inline">-->
			<!--					<label class="checkbox m-0 text-muted font-weight-bold">-->
			<!--						<input type="checkbox" name="remember" />-->
			<!--						<span></span>-->
			<!--						Remember me-->
			<!--					</label>-->
			<!--				</div>-->
							
			<!--			</div>-->
			<!--			<div class="text-center mt-15">-->
							
			<!--				<a class="btn btn-primary btn-pill shadow-sm py-4 px-9 font-weight-bold" href="dashboard.php">Sign In</a>-->
			<!--			</div>-->
			<!--		</form>-->
			<!--	</div>-->
				<!--end:Sign In Form-->

			</div>	
			</div>
		</div>
		<!--end:Content-->
	</div>
</div>
<!--end::Login-->
	</div>
<!--end::Main-->


        <script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
        <!--begin::Global Config(global config for global JS scripts)-->
        <script>
            var KTAppSettings = {
    "breakpoints": {
        "sm": 576,
        "md": 768,
        "lg": 992,
        "xl": 1200,
        "xxl": 1400
    },
    "colors": {
        "theme": {
            "base": {
                "white": "#ffffff",
                "primary": "#3699FF",
                "secondary": "#E5EAEE",
                "success": "#1BC5BD",
                "info": "#8950FC",
                "warning": "#FFA800",
                "danger": "#F64E60",
                "light": "#E4E6EF",
                "dark": "#181C32"
            },
            "light": {
                "white": "#ffffff",
                "primary": "#E1F0FF",
                "secondary": "#EBEDF3",
                "success": "#C9F7F5",
                "info": "#EEE5FF",
                "warning": "#FFF4DE",
                "danger": "#FFE2E5",
                "light": "#F3F6F9",
                "dark": "#D6D6E0"
            },
            "inverse": {
                "white": "#ffffff",
                "primary": "#ffffff",
                "secondary": "#3F4254",
                "success": "#ffffff",
                "info": "#ffffff",
                "warning": "#ffffff",
                "danger": "#ffffff",
                "light": "#464E5F",
                "dark": "#ffffff"
            }
        },
        "gray": {
            "gray-100": "#F3F6F9",
            "gray-200": "#EBEDF3",
            "gray-300": "#E4E6EF",
            "gray-400": "#D1D3E0",
            "gray-500": "#B5B5C3",
            "gray-600": "#7E8299",
            "gray-700": "#5E6278",
            "gray-800": "#3F4254",
            "gray-900": "#181C32"
        }
    },
    "font-family": "Poppins"
};
        </script>
        <!--end::Global Config-->

    	<!--begin::Global Theme Bundle(used by all pages)-->
    	    	   <script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.6')}}"></script>
		    	   <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.6')}}"></script>
		    	   <script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.6')}}"></script>
				<!--end::Global Theme Bundle-->


                    <!--begin::Page Scripts(used by this page)-->
                            <script src="{{ asset('assets/js/pages/custom/login/login-general.js?v=7.0.6')}}"></script>
                        <!--end::Page Scripts-->
            </body>
    <!--end::Body-->
</html>
