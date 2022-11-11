@extends('layout')
@section('here')
    <div class="page-header">
    		<h4 class="page-title">Ümumi məlumatlar</h4>
    </div>
    <div class="row">
		<div class="col-md">
			<div class="card overflow-hidden">
				<div class="card-header">
				   <h3 class="card-title">Tənzimləmələr</h3> <span class="btn btn-info btn-sm checkNumber" style="margin-left:10px">Nömrəni yoxla</span> <a class="btn btn-primary btn-sm " href="/admin/company/whatsapp/profile" style="margin-left:10px">Whatsapp nömrəsi</a>
				</div>
				<div class="card-body">
				   @if($company)
    				    <p class="text-danger"><i class="fa fa-info"></i> Məlumatları dəyişrəkən ehtiyatlı olun və developerinizə xəbərdarlıq edin</p>
    				    <form  action="{{ url('/admin/company/edit') }}"  method="POST">
                          {{ csrf_field() }}
        	                <div class="row">
        	                    <div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Ad</label>
                        				<input class="form-control" name="c_name" value="{{ $company->c_name }}" >
                        			</div>
                        		</div>
                        		 <div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Məhsul şəxs</label>
                        				<input class="form-control" name="c_person_charge" value="{{ $company->c_person_charge }}" >
                        			</div>
                        		</div>
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Mesaj Emaili</label>
                        				<input class="form-control"  value="{{ $company->c_email }}" disabled>
                        			</div>
                        		</div>
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Şirkət telefonu</label>
                        				<input type="text" class="form-control" name="c_phone_call" placeholder="Şirkət telefonu" value="{{ $company->c_phone_call }}"> 
                        			</div>
                        		</div>
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Whatsapp nömrəsi</label>
                        				<input type="text" class="form-control" name="c_whatsapp_number" placeholder="Whatsapp nömrəsi" disabled value="{{ $company->c_whatsapp_number }}"> 
                        			</div>
                        		</div>
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Şifrə</label>
                        				<input type="text" class="form-control" name="c_password" placeholder="Şifrə"  value="">
                        			</div>
                        		</div>
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Ünvan</label>
                        				<input type="text" class="form-control" name="c_address" placeholder="Ünvan" value=" {{ $company->c_address }}">
                        			</div>
                        		</div>
                        		<div class="col-md-6">
                        			<div class="form-group">
                        				<label class="form-label">Status</label>
                        				<select type="text" class="form-control" name="c_environment_id">
                        				    <option {{ $company->c_environment_id ==1 ? "selected" : "" }} value="1">Production version</option>
                        				    <option {{ $company->c_environment_id ==2 ? "selected" : "" }} value="2">Test version</option>
                        				</select>
                        			</div>
                        		</div>
                        		
                        		 <div class="col-md-12 ">
                        			<div class="form-group">
                        				<span type"submit" class="btn btn-success-gradient">Yadda Saxla <i class="fa fa-check"></i></span>
                        			</div>
                        		</div>
                        	</div>
                    	</form>
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
    $('.checkNumber').click(function()
    {
        $.ajax({
            url: '/admin/checknumber',
            type:'post',
            data:{"_token": "{{ csrf_token() }}"},
            success:function(response)
            {
               if(response.status=='success')
               {
                  if(response.message==1)
                  {
                      alert('Whatsapp nömrəniz aktivdir')
                  }else if(response.message==2)
                  {
                      alert('Whatsapp nömrəniz aktiv deyil');
                  }else
                  {
                      alert('Şikət aktiv deyil')
                  }
               }
            }
        }) 
    })
    $('.btn-success-gradient').click(function()
    {
        $('form').submit()
    })
</script>

@endsection