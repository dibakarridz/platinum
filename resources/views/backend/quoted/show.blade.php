@extends('backend.layouts.app')

@section('title')
     Show
@endsection

@section('styles')
    @parent
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
                <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                    
                    <a type="button" href="{{route('admin.quotes.print.view',$query->id)}}" class="btn btn-primary btn-xs" target="_blank"><i class="fas fa-print"></i>&nbsp;Print</a>&nbsp;&nbsp;
                    
                </div>
            </div>
            <div class="card mt-4">
                <div class="row">
                    <h5 style="margin-left:10px !important;margin-top:10px;!important;">View Quotes({{$query->prefix_quoteid.''.$query->booking->query_id}})</h5>
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
                                        <td><b>Email Address</b></td>
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

                                    <!--booking details -->

                                    <tr>
                                        <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> System Details</h4></td>
                                    </tr>
                                    <tr>
                                        <td><b>Datetime</b></td>
                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->datetime)->format('D d M Y h:i A')}}</td>
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
                </div>
                
               
                <hr class="line-bar">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title" style="margin-left:10px !important;">Send a email quote from here</h3>
                            </div>
                            <div class="box-body" style="margin-left:10px !important;">
                                <form class="needs-validation" id="sendEmailQuote" action="{{route('admin.quotes.send.quotation',$query->id)}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    @foreach($vehicles as $key => $val)
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ $val->name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <input id="price_{{$val->id}}" type="text" name="quotePrice[{{$val->id}}][price]" placeholder="price"
                                                        class="form-control">
                                                    @error('error_price')
                                                        <div class="invalid-feedback" style="display:inline !important;">
                                                        {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                      
                                    @endforeach
                                    
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="form-label">Quotation Details</label>
                                            <textarea class="form-control" id="quotation_details" name="quotation_details" rows="5">{{old('quotation_details')}}</textarea>
                                            @error('quotation_details')
                                                <div class="invalid-feedback" style="display:inline !important;">
                                                {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="box-footer float-end">
                                        <button type="submit" class="btn btn-primary">Send Quotation</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="line-bar">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title" style="margin-left:10px !important;">Quoted Lists</h3>
                            </div>
                            <div class="box-body table-responsive no-padding">
                                <table class="table table-hover">
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
                                    
                                    @php($resendRoute = route('admin.quotes.resend.quotation',['quote'=>$query->id,'quoted'=>$val['id']]))
                                  
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            
                                            <td>
                                            <?php foreach ($val['quote_details_price'] as $key => $price){
                                                if($price['vehicle_name'] != ''){
                                                    echo $price['vehicle_name'].' : <b>&pound;'.$price['quote_price'].'</b><hr>';
                                                }
                                            }?>
                        
                                            </td>
                                            <td>{{$val['quotation_details']}}</td>
                                            <td>
                                                {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val['datetime'])->format('D d M Y h:i A')}}
                                               
                                                <br>
                                                <a class="btn btn-primary btn-xs" data-bs-target="#resendConfirm" href="javascript:void(0);" 
                                                    data-bs-toggle="modal" title="Resend Quote" 
                                                    onclick="resendConfirm('<?php echo $resendRoute;?>','<?php echo $query->id;?>','<?php echo $val['id'];?>','Are you sure do you want resend this quotation again?')">
                                                    Resend Quote
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
   <script>
    $('#sendEmailQuote').validate({
            ignore: [],
            debug: false,
        rules: {
            quotation_details: {
                required: true,
            },
        },
        messages: {
            quotation_details: {
                required: "This field is required",
            },
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
        error.addClass('invalid-feedback');
        element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
        $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
        $(element).removeClass('is-invalid');
        }
    });
   </script>
    @stack('scripts')
@endsection