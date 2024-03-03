@extends('backend.layouts.app')

@section('title')
    User Show
@endsection

@section('styles')
    @parent
   
    @stack('styles')
@endsection

@section('content')
<div class="content-body">
            <div class="container-fluid">
               
                <div class="row ">
                    <div class="col-sm-6 d-flex align-items-center">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.users.index') }}">Users</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">view</a></li>
                        </ol>
                    </div>
                    
                </div>
                <!-- row -->

                <div class="card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">User Details</h4>
                                </div>
                                <div class="card-body">
                                    <div class="card-body p-4">
                                        <div class="row justify-content-center">
                                            <div class="col-md-3 col-sm-12 text-center">
                                                @if($user->avatar!='')
                                                <img src="{{ $user->avatar_url }}" id="profile_img"
                                                    class="rounded border img-fluid mb-2" alt="" />
                                                @else
                                                <img src="{{ url('backend/images/avatar/1.jpg') }}" id="profile_img"
                                                    class="rounded border img-fluid mb-2" alt="" />
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row">                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Name</label>
                                                    <input type="text" value="{{ $user->name }}" class="form-control"
                                                        readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email</label>
                                                    <input type="text"  value="{{ $user->email }}" class="form-control"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div><!-- /.row -->
                                        <div class="row">
                                            
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Status</label>
                                                        @if($user->status == 1)
                                                            <span class="badge light badge-success">Active</span>
                                                        @else
                                                            <span class="badge light badge-danger">Inactive</span>
                                                        @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">User Type</label>
                                                        @if($user->type != 1)
                                                            <span class="badge light badge-success">User</span>
                                                        @else
                                                            <span class="badge light badge-success">Admin</span>
                                                        @endif
                                                </div>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

        
@endsection
@section('scripts')
    @parent
   
    @stack('scripts')
@endsection
