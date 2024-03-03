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
        .mycontent-left {
            border-right: 2px solid blue;
            border-radius: .75rem;
            color: rgb(255,255,255,0.25);
        }
        .ck {
            /* height: 300px !important; */
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Book</a></li>
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
                                        <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Booked the quote</h4></td>
                                    </tr>
                                </table>
                                <form class="needs-validation" id="bookForm" action="{{route('admin.quotes.book.store',$query->id)}}" method="post" enctype="multipart/form-data" autocomplete="off">
                                    @csrf
                                    @method('PUT')
                                    <div class="col-md-12">
                                        <div class="form-group comment-field">
                                            <label class="form-label">Comments</label>
                                            <textarea id="comment" type="text" name="comment" rows="15" placeholder="Enter comment"
                                                class="form-control ckeditor @error('comment') is-invalid @enderror">{{$query->booked_comment ?? ''}}</textarea>
                                                <div class="comment-invalid-feedback" id="error_comment"></div>
                                            @error('comment')
                                                <div class="invalid-feedback" id="error_comment">
                                                {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-12 d-flex flex-row-reverse">
                                        <button type="submit" class="btn btn-xs btn-primary comment-field">Booked</button>
                                    </div>
                                </form>
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
    <script src="{{url('backend/vendor/ckeditor/ckeditor.js')}}"></script>
    <script>
       
       ClassicEditor
        .create( document.querySelector( '.ckeditor' ), {
       
        } )
        $("#bookForm").submit(function(e) {
            var content = $('.ckeditor').val();
            html = $(content).text();
            if ($.trim(html) == '') {
                $('#error_comment').text("This field is required");
                e.preventDefault();
            } 
        });
        $('#bookForm').validate({
            ignore: [],
            debug: false,
        rules: {
            comment: {
                required: true,
            },
        },
        messages: {
            comment: {
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
