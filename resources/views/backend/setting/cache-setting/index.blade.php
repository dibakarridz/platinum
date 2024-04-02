@extends('backend.layouts.app')

@section('title')
    Cache Setting
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
            <li class="breadcrumb-item active"><a href="javascript:void(0)">Cache Setting</a></li>
        </ol>
    </div>
    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">

    </div>
</div>


<div class="card mt-4"> 
        
    <div class="card-body p-4">            
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">Clear View Cache</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <a href="{{route('admin.cache.update',1)}}">
                        <button type="button" class="btn btn-info" style="margin-left:-13px;margin-top:-7px;">Click Here</button>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">Clear Route Cache</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <a href="{{route('admin.cache.update',2)}}">
                        <button type="button" class="btn btn-info" style="margin-left:-13px;margin-top:-7px;">Click Here</button>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">Clear Config Cache</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <a href="{{route('admin.cache.update',3)}}">
                        <button type="button" class="btn btn-info" style="margin-left:-13px;margin-top:-7px;">Click Here</button>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">Application Clear Cache</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <a href="{{route('admin.cache.update',4)}}">
                        <button type="button" class="btn btn-info" style="margin-left:-13px;margin-top:-7px;">Click Here</button>
                    </a>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label class="form-label">Storage Link</label>
                </div>
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <a href="{{route('admin.cache.update',5)}}">
                        <button type="button" class="btn btn-info" style="margin-left:-13px;margin-top:-7px;">Click Here</button>
                    </a>
                </div>
            </div>
        </div><!-- /.row -->
    </div>
</div></div></div>
@endsection
@section('scripts')
    @parent

    @stack('scripts')
@endsection