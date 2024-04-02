@extends('backend.layouts.app')

@section('title')
    Create
@endsection

@section('styles')
    @parent
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
					<li class="breadcrumb-item active"><a href="{{route('admin.users.index')}}">Users</a></li>
					<li class="breadcrumb-item active"><a href="javascript:void(0)">Add</a></li>
				</ol>
			</div>
		</div>


		<div class="card mt-4">
			<form class="needs-validation" id="useForm" action="{{route('admin.users.store')}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        
        <div class="card-body p-4">
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">User Type</label>
                        <select class="select2-width-50" name="user_type" id="user_type">
                            <option value="">--Select User Type--</option>
                            <option value="1">{{'Admin'}}</option>
                            <option value="2">{{'Customer'}}</option>
                        
                        </select>

                        @error('user_type')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input id="name" type="text" name="name" placeholder="Enter name"
                            class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}">

                        @error('name')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Username</label>
                        <input id="username" type="text" name="username" placeholder="Enter username"
                            class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}">
                        @error('username')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" name="email" placeholder="Enter email address"
                            class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}">
                        @error('email')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label password-gen-label">Password <a href="javascript:void(0)" class="badge badge-rounded badge-primary pass-generate" onclick="passwordGenerate()" data-bs-toggle="modal" data-bs-target="#password_generate">Generate password</a></label>
                        <input id="password" type="password" name="password" placeholder="Enter password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input id="confirm_password" type="password" name="confirm_password" placeholder="Enter confirm password"
                            class="form-control @error('confirm_password') is-invalid @enderror">
                        @error('confirm_password')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                
            </div><!-- /.row -->

            <div class="row">
                <div class="col-sm-6 d-flex align-items-center"></div>
                <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                    <button type="submit" class="btn btn-xs btn-primary">Save</button>
                </div>
            </div>
        </div>
    </form>
		</div>
	</div>
</div>
<!-- password generator modal -->

<div class="modal fade" id="password_generate" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-primary" id="generatePasswordmodalTitle">Password Generator</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="AjaxModalBody">
            <input class="form-control gen_password_field" readonly type="text" id="copyTarget" value="Text to Copy">
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-sm-6 gen-pass">
                        <button type="button" id="regenerate_password" class="btn btn-sm btn-warning gen-pass-btn" onClick="reg_pass()">Re-Generate</button>
                    </div>
                    <div class="col-sm-6 copy-pass">
                        <button type="button" id="copyButton" class="btn btn-sm btn-primary copy-pass-btn" >Copy & Paste</button>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- close password generator modal -->
@endsection
@section('scripts')
    @parent
    <script src="{{url('backend/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/select2-init.js')}}"></script>
   
    <script>
        $('#useForm').validate({
            ignore: [],
            debug: false,
        rules: {
            user_type: {
                required: true,
            },
            name: {
                required: true,
            },
            username: {
                required: true,
            },
            email: {
                required: true,
                email:true,
            },
            password: {
                required: true,
            },
            confirm_password: {
                required: false,
                equalTo: "#password"

            },
        },
        messages: {
            user_type: {
                required: "This field is required",
            },
            name: {
                required: "This field is required",
            },
            username: {
                required: "This field is required",
            },
            email: {
                required: "This field is required",
            },
            password: {
                required: "This field is required",
            },
            confirm_password: {
                required: "This field is required",
                equalTo: "Confirm password doesn't match password"
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
    document.getElementById("copyButton").addEventListener("click", function() {
        copyToClipboard(document.getElementById("copyTarget"));
        setTimeout(function(){ $(".btn-close").click(); }, 1);
    });

    </script>
    @stack('scripts')
@endsection