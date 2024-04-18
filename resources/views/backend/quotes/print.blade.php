<!DOCTYPE html>
<html lang="en" class="h-100">
<?php $setting = Setting();?>
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Print Quote :: {{$setting->title}}</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{url('backend/images/favicon.ico')}}">
	<link href="{{url('backend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{url('backend/vendor/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link href="{{url('backend/backend/css/adminlte.min.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <style type="text/css">
        @media print{
            @page { margin: 1cm; }
            body { margin: 0cm; }
            .table-responsive{
                width:48%;
            }

        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->



            <!-- Table row -->
            <div class="row">
                <div class="row">
                    <div class="col-md-12" style="margin-left: 20px;">
                        <h3>Quotation ID : {{$query->prefix_quoteid ?? ''}} {{$query->booking->query_id ?? ''}}</h3>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-5 table-responsive pull-left" style="margin-left: 20px;">
                        <table class="table table-striped">
                            <tr>
                                <td colspan="2"><h4>Personal Details</h4></td>
                            </tr>
                            <tr>
                                <td><b>Name</b></td>
                                <td>
                                    {{ $query->full_name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <td><b>Email</b></td>
                                <td>{{ $query->email ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><b>Phone</b></td>
                                <td>{{ $query->phone ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><b>Mobile</b></td>
                                <td>{{ $query->mobile ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><b>Address</b></td>
                                <td>{{ $query->address ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><b>City</b></td>
                                <td>{{ $query->city ?? '' }}</td>
                            </tr>
                            <tr>
                                <td><b>Post Code</b></td>
                                <td>{{ $query->postcode ?? '' }}</td>
                            </tr>

                            <tr>
                                <td><b>Status</b></td>
                                <td>
                                    @if($query->status!='')
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
                                    @else
                                        {{'No status'}}
                                    @endif
                                </td>
                            </tr>
                            @if($query->booked_comment !='') 
                                <tr>
                                    <td>Booking Comment</td>
                                    <td>                                                             
                                        {{strip_tags($query->booked_comment)}}
                                    </td>
                                </tr>
                            @endif
                        </table>    
                    </div>

                    <div class="col-md-5 table-responsive pull-right">
                        <table class="table table-striped">
                            <tr>
                                <td colspan="2"><h4>Booking Details</h4></td>
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
                                <td>
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->pick_datetime)->format('D d M Y h:i A')}}
                                </td>
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

                            <?php if(!empty($Details['returning_datetime']) && $Details['returning_datetime'] !='0000-00-00 00:00:00') {?>
                            <tr>
                                <td><b>Returning Datetime</b></td>
                                @if(!empty($query->booking->returning_datetime) && $query->booking->returning_datetime !='0000-00-00 00:00:00')
                                <td>
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $query->booking->returning_datetime)->format('D d M Y h:i A')}}
                                </td>
                                @endif
                            </tr>
                            <?php }?>

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

                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12" style="margin-left: 20px;">
                        <table class="table table-striped" style="width: 100%;">
                            <tr>
                                <td colspan="4"><h4>Quoted Lists</h4></td>
                            </tr>

                            <tr>
                                <th>SL</th>
                                <th>Prices</th>
                                <th>Details</th>
                                <th>Sent On</th>
                            </tr>
                            @if(empty($quoted))
                                <tr><td colspan="4" style="text-align: center;">No Quoted Found !!!</td></tr>
                            @endif
                            @foreach($quoted as $key => $val)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        <?php foreach ($val['quote_details_price'] as $price){
                                            echo $price['vehicle_name'].' : <b>&pound;'.$price['quote_price'].'</b><br>';
                                        }?>

                                    </td>
                                    <td>{{$val['quotation_details']}}</td>
                                    <td>{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $val['datetime'])->format('D d M Y h:i A')}}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>


                <!-- /.col -->
            </div>
            <!-- /.row -->


        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->
</body>
<script type="text/javascript">
    window.print();
</script>
</html>
