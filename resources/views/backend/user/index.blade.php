@extends('backend.layouts.app')

@section('title')
    Users
@endsection

@section('styles')
    @parent
    <link href="{{url('backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Users</a></li>
                        </ol>
                    </div>
                    @if(Auth::user()->type == 1)
                    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                        <a type="button" href="{{ route('admin.users.create') }}" class="btn btn-primary btn-xs">Add New</a>
                    </div>
                    @endif
                </div>
                <!-- row -->

                <div class="card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                @if(Auth::user()->type == 1)
                                <div class="card-header" style="overflow:auto !important;">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control select2-width-50" name ="select_action" id="id_label_single">
                                                <option value="">Select Action</option>
                                                <option value="1">Move To Trashed</option>
                                                <option value="2">Permanently Delete</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3" style="margin-right: auto;padding-left: 5px;">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-rounded btn-primary apply_action">Apply</button>                                                
                                        </div>
                                    </div>
                                    <div class="bootstrap-badge" id="countBadge">
                                        <a href="{{route('admin.users.index')}}" class="badge badge-rounded badge-info" id="activeCount">All ({{$activeCount}})</a>
                                        <a href="{{route('admin.trashed.index')}}" class="badge badge-rounded badge-danger" id="trashedCount">Trashed ({{$trashedCount}})</a>
                                    </div>
                                </div>
                                @endif
                                <div class="card-body" id="refreshData">
                                    <!-- <div class="col-md-3">
                                        <select id='status' class="form-control select2-width-50">
                                            <option value="">select user type</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Customer</option>
                                        </select>
                                    </div> -->
                                    <!-- <div class="table-responsive"> -->
                                        <table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    @if(Auth::user()->type == 1)
                                                    <th class="checkbox_custom_style text-center">
                                                        <input name="multi_check" type="checkbox" id="multi_check"
                                                            class="chk-col-cyan" onclick="checkall()"/>
                                                        <label for="multi_check"></label>
                                                    </th>
                                                    @endif
                                                    <th>#</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>User Type</th>
                                                    <th>Status</th>
                                                    <th>Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($users as $key =>$value)
                                                    <tr>
                                                        @if(Auth::user()->type == 1)
                                                        <th class="text-center">
                                                            <input name="single_check" value="{{ $value->id }}"
                                                                    type="checkbox" id="single_check_{{ $key+1 }}"
                                                                    class="chk-col-cyan selects single_check "/>
                                                            <label for="single_check_{{ $key+1 }}"></label>
                                                        </th>
                                                        @endif
                                                        <td>{{ $key + 1 }}</td>
                                                        <td>{{ $value->name }}</td>
                                                        <td>{{ $value->email }}</td>
                                                        <td>
                                                            @if($value->type == 1)
                                                                <span class="badge light badge-success">Admin</span>
                                                            @else
                                                                <span class="badge light badge-info">User</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if($value->status == 1)
                                                                <span class="badge light badge-success">Active</span>
                                                            @else
                                                                <span class="badge light badge-danger">Inactive</span>
                                                            @endif
                                                        </td>
                                                        
                                                        <td>
                                                            <div class="dropdown ms-auto text-right" style="cursor: pointer;">
                                                                <div class="btn-link" data-bs-toggle="dropdown">
                                                                    <svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                                                </div>
                                                                <div class="dropdown-menu dropdown-menu-right">
                                                                    <a class="dropdown-item" href="{{route('admin.users.show',['user' => $value->id])}}" title="View"><i class="fas fa-eye" style="color: blue;"></i> View</a>
                                                                    <a class="dropdown-item" href="{{route('admin.users.edit',['user' => $value->id])}}" title="Edit"><i class="fas fa-edit" style="color: green;"></i> Edit</a>
                                                                    @if(Auth::user()->type == 1)
                                                                    <a class="dropdown-item" data-bs-target="#deleteConfirm" href="javascript:void(0);" 
                                                                        data-bs-toggle="modal" title="Trashed"
                                                                        onclick="deleteConfirm('{{ route('admin.users.destroy',['user' => $value->id])}}','Are you sure you, want to delete?')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>
                                                                    
                                                                    <a class="dropdown-item" data-bs-target="#statusChange"
                                                                        href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                        onclick="statusChange('{{ route('admin.users.status', $value->id) }}')">
                                                                        <i class="fas fa-toggle-on pr-1" style="color: green;"></i> Status
                                                                    </a>
                                                                    @endif
                                                                    
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    <!-- </div> -->
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

    <input type="hidden" class="actionUrl" value="{{route('admin.users.active.action')}}">
@endsection
@section('scripts')
    @parent
    <script src="{{url('backend/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{url('backend/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/select2-init.js')}}"></script>
    <script src="{{url('backend/vendor/toastr/js/toastr.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/toastr-init.js')}}"></script>
    <script src="{{url('backend/js/loader.js')}}"></script>
    <script>
       $(document).ready(function() {
            var table = $('#dataTable').dataTable({
                "pageLength": 15,
                lengthMenu: [
                    [15, 25, 50, -1],
                    [15, 25, 50, 'All']
                ]
            });
            
        } );
    </script>
    @stack('scripts')
@endsection
