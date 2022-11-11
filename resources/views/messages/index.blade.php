@extends('layout')
@section('here')
<div class="page-header">
	<h4 class="page-title">Mesajlar</h4>
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
			<div class="card-body">
				<div class="table-responsive">
				    <form action="" method="get">
				        <div class=" row">
                            <div class="col-md-2">
                                <label>Müştəri nömrəsi</label>
                    	        <input class="form-control" name="to_message" placeholder="Müştəri nömrəsi" value="@if(!empty($to_message)) {{ $to_message }} @endif">
                    	    </div>
                    	    <div class="col-md-2">
                    	        <div class="row">
                    	            <div class="col-md-12">
                    	                <label>Şirkət nömrəsi</label>
                            	        <input class="form-control" name="from_message" placeholder="Şirkət nömrəsi" value="@if(!empty($from_message)) {{ $from_message }} @endif">
                            	    </div>
                	            </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label>Mesaj tipi</label>
                    					<select class="form-control" name="chat_type_id">
                    		    		    <option @if(!empty($type) && $type==0) selected @endif value="0">Hamısı</option>
                    		    		    @foreach($chatypes as $t)
                    			    	    <option @if(!empty($type) && $type==$t->id) selected @endif value="{{ $t->id }}">{{ $t->title }}</option>
                    			    	    @endforeach
                    					</select>
                    				</div>
                    				
                    				<div class="col-md-3">
                                        <label>Göndəri s</label>
                    					<select class="form-control" name="send_status_id">
                    		    		    <option @if(!empty($s_status) && $s_status==0) selected @endif value="0">Hamısı</option>
                    		    		    @foreach($sendtstauses as $s_s)
                    			    	    <option @if(!empty($s_status) && $s_status==$s_s->id) selected @endif value="{{ $s_s->id }}">{{ $s_s->title }}</option>
                    			    	    @endforeach
                    					</select>
                    				</div>
                    				<div class="col-md-3">
                                        <label>Mesaj s</label>
                    					<select class="form-control" name="message_status_id">
                    		    		    <option @if(!empty($m_status) && $m_status==0) selected @endif value="0">Hamısı</option>
                    		    		    @foreach($messagestatuses as $m_s)
                    			    	    <option @if(!empty($m_status) && $m_status==$m_s->id) selected @endif value="{{ $m_s->id }}">{{ $m_s->title }}</option>
                    			    	    @endforeach
                    					</select>
                    				</div>
                    				<div class="col-md-3">
                                        <label>Priority</label>
                    					<select class="form-control" name="priority_id">
                    		    		    <option @if(!empty($priority) && $priority==0) selected @endif value="0">Hamısı</option>
                    		    		    @foreach($priorities as $p)
                    			    	    <option @if(!empty($priority) && $priority==$p->id) selected @endif value="{{ $p->id }}">{{ $p->title }}</option>
                    			    	    @endforeach
                    					</select>
                    				</div>
                            	 </div>
                            </div>
            						
            				<div class="col-md-3">
            				    <label>Tarix</label>
            					<div class="input-daterange input-group" data-plugin-datepicker>
            						<input type="date" class="form-control" name="bir"  value="{{ !empty($date1) ? $date1 : "" }}" style="margin-right:5px">
            						<input type="date" class="form-control" name="iki" value="{{ !empty($date2) ? $date2 : "" }}">
            					</div>
            				</div>
            				<input type="hidden" name="search" value="search">
            				<label class="col-md-1 control-label"></br><span type="submit" name="search" value="search" class="btn btn-info  " id="searchButton" style="margin-top:9px !important">Axtar</span></label>
            			</div>
				    </form>
				    <table class="table table-striped table-bordered text-nowrap w-100 dataTable no-footer">
				        <thead>
				            <tr>
				                <td>№</td>
				                <td>Müştəri</td>
				                <td>Şirkət nömrəsi</td>
				                <td>Mətn</td>
				                <td>Mesaj tipi</td>
				                <td>Göndəri statusu</td>
				                <td>Mesaj Statusu</td>
				                <td>Priority</td>
				                <td>Göndəri tarixi</td>
				            </tr>
				        </thead>
				        <tbody>
				            @foreach($messages as $key=>$message)
				             <tr>
				                 <td>
				                     {{ $currentpage+$key+1 }}
				                 </td>
				                 <td>{{ $message->to_message }}</td>
				                 <td>{{ $message->from_message }}</td>
				                 <td>{{ $message->body_message }}</td>
				                 <td>{{ $message->chatType['title'] }}</td>
				                 <td>{{ $message->sendStatus['title'] }}</td>
				                 <td>{{ $message->messageStatus['title'] }}</td>
				                 <td>{{ $message->priority['title'] }}</td>
				                 <td>{{ date('d.m.Y H:i:s',strtotime($message->message_sent_at)) }}</td>
				             </tr>
				            @endforeach
				        </tbody>
				        
				    </table>
				    </br>
				    <div class="pagination">
                      <ul> <!--pages or li are comes from javascript --> </ul>
                    </div></br>
                    <div class="excel"></div>
				</div>
			</div>
			<!-- TABLE WRAPPER -->
		</div>
		<!-- SECTION WRAPPER -->
	</div>
</div>

@endsection
@section('script')
<script>
    
    $('#searchButton').click(function()
    {
        $('form').submit();
    })
    $(document).ready(function(e)
    {
        if (e.keyCode == 13) {               
            $('form').submit();
        }
    })
    let searchParams2 = new URLSearchParams(window.location.search)
    searchParams2.has('search') // true
    let param2 = searchParams2.get('search')
    var excelUrl=window.location.href;
    if(param2)
    {
        $('.excel').append('<a href="'+excelUrl+'&export=true" class="btn btn-success">Download Excel</a>')
    }else
    {
        $('.excel').append('<a href="'+excelUrl+'?export=true" class="btn btn-success">Download Excel</a>')
    }
</script>

@endsection