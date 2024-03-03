@extends('backend.layouts.app')

@section('title')
     Show
@endsection

@section('styles')
    @parent
    <style>
        .nav-tabs {
            font-size:smaller !important;
        }
    </style>
    @stack('styles')
@endsection

@section('content')
          
<div class="content-body">
            <div class="container-fluid">
            <div id="notify">@include('backend.layouts.alerts')</div>
                <div class="row page-titles mx-0">
                    <div class="col-sm-6 d-flex align-items-center">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.index') }}">Home</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.quotes.index') }}">Quotes</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">view</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                        <a type="button" href="#" class="btn btn-primary btn-xs"><i class="fas fa-print"></i>Print</a>&nbsp;&nbsp;
                        <a type="button" href="#" class="btn btn-secondary btn-xs"><i class="fas fa-edit"></i>Edit</a>
                    </div>
                </div>
                <div class="row">
                    
                    <div class="col-xl-12">
                        <div class="card">
                           
                            <div class="card-body">
                                <!-- Nav tabs -->
                                <div class="custom-tab-1">
                                    <ul class="nav nav-tabs">
                                        <li class="nav-item">
                                            <a class="nav-link @if((Session::get('tab_active') == 'home') || empty(Session::get('tab_active'))){{'active'}} @endif" data-bs-toggle="tab" href="#home"> Personal Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#systemDetails"> System Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#bookingComment"> Booking Comment</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#bookingDetails">Booking Details</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" data-bs-toggle="tab" href="#quotedList">Quoted Lists</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link @if(Session::get('tab_active') == 'changeStatus'){{'active'}}@endif" data-bs-toggle="tab" href="#changeStatus">Change Status</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">
                                        <div class="tab-pane fade @if((Session::get('tab_active') == 'home') || empty(Session::get('tab_active'))){{'show active'}} @endif" id="home" role="tabpanel">
                                            <div class="pt-4">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="card text-white bg-primary">
                                                                <div class="card-header">
                                                                    <h4 class="card-title text-white"><i class="fa fa-arrow-circle-right"></i> Personal Details</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    
                                                    <tr>
                                                        <td><b>Name</b></td>
                                                        <td>{{$query->full_name ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Email Address</b></td>
                                                        <td>{{$query->email ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Phone</b></td>
                                                        <td>{{$query->phone ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Mobile</b></td>
                                                        <td>{{$query->mobile ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Address</b></td>
                                                        <td>{{$query->address ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>City</b></td>
                                                        <td>{{$query->city ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Post Code</b></td>
                                                        <td>{{$query->postcode ?? ''}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="systemDetails">
                                            <div class="pt-4">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="card text-white bg-primary">
                                                                <div class="card-header">
                                                                    <h4 class="card-title text-white"><i class="fa fa-arrow-circle-right"></i> System Details</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Datetime</b></td>
                                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->datetime)->format('d M Y h:i A')}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>IP Address</b></td>
                                                        <td>{{$query->ip_address ?: ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Website</b></td>
                                                        <td>{{$query->comes_website ?: ''}}</td>
                                                    </tr>

                                                    <tr>
                                                        <td><b>Status</b></td>
                                                        <td>
                                                            @if($query->status == 1)
                                                                {{'New Quote'}}
                                                            @elseif($query->status == 2)
                                                                {{'Quoted'}}
                                                            @elseif($query->status == 3)
                                                                {{'Forwarded'}}
                                                            @elseif($query->status == 4)
                                                                {{'Booked'}}
                                                            @else
                                                                {{''}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="bookingComment">
                                            <div class="pt-4">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="card text-white bg-primary">
                                                                <div class="card-header">
                                                                    <h4 class="card-title text-white"><i class="fa fa-arrow-circle-right"></i> Booking Comment</h4>
                                                                </div>
                                                                
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="card">
                                                                <div class="card-body">
                                                                   
                                                                        @if($query->booked_comment !='')                                                                        
                                                                            {{strip_tags($query->booked_comment)}}
                                                                        @else
                                                                         {{'No data'}}
                                                                        @endif
                                                                </div>
                                                                
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="bookingDetails">
                                            <div class="pt-4">
                                                <table class="table">
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="card text-white bg-primary">
                                                                <div class="card-header">
                                                                    <h4 class="card-title text-white"><i class="fa fa-arrow-circle-right"></i> Booking Details</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Pickup Point</b></td>
                                                        <td>{{$query->booking->booking_pickupPoint ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Postcode</b></td>
                                                        <td>{{$query->booking->booking_postcode ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Pick Datetime</b></td>
                                                        @if(!empty($query->booking->pick_datetime) && ($query->booking->pick_datetime !='0000-00-00 00:00:00'))
                                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->pick_datetime)->format('d M Y h:i A')}}</td>
                                                        @endif
                                                    </tr>
                                                    <tr>
                                                        <td><b>No of Passenger</b></td>
                                                        <td>{{$query->booking->noOf_passenger ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Type of Journey</b></td>
                                                        <td>{{$query->booking->booking_return ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Destination</b></td>
                                                        <td>{{$query->booking->destination ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Destination Postcode</b></td>
                                                        <td>{{$query->booking->destination_postcode ?? ''}}</td>
                                                    </tr>
                                                    @if(!empty($query->booking->returning_datetime) && $query->booking->returning_datetime !='0000-00-00 00:00:00')
                                                    <tr>
                                                        <td><b>Returning Datetime</b></td>
                                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->returning_datetime)->format('d M Y h:i A')}}</td>
                                                    </tr>
                                                    @endif
                                                    <tr>
                                                        <td><b>Occasion</b></td>
                                                        <td>{{$query->booking->occasion ?? ''}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td><b>Journey Details</b></td>
                                                        <td>{{$query->booking->journey_details ?? ''}}</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="quotedList">
                                            <div class="pt-4">
                                                <div class="table-responsive">
                                                    <div class="card text-white bg-primary">
                                                        <div class="card-header">
                                                            <h4 class="card-title text-white"><i class="fa fa-arrow-circle-right"></i> Quoted List</h4>
                                                        </div>
                                                    </div>
                                                    <table id="dataTable" class="table table-responsive-sm" style="min-width: 845px">
                                                    
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Prices</th>
                                                                <th>Details</th>
                                                                <th>Sent On</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @if(empty($quoted))
                                                                <tr><td colspan="4" style="text-align: center;"> No data here!</td></tr>
                                                            @endif

                                                            @foreach($quoted as $key => $val)
                                                                <tr>
                                                                    <td>{{$loop->iteration}}</td>
                                                                   
                                                                    <td>
                                                                    <?php foreach ($val['quote_details_price'] as $price){
                                                                        echo $price['vehicle_name'].' : <b>&pound;'.$price['quote_price'].'</b><br>';
                                                                    }?>
                                               
                                                                    </td>
                                                                    <td>{{$val['quotation_details']}}</td>
                                                                    <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val['datetime'])->format('d M Y h:i A')}}</td>
                                                                </tr>
                                                            @endforeach
                                                            
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade @if(Session::get('tab_active') == 'changeStatus'){{'show active'}} @endif" id="changeStatus">
                                            <div class="pt-4">
                                            <table class="table">
                                                    <tr>
                                                        <td colspan="2">
                                                            <div class="card text-white bg-primary">
                                                                <div class="card-header">
                                                                    <h4 class="card-title text-white"><i class="fa fa-arrow-circle-right"></i> Change Status</h4>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b> Current Status</b></td>
                                                        <td>
                                                            @if($query->status == 1)
                                                                {{'New Quote'}}
                                                            @elseif($query->status == 2)
                                                                {{'Quoted'}}
                                                            @elseif($query->status == 3)
                                                                {{'Forwarded'}}
                                                            @elseif($query->status == 4)
                                                                {{'Booked'}}
                                                            @else
                                                                {{'N/A'}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td><b> Change Status</b></td>
                                                        <td>
                                                            @if($query->status == 1)
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','2','Are you sure to change the status as a quoted?')">
                                                                    Quoted
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','3','Are you sure to change the status as a forward?')">
                                                                    Forward
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','4','Are you sure to change the status as a booked?')">
                                                                    Booked
                                                                </a>
                                                            @elseif($query->status == 2)
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','1','Are you sure to change the status as a new quoted?')">
                                                                    New Quote
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','3','Are you sure to change the status as a new forward?')">
                                                                    Forward
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','4','Are you sure to change the status as a new booked?')">
                                                                    Booked
                                                                </a>
                                                            @elseif($query->status == 3)
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','1','Are you sure to change the status as a new quoted?')">
                                                                    New Quote
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','2','Are you sure to change the status as a quoted?')">
                                                                    Quoted
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','4','Are you sure to change the status as a new booked?')">
                                                                    Booked
                                                                </a>
                                                            @elseif($query->status == 4)
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','1','Are you sure to change the status as a new quoted?')">
                                                                    New Quote
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','2','Are you sure to change the status as a quoted?')">
                                                                    Quoted
                                                                </a>
                                                                <a class="btn btn-primary btn-xs" data-bs-target="#QuotesChangeStatus"
                                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','3','Are you sure to change the status as a new forward?')">
                                                                    Forward
                                                                </a>
                                                            @else
                                                                {{'N/A'}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                </table>
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
