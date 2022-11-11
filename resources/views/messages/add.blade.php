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
	<h4 class="page-title">Mesaj Yarat</h4>
</div>
<!-- PAGE-HEADER END -->
<!-- ROW-1 OPEN -->
<div class="row">
	<div class="col-md-12 col-lg-12">
		<div class="card">
			<div class="card-header">
    			<div class="card-body">
    			    <div class="row">
    				    <div class="col-md-12">
    				        <label>Telefon nömrəsi</label>
    				        <input class="form-control" name="telephone" value="994">
    				    </div>
    				    </br>
    				   
    				    <div class="col-md-12">
    				         <label>Mesaj</label>
    				        <textarea class="form-control" name="message">
    				            
    				        </textarea>
    				    </div>
    				    </br>
    				    <div class="col-md-12 text-center" style="margin-top:5px">
    				        <span class="btn btn-success sendmessage col-md-6"><i class="fa fa-telegram"></i> Göndər</span>    
    				    </div>
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
    
    $('.sendmessage').click(function()
    {
        var telephone=$('[name=telephone]').val();
        var message=$('[name=message]').val();
        if(telephone.length!=12 || telephone==null)
        {
            alert('Telefon nömrəsi düzgün deyil')
        }else if(!message)
        {
            alert('Mesaj boş qoyula bilməz')
        }else
        {
            $.ajax({
                    url: '/admin/company_add_message_post',
                    type:'post',
                    data:{'telephone':telephone,'message':message,"_token": "{{ csrf_token() }}"},
                    success:function(response)
                    {
                       if(response.status=='success')
                       {
                          alert('Mesaj göndərildi');
                          location.reload();
                       }else if(response.status=="error")
                       {
                           alert(response.message)
                       }else
                       {
                           alert('Sistem Xətası')
                       }
                     }
                }) 
        }
    });
</script>
@endsection