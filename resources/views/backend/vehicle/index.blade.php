@extends('backend.layouts.app')

@section('title')
    Vehicles
@endsection

@section('styles')
    @parent
    <link href="{{url('backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('backend/vendor/select2/css/select2.min.css')}}">
    <link href="{{url('backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('backend/vendor/toastr/css/toastr.min.css')}}">
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Vechiles</a></li>
                        </ol> -->
                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                        <a type="button" href="{{ route('admin.vehicles.create') }}" class="btn btn-primary btn-xs">Add New</a>
                    </div>
                </div>
                <!-- row -->

                <div class="card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header" style="overflow:auto !important;">
                                        
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <select class="form-control single-select" name ="select_action" id="id_label_single">
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
                                        <a href="{{route('admin.vehicles.index')}}" class="badge badge-rounded badge-info" id="activeCount">All ({{$activeCount}})</a>
                                        <a href="{{route('admin.vehicle.trashed.index')}}" class="badge badge-rounded badge-danger" id="trashedCount">Trashed ({{$trashedCount}})</a>
                                    </div>
                                        
                                </div>
                                <div class="card-body">
                                        <table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th class="checkbox_custom_style text-center">
                                                        <input name="multi_check" type="checkbox" id="multi_check"
                                                            class="chk-col-cyan" onclick="checkall()"/>
                                                        <label for="multi_check"></label>
                                                    </th>
                                                    <th>#</th>
                                                    <th>Vehicle</th>
                                                    <th>Order By</th>
                                                    <th>Status </th>
                                                    <th>Action </th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableBodyContents" style="cursor: all-scroll !important;">
                                                @foreach($vehicles as $key =>$value)
                                                    <tr class="tableRow" data-id="{{ $value->id }}">
                                                       
                                                        <th class="text-center">
                                                         <i class="fas fa-arrows-alt"></i>&nbsp;&nbsp;
                                                            <input name="single_check" value="{{ $value->id }}"
                                                                    type="checkbox" id="single_check_{{ $key+1 }}"
                                                                    class="chk-col-cyan selects single_check "/>
                                                            <label for="single_check_{{ $key+1 }}"></label>
                                                        </th>
                                                        
                                                        <td>{{ $loop->index + 1 }}</td>
                                                        
                                                           
                                                        <td>{{ $value->name }}</td>
                                                        <td class="pos_num">{{ $value->order_by }}</td>
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
                                                                    <a class="dropdown-item" href="{{route('admin.vehicles.edit',['vehicle' => $value->id])}}" title="Edit"><i class="fas fa-pencil-alt" style="color: blue;"></i> Edit</a>
                                                                    
                                                                    <a class="dropdown-item" data-bs-target="#deleteConfirm" href="javascript:void(0);" 
                                                                        data-bs-toggle="modal" title="Delete" 
                                                                        onclick="deleteConfirm('{{ route('admin.vehicles.destroy',['vehicle' => $value->id])}}','Are you sure you, want to delete?')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>
                                                                    
                                                                    <a class="dropdown-item" data-bs-target="#statusChange"
                                                                        href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                        onclick="statusChange('{{ route('admin.vehicle.status', $value->id) }}')">
                                                                        <i class="fas fa-toggle-on pr-1" style="color: green;"></i> Status
                                                                    </a>
                                                                    
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

    <input type="hidden" class="actionUrl" value="{{route('admin.vehicle.active.action')}}">
@endsection
@section('scripts')
    @parent
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>

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

            $("#tableBodyContents").sortable({
                items: "tr",
                cursor: 'move',
                opacity: 0.6,
                update: function() {
                    sendOrderToServer();
                }
            });
            function sendOrderToServer() {

                var order = [];
                var token = $('meta[name="csrf-token"]').attr('content');

                $('tr.tableRow').each(function(index,element) {
                    order.push({
                        id: $(this).attr('data-id'),
                        position: index+1
                    });
                });
                console.log(order);
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "{{ route('admin.vehicle.position.change') }}",
                        data: {
                        order: order,
                        _token: token
                    },
                    success: function(response) {
                        if (response.status == "success") {
                            $('tr.tableRow').each(function(index) {
                                $(this).find('.pos_num').text(index + 1);

                                //console.log(index);
                            });
                            toastr.success(response.message, "", {
                                positionClass: "toast-top-right",
                                timeOut: 5e3,
                                closeButton: !0,
                                progressBar: !0
                                
                            })
                        } else {
                            toastr.error(response.message, "", {
                                positionClass: "toast-top-right",
                                timeOut: 5e3,
                                closeButton: !0,
                                progressBar: !0
                                
                            })
                        }
                    }
                });
            }
        } );
    </script>
    @stack('scripts')
@endsection
