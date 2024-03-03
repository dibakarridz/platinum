@extends('backend.layouts.app')

@section('title')
    Setting
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
            <li class="breadcrumb-item active"><a href="{{route('admin.settings.edit',['setting' => $setting->id])}}">Settings</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
        </ol>
    </div>
    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">

    </div>
</div>

<div class="card mt-4">
    <form class="needs-validation" id="setting" action="{{route('admin.settings.update',['setting' => $setting->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="row justify-content-center">
                <div class="col-md-3 col-sm-6 text-center">
                    <label class="form-label">Squre Logo</label>
                    @if($setting->file_path!='')
                    <img src="{{ $setting->file_url }}" id="logo_img_squre"
                        class="rounded border img-fluid mb-2" alt="" />
                    @else
                    <img src="{{ url('backend/images/avatar/1.jpg') }}" id="logo_img_squre"
                        class="rounded border img-fluid mb-2" alt="" />
                    @endif
                        <a class="btn btn-xs btn-rounded btn-outline-primary" role="button" onclick="$('.js-image-upload').click();" title="Set Avatar">
                            Choose Image
                        </a>
                    <input type="file" name="image" class="js-image-upload form-control d-none"
                        accept='.jpg, .jpeg, .png'
                        onchange="document.getElementById('logo_img_squre').src = window.URL.createObjectURL(this.files[0]);" />
                    
                </div>
                
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Title</label>
                        <input id="title" type="text" name="title" value="{{ $setting->title }}"
                            class="form-control @error('title') is-invalid @enderror">

                        @error('title')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ $setting->email }}"
                            class="form-control @error('email') is-invalid @enderror">

                        @error('email')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Mobile Number</label>
                        <input id="phone" type="text" name="phone" value="{{ $setting->mobile_number }}"
                            class="form-control @error('phone') is-invalid @enderror">

                        @error('phone')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Address</label>
                        <input id="address" type="text" name="address" value="{{ $setting->address }}"
                            class="form-control @error('address') is-invalid @enderror">

                        @error('address')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">App Copyright</label>
                        <input id="copyright" type="text" name="copyright" value="{{ $setting->copyright }}"
                            class="form-control @error('copyright') is-invalid @enderror">

                        @error('copyright')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Developed By</label>
                        <input id="developed" type="text" name="developed" value="{{ $setting->developed_by }}"
                            class="form-control @error('developed') is-invalid @enderror">

                        @error('developed')
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
                    <button type="submit" class="btn btn-xs btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
@section('scripts')
    @parent
    <script src="{{url('backend/vendor/select2/js/select2.full.min.js')}}"></script>
<script src="{{url('backend/js/plugins-init/select2-init.js')}}"></script>
    <script>
        $('#setting').validate({
        rules: {
            title: {
                required: true,
            },
            email: {
                required: true,
                email:true,
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 11,
            },
            address: {
                required: true,
            },
        },
        messages: {
            title: {
                required: "This field is required",
            },
            email: {
                required: "This field is required",
            },
            phone: {
                required: "This field is required",
            },
            title: {
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