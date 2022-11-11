@extends('layout')
@section('here')
<style>
    .dark-mode .note-editor.note-frame .note-editing-area .note-editable {
        background:white !important;
    }
    .commands-head
    {
        padding:16px;
    }
    .div-commands
    {
        border-radius:5px;
    }
    .dark-mode .model-wrapper-demo {
        background: #28273a;
    }
    .model-wrapper-demo {
        padding:0px;
    }
    .bot-commands .modal-footer
    {
        display:block;
    }
    .bot-commands .modal-header
    {
        background:#51a399;
    }
    .model-wrapper-demo .modal-dialog
    {
        border:1px solid #51a399 ;
        border-radius:5px;
    }
    .close 
    {
        color:white !important;
    }
    .glyph{
        position: relative;
        left: 23%;
        color: white;
        z-index: 2;
    }
</style>
<div class="page-header">
	<h4 class="page-title">Çat Bot</h4>
</div>
<!-- PAGE-HEADER END -->
<!-- ROW-1 OPEN -->
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-header">
				<div class="card-title">
				</div>
    			<div class="card-body">
    			    <div class="row">
    				    <span class="form-control" name="command_text" disabled>@if($command) {!! $command->text !!} @endif</span>
    			    </div>
    				</br>
    				<div class="bot-commands">
    				    @if($command)
    				    @foreach($command->messages as $message)
        				    <div class="command" > 
            				    <div class="model-wrapper-demo">
            					    <div class="modal-dialog modal-lg" role="document">
            							<div class="modal-content">
            								<div class="modal-header">
            									<h5 class="modal-title">Commands# <span class="btn btn-white btn-sm squence"></span></h5>
            									<span type="button" class="close"><i class="fa fa-comment"></i> Chat
            									</span>
            								</div>
            								<div class="modal-body">
            								    <div class="row">
            								        <div class="col-md-2">Başlıq</div>
            								        <div class="col-md-9">
            									        <input class="form-control" disabled value="{{ $message->title }}">
            								         </div>
            								    </div></br>
            								    <div class="row">
            								        <div class="col-md-2">Mesaj</div>
            								        <div class="col-md-9">
            									        <textarea class="form-control"  disabled>{!! $message->message !!}</textarea>
            								         </div>
            								    </div>
            					    		</div>
            								<div class="modal-footer">
            									@if($message->status==0)<span type="button" class="btn btn-warning pull-left" >Gözləyir</span>@elseif($message->status==1) <span type="button" class="btn btn-success pull-left" >İcra edildi</span> @else <span type="button" class="btn btn-danger pull-left" >Ləğv edildi</span> @endif
            								</div>
            							</div>
            						</div>
            					</div>
            				</div>
            				</br>
        				@endforeach
    				    @endif
    				    @if($command->images)
    				    @foreach($command->images as $image)
        				    <div class="command" > 
            				    <div class="model-wrapper-demo">
            					    <div class="modal-dialog modal-lg" role="document">
            							<div class="modal-content">
            								<div class="modal-header">
            									<h5 class="modal-title">Commands# <span class="btn btn-white btn-sm squence"></span></h5>
            									<span type="button" class="close"><i class="fa fa-image"></i> Image
            									</span>
            								</div>
            								<div class="modal-body">
            								    <div class="row">
            								        <div class="col-md-2">Şəkil</div>
            								        <div class="col-md-9">
            									        <img src="/storage/{{ $image->image }}" width="100" height="100">
            								         </div>
            								    </div>
            								    </br>
            								    <div class="row">
            								        <div class="col-md-2">Şəkil başlığı</div>
            								        <div class="col-md-9">
            									        <input   disabled class="form-control" value="{{ $image->caption }}">
            								         </div>
            								    </div>
            					    		</div>
            								<div class="modal-footer">
            									@if($image->status==0)<span type="button" class="btn btn-warning pull-left" >Gözləyir</span>@elseif($image->status==1) <span type="button" class="btn btn-success pull-left" >İcra edildi</span> @else <span type="button" class="btn btn-danger pull-left" >Ləğv edildi</span> @endif
            								</div>
            							</div>
            						</div>
            					</div>
            				</div></br>
    				    @endforeach
    				    @endif
    				    @if($command->addresses)
    				    @foreach($command->addresses as $address)
    				        <div class="command" > 
            				    <div class="model-wrapper-demo">
            					    <div class="modal-dialog modal-lg" role="document">
            							<div class="modal-content">
            								<div class="modal-header">
            									<h5 class="modal-title">Commands# <span class="btn btn-white btn-sm squence"></span></h5>
            									<span type="button" class="close"><i class="fa fa-map-marker"></i> Address
            									</span>
            								</div>
            								<div class="modal-body">
            								    <div class="row">
            								        <div class="col-md-2">Ünvan</div>
            								        <div class="col-md-9">
            									        <input name="address[]" disabled class="form-control" value="{{ $address->address }}">
            								         </div>
            								    </div>
            								    </br>
            								    <div class="row">
            								        <div class="col-md-2">Latitude</div>
            								        <div class="col-md-9">
            									        <input name="latitude[]" disabled class="form-control" value="{{ $address->latitude }}">
            								         </div>
            								    </div>
            								    </br>
            								    <div class="row">
            								        <div class="col-md-2">Longitude</div>
            								        <div class="col-md-9">
            									        <input name="longitude[]" disabled class="form-control" value="{{ $address->longitude }}">
            								         </div>
            								    </div>
            					    		</div>
            								<div class="modal-footer">
            									@if($address->status==0)<span type="button" class="btn btn-warning pull-left" >Gözləyir</span>@elseif($address->status==1) <span type="button" class="btn btn-success pull-left" >İcra edildi</span> @else <span type="button" class="btn btn-danger pull-left" >Ləğv edildi</span> @endif
            								</div>
            							</div>
            						</div>
            					</div>
            				</div></br>
    				    @endforeach
    				    @endif
    				    
    				    @if($command->videos)
    				    @foreach($command->videos as $video)
    				        <div class="command"> 
            				    <div class="model-wrapper-demo">
            					    <div class="modal-dialog modal-lg" role="document">
            							<div class="modal-content">
            								<div class="modal-header">
            									<h5 class="modal-title">Commands# <span class="btn btn-white btn-sm squence"></span></h5>
            									<span type="button" class="close"><i class="fa fa-video-camera"></i> Video
            									</span>
            								</div>
            								<div class="modal-body">
            								    <div class="row">
            								        <div class="col-md-2">Video</div>
            								        <div class="col-md-9">
            									        <video src="/storage/{{ $video->video }}" width="200" height="200"></video>
            								         </div>
            								    </div>
            								    </br>
            								    <div class="row">
            								        <div class="col-md-2">Video Başlığı</div>
            								        <div class="col-md-9">
            									        <input name="video_name[]" class="form-control" value="{{ $video->caption }}" required>
            								         </div>
            								    </div>
            					    		</div>
            								<div class="modal-footer">
            									@if($video->status==0)<span type="button" class="btn btn-warning pull-left" >Gözləyir</span>@elseif($video->status==1) <span type="button" class="btn btn-success pull-left" >İcra edildi</span> @else <span type="button" class="btn btn-danger pull-left" >Ləğv edildi</span> @endif
            								</div>
            							</div>
            						</div>
            					</div>
            				</div>
    				    @endforeach
    				    @endif
    				</div>
    			</div>
			<!-- TABLE WRAPPER -->
		</div>
		<!-- SECTION WRAPPER -->
	</div>
</div>

@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    // CKEDITOR.replace('command_text')
   
    $(document).ready(function()
    {
        squence()
    })
    
    function squence() {
            var squence = 0;
            $('.command').each(function () {
                $(this).find('.squence').text(++squence);
            })
    }
</script>
@endsection