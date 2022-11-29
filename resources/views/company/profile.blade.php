@extends('layout')
@section('here')
    <div class="page-header">
    		<h4 class="page-title">Ümumi məlumatlar</h4>
    </div>
    <div class="row">
		<div class="col-md">
			<div class="card overflow-hidden">
				<div class="card-header">
				   <h3 class="card-title">Profil</h3>
				</div>
				<div class="card-body">
				   @if($message)
				   <div class="row" id="user-profile">
						<div class="wideget-user">
							<div class="row">
								<div class="col-lg-12 col-md-12">
									<div class="wideget-user-desc d-flex">
										<div class="wideget-user-img">
											<img class="" src="{{  $message['profile_picture'] }}" width="150" height="150" alt="img">
										</div>
										<div class="user-wrap">
											<h4>{{ Auth::user()->name }}</h4>
											<h6 class="text-muted mb-3">Status: <span class="text-success">{{ $message['name'] }}</span></h6>
											<h6 class="text-muted mb-3">
                                                İsmarıc limiti:
                                                @if($messageLimit[0]['c_message_limit']===0)
                                                <span class="text-success">Limitsiz</span>
                                                @elseif($messageLimit[0]['c_message_limit']===1)
                                                    <span class="text-danger">Limitiniz bitdi!</span>
                                                @else
                                                    <span class="text-success">{{$messageLimit[0]['c_message_limit']}}</span>
                                                @endif
                                            </h6>
											<h6 class="text-muted mb-3">Whatsapp nömrə: <span class="text-success">+{{ str_replace("@c.us", "", $message['id']) }}</span></h6>
											<h6 class="text-muted mb-3">Business nömrə: @if($message['is_business']) <span class="text-success">Aktiv</span> @else <span class="text-danger"></span> @endif</h6>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
                	@else
                       <div class="row">
                           <h3 class="card-title">Şirkət məlumatlarınız aktiv deyil</h3>
                       </div>
                	@endif
                </div>
	        </div>
	   </div>
	</div>
@endsection
@section('script')

<script>
</script>

@endsection
