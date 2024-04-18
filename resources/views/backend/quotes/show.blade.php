@extends('backend.layouts.app')

@section('title')
     Show
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    <style>
        .line-bar {
            border: 2px solid blue;
            border-radius: .75rem;
            color: rgb(255,255,255,0.25);
          
        }
        hr:last-child {
            display: none;
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
                <div class="col-sm-6 d-flex flex-row-reverse align-items-center viewBtn">
                    <a type="button" href="{{route('admin.quotes.edit',['quote' => $query->id])}}" class="btn btn-secondary btn-xs"><i class="fas fa-edit"></i>&nbsp;Edit</a>
                </div>
            </div>
            <div class="card mt-4">
                <div class="row">	
					<div class="col-md-12">
                    <h5 class="vq">View Quotes({{$query->prefix_quoteid.''.$query->booking->query_id}})</h5>
					</div>
                    <div class="col-md-6">
                        <hr class="line-bar">
                        <div class="box box-primary">
                            <div class="box-body">
                                <table class="table">
                                    <tr>
                                        <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Personal Details</h4></td>
                                    </tr>
                                    <tr>
                                        <td><b>Name</b></td>
                                        <td>{{$query->full_name ?: ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Email</b></td>
                                        <td>{{$query->email ?: ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Phone</b></td>
                                        <td>{{$query->phone ?: ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Mobile</b></td>
                                        <td>{{$query->mobile ?: ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Address</b></td>
                                        <td>{{$query->address ?: ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>City</b></td>
                                        <td>{{$query->city ?: ''}}</td>
                                    </tr>
                                    <tr>
                                        <td><b>Post Code</b></td>
                                        <td>{{$query->postcode ?: ''}}</td>
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
                                    <tr>
                                        <td><b>Booking Comment</b></td>
                                        <td>
                                            {!! $query->booked_comment ?: 'No comment' !!}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <hr class="line-bar">
                        <div class="box box-primary">
                            <div class="box-body">
                                <table class="table">
                                    <tr>
                                        <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Booking Details</h4></td>
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
                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->pick_datetime)->format('D d M Y h:i A')}}</td>
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
                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->returning_datetime)->format('D d M Y h:i A')}}</td>
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
                    </div>
                    <div class="col-sm-12">
                        <hr class="line-bar">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">Quoted Lists</h3>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-striped table-responsive-sm">
                                    <tr>
                                        <th>SL</th>
                                        <th>Prices</th>
                                        <th>Details</th>
                                        <th>Sent On</th>
                                    </tr>
                                    @if(empty($quoted))
                                        <tr><td colspan="4" style="text-align: center;"> No data here!</td></tr>
                                    @endif

                                    @foreach($quoted as $key => $val)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            
                                            <td>
                                            <?php foreach ($val['quote_details_price'] as $key => $price){
                                                echo $price['vehicle_name'].' : <b>&pound;'.$price['quote_price'].'</b><hr>';
                                            }?>
                        
                                            </td>
                                            <td>{{$val['quotation_details']}}</td>
                                            <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val['datetime'])->format('D d M Y h:i A')}}</td>
                                        </tr>
                                    @endforeach
                                </table>
                            </div>
                        </div>
                        <hr class="line-bar">
                        <div class="box box-primary">
                            <div class="box-body">
                                <table class="table">
                                    <tr>
                                        <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Change Status</h4></td>
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
                                        <td class="changeStatusBtn">
                                            @if($query->status == 1)
                                                <a class="btn btn-primary btn-xs btn-primary-quoted" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','2','Are you sure to change the status as a quoted?')">
                                                    <i class="fas fa-question"></i> Quoted
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-forward" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','3','Are you sure to change the status as a forward?')">
                                                    <i class="fas fa-share"></i> Forward
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-booked" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','4','Are you sure to change the status as a booked?')">
                                                    <i class="fas fa-check"></i> Booked
                                                </a>
                                            @elseif($query->status == 2)
                                                <a class="btn btn-primary btn-xs btn-primary-quotes" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','1','Are you sure to change the status as a new quoted?')">
                                                    <i class="fas fa-exclamation"></i> New Quote
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-forward" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','3','Are you sure to change the status as a new forward?')">
                                                    <i class="fas fa-share"></i> Forward
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-booked" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','4','Are you sure to change the status as a new booked?')">
                                                    <i class="fas fa-check"></i> Booked
                                                </a>
                                            @elseif($query->status == 3)
                                                <a class="btn btn-primary btn-xs btn-primary-quotes" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','1','Are you sure to change the status as a new quoted?')">
                                                    <i class="fas fa-exclamation"></i> New Quote
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-quoted" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','2','Are you sure to change the status as a quoted?')">
                                                    <i class="fas fa-question"></i> Quoted
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-booked" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','4','Are you sure to change the status as a new booked?')">
                                                    <i class="fas fa-check"></i> Booked
                                                </a>
                                            @elseif($query->status == 4)
                                                <a class="btn btn-primary btn-xs btn-primary-quotes" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','1','Are you sure to change the status as a new quoted?')">
                                                    <i class="fas fa-exclamation"></i> New Quote
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-quoted" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','2','Are you sure to change the status as a quoted?')">
                                                    <i class="fas fa-question"></i> Quoted
                                                </a>
                                                <a class="btn btn-primary btn-xs btn-primary-forward" data-bs-target="#QuotesChangeStatus"
                                                    href="javascript:void(0);" data-bs-toggle="modal" title="Status" 
                                                    onclick="quoteStatusChange('{{ route('admin.quotes.change.status', $query->id)}}','3','Are you sure to change the status as a new forward?')">
                                                    <i class="fas fa-share"></i>Forward
                                                </a>
                                            @else
                                                {{'N/A'}}
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        {{-- <td></td> --}}
                                        <td>
                                            <a type="button" href="{{route('admin.quotes.print.view',$query->id)}}" class="btn btn-primary btn-xs" target="_blank"><i class="fas fa-print"></i>&nbsp;Print</a>
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
        
@endsection
@section('scripts')
    @parent
   
    @stack('scripts')
@endsection
