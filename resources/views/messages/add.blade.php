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

        .send-image{
            width: 90px;
            margin-top: 10px;
            float: left;
        }

        .send-collection-image{
            display: none;
            width: 90px;
            margin-top: 10px;
        }

        .count_recipients {
            float: right;
        }

        .recipient_select {
            padding: 5px 10px;
            width: 90px;
            color: white;
            background-color: #2d2c40;
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
        body {
            background-color: #222;
        }

        .numbers-label-img{
            display: none;
        }
        #numbers-list-img{
            display: none;
            margin-top: 10px;
        }


        #loading-wrapper {
            position: fixed;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            display: none;
        }

        #loading-text {
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            color: #999;
            width: 100px;
            height: 30px;
            margin: -7px 0 0 -45px;
            text-align: center;
            font-family: 'PT Sans Narrow', sans-serif;
            font-size: 20px;
        }

        #loading-content {
            display: block;
            position: relative;
            left: 50%;
            top: 50%;
            width: 170px;
            height: 170px;
            margin: -85px 0 0 -85px;
            border: 3px solid #F00;
        }

        #loading-content:after {
            content: "";
            position: absolute;
            border: 3px solid #0F0;
            left: 15px;
            right: 15px;
            top: 15px;
            bottom: 15px;
        }

        #loading-content:before {
            content: "";
            position: absolute;
            border: 3px solid #00F;
            left: 5px;
            right: 5px;
            top: 5px;
            bottom: 5px;
        }

        #loading-content {
            border: 3px solid transparent;
            border-top-color: #564ec1;
            border-bottom-color: #564ec1;
            border-radius: 50%;
            -webkit-animation: loader 2s linear infinite;
            -moz-animation: loader 2s linear infinite;
            -o-animation: loader 2s linear infinite;
            animation: loader 2s linear infinite;
        }

        #loading-content:before {
            border: 3px solid transparent;
            border-top-color: white;
            border-bottom-color: white;
            border-radius: 50%;
            -webkit-animation: loader 3s linear infinite;
            -moz-animation: loader 2s linear infinite;
            -o-animation: loader 2s linear infinite;
            animation: loader 3s linear infinite;
        }

        #loading-content:after {
            border: 3px solid transparent;
            border-top-color: #84417C;
            border-bottom-color: #84417C;
            border-radius: 50%;
            -webkit-animation: loader 1.5s linear infinite;
            animation: loader 1.5s linear infinite;
            -moz-animation: loader 2s linear infinite;
            -o-animation: loader 2s linear infinite;
        }

        @-webkit-keyframes loaders {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        @keyframes loader {
            0% {
                -webkit-transform: rotate(0deg);
                -ms-transform: rotate(0deg);
                transform: rotate(0deg);
            }
            100% {
                -webkit-transform: rotate(360deg);
                -ms-transform: rotate(360deg);
                transform: rotate(360deg);
            }
        }

        #content-wrapper {
            color: #FFF;
            position: fixed;
            left: 0;
            top: 20px;
            width: 100%;
            height: 100%;
        }

        #header
        {
            width: 800px;
            margin: 0 auto;
            text-align: center;
            height: 100px;
            background-color: #666;
        }

        #content
        {
            width: 800px;
            height: 1000px;
            margin: 0 auto;
            text-align: center;
            background-color: #888;
        }
        .alert-area{
            display: none;
            border-radius: 20px;
            margin-top:15px ;
        }
        .text-message{
            display: none;
        }
        .image-message{
            display: none;
        }

    </style>
    <div id="loading-wrapper">
        <div id="loading-text">Göndərilir</div>
        <div id="loading-content"></div>
    </div>

    <div class="alert alert-success col-12 text-center alert-area" role="alert">
        <strong>İsmarıc göndərildi!</strong>
    </div>

    <div class="page-header">
        <h4 class="page-title">Mesaj Yarat</h4>
    </div>
    <!-- PAGE-HEADER END -->
    <!-- ROW-1 OPEN -->
    <div class="row card-head-div">
        <div class="col-md-3 col-lg-3 type-message">
            <button class="btn btn-light image-m-btn">Şəkilli mesaj</button>
            <button class="btn btn-light text-m-btn">Mətn mesajı</button>
        </div>
        <div class="col-md-6 col-lg-6 text-message">
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
                            <div style="margin-left: 17px">
{{--                                <button style="display:block" class="btn btn-info excelFileBtn" onclick="document.getElementById('excelFile').click()"><i class="fa fa-plus"></i> Excel</button>--}}
                                <label for="excelFile">Excel əlavə et</label>
                                <input style="display: block" name="excelFile" id="excelFile" type="file" class="form-control col-md-7" accept=".xlsx">
                            </div>

                            <div class="col-md-12 numbers-div">

                                <div class="d-flex align-items-end" >
                                    <div class="w-100">
                                        <label>Telefon nömrəsi</label>
                                        <div class="d-flex">
                                            <select name="" id="" class="form-control col-md-3 text-center num-head">
                                                <option value="99450">050</option>
                                                <option value="99451">051</option>
                                                <option value="99455">055</option>
                                                <option value="99499">099</option>
                                                <option value="99470">070</option>
                                                <option selected value="99477">077</option>
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
        <div class="col-md-6 col-lg-6 image-message">
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
                            <div style="margin-left: 17px">
{{--                                <button style="display:block" class="btn btn-info excelFileBtn" onclick="document.getElementById('excelFile').click()"><i class="fa fa-plus"></i> Excel</button>--}}
                                <label for="excelFileForImg">Excel əlavə et</label>
                                <input style="display: block" id="excelFileForImg" name="excelFileForImg" type="file" class="form-control col-md-7">
                            </div>
                            <div class="col-md-12 numbers-div">

                                <div class="d-flex align-items-end">
                                    <div class="w-100">
                                        <label>Telefon nömrəsi</label>
                                        <div class="d-flex">
                                            <select name="" id="" class="form-control col-md-3 text-center num-head-img">
                                                <option value="99450">050</option>
                                                <option value="99451">051</option>
                                                <option value="99455">055</option>
                                                <option value="99499">099</option>
                                                <option value="99470">070</option>
                                                <option selected value="99477">077</option>
                                            </select>
                                            <input oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" maxlength="7" type="number" class="form-control number-input" name="phoneBodyImg" />
                                        </div>
                                    </div>
                                    <div class="ml-2">
                                        <button class="btn btn-success add-number-btn"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12 numbers">
                                <label class="numbers-label-img">Nömrələr</label>
                                <textarea class="form-control"  name="" id="numbers-list-img"></textarea>
                            </div>
                            </br>

                            <div class="col-md-6 message-area" style="margin-top: 10px">
{{--                                <button style="display:block;background-color: #c09322" class="btn btn-dark imageFileBtn" onclick="document.getElementById('imageFile').click()"><i class="fa fa-plus"></i> Şəkil</button>--}}
                                <label for="imageLink">Şəkil əlavə et</label>
                                <input style="display: block" id="imageLink" type="text" class="form-control" placeholder="Şəkil üçün link əlavə edin">
{{--                                <input style="display: block" id="imageFile" type="file" class="form-control col-md-12">--}}
                            </div>
                            </br>
                            <div class="col-md-12 text-center" style="margin-top:5px">
                                <span class="btn btn-success send-image col-md-6"><i class="fa fa-telegram"></i> Göndər</span>
                                <span class="btn btn-success send-collection-image col-md-3"><i class="fa fa-telegram"></i> Göndər</span>
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
                    $('.template-select').on('change', function(){
                        $('.message-area').hide();
                    });
                } )

                $('.text-m-btn').on('click',function (  ){
                    $('.text-message').css('display','block');
                    $('.image-message').css('display','none');
                })

                $('.image-m-btn').on('click',function (  ) {
                    $('.image-message').css('display','block');
                    $('.text-message').css('display','none');
                })

                function successFunc( ) {
                    $('.alert-success').css('display','block');
                    $('.card-head-div').css('display','block');
                    $('.page-header').css('display','block');
                    $('#loading-wrapper').css('display','none');
                    window.setTimeout(function() {
                        $(".alert-area").fadeTo(500, 0).slideUp(500, function(){
                            $(this).remove();
                        });
                    }, 3000);
                }

                function errorFunc(  ) {
                    $('.alert-success').css('display','none');
                    $('.card-head-div').css('display','block');
                    $('.page-header').css('display','block');
                    $('#loading-wrapper').css('display','none');
                }


                $( '.sendmessage' ).click( function () {
                    var formData = new FormData();
                    formData.append('excelFile', $('#excelFile')[0].files[0]);

                    $.ajax({
                        url : '/api/import',
                        type : 'POST',
                        data : formData,
                        processData: false,  // tell jQuery not to process the data
                        contentType: false,  // tell jQuery not to set contentType
                        success : function(data) {
                            console.log(data);
                        }
                    });

                    $.ajax({
                        url: '/api/send',
                        type: 'post',
                        data: {
                            'message': message,
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function ( response ) {
                            if(response.status=='success'){
                                alert(response.message);
                            }
                            else if(response.status=='error'){
                                alert(response.message);
                            }
                        }
                    } )


                    $('.card-head-div').css('display','none');
                    $('.page-header').css('display','none');
                    $('#loading-wrapper').css('display','block');

                    var templateId=$('.template-select option:selected').val();
                    var numHead=$('.num-head option:selected').val();
                    var numBody = $( '[name=telephone]' ).val();
                    var telephone=numHead+numBody;
                    var message = $( '[name=message]' ).val();
                    var numLength=telephone.length;
                    if (  numLength> 12 || numLength<10 || telephone == null ) {
                        alert( 'Telefon nömrəsi düzgün deyil' );
                        $('.alert-success').css('display','none');
                        $('.card-head-div').css('display','block');
                        $('.page-header').css('display','block');
                        $('#loading-wrapper').css('display','none');
                    }
                    if(templateId==''){
                    if ( !message ) {
                            alert( 'Mesaj boş qoyula bilməz' );
                        $('.alert-success').css('display','none');
                        $('.card-head-div').css('display','block');
                        $('.page-header').css('display','block');
                        $('#loading-wrapper').css('display','none');
                        }
                    else{
                        $.ajax( {
                            url: '/admin/company_add_message_post',
                            type: 'post',
                            data: { 'telephone': telephone,
                                'message': message,
                                "_token": "{{ csrf_token() }}"
                            },
                            success: function ( response ) {
                                if ( response.status == 'success' ) {
                                    successFunc();
                                } else if ( response.status == "error" ) {
                                    errorFunc();
                                    alert( response.message )
                                } else {
                                    errorFunc();
                                    alert( 'Sistem Xətası' )
                                }
                            }
                        } )
                    }

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
                                    successFunc();
                                } else if ( response.status == "error" ) {
                                    errorFunc();
                                    alert( response.message )
                                } else {
                                    errorFunc();
                                    alert( 'Sistem Xətası' )
                                }
                            }

                        } )
                    }
                } );

                let numberArray=[];
                let numberString;
                $( '.recipient_select' ).click( function () {

                    let selected = $( this ).find( ":selected" ).val();
                    if ( selected == 1 ) {
                        $('.sendmessage').css('display','none');
                        $('.send-image').css('display','none');
                        $('.send-collection-message').css('display','block');
                        $('.send-collection-image').css('display','block');
                        $('#numbers-list').css('display','block');
                        $('#numbers-list-img').css('display','block');
                        $('.numbers-label').css('display','block');
                        $('.numbers-label-img').css('display','block');

                        $('.add-number-btn').css('display','block').click(function (  ){
                            var numHead=$('.num-head option:selected').val();
                            var numBody = $( '[name=telephone]' ).val();
                            var number=numHead+numBody;
                            numberArray.push(number);
                            numberString=numberArray.join(",");
                            $('#numbers-list').val(numberString);
                        })
                        $('.send-collection-message').click(function (  ){
                            if($.isEmptyObject(numberString)){
                                alert('Nömrə hissəsi boş qala bilməz')
                                $('.alert-success').css('display','none');
                                $('.card-head-div').css('display','block');
                                $('.page-header').css('display','block');
                                $('#loading-wrapper').css('display','none');
                            }
                            else{
                                $('.card-head-div').css('display','none');
                                $('.page-header').css('display','none');
                                $('#loading-wrapper').css('display','block');

                                let message = $( '[name=message]' ).val();
                                var templateId=$('.template-select option:selected').val();
                                var numHead=$('.num-head option:selected').val();
                                var numBody = $( '[name=telephone]' ).val();
                                var telephone=numHead+numBody;

                                if(templateId==''){
                                    if ( !message ) {
                                        alert( 'Mesaj boş qoyula bilməz' );
                                        errorFunc();
                                    }
                                    else{
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
                                                    successFunc();
                                                } else if ( response.status == "error" ) {
                                                    errorFunc();
                                                    alert( response.message )
                                                } else {
                                                    errorFunc();
                                                    alert( 'Sistem Xətası' )
                                                }
                                            }
                                        } )
                                    }

                                }
                                else{
                                    $.ajax( {
                                        url: '/admin/send-collection-message',
                                        type: 'post',
                                        data: { 'telephone': telephone,
                                            'templateId':templateId,
                                            "_token": "{{ csrf_token() }}"
                                        },
                                        success: function ( response ) {
                                            if ( response.status == 'success' ) {
                                                successFunc();
                                            } else if ( response.status == "error" ) {
                                                errorFunc();
                                                alert( response.message );
                                            } else {
                                                alert( 'Sistem Xətası' )
                                            }
                                        }
                                    } )
                                }
                            }

                        })
                    } else {
                        $('.send-collection-message').css('display','none');
                        $('.sendmessage').css('display','block');
                        $( '.add-number-btn' ).css('display','none');
                        $('#numbers-list').css('display','none');
                        $('#numbers-list-img').css('display','none');
                        $('.numbers-label').css('display','none');
                        $('.numbers-label-img').css('display','none');
                    }
                } )

                $('.excelFileBtn').on('click',function (  ){
                    $(this).html('Fayl secildi')
                    $('.numbers-div').hide()
                    $('.numbers').hide()
                    $('.imageFileBtn').css('margin-top','-10px')
                })

                $('#excelFileForImg').on('click',function (  ){
                    $(this).html('Şəkil seçildi')
                    $('.numbers-div').hide()
                    $('.numbers').hide()
                })

                $('.send-image').on('click',function (  ){
                    let excelFile=$('#excelFileForImg')[0].files[0];
                    // let imageFile=$('#imageFile')[0].files[0];
                    let imageLink=$('#imageLink').val().trim();
                    let numHead=$('.num-head-img option:selected').val();
                    let numBody = $( '[name=phoneBodyImg]' ).val();
                    let telephone=numHead+numBody;
                    // console.log(telephone)
                    // console.log(imageFile['name'])

                    let formData = new FormData();
                    formData.append('excelFile', excelFile);

                    if(imageLink){
                        if(excelFile){
                            $.ajax({
                                url : '/api/import',
                                type : 'POST',
                                data : formData,
                                processData: false,  // tell jQuery not to process the data
                                contentType: false,  // tell jQuery not to set contentType
                                success : function(data) {
                                    console.log(data);
                                }
                            });

                            axios({
                                method: 'post',
                                url: '/api/send',
                                data: {
                                    message:imageLink ,
                                }
                            }).then((response) => {
                                console.log(response);
                            }, (error) => {
                                console.log(error);
                            });
                        }
                        // else{
                        //
                        // }
                        else{

                        }

                    }
                    else{
                        alert('Şekil əlavə edin!')
                    }
                })


            </script>
            <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@endsection
