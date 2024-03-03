<!DOCTYPE html>
<html lang="en" class="h-100">
<?php $setting = Setting();?>
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
    <title>Forgot Password :: {{$setting->title}}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('backend/images/favicon.ico')}}">
	<link href="{{url('backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link href="{{url('backend/css/style.css')}}" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                @include('backend.layouts.alerts')
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                               
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="{{route('admin.login')}}">
                                        @if($setting->file_path!='')
                                            <img src="{{ $setting->file_url }}" alt="{{ $setting->title }}" class="img-fluid">
                                        @else
                                            <img src="{{url('backend/images/logo-full.png')}}" alt="">
                                        @endif
                                        </a>
									</div>
                                    <h4 class="text-center mb-4">Forgot Password</h4>
                                    <form action="{{route('admin.password.email')}}" method="post">
                                        {{csrf_field()}}
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email">
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">SUBMIT</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="{{url('backend/vendor/global/global.min.js')}}"></script>
	<script src="{{url('backend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
    <script src="{{url('backend/js/custom.min.js')}}"></script>
	<script src="{{url('backend/js/deznav-init.js')}}"></script>
</body>
</html>