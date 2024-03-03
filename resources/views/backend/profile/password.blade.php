@extends('backend.layouts.app')

@section('title')
    Change Password
@endsection

@section('styles')
    @parent

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
            <li class="breadcrumb-item active"><a href="{{ route('admin.profile.index') }}">My Account</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Change Password</a></li>
        </ol>
    </div>
    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">

    </div>
</div>

<div class="content">
    <div class="container-fluid">
       
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card">
                    <form class="needs-validation" id="change_password" action="{{route('admin.update.password',['id' => $user->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Current Password</label>
                                        <input id="current_password" type="password" name="current_password"
                                            class="form-control @error('current_password') is-invalid @enderror">

                                        @error('current_password')
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">New Password</label>
                                        <input id="password" type="password" name="password"
                                            class="form-control @error('password') is-invalid @enderror">

                                        @error('password')
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="form-group">
                                        <label class="form-label">Confirm Password</label>
                                        <input id="confirm_password" type="password" name="confirm_password"
                                            class="form-control @error('confirm_password') is-invalid @enderror">

                                        @error('confirm_password')
                                            <div class="invalid-feedback">
                                                This field is required
                                            </div>
                                        @enderror
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
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
    @parent
   
    <script>
        $('#change_password').validate({
        rules: {
            current_password: {
                required: true,
            },
            password: {
                required: true,
            },
            confirm_password: {
                required: true,
                equalTo:'#password',
            },
        },
        messages: {
            current_password: {
                required: "This field is required",
            },
            password: {
                required: "This field is required",
            },
            confirm_password: {
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
@endsection