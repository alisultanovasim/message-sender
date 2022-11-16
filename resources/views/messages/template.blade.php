@extends('layout')
@section('here')
    <style>
        .template-div{
            display: none;
        }
    </style>
    <div class="page-header">
        <h4 class="page-title">Şablonlar</h4>
    </div>

    <!-- PAGE-HEADER END -->
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-md-12 col-lg-12">
            <div class="card">
                <div class="card-body text-right">
                        <button class="btn btn-success add-template">
                            Əlavə et
                        </button>
                    <div class="row template-div text-left col-7">
                        <div class="col-md-12">

                            <div class="d-flex align-items-end">
                                <div class="w-100">
                                    <label>Başlıq</label>
                                    <input type="text" class="form-control header-input" name="header">
                                </div>
                            </div>
                        </div>
                        <br>

                        <div class="col-md-12">
                            <label>Mətn</label>
                            <textarea class="form-control text-template"  name="message" ></textarea>
                        </div>
                        </br>
                        <div class="col-md-12 text-center" style="margin-top:5px">
                            <span class="btn btn-success save-template col-md-2"><i class="fa fa-telegram"></i> Əlavə et</span>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table text-center table-striped table-bordered text-nowrap w-100 dataTable no-footer">
                            <thead>
                            <tr>
                                <td>№</td>
                                <td>ID</td>
                                <td>Başlıq</td>
                                <td>Mətn</td>
                                <th>Redaktə</th>
                                <th>Sil</th>
                            </tr>
                            </thead>
                            @foreach($templates as $key=>$template)
                                <tbody id="tbody">
                                <tr id="body_tr">
                                    <td>{{$key+1}}</td>
                                    <td>{{$template->id}}</td>
                                    <td>{{$template->title}}</td>
                                    <td>{{$template->text}}</td>
                                    <td>
                                        <button class="btn btn-primary edit" data-toggle="modal" data-target="#editGroup" title="Add Group">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a href="{{route('delete-template',['id'=>$template->id,])}}" type="submit" style="background-color: red;color: white;padding: 5px 10px;border-radius: 4px;text-decoration: none" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            Sil</a>
                                        <form id="logout-form" action="{{route('delete-template',['id'=>$template->id])}}" method="post" style="display: none;">
                                            @csrf
                                        </form>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        </table>
                        </br>
{{--                        {{$messages->onEachSide(1)->links()}}--}}
                        {{--				    <div class="pagination">--}}
                        {{--                      <ul> <!--pages or li are comes from javascript --> </ul>--}}
                        {{--                    </div></br>--}}
                    </div>
                </div>
                <!-- TABLE WRAPPER -->
            </div>
            <!-- SECTION WRAPPER -->
        </div>
    </div>
{{--    <script src="{{ asset('admin/assets/js/vendors/jquery-3.2.1.min.js') }}"></script>--}}
    @section('script')
    <script>

        $('.add-template').click(function (  ){
            $(this).css('display','none');
            $('.template-div').css('display','block');
        })
        $('.save-template').click(function (  ){
            let text = $( '.text-template' ).val().trim();
            let title = $( '.header-input' ).val().trim();
            $.ajax( {
                url: '/admin/add-template',
                type: 'post',
                data: {
                    'title': title,
                    'text':text,
                    "_token": "{{ csrf_token() }}"
                },
                success: function ( response ) {
                    if ( response.status == 'success' ) {
                        $( '.header-input' ).val('');
                        $( '.text-template' ).val('');
                    } else if ( response.status == "error" ) {
                        alert( response.message )
                    }
                }
            } )
        })

        $('.edit').on('click',function (  ){
            let tr=$(this).closest('tr');
            let tid= tr.find("td:eq(1)").text();
            $.ajax({
                type:"POST",
                url:`http://localhost:8000/admin/edit-template/`+tid+``,
                data:{
                    'title': title,
                    'text':text,
                    "_token": "{{ csrf_token() }}"
                },
                success:function (res){
                    if(res.status=="Error: Survey does not pass consistency check"){
                        alert('Error');
                    }
                },
                error:function (xhr){
                }
            });
        })
    </script>
    @endsection
@endsection
