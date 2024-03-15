@extends('backend.layouts.app')

@section('title')
    Quotes
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
               

                <div class="card mt-4">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                
                                <div class="card-body">
                                    <div class="">
                                        <table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
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
                language: {
                        processing: '<div id="resultLoading"><div><i style="font-size: 46px;color: #363062;" class="fa fa-spinner fa-spin fa-2x fa-fw" aria-hidden="true"></i></div><div class="bg"></div></div>'
                    },
                ajax: "{{ route('admin.forwarded.index') }}",
                
                columns: [
                    {data: 'id', name: 'id', visible:false },
                    {data: 'quote_id', name: 'quote_id'},
                    {data: 'user_details', name: 'user_details'},
                    {data: 'pickup_point', name: 'pickup_point'},
                    {data: 'pickup_datetime', name: 'pickup_datetime'},
                    {data: 'destination', name: 'destination'},
                    {data: 'action', name: 'action', orderable: false, searchable: true}
                ],
                "order": [[0,'desc']],
                "pageLength": 15,
                lengthMenu: [
                    [15, 25, 50, -1],
                    [15, 25, 50, 'All']
                ]
            });
        });
    </script>
    @stack('scripts')
@endsection
