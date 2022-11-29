<!doctype html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Bigonder admin" name="description">
		<meta content="Bigonder" name="author">
		<meta name="keywords" content="Bigonder.az"  />

		<!--favicon -->
		<link rel="icon" href="/favicon.png" type="image/x-icon"/>
		<link rel="shortcut icon" href="/favicon.png" type="image/x-icon"/>

		<!-- TITLE -->
		<title>Bigonder.az - Admin</title>

		<!-- DASHBOARD CSS -->
		<link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet"/>
		<link href="{{ asset('admin/assets/css/dashboard-dark.css') }}" rel="stylesheet"/>
		<link href="{{ asset('admin/assets/css/style-modes.css') }}" rel="stylesheet"/>


		<!-- HORIZONTAL-MENU CSS -->
		<link href="{{ asset('admin/assets/css/horizontal-menu.css') }}" rel="stylesheet">

		<!--C3.JS CHARTS PLUGIN -->
		<link href="{{ asset('admin/assets/plugins/charts-c3/c3-chart.css') }}" rel="stylesheet"/>

		<!-- TABS CSS -->
		<link href="{{ asset('admin/assets/plugins/tabs/style-2.css') }}" rel="stylesheet" type="text/css">

		<!-- PERFECT SCROLL BAR CSS-->
		<link href="{{ asset('admin/assets/plugins/pscrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />

		<!--- FONT-ICONS CSS -->
		<link href="{{ asset('admin/assets/css/icons.css') }}" rel="stylesheet"/>

		<!-- SELECT2 CSS -->
{{--		<link href="{{ asset('admin/assets/plugins/select2/select2.min.css') }}" rel="stylesheet"/>--}}
		<link href="{{ asset('admin/assets/plugins/accordion/accordion.css') }}" rel="stylesheet" />

		<link rel="stylesheet" href="{{ asset('admin/assets/plugins/summernote/summernote-bs4.css') }}">

		<link href="{{ asset('admin/assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
		<link rel="stylesheet" href="{{ asset('admin/assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}">
		<link href="{{ asset('admin/assets/plugins/datatable/responsive.bootstrap4.min.css') }}" rel="stylesheet" />



		<!-- Skin css-->
		<link href="{{ asset('admin/assets/skins/skins-modes/color1.css') }}"  id="theme" rel="stylesheet" type="text/css" media="all" />

	</head>
    <style>
        th
        {
             text-transform: capitalize !important;
        }
        tr
        {
            font-size:12.5px;
        }
        tr a
        {
            color:white;
        }
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
        .pagination ul{
          width: 100%;
          display: flex;
          flex-wrap: wrap;
          background: #272638;
          border:1px solid;
          padding: 8px;
          border-radius: 50px;
          box-shadow: 0px 10px 15px rgba(0,0,0,0.1);
        }
        .pagination ul li{
          color: #564ec1;
          list-style: none;
          line-height: 45px;
          text-align: center;
          font-size: 18px;
          font-weight: 500;
          cursor: pointer;
          user-select: none;
          transition: all 0.3s ease;
        }
        .pagination ul li.numb{
          list-style: none;
          height: 45px;
          width: 45px;
          margin: 0 3px;
          line-height: 45px;
          border-radius: 50%;
        }
        .pagination ul li.numb.first{
          margin: 0px 3px 0 -5px;
        }
        .pagination ul li.numb.last{
          margin: 0px -5px 0 3px;
        }
        .pagination ul li.dots{
          font-size: 22px;
          cursor: default;
        }
        .pagination ul li.btn{
          padding: 0 20px;
          border-radius: 50px;
        }
        .pagination li.active,
        .pagination ul li.numb:hover,
        .pagination ul li:first-child:hover,
        .pagination ul li:last-child:hover{
          color: white !important;
          background: #ffd430;
        }
        .pull-left
        {
            float:left !important;
        }
        .pull-right
        {
            float:right !important;
        }

    </style>
	<body class="default-header dark-mode">

		<!-- GLOBAL-LOADER -->
		<div id="global-loader">
			<img src="{{ asset('admin/assets/images/svgs/loader.svg') }}" class="loader-img"  alt="Loader">
		</div>
		<div class="page">
			<div class="page-main">
				<!-- HEADER -->
				<div class="header">
					<div class="container">
						<div class="d-flex">
						    <a id="horizontal-navtoggle" class="animated-arrow hor-toggle"><span></span></a>
							<a class="header-brand" href="/admin/home">
								<img src="/bigonder.az-original.png" class="header-brand-img desktop-logo" style="height:3rem;" alt=" logo">
								<img src="/bigonder.az-original.png" class="header-brand-img mobile-view-logo" alt=" logo">
							</a><!-- LOGO -->
							<div class="d-flex order-lg-2 ml-auto header-right-icons header-search-icon">
							    <a href="#" data-toggle="search" class="nav-link nav-link-lg d-md-none navsearch"><i class="fa fa-search"></i></a>
								<div class="">
									<form class="form-inline" action="/admin/search" method="get">
									    @csrf
										<div class="search-element">
											<input type="search" class="form-control header-search"  name="word" placeholder="" aria-label="Search" tabindex="1">
											<span class="btn btn-primary-color" type="submit"><i class="fa fa-search"></i></span>
										</div>
									</form>
								</div><!-- SEARCH -->
								<div class="dropdown d-md-flex">
									<a class="nav-link icon full-screen-link nav-link-bg" id="fullscreen-button">
										<i class="fe fe-maximize-2" ></i>
									</a>
								</div><!-- FULL-SCREEN -->
								<div class="dropdown d-md-flex header-settings">
									<a href="#" class="nav-link " data-toggle="dropdown">
										<span><img src="{{ asset('admin/assets/images/users/male/'.\App\Companies::query()->findOrFail(\auth()->user()->c_id)->with('logo:id,name')->get()[0]['logo']['name']).''}}" alt="profile-user" class="avatar brround cover-image mb-0 ml-0"></span>
									</a>
									<div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
										<div class="drop-heading  text-center border-bottom pb-3">
                                            <span><img src="{{ asset('admin/assets/images/users/male/'.\App\Companies::query()->findOrFail(\auth()->user()->c_id)->with('logo:id,name')->get()[0]['logo']['name']).''}}" alt="profile-user" class="avatar brround cover-image mb-0 ml-0"></span>
                                            <h5 style="display: inline-block" class="text-white mb-1">{{ Session::get('admin_name') }}</h5>
											<small class="text-muted"></small>
										</div>
										<a class="dropdown-item" href="/admin/logout"><i class="mdi  mdi-logout-variant mr-2"></i> <span>Çıxış</span></a>
									</div>
								</div><!-- SIDE-MENU -->

							</div>
						</div>
					</div>
				</div>
				<!-- HEADER END -->

				<!-- HORIZONTAL-MENU -->
				<div class="sticky">
					<div class="horizontal-main hor-menu clearfix">
						<div class="horizontal-mainwrapper container clearfix">
							<nav class="horizontalMenu clearfix">
								<ul class="horizontalMenu-list">
								    <li aria-haspopup="true"><a href="/admin/company/whatsapp/profile" class="sub-icon "><i class="fe fe-check"></i> Status</a></li>
									<li aria-haspopup="true"><a href="/admin/home" class="sub-icon "><i class="fe fe-airplay"></i> Statistika</a></li>
									<li aria-haspopup="true"><a href="/admin/company_add_messages" class="sub-icon "><i class="fa fa-plus"></i> Yarat</a></li>
									<li aria-haspopup="true"><a href="/admin/template" class="sub-icon "><i class="fa fa-paste"></i> Şablonlar</a></li>
									<li aria-haspopup="true"><a href="/admin/company_messages" class="sub-icon "><i class="fa fa-envelope"></i> Hesabat</a></li>
									<li aria-haspopup="true"><a href="#" class="sub-icon"><i class="fa fa-comments"></i> Çat Bot <i class="fa fa-angle-down horizontal-icon"></i></a>
										<ul class="sub-menu">
											<li aria-haspopup="true"><a href="/admin/chatbotlist">Siyahı</a></li>
											<li aria-haspopup="true"><a href="/admin/chatbot">Əlavə et</a></li>
										</ul>
									</li>
									<li aria-haspopup="true"><a href="#" class="sub-icon "><i class="fa fa-file"></i>API Doc</a></li>
									<li aria-haspopup="true"><a href="/admin/company/edit" class="sub-icon "><i class="fa fa-cog"></i> Tənzimləmələr</a></li>
								</ul>
							</nav>
							<!-- NAV END -->
						</div>
					</div>
				</div>
				<!-- HORIZONTAL-MENU END -->

				<!-- CONTAINER -->
				<div class="container content-area relative">

				  @yield('here')

				</div>
				<!-- CONTAINER END -->
            </div>

			<!-- SIDE-BAR -->

			<!-- SIDE-BAR CLOSED -->

			<!-- FOOTER -->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 text-center">
							Bigonder.az © 2022
						</div>
					</div>
				</div>
			</footer>
			<!-- FOOTER END -->
		</div>

		<!-- BACK-TO-TOP -->
		<a href="#top" id="back-to-top"><i class="fa fa-long-arrow-up"></i></a>

		<!-- JQUERY SCRIPTS -->
		<script src="{{ asset('admin/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>

		<!-- BOOTSTRAP SCRIPTS -->
		<script src="{{ asset('admin/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>

		<!-- SPARKLINE -->
		<script src="{{ asset('admin/assets/js/vendors/jquery.sparkline.min.js') }}"></script>

		<!-- CHART-CIRCLE -->
		<script src="{{ asset('admin/assets/js/vendors/circle-progress.min.js') }}"></script>

		<!-- RATING STAR -->
		<script src="{{ asset('admin/assets/plugins/rating/jquery.rating-stars.js') }}"></script>

		<!-- CHARTJS CHART -->
		<script src="{{ asset('admin/assets/plugins/chart/Chart.bundle.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/chart/utils.js') }}"></script>

		<!-- PIETY CHART -->
		<script src="{{ asset('admin/assets/plugins/peitychart/jquery.peity.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/peitychart/peitychart.init.js') }}"></script>

		<!-- HORIZONTAL-MENU -->
		<script src="{{ asset('admin/assets/plugins/horizontal-menu/horizontal-menu.js') }}"></script>

		<!-- PERFECT SCROLL BAR JS-->
		<script src="{{ asset('admin/assets/plugins/pscrollbar/perfect-scrollbar.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/pscrollbar/pscroll-1.js') }}"></script>

		<!-- SIDEBAR JS -->
		<script src="../../assets/plugins/sidebar/sidebar.js') }}"></script>

		<!-- APEX-CHARTS JS -->
		<script src="{{ asset('admin/assets/plugins/apexcharts/apexcharts.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/apexcharts/irregular-data-series.js') }}"></script>

		<!-- INDEX-SCRIPTS  -->
		<script src="{{ asset('admin/assets/js/index.js')  }}"></script>

		<!-- STICKY JS -->
		<script src="{{ asset('admin/assets/js/stiky.js') }}"></script>

		<!-- CUSTOM JS -->
		<script src="{{ asset('admin/assets/js/custom.js') }}"></script>


		<script src="{{ asset('admin/assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/jszip.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/accordion/accordion.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/accordion/accordion.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/dataTables.responsive.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/responsive.bootstrap4.min.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/datatable/datatable.js') }}"></script>
		<script src="{{ asset('admin/assets/plugins/summernote/summernote-bs4.js') }}"></script>
		<script src="{{ asset('admin/assets/js/summernote.js') }}"></script>
		<script>
		    // selecting required element
            const element = document.querySelector(".pagination ul");
            let page = {{ !empty($page) ? $page : 1 }};
            function totalPage()
            {
                $.ajax({
                    url: '/admin/checkmessages',
                    type:'get',
                    data:{"_token": "{{ csrf_token() }}"},
                    success:function(response)
                    {
                       if(response.status=='success')
                       {

                          createPagination(response.count,page);
                       }
                     }
                })
            }
            let totalPages = totalPage();

            let searchParams = new URLSearchParams(window.location.search)
            searchParams.has('search') // true
            let param = searchParams.get('search')
            let url = new URL(location.href);
            url.searchParams.delete('page');
            var currentUrl = url

            //calling function with passing parameters and adding inside element which is ul tag
            element.innerHTML = createPagination(totalPages, page);
            function createPagination(totalPages, page){
              let liTag = '';
              let active;
              let beforePage = page==1 ? page : (page - 1);
              let afterPage = page + 1;
              if(page > 1){ //show the next button if the page value is greater than 1
                if(param)
                {
                    liTag += `<li class="btn prev" onclick="createPagination(totalPages, ${page - 1})"><a href="`+currentUrl+`&page=${page - 1}"><span><i class="fa fa-angle-left"></i> Prev</span></a></li>`;
                }else
                {
                    liTag += `<li class="btn prev" onclick="createPagination(totalPages, ${page - 1})"><a href="`+currentUrl+`?page=${page - 1}"><span><i class="fa fa-angle-left"></i> Prev</span></a></li>`;
                }
              }

              if(page > 2){ //if page value is less than 2 then add 1 after the previous button
                if(param)
                {
                    liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><a href="`+currentUrl+`&page=1"><span>1</span></a></li>`;
                }else
                {
                    liTag += `<li class="first numb" onclick="createPagination(totalPages, 1)"><a href="`+currentUrl+`?page=1"><span>1</span></a></li>`;
                }
                if(page > 3){ //if page value is greater than 3 then add this (...) after the first li or page
                  liTag += `<li class="dots"><span>...</span></li>`;
                }
              }

              // how many pages or li show before the current li
              if (page == totalPages) {
                if(beforePage>2)
                {
                beforePage = beforePage - 2;
                }
              } else if (page == totalPages - 1) {
                beforePage = beforePage - 1;
              }
              // how many pages or li show after the current li
              if (page == 1) {
                afterPage = afterPage + 2;
              } else if (page == 2) {
                afterPage  = afterPage + 1;
              }

              for (var plength = beforePage; plength <= afterPage; plength++) {
                if (plength > totalPages) { //if plength is greater than totalPage length then continue
                  continue;
                }
                if (plength == 0) { //if plength is 0 than add +1 in plength value
                  plength = plength + 1;
                }
                if(page == plength){ //if page is equal to plength than assign active string in the active variable
                  active = "active";
                }else{ //else leave empty to the active variable
                  active = "";
                }
                if(param)
                {
                    liTag += `<li class="numb ${active}" onclick="createPagination(totalPages, ${plength})"><a href="`+currentUrl+`&page=${plength}"><span>${plength}</span></a></li>`;
                }else
                {
                    liTag += `<li class="numb ${active}" onclick="createPagination(totalPages, ${plength})"><a href="`+currentUrl+`?page=${plength}"><span>${plength}</span></a></li>`;
                }
              }

              if(page < totalPages - 1){ //if page value is less than totalPage value by -1 then show the last li or page
                if(page < totalPages - 2){ //if page value is less than totalPage value by -2 then add this (...) before the last li or page
                  liTag += `<li class="dots"><span>...</span></li>`;
                }
                if(param)
                {
                    liTag += `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><a href="`+currentUrl+`&page=${totalPages}"><span>${totalPages}</span></a></li>`;
                }else
                {
                    liTag += `<li class="last numb" onclick="createPagination(totalPages, ${totalPages})"><a href="`+currentUrl+`?page=${totalPages}"><span>${totalPages}</span></a></li>`;
                }
              }

              if (page < totalPages) { //show the next button if the page value is less than totalPage(20)
                if(param)
                {
                    liTag += `<li class="btn next" onclick="createPagination(totalPages, ${page + 1})"><a href="`+currentUrl+`&page=${page + 1}"><span>Next <i class="fa fa-angle-right"></i></span></a></li>`;
                }else
                {
                    liTag += `<li class="btn next" onclick="createPagination(totalPages, ${page + 1})"><a href="`+currentUrl+`?page=${page + 1}"><span>Next <i class="fa fa-angle-right"></i></span></a></li>`;
                }

              }
              element.innerHTML = liTag; //add li tag inside ul tag
              return liTag; //reurn the li tag
            }


		</script>
        @yield('script')
	</body>
</html>
