@extends('backend.layouts.app')

@section('title')
    Edit
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
            <li class="breadcrumb-item active"><a href="{{route('admin.vehicles.index')}}">Vehicles</a></li>
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
        </ol>
    </div>
    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">

    </div>
</div>


<div class="card mt-4">
    <form class="needs-validation" id="vechile" action="{{route('admin.vehicles.update',['vehicle' => $vehicle->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
        @csrf
        @method('PUT')
        <div class="card-body p-4">
            
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Vechile Name</label>
                        <input id="name" type="text" name="name" value="{{ $vehicle->name }}"
                            class="form-control @error('name') is-invalid @enderror">

                        @error('name')
                            <div class="invalid-feedback">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Description</label>
                            <textarea cols="80" id="description" name="description" rows="10" class="form-control ckeditor @error('description') is-invalid @enderror" placeholder="Enter description">{{$vehicle->description}}</textarea>
                        @error('description')
                            <div class="invalid-feedback" id="error_description">
                            {{ $message }}
                            </div>
                        @enderror
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="form-label">Order By</label>
                        <input id="order_by" type="text" name="order_by" value="{{ $vehicle->order_by }}"
                            class="form-control @error('order_by') is-invalid @enderror" readonly>

                        @error('order_by')
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
    <script src="{{url('backend/vendor/ckeditor/ckeditor.js')}}"></script>
    <script>
        var Editor = document.querySelector('.ckeditor');
        ClassicEditor.create(Editor);
        $("#vehicle").submit(function(e) {
            var content = $('.ckeditor').val();
            html = $(content).text();
            if ($.trim(html) == '') {
                $('#error_description').text("This field is required");
                e.preventDefault();
            } 
        });
        $('#vehicle').validate({
        rules: {
            name: {
                required: true,
            },
            link: {
                required: true,
            },
            icon: {
                required: true,
            },
        },
        messages: {
            name: {
                required: "This field is required",
            },
            link: {
                required: "This field is required",
            },
            icon: {
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