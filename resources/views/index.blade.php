@extends('layout')
@section('here')
<div class="page-header">
    <h4 class="page-title">{{ Auth::user()->name }}, xoş gəlmisiniz</h4>
</div>

<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
				</div>
			</div>
			<div class="card-body">
			    @if(!empty($statics['messages_statistics']))
			    <div class="row">
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=1">
							<div class="card-body">
								<h6 class="mb-3">Göndərilib</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold"><i class="mdi mdi-wunderlist text-success mr-2"></i>{{ $statics['messages_statistics']['sent'] }}</h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=2">
							<div class="card-body">
								<h6 class="mb-3">Göndərilmədi</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold"><i class="fa fa-times text-danger mr-2"></i>{{ $statics['messages_statistics']['unsent'] }}</h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=3">
							<div class="card-body">
								<h6 class="mb-3">Ləğv edildi</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold"><i class="zmdi zmdi-layers-off text-warning mr-2"></i>{{ $statics['messages_statistics']['invalid'] }}</h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=4">
							<div class="card-body">
								<h6 class="mb-3">Müddəti bitdi</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold"><i class="mdi mdi-update text-secondary mr-2"></i>{{ $statics['messages_statistics']['expired'] }}</h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
					    <a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=5">
							<div class="card-body">
								<h6 class="mb-3">Növbədə</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold"><i class="mdi mdi-autorenew text-primary mr-2"></i>{{ $statics['messages_statistics']['queue'] }}</h2>
							</div>
						</a>
					</div>
				</div>	
				@else
				<h4 class="page-title">Hörmətli {{ Auth::user()->name }}, sizin hələ tokeniniz yoxdur!</h4>
				@endif
			</div>
			<!-- TABLE WRAPPER -->
		</div>
		<!-- SECTION WRAPPER -->
	</div>
</div>

@endsection
@section('script')


@endsection