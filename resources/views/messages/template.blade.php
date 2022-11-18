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
                <div class="card-body">
                        <button class="btn btn-success add-template">
                            Əlavə et
                        </button>
                    <div class="row template-div text-left col-7">
                        <div class="col-md-12 d-flex">
                            <div class="d-flex align-items-end col-md-8">
                                <div class="w-100">
                                    <label>Başlıq</label>
                                    <input type="text" class="form-control header-input" name="header">
                                </div>
                            </div>
                            <div class="close-add float-right col-md-4" >
                                <button class="btn btn-warning close-btn">
                                    <i class="fa fa-close"></i>
                                </button>
                            </div>
                        </div>
                        <br>

                        <div class="col-md-8">
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
                                        <button class="btn btn-primary edit" data-toggle="modal">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </td>
                                    <td>
                                        <a class="del-btn" href="{{route('delete-template',['id'=>$template->id,])}}" type="submit" style="background-color: red;color: white;padding: 5px 10px;border-radius: 4px;text-decoration: none" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

        $('.close-btn').click(function (  ){
            $('.template-div').css('display','none');
            $('.add-template').css('display','block');
        })

        $('.del-btn').on('click',function (  ){
            let tr=$(this).closest('tr');
            tr.remove();
        })

        $('.add-template').click(function (  ){
            $(this).css('display','none');
            $('.template-div').css('display','block');
        })
        $('.save-template').click(function (  ){
            let subject = $( '.text-template' ).val().trim();
            let header = $( '.header-input' ).val().trim();
            $.ajax( {
                url: '/admin/add-template',
                type: 'post',
                data: {
                    'title': header,
                    'text':subject,
                    "_token": "{{ csrf_token() }}"
                },
                success: function ( res ) {
                        $( '.header-input' ).val('');
                        $( '.text-template' ).val('');

                        // $.each(res,function ( ){
                        //     $('tbody').append(`<tr>
                        //                     <td></td>
                        //                     <td>${res['id']}</td>
                        //                     <td>${res['title']}</td>
                        //                     <td>${res['text']}</td>
                        //                     <td>
                        //                         <button class="btn btn-primary edit" data-toggle="modal" data-target="#editGroup" title="Add Group">
                        //                             <i class="fa fa-pencil"></i>
                        //                         </button>
                        //                     </td>
                        //                     <td>
                        //                         <a class="del-btn" href="" type="submit" style="background-color: red;color: white;padding: 5px 10px;border-radius: 4px;text-decoration: none" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        //                             Sil</a>
                        //                         <form id="logout-form" action="" method="post" style="display: none;">
                        //
                        //         </form>
                        //     </td>
                        //               </tr>`);
                        // })


                }
            } )
        })

        $('.edit').on('click',function (  ){
            let tr=$(this).closest('tr');
            let tid= tr.find("td:eq(1)").text();
            let oldTitle= tr.find("td:eq(2)").text().trim();
            let oldText= tr.find("td:eq(3)").text().trim();

            tr.find("td:eq(2)").html(`<input type="text" class="form-control edit-title-inp" value="${oldTitle}" name="edit-title">`)
            tr.find("td:eq(3)").html(`<input type="text" class="form-control edit-text-inp" value="${oldText}" name="edit-text">`)
            tr.find("td:eq(4)").html(`<button class="btn btn-success save-new" data-toggle="modal">
                                            <i class="fa fa-save"></i>
                                        </button>
                                        <button class="btn btn-warning ban-btn" data-toggle="modal">
                                            <i class="fa fa-ban"></i>
                                        </button>`)

            $('.ban-btn').on('click',function (  ){
                tr.find("td:eq(2)").text(oldTitle)
                tr.find("td:eq(3)").text(oldText)
                tr.find("td:eq(4)").html(`<button class="btn btn-primary edit" data-toggle="modal">
                                            <i class="fa fa-pencil"></i>
                                        </button>`)
            })

            $('.save-new').on('click',function (  ){
                let newTitle=$('.edit-title-inp').val().trim();
                let newText=$('.edit-text-inp').val().trim();

                $.ajax({
                    type:"POST",
                    url:`http://localhost:8000/admin/edit-template/`+tid+``,
                    data:{
                        'title': newTitle,
                        'text':newText,
                        "_token": "{{ csrf_token() }}"
                    },
                    success:function (res){
                        if(res.status=="success"){
                            tr.find("td:eq(2)").text(newTitle)
                            tr.find("td:eq(3)").text(newText)
                            tr.find("td:eq(4)").html(`<button class="btn btn-primary edit" data-toggle="modal">
                                            <i class="fa fa-pencil"></i>
                                        </button>`)
                        }
                    },
                    error:function (xhr){
                    }
                });
            })
        })
    </script>
    @endsection
@endsection
