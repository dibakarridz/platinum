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
	<link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    <link rel="stylesheet" href="{{url('backend/vendor/bootstrap-daterangepicker/daterangepicker.css')}}">
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Quotes</a></li>
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
                            
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-xl-4 mb-3">
                                            <div class="example">
                                                <p class="mb-1">Pickup Date</p>
                                                <input id="filter_daterange" class="form-control input-daterange-datepicker"
                                                 type="text" name="daterange" placeholder="Select Pickup Date">
                                                <input type="hidden" id="start_date" name="start_date" value="">
                                                <input type="hidden" id="end_date" name="end_date" value="">
                                            </div>
                                        </div>
                                        <div class="col-xl-4 mb-3">
                                            <div class="example">
                                                <p class="mb-1">Returning Date</p>
                                                <input id="filter_returndaterange" class="form-control input-daterange-datepicker"
                                                 type="text" name="returndaterange" placeholder="Select Returning Date">
                                                <input type="hidden" id="return_start_date" name="return_start_date" value="">
                                                <input type="hidden" id="return_end_date" name="return_end_date" value="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="">
                                        <table id="dataTable" class="table table-striped table-responsive-sm" style="min-width: 845px">
                                            <thead>
                                                <tr>
													<th class="sortAlignment">#</th>
                                                    <th class="sortAlignment">Quote ID</th>
                                                    <th class="sortAlignment">User Details</th>
                                                    <th class="sortAlignment">Pickup Point</th>
                                                    <th class="sortAlignment">Pickup Date</th>
                                                    <th class="sortAlignment">Destination</th>
                                                    <th class="sortAlignment">Action </th>
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
    <script src="{{url('backend/vendor/moment/moment.min.js')}}"></script>
    <script src="{{url('backend/vendor/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
    <script src="{{url('backend/js/loader.js')}}"></script>
    <script>
       $(function () {
            $('#start_date').val(moment().subtract(100, 'Y'));
            $('#end_date').val(moment().add(1, 'Y'));
            $('#return_start_date').val(moment().subtract(100, 'Y'));
            $('#return_end_date').val(moment().add(1, 'Y'));
            var oTable = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                columnDefs: [ { orderable: false, targets: [0,1,2,3,4,5] ,} ],
                language: {
                        processing: '<div id="resultLoading"><div><i style="font-size: 46px;color: #363062;" class="fa fa-spinner fa-spin fa-2x fa-fw" aria-hidden="true"></i></div><div class="bg"></div></div>'
                    },
                ajax : {
                    url : "{{ route('admin.removed.index') }}",
                    data : function(d){
                        d.start_date = $('#start_date').val(),
                        d.end_date = $('#end_date').val(),
                        d.return_start_date = $('#return_start_date').val(),
                        d.return_end_date = $('#return_end_date').val(),
                        d.search = $('input[type="search"]').val()
                    }
                },
                
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false,visible: false },
					{data: 'quote_id', name: 'quote_id'},
					{data: 'user_details', name: 'user_details'},
					{data: 'pickup_point', name: 'pickup_point'},
					{data: 'pickup_datetime', name: 'pickup_datetime'},
					{data: 'destination', name: 'destination'},
					{data: 'action', name: 'action', orderable: false, searchable: true}
                ],
            });
           
            $('.input-daterange-datepicker').daterangepicker({
                buttonClasses: ['btn', 'btn-sm'],
                applyClass: 'btn-danger',
                cancelClass: 'btn-inverse',
                autoUpdateInput: false,
                //showDropdowns: true,
                locale: {
                    format: 'YYYY-MM-DD',
                    separator: " to ",
                    cancelLabel: 'Clear'

                }
            });
            $('input[name="daterange"]').on('apply.daterangepicker', function(ev, picker) {
                
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
                $('#start_date').val(picker.startDate.format('YYYY-MM-DD'));
                $('#end_date').val(picker.endDate.format('YYYY-MM-DD'));
                oTable.draw();
            });

            $('input[name="daterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('#start_date').val(moment().subtract(100, 'Y'));
                $('#end_date').val(moment().add(1, 'Y'));
                oTable.draw();
            });

            $('input[name="returndaterange"]').on('apply.daterangepicker', function(ev, picker) {
                
                $(this).val(picker.startDate.format('YYYY-MM-DD') + ' to ' + picker.endDate.format('YYYY-MM-DD'));
                $('#return_start_date').val(picker.startDate.format('YYYY-MM-DD'));
                $('#return_end_date').val(picker.endDate.format('YYYY-MM-DD'));
                oTable.draw();
            });

            $('input[name="returndaterange"]').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
                $('#return_start_date').val(moment().subtract(100, 'Y'));
                $('#return_end_date').val(moment().add(1, 'Y'));
                oTable.draw();
            });
        });
        
    </script>
    @stack('scripts')
@endsection
