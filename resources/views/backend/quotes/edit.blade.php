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
        .line-bar {
            border: 2px solid blue;
            border-radius: .75rem;
            color: rgb(255,255,255,0.25);
          
        }
        .mycontent-left {
            border-right: 2px solid blue;
            border-radius: .75rem;
            color: rgb(255,255,255,0.25);
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit</a></li>
                        </ol>
                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse align-items-center">
                        <a type="button" href="#" class="btn btn-primary btn-xs"><i class="fas fa-print"></i>&nbsp;Print</a>&nbsp;&nbsp;
                       
                    </div>
                </div>
                <form class="needs-validation" id="quoteEdit" action="{{route('admin.quotes.update',['quote' => $query->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <h5>Edit Quotes({{$query->prefix_quoteid.''.$query->booking->query_id}})</h5>
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
                                            <td class="form-group">
                                                <input type="text" id="full_name" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{old('full_name',$query->full_name ?: '')}}">
                                                @error('full_name')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Email Address</b></td>
                                            <td class="form-group">
                                                <input type="text" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email',$query->email ?: '')}}">
                                                @error('email')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Phone</b></td>
                                            <td class="form-group">
                                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone',$query->phone ?: '')}}">
                                                @error('phone')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Mobile</b></td>
                                            <td class="form-group">
                                                <input type="text" id="mobile" name="mobile" class="form-control @error('mobile') is-invalid @enderror" value="{{old('mobile',$query->mobile ?: '')}}">
                                                @error('mobile')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Address</b></td>
                                            <td class="form-group">
                                                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{old('address',$query->address ?: '')}}">
                                                @error('address')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>City</b></td>
                                            <td class="form-group">
                                                <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{old('city',$query->city ?: '')}}">
                                                @error('city')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Post Code</b></td>
                                            <td class="form-group">
                                                <input type="text" id="postcode" name="postcode" class="form-control @error('postcode') is-invalid @enderror" value="{{old('postcode',$query->postcode ?: '')}}">
                                                @error('postcode')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
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
                                            <td class="form-group">
                                                <select id="single-select" name="status" class="form-control @error('status') is-invalid @enderror">
                                                    <option value="">--Select Status--</option>
                                                    <option value="1" @if($query->status == 1){{'selected'}}@endif>New Quote</option>
                                                    <option value="2" @if($query->status == 2){{'selected'}}@endif>Quoted</option>
                                                    <option value="3" @if($query->status == 3){{'selected'}}@endif>Forward</option>
                                                    <option value="4" @if($query->status == 4){{'selected'}}@endif>Booked</option>
                                                </select>
                                                @error('status')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
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
                                            <td class="form-group">
                                                <input type="text" id="booking_pickupPoint" name="booking_pickupPoint" class="form-control @error('booking_pickupPoint') is-invalid @enderror" value="{{old('booking_pickupPoint',$query->booking->booking_pickupPoint ?? '')}}">
                                                @error('booking_pickupPoint')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Postcode</b></td>
                                            <td class="form-group">
                                                <input type="text" id="booking_postcode" name="booking_postcode" class="form-control @error('booking_postcode') is-invalid @enderror" value="{{old('booking_postcode',$query->booking->booking_postcode ?? '')}}">
                                                @error('booking_postcode')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Pick Datetime</b></td>
                                            <td class="form-group">
                                                <input type="datetime-local" id="pick_datetime" name="pick_datetime" class="form-control datatimepicker @error('pick_datetime') is-invalid @enderror" value="{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->pick_datetime)->format('Y-m-d h:i:s')}}">
                                                @error('pick_datetime')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>No of Passenger</b></td>
                                            <td class="form-group">
                                                <input type="text" id="noOf_passenger" name="noOf_passenger" class="form-control @error('noOf_passenger') is-invalid @enderror" value="{{old('noOf_passenger',$query->booking->noOf_passenger ?? '')}}">
                                                @error('noOf_passenger')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Type of Journey</b></td>
                                            <td class="form-group">
                                                <input type="text" id="booking_return" name="booking_return" class="form-control @error('booking_return') is-invalid @enderror" value="{{old('booking_return',$query->booking->booking_return ?? '')}}">
                                                @error('booking_return')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror

                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Destination</b></td>
                                            <td class="form-group">
                                                <input type="text" id="destination" name="destination" class="form-control @error('destination') is-invalid @enderror" value="{{old('destination',$query->booking->destination ?? '')}}">
                                                @error('destination')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror

                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Destination Postcode</b></td>
                                            <td class="form-group">
                                                <input type="text" id="destination_postcode" name="destination_postcode" class="form-control @error('destination_postcode') is-invalid @enderror" value="{{old('destination_postcode',$query->booking->destination_postcode ?? '')}}">
                                                @error('destination_postcode')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td><b>Returning Datetime</b></td>
                                            <td class="form-group">
                                                @if(!empty($query->booking->returning_datetime) && ($query->booking->returning_datetime != '0000-00-00 00:00:00'))
                                                    <input type="datetime-local" my-date-format="YYYY-MM-DD, hh:mm:ss" id="returning_datetime" name="returning_datetime" class="form-control datatimepicker @error('returning_datetime') is-invalid @enderror" value="{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->returning_datetime)->format('Y-m-d H:i:s')}}">
                                                @else
                                                    <input type="datetime-local" my-date-format="YYYY-MM-DD, hh:mm:ss" id="returning_datetime" name="returning_datetime" class="form-control datatimepicker @error('returning_datetime') is-invalid @enderror" value="">
                                                @endif
                                                @error('returning_datetime')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Occasion</b></td>
                                            <td class="form-group">
                                                <input type="text" id="occasion" name="occasion" class="form-control @error('occasion') is-invalid @enderror" value="{{old('occasion',$query->booking->occasion ?? '')}}">
                                                @error('occasion')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><b>Journey Details</b></td>
                                            <td class="form-group">
                                                <textarea id="journey_details" name="journey_details" class="form-control @error('journey_details') is-invalid @enderror" rows="5">{{old('journey_details',$query->booking->journey_details)}}</textarea>
                                            
                                                @error('journey_details')
                                                    <div class="invalid-feedback">
                                                    {{ $message }}
                                                    </div>
                                                @enderror
                                            </td>
                                        </tr>
                                        

                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="box-footer text-center">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
@endsection
@section('scripts')
    @parent
    <script src="{{url('backend/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{url('backend/js/plugins-init/select2-init.js')}}"></script>
    <script>
        
       
        $(document).ready(function () {
            var today = new Date().toISOString().slice(0, 16);
            document.getElementsByClassName("datatimepicker")[0].min = today;
            // jQuery('#endDate').datetimepicker({
            //     format: 'DD/MM/YYYY HH:mm:ss',
            //     minDate: new Date()
            // });
            $(".datetimepicker").each(function () {
                $(this).datetimepicker();
            });
        })
        $('#quoteEdit').validate({
            ignore: [],
            debug: false,
        rules: {
            full_name: {
                required: true,
            },
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength:11,
            },
            address: {
                required: true,
            },
            city: {
                required: true,
            },
            postcode: {
                required: true,
            },
            status: {
                required: true,
            },
            booking_pickupPoint: {
                required: true,
            },
            booking_postcode: {
                required: true,
            },
            pick_datetime: {
                required: true,
            },
            noOf_passenger: {
                required: true,
            },
            booking_return: {
                required: true,
            },
            destination: {
                required: true,
            },
            destination_postcode: {
                required: true,
            },
            returning_datetime: {
                required: true,
            },
            occasion: {
                required: true,
            },
            journey_details: {
                required: true,
            },
        },
        messages: {
            full_name: {
                required: "This field is required",
            },
            email: {
                required: "This field is required",
            },
            phone: {
                required: "This field is required",
            },
            address: {
                required: "This field is required",
            },
            city: {
                required: "This field is required",
            },
            postcode: {
                required: "This field is required",
            },
            status: {
                required: "This field is required",
            },
            booking_pickupPoint: {
                required: "This field is required",
            },
            booking_postcode: {
                required: "This field is required",
            },
            pick_datetime: {
                required: "This field is required",
            },
            noOf_passenger: {
                required: "This field is required",
            },
            booking_return: {
                required: "This field is required",
            },
            destination: {
                required: "This field is required",
            },
            destination_postcode: {
                required: "This field is required",
            },
            returning_datetime: {
                required: "This field is required",
            },
            occasion: {
                required: "This field is required",
            },
            journey_details: {
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
