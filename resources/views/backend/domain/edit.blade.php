@extends('backend.layouts.app')

@section('title')
    Edit
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{url('backend/vendor/toastr/css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    @stack('styles')
@endsection

@section('content')
	<div class="content-body">
        <div class="container-fluid">
        <div id="notify">@include('backend.layouts.alerts')</div>
        <div class="row ">
    <div class="col-sm-6 d-flex align-items-center">
        <ol class="breadcrumb m-0">
            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{route('admin.domains.index')}}">Domains</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
        </ol>
    </div>
    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
       
        <a href="javascript:void(0);"
            title="Send Test Mail" 
            data-title="Send Test Mail" 
            data-action-url="{{ route('admin.domain.mail', ['id' => $data->id]) }}" 
            class="openPopup badge badge-primary">
            Send Test Mail
        </a>
    </div>
</div>


<div class="card mt-4">
    <form class="needs-validation" id="domain" action="{{route('admin.domains.update',['domain' => $data->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Domain Url</label>
                        <input id="domain" type="text" name="domain" placeholder="Enter domain url"
                            class="form-control @error('domain') is-invalid @enderror" value="{{ $data->domain_name ?? '' }}">

                        @error('domain')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Unique ID</label>
                        <input id="unique_id" type="text" name="unique_id" placeholder="Enter unique id"
                            class="form-control @error('unique_id') is-invalid @enderror" value="{{ $data->unique_id ?? '' }}">
                            

                        @error('unique_id')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Domain Name</label>
                        <input id="name" type="text" name="name" placeholder="Enter domain name"
                            class="form-control @error('name') is-invalid @enderror" value="{{ $data->domain ?? '' }}">
                            

                        @error('name')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Reply Email</label>
                        <input id="email" type="email" name="email" placeholder="Enter reply email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ $data->reply_email ?? '' }}">
                            

                        @error('email')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">SMTP Protocol</label>
                        <input id="driver" type="text" name="driver" placeholder="Enter smtp protocol"
                            class="form-control @error('driver') is-invalid @enderror" value="{{ $data->protocol ?? '' }}">
                            

                        @error('driver')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">SMTP Host</label>
                        <input id="host" type="text" name="host" placeholder="Enter smtp host"
                            class="form-control @error('host') is-invalid @enderror" value="{{ $data->smtp_host ?? '' }}">
                            

                        @error('host')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">SMTP Port</label>
                        <input id="port" type="text" name="port" placeholder="Enter smtp port"
                            class="form-control @error('port') is-invalid @enderror" value="{{ $data->smtp_port ?? '' }}">
                            

                        @error('port')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">SMTP Username</label>
                        <input id="username" type="text" name="username" placeholder="Enter smtp username"
                            class="form-control @error('username') is-invalid @enderror" value="{{ $data->smtp_username ?? '' }}">
                            

                        @error('username')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">SMTP Password</label>
                        <input id="password" type="text" name="password" placeholder="Enter smtp password"
                            class="form-control @error('password') is-invalid @enderror" value="{{ $data->smtp_password ?? '' }}">
                            

                        @error('password')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Email Encryption</label>
                        <select class="select2-width-50" name="encryption">
                            <option value="">--Select Encryption--</option>
                            <option value="ssl" @if($data->encryption == 'ssl'){{'selected'}}@endif>{{'SSL'}}</option>
                            <option value="tls" @if($data->encryption == 'tls'){{'selected'}}@endif>{{'TLS'}}</option>
                          
                        </select>
                        @error('encryption')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Email Title</label>
                        <input id="title" type="text" name="title" placeholder="Enter email title"
                            class="form-control @error('title') is-invalid @enderror" value="{{ $data->email_title ?? '' }}">
                            

                        @error('title')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Success Message</label>
                                <textarea id="success_message" name="success_message" rows="5" cols="50" placeholder="Enter success message"
                                    class="form-control @error('success_message') is-invalid @enderror">{{ $data->success_msg ?? '' }}</textarea>
                                    

                                @error('success_message')
                                    <div class="invalid-feedback">
                                    {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Error Message</label>
                                <textarea id="error_message" name="error_message" rows="5" cols="50" placeholder="Enter error message"
                                    class="form-control @error('error_message') is-invalid @enderror">{{ $data->error_msg ?? '' }}</textarea>
                                    

                                @error('error_message')
                                    <div class="invalid-feedback">
                                    {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Email Template</label>
                            <textarea cols="80" id="template" name="template" rows="10" class="form-control ckeditor @error('template') is-invalid @enderror" placeholder="Enter template">{{ $data->template ?? ''}}</textarea>
                        @error('template')
                            <div class="invalid-feedback" id="error_description">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                    <p>Note: use <b>[Vehicle]</b> to replace the vehicle quotation</p>
                    <p>Note: use <b>[QuoteDetails]</b> to replace the quotation form</p>
                    <p>Note: use <b>[QuoteDetails]</b> to replace the quotation form</p>
                    </div>
                </div>
            </div><!-- /.row -->
            

            <div class="row">
                <div class="col-sm-6 d-flex align-items-center"></div>
                <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                    <button type="submit" class="btn btn-xs btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
    @parent
    
    <script src="{{url('backend/vendor/ckeditor/ckeditor.js')}}"></script>
    <script src="{{url('backend/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/select2-init.js')}}"></script>
    <script src="{{url('backend/vendor/toastr/js/toastr.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/toastr-init.js')}}"></script>
    <script src="{{url('backend/js/loader.js')}}"></script>
    
    <script>
         function form_submit() {
            var inputString = $("#sender_email").val();
            if (inputString == '') {
               var msg = "This field is required";
                toastr.error(msg, "", {
                        positionClass: "toast-top-right",
                        timeOut: 5e3,
                        closeButton: !0,
                        progressBar: !0
                        
                    })
            }else if(IsEmail(inputString) === false){
                var msg = "Entered Email is not Valid";
                toastr.error(msg, "", {
                        positionClass: "toast-top-right",
                        timeOut: 5e3,
                        closeButton: !0,
                        progressBar: !0
                        
                    })
            }else{
                document.getElementById("sendMailForm").submit();
            }
        }

        function IsEmail(inputString) {
            const regex =/^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
            if (!regex.test(inputString)) {
                return false;
            }
            else {
                return true;
            }
        }
        
        var Editor = document.querySelector('.ckeditor');
        ClassicEditor.create(Editor);
        $("#domain").submit(function(e) {
            var content = $('.ckeditor').val();
            html = $(content).text();
            if ($.trim(html) == '') {
                $('#error_template').text("This field is required");
                e.preventDefault();
            } 
        });
       
        $('#domain').validate({
            ignore: [],
            debug: false,
            rules: {
                domain: {
                    required: true,
                    url: true
                },
                unique_id: {
                    required: true,
                },
                name: {
                    required: true,
                },
                email: {
                    required: true,
                    email: true
                },
                driver: {
                    required: true,
                },
                host: {
                    required: true,
                },
                port: {
                    required: true,
                },
                username: {
                    required: true,
                },
                password: {
                    required: true,
                },
                encryption: {
                    required: true,
                },
                title: {
                    required: true,
                },
                success_message: {
                    required: true,
                },
                error_message: {
                    required: true,
                },
                template: {
                    required: true,
                },
            },
            messages: {
                domain: {
                    required: "This field is required",
                },
                unique_id: {
                    required: "This field is required",
                },
                name: {
                    required: "This field is required",
                },
                email: {
                    required: "This field is required",
                },
                driver: {
                    required: "This field is required",
                },
                host: {
                    required: "This field is required",
                },
                port: {
                    required: "This field is required",
                },
                username: {
                    required: "This field is required",
                },
                password: {
                    required: "This field is required",
                },
                encryption: {
                    required: "This field is required",
                },
                title: {
                    required: "This field is required",
                },
                success_message: {
                    required: "This field is required",
                },
                error_message: {
                    required: "This field is required",
                },
                template: {
                    required: "This field is required",
                },
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
            error.addClass('invalid-feedback');
            element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
            $(element).addClass('is-invalid');
            },
            unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass('is-invalid');
            }
        });
        
        
    
    </script>
    @stack('scripts')
@endsection