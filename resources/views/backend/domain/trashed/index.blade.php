@extends('backend.layouts.app')

@section('title')
    Trashed
@endsection

@section('styles')
    @parent
    <link href="{{url('backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('backend/vendor/select2/css/select2.min.css')}}">
    <link href="{{url('backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('backend/vendor/toastr/css/toastr.min.css')}}">
 <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    @stack('styles')
@endsection

@section('content')
        <div class="content-body">
            <div class="container-fluid">
                <div id="notify">@include('backend.layouts.alerts')</div>
                <!-- <div class="row ">
                    <div class="col-sm-6 d-flex align-items-center">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)"> Domains Trashed</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                        
                    </div>
                </div> -->
                <!-- row -->

                <div class="card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                        
                                    <div class="col-md-3">
                                        <div class="form-group" style="margin-bottom:0;">
                                            <select class="form-control select2-width-50" name ="select_action" id="id_label_single">
                                                <option value="">Select Action</option>
                                                <option value="1">Restore</option>
                                                <option value="2">Delete</option>
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
                                        <a href="javascript:void(0)" class="" id="trashedCount">Trashed ({{$trashedCount}})</a>
                                    </div>
                                        
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th class="checkbox_custom_style text-center">
                                                        <input name="multi_check" type="checkbox" id="multi_check"
                                                            class="chk-col-cyan" onclick="checkall()"/>
                                                        <label for="multi_check"></label>
                                                    </th>
                                                    <th>#</th>
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
                                                                    <a class="dropdown-item" href="{{route('admin.domain.trashed.restore',$value->id)}}" title="restore"><i class="fas fa-sync-alt" style="color: #3A82EF;"></i> Restore</a>
                                                                    <a class="dropdown-item" data-bs-target="#deleteConfirm" href="javascript:void(0);" 
                                                                        data-bs-toggle="modal" title="Delete" 
                                                                        onclick="deleteConfirm('{{ route('admin.domain.trashed.destroy',$value->id)}}','Are you sure you, want to delete permanently?')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>
                                                                    
                                                                   
                                                                    
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
        </div>

    <input type="hidden" class="actionUrl" value="{{route('admin.domain.trashed.action')}}">
@endsection
@section('scripts')
    @parent
    <script src="{{url('backend/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{url('backend/vendor/bootstrap-select/dist/js/bootstrap-select.min.js')}}"></script>
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
