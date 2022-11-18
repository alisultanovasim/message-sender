@extends('layout')
@section('here')
    <style>
        .dark-mode .note-editor.note-frame .note-editing-area .note-editable {
            background: white !important;
        }

        .commands-head {
            padding: 16px;
        }

        .div-commands {
            border-radius: 5px;
        }

        .dark-mode .model-wrapper-demo {
            background: #28273a;
        }

        .model-wrapper-demo {
            padding: 0px;
        }

        .bot-commands .modal-footer {
            display: block;
        }

        .bot-commands .modal-header {
            background: #51a399;
        }

        .model-wrapper-demo .modal-dialog {
            border: 1px solid #51a399;
            border-radius: 5px;
        }

        .close {
            color: white !important;
        }

        .glyph {
            position: relative;
            left: 23%;
            color: white;
            z-index: 2;
        }

        .sendmessage {
            width: 90px;
            margin-top: 10px;
            float: left;
        }

        .count_recipients {
            float: right;
        }

        .recipient_select {
            padding: 5px 10px;
            width: 90px;
            background-color: #77c8ce;
            border-radius: 10px;
            margin-top: -20px;
            margin-right: -20px;
        }
        #numbers-list{
            display: none;
            margin-top: 10px;
        }
        .add-number-btn{
            display: none;
        }
        .numbers-label{
            display: none;
        }
        .send-collection-message{
            display: none;
            width: 90px;
            margin-top: 10px;
        }
    </style>
    <div class="page-header">
        <h4 class="page-title">Mesaj Yarat</h4>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- ROW-1 OPEN -->
    <div class="row">
        <div class="col-md-6 col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-body">
                        <div class="count_recipients">
                            <select class="form-select recipient_select">
                                <option selected>Tək</option>
                                <option value="1">Toplu</option>
                            </select>
                        </div>
                        <div class="row number-div">
                            <div class="col-md-12">

                                <div class="d-flex align-items-end">
                                    <div class="w-100">
                                        <label>Telefon nömrəsi</label>
                                        <div class="d-flex">
                                            <select name="" id="" class="form-control col-md-3 text-center num-head">
                                                <option value="99450">050</option>
                                                <option value="99451">051</option>
                                                <option value="99455">055</option>
                                                <option value="99499">099</option>
                                                <option value="99470">070</option>
                                                <option value="99477">077</option>
                                            </select>
                                            <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="7" type="number" class="form-control number-input" name="telephone" />
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        <button class="btn btn-success add-number-btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12" style="margin-top: 10px">

                                <select class="col-md-3 form-control template-select" name="templates" id="">
                                    <option value="" selected disabled hidden>Şablon</option>
                                    <option value="no-one">Heç biri</option>
                                    @foreach($templates as $template)
                                    <option class="template-option" value="{{$template->id}}">{{$template->title}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <br>
                            <div class="col-md-12 numbers">
                                <label class="numbers-label">Nömrələr</label>
                                <textarea class="form-control"  name="" id="numbers-list"></textarea>
                            </div>
                            </br>

                            <div class="col-md-12 message-area">
                                <label>Mesaj</label>
                                <textarea class="form-control"  name="message" ></textarea>
                            </div>
                            </br>
                            <div class="col-md-12 text-center" style="margin-top:5px">
                                <span class="btn btn-success sendmessage col-md-6"><i class="fa fa-telegram"></i> Göndər</span>
                                <span class="btn btn-success send-collection-message col-md-3"><i class="fa fa-telegram"></i> Göndər</span>
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

                $( document ).ready( function () {
                    squence()
                } )


                $( '.sendmessage' ).click( function () {
                    var templateId=$('.template-select option:selected').val();
                    var numHead=$('.num-head option:selected').val();
                    var numBody = $( '[name=telephone]' ).val();
                    var telephone=numHead+numBody;
                    var message = $( '[name=message]' ).val();
                    var numLength=telephone.length;
                    if (  numLength> 12 || numLength<10 || telephone == null ) {
                        alert( 'Telefon nömrəsi düzgün deyil' )
                    }
                    if(templateId==''){
                    if ( !message ) {
                            alert( 'Mesaj boş qoyula bilməz' )
                        }
                        $.ajax( {
                            url: '/admin/company_add_message_post',
                            type: 'post',
                            data: { 'telephone': telephone,
                                'message': message,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function ( response ) {
                                if ( response.status == 'success' ) {
                                    alert( 'Mesaj göndərildi' );
                                    location.reload();
                                } else if ( response.status == "error" ) {
                                    alert( response.message )
                                } else {
                                    alert( 'Sistem Xətası' )
                                }
                            }
                        } )
                    }
                     else {
                        $.ajax( {
                            url: '/admin/company_add_message_post',
                            type: 'post',
                            data: { 'telephone': telephone,
                                    'templateId':templateId,
                                    "_token": "{{ csrf_token() }}"
                            },
                            success: function ( response ) {
                                if ( response.status == 'success' ) {
                                    alert( 'Mesaj göndərildi' );
                                    location.reload();
                                } else if ( response.status == "error" ) {
                                    alert( response.message )
                                } else {
                                    alert( 'Sistem Xətası' )
                                }
                            }
                        } )
                    }
                } );
                $(document).ready(function(){
                    $('.template-select').on('change', function(){
                        var demovalue = $(this).val();
                        $('.message-area').hide();
                    });
                });

                let numberArray=[];
                let numberString;
                $( '.recipient_select' ).click( function () {

                    let selected = $( this ).find( ":selected" ).val();
                    if ( selected == 1 ) {
                        $('.sendmessage').css('display','none');
                        $('.send-collection-message').css('display','block');
                        $('#numbers-list').css('display','block');
                        $('.numbers-label').css('display','block');

                        $('.add-number-btn').css('display','block').click(function (  ){
                            var numHead=$('.num-head option:selected').val();
                            var numBody = $( '[name=telephone]' ).val();
                            var number=numHead+numBody;
                            numberArray.push(number);
                            numberString=numberArray.join(",");
                            $('#numbers-list').val(numberString);
                        })
                        $('.send-collection-message').click(function (  ){
                            let message = $( '[name=message]' ).val();
                            $.ajax( {
                                url: '/admin/send-collection-message',
                                type: 'post',
                                data: {
                                    'telephone': numberString,
                                    'message':message,
                                    "_token": "{{ csrf_token() }}"
                                },
                                success: function ( response ) {
                                    if ( response.status == 'success' ) {
                                        console.log(response)
                                    } else if ( response.status == "error" ) {
                                        alert( response.message )
                                    } else {
                                        alert( 'Sistem Xətası' )
                                    }
                                }
                            } )
                        })
                    } else {
                        $('.send-collection-message').css('display','none');
                        $('.sendmessage').css('display','block');
                        $( '.add-number-btn' ).css('display','none');
                        $('#numbers-list').css('display','none');
                        $('.numbers-label').css('display','none');
                    }
                } )

            </script>
@endsection
