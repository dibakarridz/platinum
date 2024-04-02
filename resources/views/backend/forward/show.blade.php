@extends('backend.layouts.app')

@section('title')
     Show
@endsection

@section('styles')
    @parent
    <link rel="stylesheet" href="{{url('backend/css/custom.css')}}">
    <style>
       
        hr:last-child {
            display: none;
        }
       
        .cke_chrome{
    border-radius: 10px;
    border: 1px solid #695656;
    border-width: thin;        
}

.cke_top{
    border-radius: 10px 10px 0px 0px
}

.cke_bottom{
    border-radius: 0px 0px 10px 10px
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Forward</a></li>
                    </ol>
                </div>
                <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                </div>
            </div>
            <div class="card mt-4">
                <div class="row">
                    <div class="col-md-6 mycontent-left">
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
                                        <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Forward the quote</h4></td>
                                    </tr>
                                </table>
                                
                                <form class="needs-validation" id="forwardForm" action="{{route('admin.quotes.forward.store',$query->id)}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-12">
                                        <div class="form-group comment-field">
                                            <label class="form-label"><strong>Email</strong></label>
                                            <input id="email" type="email" name="email" placeholder="Enter email"
                                                class="form-control @error('email') is-invalid @enderror">
                                             
                                            @error('email')
                                                <div class="invalid-feedback">
                                                {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex flex-row-reverse">
                                        <button type="submit" class="btn btn-xs btn-primary comment-field">Forward</button>
                                    </div>
                                </form>
                               
                                <hr class="line-bar">
                                    <div class ="col-sm-12">
                                        <table class="table">
                                            <tr>
                                                <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Forward Lists</h4></td>
                                            </tr>
                                        </table>
                                        <table class="table">
                                            <tr>
                                                <th>SL</th>
                                                <th>Email</th>
                                                <th>Sent On</th>
                                            </tr>
                                            @if(empty($query->forward))
                                                <tr>
                                                    <td colspan="3" style="text-align: center">No Forwarded Found </td>
                                                </tr>
                                            @endif
                                            @foreach($query->forward as $key => $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $item->forwarded_email ?? '' }}</td>
                                                    @if($item->datetime !='' || $item->datetime != '0000-00-00 00:00:00')
                                                        <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->datetime)->format('D d M Y h:i A')}}</td>
                                                    @else
                                                     {{ 'N/A' }}
                                                    @endif
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
    </div>
        
@endsection
@section('scripts')
    @parent
    <script>
     
        $('#forwardForm').validate({
            ignore: [],
            debug: false,
        rules: {
            email: {
                required: true,
                email: true,
            },
        },
        messages: {
            email: {
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
