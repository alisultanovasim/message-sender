@extends('layout')
@section('here')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<div class="page-header">
    <h4 class="page-title">{{ Auth::user()->name }}, xoş gəlmisiniz</h4>
</div>

<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
                    <div class="date-filter">
                        <input id="date-1" type="date" value="2022-01-01"/><br>
                        <input id="date-2" type="date" value="2022-12-01"/>
                    </div>
                    <button class="btn btn-primary filter-by-date"><i class="fa fa-filter"></i></button>
				</div>
			</div>
			<div class="card-body">
			    @if(!empty($statics['messages_statistics']))
			    <div class="row">
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=1">
							<div class="card-body">
								<h6 class="mb-3">Göndərilib</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold sent-messages">
                                    <i class="mdi mdi-wunderlist text-success mr-2"></i>
                                    {{ $statics['messages_statistics']['sent'] }}
                                </h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=2">
							<div class="card-body">
								<h6 class="mb-3">Göndərilmədi</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold unsent-messages">
                                    <i class="fa fa-times text-danger mr-2"></i>
                                    {{ $statics['messages_statistics']['unsent'] }}
                                </h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=3">
							<div class="card-body">
								<h6 class="mb-3">Ləğv edildi</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold invalid-messages">
                                    <i class="zmdi zmdi-layers-off text-warning mr-2"></i>
                                    {{ $statics['messages_statistics']['invalid'] }}
                                </h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
						<a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=4">
							<div class="card-body">
								<h6 class="mb-3">Müddəti bitdi</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold expired-messages">
                                    <i class="mdi mdi-update text-secondary mr-2"></i>
                                    {{ $statics['messages_statistics']['expired'] }}
                                </h2>
							</div>
						</a>
					</div>
					<div class="col-sm-6 col-lg-6 col-xl-3">
					    <a class="card text-center" href="/admin/company_messages?search=search?&send_status_id=5">
							<div class="card-body">
								<h6 class="mb-3">Növbədə</h6>
								<h2 class="mb-2 text-white display-4 font-weight-bold queue-messages">
                                    <i class="mdi mdi-autorenew text-primary mr-2">
                                    </i>{{ $statics['messages_statistics']['queue'] }}
                                </h2>
							</div>
						</a>
					</div>
                    <div class="col-sm-6 col-lg-6 col-xl-3">
                        <a class="card text-center">
                            <div class="card-body">
                                <h6 class="mb-3">Cəmi</h6>
                                <h2 class="mb-2 text-white display-4 font-weight-bold total-messages">
                                    <i class="mdi mdi-database text-primary mr-2"></i>
                                    {{   $statics['messages_statistics']['sent']+
                                         $statics['messages_statistics']['unsent']+
                                         $statics['messages_statistics']['invalid']+
                                         $statics['messages_statistics']['expired']+
                                         $statics['messages_statistics']['queue']
                                    }}</h2>
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
<script>
    $('.filter-by-date').click(function (  ){
        let from=$('#date-1').val().trim();
        let to=$('#date-2').val().trim();

        $.ajax({
            type:"GET",
            url:"/admin/date-filter",
            data:{
                "from":from,
                "to":to,
                "c_id":{{auth()->user()->c_id}}
            },
            success:function ( res ){
                $.each(res.data, function () {
                    let total=parseInt(res.data['sent']+res.data['invalid']+res.data['unsent']+res.data['expired']+res.data['queue']);
                     $('.sent-messages').html(`<i class="mdi mdi-wunderlist text-success mr-2"></i>${res.data['sent']}`)
                     $('.unsent-messages').html(`<i class="fa fa-times text-danger mr-2"></i>${res.data['unsent']}`)
                     $('.invalid-messages').html(`<i class="zmdi zmdi-layers-off text-warning mr-2"></i>${res.data['invalid']}`)
                     $('.expired-messages').html(`<i class="mdi mdi-update text-secondary mr-2"></i>${res.data['expired']}`)
                     $('.queue-messages').html(`<i class="mdi mdi-autorenew text-primary mr-2"></i>${res.data['queue']}`)
                     $('.total-messages').html(`<i class="mdi mdi-database text-primary mr-2"></i>${total}`)
                });

            }
        })
    })
</script>

@endsection
@section('script')


@endsection
