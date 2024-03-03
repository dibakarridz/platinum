<!DOCTYPE html>
<html lang="en">
<?php $setting = Setting();?>
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>@yield('title') :: {{$setting->title}} </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Favicon icon -->
	<link rel="icon" type="image/png" sizes="16x16" href="{{url('backend/images/favicon.ico')}}">
		<!-- Styles -->
		@section('styles')
			@include('backend.layouts.styles')
		<!--/.Styles -->
		@show
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
    
        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="#" class="brand-logo">
            @if($setting->file_path!='')
                <img class="logo-abbr" src="{{ $setting->file_url }}" alt="{{ $setting->title }}">
            @else
				<img class="logo-abbr" src="{{url('backend/images/logo-full.png')}}" alt="">
            @endif
				
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
		<!--**********************************
            Header start
        ***********************************-->
        @include('backend.layouts.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('backend.layouts.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->
		
		<!--**********************************
            Content body start
        ***********************************-->
        @section('content')
        @yield('content')
        <!--**********************************
            Content body end
        ***********************************-->

        <!--**********************************
            Footer start
        ***********************************-->
        @section('footer')
        @include('backend.layouts.footer')
        <!--**********************************
            Footer end
        ***********************************-->

	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
	@section('scripts')
    	@include('backend.layouts.scripts')
	@show

</body>
</html>