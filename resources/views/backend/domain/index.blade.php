@extends('backend.layouts.app')

@section('title')
    Domains
@endsection

@section('styles')
    @parent
    <link href="{{url('backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('backend/vendor/toastr/css/toastr.min.css')}}">
    <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    <style>
    

    </style>
    @stack('styles')
@endsection

@section('content')
        <div class="content-body">
            <div class="container-fluid">
                <div id="notify">@include('backend.layouts.alerts')</div>
                <div class="row ">
                    <div class="col-sm-6 d-flex align-items-center">
                        <!-- <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Domains</a></li>
                        </ol> -->
                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                        <a type="button" href="{{ route('admin.domains.create') }}" class="btn btn-rounded btn-primary">Add New</a>
                    </div>
                </div>
                <!-- row -->

                <div class="card mt-4">
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                            
                                        <div class="col-md-3">
                                            <div class="form-group" style="margin-bottom:0;">
                                                <select class="form-control select2-width-50" name ="select_action" id="select2-width-50">
                                                    <option value="">Select Action</option>
                                                    <option value="1">Move To Trashed</option>
                                                    <option value="2">Permanently Delete</option>
                                                </select>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="col-md-3" style="margin-right: auto;padding-left: 5px;">
                                            <div class="form-group" style="margin-bottom:0;">
                                            <button type="button" class="btn btn-rounded btn-primary apply_action">Apply</button>
                                                
                                            </div>
                                            
                                        </div>
                                        <div class="bootstrap-badge" id="countBadge">
                                            <a href="{{route('admin.domains.index')}}" class="" id="activeCount">All ({{$activeCount}})</a>
                                            <a href="{{route('admin.domain.trashed.index')}}" class="" id="trashedCount">Trashed ({{$trashedCount}})</a>
                                        </div>
                                            
                                    </div>
<<<<<<< HEAD
                                    <div class="card-body" id="domain_table">
=======
                                    <div class="card-body" id="">
>>>>>>> cdf5ca0 (design changes issue fixed)
                                            <table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
                                                <thead>
                                                    <tr>
                                                        <th class="checkbox_custom_style text-center">
                                                            <input name="multi_check" type="checkbox" id="multi_check"
                                                                class="chk-col-cyan" onclick="checkall()"/>
                                                            <label for="multi_check"></label>
                                                        </th>
                                                        <th>#</th>
                                                        <th>Unique ID</th>
                                                        <th>Domain</th>
                                                        <th>Status </th>
                                                        <th>Action </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($domains as $key =>$value)
                                                        <tr>
                                                            <th class="text-center">
                                                                <input name="single_check" value="{{ $value->id }}"
                                                                        type="checkbox" id="single_check_{{ $key+1 }}"
                                                                        class="chk-col-cyan selects single_check "/>
                                                                <label for="single_check_{{ $key+1 }}"></label>
                                                            </th>
                                                            <td>{{ $key + 1 }}</td>
                                                            <td>{{ $value->unique_id }}</td>
                                                            <td>{{ $value->domain_name }}</td>
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
                                                                        <a class="dropdown-item" href="{{route('admin.domains.edit',['domain' => $value->id])}}" title="Edit"><i class="fas fa-pencil-alt" style="color: blue;"></i> Edit</a>
                                                                        
                                                                        <a class="dropdown-item" data-bs-target="#deleteConfirm" href="javascript:void(0);" 
                                                                            data-bs-toggle="modal" title="Delete" 
                                                                            onclick="deleteConfirm('{{ route('admin.domains.destroy',['domain' => $value->id])}}','Are you sure you, want to delete?')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>
                                                                        
                                                                        <a class="dropdown-item" data-bs-target="#statusChange"
                                                                            href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                            onclick="statusChange('{{ route('admin.domain.status', $value->id) }}')">
                                                                            <i class="fas fa-toggle-on pr-1" style="color: green;"></i> Status
                                                                        </a>
                                                                        
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
<<<<<<< HEAD
                                            <div class="col-sm-12 d-flex flex-row-reverse align-items-center">
                                                <nav class="d-flex">
                                                    <ul class="pagination pagination-sm pagination-gutter">
                                                        <li class="page-item page-indicator">
                                                            <a class="page-link" href="javascript:void(0)">
                                                                <i class="la la-angle-left"></i></a>
                                                        </li>
                                                        <li class="page-item active"><a class="page-link" href="javascript:void(0)">1</a>
                                                        </li>
                                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">2</a></li>
                                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a></li>
                                                        <li class="page-item"><a class="page-link" href="javascript:void(0)">4</a></li>
                                                        <li class="page-item page-indicator">
                                                            <a class="page-link" href="javascript:void(0)">
                                                                <i class="la la-angle-right"></i></a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                            </div>
=======
                                            
>>>>>>> cdf5ca0 (design changes issue fixed)
                                            
                                    </div>
                                </div>
                            </div>
                        
                        
                    </div>
                </div>
            </div>
        </div>

    <input type="hidden" class="actionUrl" value="{{route('admin.domain.active.action')}}">
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
            $('#dataTable').dataTable({
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
