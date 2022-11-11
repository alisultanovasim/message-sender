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
			</div>
			<form class="form-command" action="/admin/addcommands" method="post" enctype="multipart/form-data">
			    @csrf
			
    			<div class="card-body">
    			    @if(Session::get('status')=="success")
                            <div class="alert alert-{{ Session::get('status') }}">
								<span type="button" class="close" data-dismiss="alert" aria-hidden="true">×</span>
								 <strong>Success</strong>
								<hr class="message-inner-separator">
									<p>{{ Session::get('message') }}</p>
							</div>
    			    @endif
    			    @if(Session::get('status')=="error")
                            <div class="alert alert-danger">
								<span type="button" class="close" data-dismiss="alert" aria-hidden="true">×</span>
								 <strong>Error</strong>
								<hr class="message-inner-separator">
									<p>{{ Session::get('message') }}</p>
							</div>
    			    @endif
    				<textarea class="form-control" name="command_text" required>{!! $command ? $command->text : null !!}</textarea>
    				</br>
    				<div class="row">
    				    <div class="col-md-12">
    				        <div class="bg-dark div-commands">
    				            <div class="row commands-head"> 
    				                <div class="col-md-6">
    				                    <h3 class="">Bot Commands</h3>
    				                </div>
    				                <div class="col-md-6">
    				                    <div class="dropdown pull-right">
    										<span type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
    											<i class="fe fe-plus mr-2"></i> Add Commands
    										</span>
    										<div class="dropdown-menu">
    											<span class="dropdown-item add-chat-type" data-id="1"><i class="fa fa-comment"></i> Chat</span>
    											<span class="dropdown-item add-chat-type" data-id="2"><i class="fa fa-image"></i> Image</span>
    											<span class="dropdown-item add-chat-type" data-id="3"><i class="fa fa-map-marker"></i> Location</span>
    											<span class="dropdown-item add-chat-type" data-id="4"><i class="fa fa-video-camera"></i> Video</span>
    										</div>
    									</div>
    				                </div>
    				            </div>
    				        </div>
    				    </div>
    				    <div class="col-md-12 bot-commands">
    				      
    				    </div></br>
    				    <div class="col-md-12 text-center">
    				        <span><i class="fa fa-save glyph"></i></span>
    				        <input class="btn btn-success  col-md-6" type="submit" value=" Save">   
    				     </div>
    				</div>
    			</div>
			</form>
			<!-- TABLE WRAPPER -->
		</div>
		<!-- SECTION WRAPPER -->
	</div>
</div>

@endsection
@section('script')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    $('.save').click(function()
    {
        $('.form-command').submit();
    })
    CKEDITOR.replace('command_text')
    $('.add-chat-type').click(function()
    {
        var id=$(this).attr('data-id');
        var count=$('.command').length;
        var orjinalCount='{{ $count }}';
        if(parseInt(orjinalCount)+count>=10)
        {
            alert('Command limiti dolub');
            return false;
        }
        if(id==1)
        {
            $('.bot-commands').prepend(`
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
									        <input class="form-control" required name="title[]">
								         </div>
								    </div></br>
								    <div class="row">
								        <div class="col-md-2">Mesaj</div>
								        <div class="col-md-9">
									        <textarea class="form-control" required name="message[]"></textarea>
								         </div>
								    </div>
					    		</div>
								<div class="modal-footer">
									<span type="button" class="btn btn-danger pull-left btn-del" ><i class="fa fa-trash"></i> </span>
								</div>
							</div>
						</div>
					</div>
				</div>
            `)
        }else if(id==2)
        {
            $('.bot-commands').prepend(`
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
								        <div class="col-md-2">Şəkil</div>
								        <div class="col-md-9">
									        <input name="image[]" type="file" required accept="image/*" class="form-control" placeholder="">
								         </div>
								    </div>
								    </br>
								    <div class="row">
								        <div class="col-md-2">Şəkil başlığı</div>
								        <div class="col-md-9">
									        <input name="image_name[]" required class="form-control" placeholder="">
								         </div>
								    </div>
					    		</div>
								<div class="modal-footer">
									<span type="button" class="btn btn-danger pull-left btn-del" ><i class="fa fa-trash"></i> </span>
								</div>
							</div>
						</div>
					</div>
				</div>
            `)
        }
        else if(id==3)
        {
            $('.bot-commands').prepend(`
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
								        <div class="col-md-2">Ünvan</div>
								        <div class="col-md-9">
									        <input name="address[]" required class="form-control" placeholder="">
								         </div>
								    </div>
								    </br>
								    <div class="row">
								        <div class="col-md-2">Latitude</div>
								        <div class="col-md-9">
									        <input name="latitude[]" required class="form-control" placeholder="">
								         </div>
								    </div>
								    </br>
								    <div class="row">
								        <div class="col-md-2">Longitude</div>
								        <div class="col-md-9">
									        <input name="longitude[]" required class="form-control" placeholder="">
								         </div>
								    </div>
					    		</div>
								<div class="modal-footer">
									<span type="button" class="btn btn-danger pull-left btn-del" ><i class="fa fa-trash"></i> </span>
								</div>
							</div>
						</div>
					</div>
				</div>
            `)
        }
        else if(id==4)
        {
            $('.bot-commands').prepend(`
                <div class="command"> 
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
								        <div class="col-md-2">Video</div>
								        <div class="col-md-9">
									        <input name="video[]" type="file" class="form-control" placeholder="" required>
								         </div>
								    </div>
								    </br>
								    <div class="row">
								        <div class="col-md-2">Video Başlığı</div>
								        <div class="col-md-9">
									        <input name="video_name[]" class="form-control" placeholder="" required>
								         </div>
								    </div>
					    		</div>
								<div class="modal-footer">
									<span type="button" class="btn btn-danger pull-left btn-del" ><i class="fa fa-trash"></i> </span>
								</div>
							</div>
						</div>
					</div>
				</div>
            `)
        }
        squence();
    })
    
    
    function squence() {
            var squence = 0;
            $('.command').each(function () {
                $(this).find('.squence').text(++squence);
            })
    }
    $(document).on('click', '.btn-del', function(e){
        $(this).parents('.command').remove();
        squence();
    });
</script>
@endsection