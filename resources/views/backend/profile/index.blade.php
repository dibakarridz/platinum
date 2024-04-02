@extends('backend.layouts.app')

@section('title')
    My Account
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
        </ol>
    </div>
    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">

    </div>
</div>


<div class="card mt-4">
    <form class="needs-validation" id="profile" action="{{route('admin.profile.update',['profile' => $user->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            <div class="row justify-content-center">
                <div class="col-md-3 col-sm-12 text-center">
                    @if($user->file_path!='')
                    <img src="{{ $user->avatar_url }}" id="profile_img"
                        class="rounded border img-fluid mb-2" alt="" />
                    @else
                    <img src="{{ url('backend/images/avatar/1.jpg') }}" id="profile_img"
                        class="rounded border img-fluid mb-2" alt="" />
                    @endif
                        <a class="btn btn-xs btn-rounded btn-outline-primary" role="button" onclick="$('.js-image-upload').click();" title="Set Avatar">
                            Choose Image
                        </a>
                    <input type="file" name="avatar" class="js-image-upload form-control d-none"
                        accept='.jpg, .jpeg, .png'
                        onchange="document.getElementById('profile_img').src = window.URL.createObjectURL(this.files[0]);" />
                    
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Name</label>
                        <input id="name" type="text" name="name" value="{{ $user->name }}"
                            class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback">
                                This field is required
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Email</label>
                        <input id="email" type="text" name="email" value="{{ $user->email }}"
                            class="form-control @error('email') is-invalid @enderror">

                        @error('email')
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
			</div></div></div>
@endsection
@section('scripts')
    @parent
    <script>
        $('#profile').validate({
        rules: {
            name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            name: {
                required: "This field is required",
            },
            email: {
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