@extends('backend.layouts.app')

@section('title')
    Removed
@endsection

@section('styles')
    @parent
    <link href="{{url('backend/vendor/datatables/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('backend/vendor/select2/css/select2.min.css')}}">
    <link href="{{url('backend/vendor/bootstrap-select/dist/css/bootstrap-select.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{url('backend/vendor/toastr/css/toastr.min.css')}}">
<<<<<<< HEAD
    <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
=======
	<link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
>>>>>>> cdf5ca0 (design changes issue fixed)
    @stack('styles')
@endsection

@section('content')

        <div class="content-body">
            <div class="container-fluid">
                <div id="notify">@include('backend.layouts.alerts')</div>
                

                <div class="card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                            
                                <div class="card-body">
                                    <div class="">
                                        <table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
                                            <thead>
                                                <tr>
<<<<<<< HEAD
                                                    <th>#</th>
=======
													<th>#</th>
>>>>>>> cdf5ca0 (design changes issue fixed)
                                                    <th>Quote ID</th>
                                                    <th>User Details</th>
                                                    <th>Pickup Point</th>
                                                    <th>Pickup Date</th>
                                                    <th>Destination</th>
                                                    <th>Action </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                
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

@endsection
@section('scripts')
    @parent
    <script src="{{url('backend/vendor/datatables/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/datatables.init.js')}}"></script>
    <script src="{{url('backend/js/loader.js')}}"></script>
    <script>
       $(function () {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                order: [[ 0 , "desc" ]],
                pageLength: 15,
                lengthMenu: [
                    [15, 25, 50, -1],
                    [15, 25, 50, 'All']
                ],
                columnDefs: [ { orderable: false, targets: [0,1,2,3,4,5] ,} ],
                language: {
                        processing: '<div id="resultLoading"><div><i style="font-size: 46px;color: #363062;" class="fa fa-spinner fa-spin fa-2x fa-fw" aria-hidden="true"></i></div><div class="bg"></div></div>'
                    },
                ajax: "{{ route('admin.removed.index') }}",
                
                columns: [
<<<<<<< HEAD
                    {data: 'id', name: 'id', visible:false},
                    {data: 'quote_id', name: 'quote_id'},
                    {data: 'user_details', name: 'user_details'},
                    {data: 'pickup_point', name: 'pickup_point'},
                    {data: 'pickup_datetime', name: 'pickup_datetime'},
                    {data: 'destination', name: 'destination'},
                    {data: 'action', name: 'action', orderable: false, searchable: true}
=======
                     {data: 'id', name: 'id', visible:false },
					{data: 'quote_id', name: 'quote_id', orderable: false},
					{data: 'user_details', name: 'user_details', orderable: false},
					{data: 'pickup_point', name: 'pickup_point', orderable: false},
					{data: 'pickup_datetime', name: 'pickup_datetime', orderable: false},
					{data: 'destination', name: 'destination', orderable: false},
					{data: 'action', name: 'action', orderable: false, searchable: true}
>>>>>>> cdf5ca0 (design changes issue fixed)
                ],
            });
           
        });
        
    </script>
    @stack('scripts')
@endsection
