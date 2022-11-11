
<html lang="en" dir="ltr">
  <head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Bigonder admin" name="description">
		<meta content="Bigonder" name="author">
		<meta name="keywords" content="Bigonder"  />
		
		<!--favicon -->
		<link rel="icon" href="/bigonder.az mono2-02.svg" type="image/x-icon"/>
		<link rel="shortcut icon" href="/bigonder.az mono2-02.svg" type="image/x-icon"/>

		<!-- TITLE -->
		<title>Bigonder Admin Login</title>

		<!-- DASHBOARD CSS -->
		<link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet"/>
		<link href="{{ asset('admin/assets/css/dashboard-dark.css') }}" rel="stylesheet"/>
		<link href="{{ asset('admin/assets/css/style-modes.css') }}" rel="stylesheet"/>

		<!-- HORIZONTAL-MENU CSS -->
		<link href="{{ asset('admin/assets/css/horizontal-menu.css') }}" rel="stylesheet">

		<!-- SINGLE-PAGE CSS -->
		<link href="{{ asset('admin/assets/plugins/single-page/css/main.css') }}" rel="stylesheet" type="text/css">

		<!--C3.JS CHARTS PLUGIN -->
		<link href="{{ asset('admin/assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet"/>

		<!-- CUSTOM SCROLL BAR CSS-->
		<link href="{{ asset('admin/assets/plugins/scroll-bar/jquery.mCustomScrollbar.css') }}" rel="stylesheet"/>

		<!--- FONT-ICONS CSS -->
		<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet"/>

		<!-- Skin css-->
		<link href="{{ asset('admin/assets/skins/skins-modes/color1.css') }}"  id="theme" rel="stylesheet" type="text/css" media="all" />

	</head>
   <style>
       .header-brand-img {
           height:6rem;
       }
   </style>
	<body class="default-header dark-mode">

		<!-- BACKGROUND-IMAGE -->
		<div class="login-img">

			<!-- GLOABAL LOADER -->
			<div id="global-loader">
				<img src="{{ asset('admin/assets/images/svgs/loader.svg') }}" class="loader-img" alt="Loader">
			</div>

			<div class="page" style="background:#636097">
				<div class="">
				    <!-- CONTAINER OPEN -->
					<div class="col col-login mx-auto">
						<div class="text-center">
							<img src="/bigonder.az-original.png" class="header-brand-img" alt="">
						</div>
					</div>
					<div class="container-login100">
						<div class="wrap-login100 p-6">
							<form class="login100-form validate-form" method="post" action="/admin/login">
							    @csrf
								<span class="login100-form-title">
									Login
								</span>
								@if(Session::has('error'))
								<strong class="text-danger" style="margin:30px">Məlumat tapılmadı</strong></br>
								@endif
								<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
									<input class="input100" type="text" name="email" placeholder="Email" required>
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<i class="zmdi zmdi-email" aria-hidden="true"></i>
									</span>
								
								</div>
								<div class="wrap-input100 validate-input" data-validate = "Password is required"  required>
									<input class="input100" type="password" name="password" placeholder="Password">
									<span class="focus-input100"></span>
									<span class="symbol-input100">
										<i class="zmdi zmdi-lock" aria-hidden="true"></i>
									</span>
								</div>
								<div class="container-login100-form-btn">
									<button type="submit" class="login100-form-btn btn-primary">
										Login
									</button>
								</div>
							</form>
						</div>
					</div>
					<!-- CONTAINER CLOSED -->
				</div>
			</div>
		</div>
		<!-- BACKGROUND-IMAGE CLOSED -->

		<!-- JQUERY SCRIPTS -->
		<script src="{{asset('admin/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>

		<!-- BOOTSTRAP SCRIPTS -->
		<script src="{{asset('admin/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>

		<!-- SPARKLINE -->
		<script src="{{asset('admin/assets/js/vendors/jquery.sparkline.min.js') }}"></script>

		<!-- CHART-CIRCLE -->
		<script src="{{asset('admin/assets/js/vendors/circle-progress.min.js') }}"></script>

		<!-- RATING STAR -->
		<script src="{{asset('admin/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

		<!-- SELECT2 JS -->
		<script src="{{asset('admin/assets/plugins/select2/select2.full.min.js') }}"></script>
		<script src="{{asset('admin/assets/js/select2.js') }}"></script>

		<!-- INPUT MASK PLUGIN-->
		<script src="{{asset('admin/assets/plugins/input-mask/jquery.mask.min.js') }}"></script>

		<!-- CUSTOM SCROLL BAR JS-->
		<script src="{{asset('admin/assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js') }}"></script>

		<!-- CUSTOM JS-->
		<script src="{{asset('admin/assets/js/custom.js') }}"></script>

	</body>
</html>