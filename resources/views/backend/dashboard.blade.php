@extends('backend.layouts.app')

@section('title')
    Dashboard
@endsection

@section('styles')
    @parent
        <link href="{{url('backend/css/custom.css')}}" rel="stylesheet">
    @stack('styles')
@endsection

@section('content')
	<div class="content-body">
        <div class="container-fluid">
                <div class="all-cardBox">
                <div class="card-box">
                    <a href="{{route('admin.quotes.index')}}">
                        <div class="card">
                           
                            <div class="card-body">
                                <div class="circle new-quotes"><i class="fas fa-exclamation"></i></div>
                                <p class="card-text new-quotes-text">New Quotes</p>
                                <p class="card-text"><strong>{{$countDataArray['countData']['newQuotes'] ?? '0'}}</strong></p>
                            </div>
                            
                        </div>
                    </a>
                </div>
                <div class="card-box">
                    <a href="{{route('admin.quoted.index')}}">
                        <div class="card">
                            <!-- <div class="card-header"></div> -->
                            <div class="card-body">
                                <div class="circle quoted"><i class="fas fa-question"></i></div>
                                <p class="card-text quote-text">Quoted</p>
                                <p class="card-text"><strong>{{$countDataArray['countData']['quoted'] ?? '0'}}</strong></p>
                            </div>
                            <!-- <div class="card-footer"></div> -->
                        </div>
                    </a>
                </div>
                <div class="card-box">
                    <a href="{{route('admin.booked.index')}}">
                        <div class="card">
                            <!-- <div class="card-header"></div> -->
                            <div class="card-body">
                                <div class="circle booked"><i class="fas fa-check"></i></div>
                                <p class="card-text book-text">Booked</p>
                                <p class="card-text"><strong>{{$countDataArray['countData']['booked'] ?? '0'}}</strong></p>
                            </div>
                            <!-- <div class="card-footer"></div> -->
                        </div>
                    </a>
                </div>
                <div class="card-box">
                    <a href="{{route('admin.removed.index')}}">
                        <div class="card">
                            <!-- <div class="card-header"></div> -->
                            <div class="card-body">
                                <div class="circle removed"><i class="fas fa-trash-alt"></i></div>
                                <p class="card-text removed-text">Removed</p>
                                <p class="card-text"><strong>{{$countDataArray['countData']['removed'] ?? '0'}}</strong></p>
                            </div>
                            <!-- <div class="card-footer"></div> -->
                        </div>
                    </a>
                </div>
                <div class="card-box">
                    <a href="{{route('admin.forwarded.index')}}">
                        <div class="card">
                            <!-- <div class="card-header"></div> -->
                            <div class="card-body">
                                <div class="circle forward"><i class="fas fa-share"></i></div>
                                <p class="card-text forward-text">Forwarded</p>
                                <p class="card-text"><strong>{{$countDataArray['countData']['forwarded'] ?? '0'}}</strong></p>
                            </div>
                            <!-- <div class="card-footer"></div> -->
                        </div>
                    </a>
                </div>
               </div>
            <!-- bar chart -->
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Previous Year Quotes</h4>
                                </div>
                                <div class="card-body">
                                    <div class="chart">
                                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end bar chart -->

            <!-- pie chart --->
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="col-xl-12 col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">All quotes</h4>
                                </div>
                                <div class="card-body">
                                    <canvas id="pieChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end pie chart -->
            
        </div>
    </div>
@endsection


@section('scripts')
    @parent
    <script src="{{url('backend/vendor/chart.js/Chart.bundle.min.js')}}"></script>
    <script>
       
        var areaChartData = {
            labels  : {!! json_encode($labels) !!},
            datasets: [
               
                
                {
                label               : 'Quoted',
                backgroundColor     : 'rgba(226,135,67,1)',
                borderColor         : 'rgba(226,135,67,0.9)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(226,135,67,1.1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(226,135,67,1.1)',
                data                : {!! json_encode($quotedData) !!}
                },
               
                {
                label               : 'Booked',
                backgroundColor     : 'rgba(73,190,37,0.9)',
                borderColor         : 'rgba(73,190,37,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(73,190,37,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(73,190,37,1)',
                data                : {!! json_encode($bookedData) !!}
                },
                {
                label               : 'Removed',
                backgroundColor     : 'rgba(103,109,102,0.9)',
                borderColor         : 'rgba(103,109,102,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(103,109,102,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(103,109,102,1)',
                data                : {!! json_encode($removedData) !!}
                },
                {
                label               : 'Forward',
                backgroundColor     : 'rgba(80,80,208,0.9)',
                borderColor         : 'rgba(80,80,208,0.8)',
                pointRadius          : false,
                pointColor          : '#3b8bba',
                pointStrokeColor    : 'rgba(80,80,208,1)',
                pointHighlightFill  : '#fff',
                pointHighlightStroke: 'rgba(80,80,208,1)',
                data                : {!! json_encode($forwardData) !!}
                },
            ]
        }
        var barChartCanvas = $('#barChart').get(0).getContext('2d')
        var barChartData = $.extend(true, {}, areaChartData)

        var barChartOptions = {
            responsive              : true,
            maintainAspectRatio     : false,
            datasetFill             : false
        }

        new Chart(barChartCanvas, {
            type: 'bar',
            data: barChartData,
            options: barChartOptions
        })

       // start pie chart
        var pieChartData        = {
            labels: @json($pieData['labels']),
            datasets: [
                    {
                    data:  @json($pieData['data']),
                    backgroundColor :  @json($pieData['backgroundColor']),
                    }
                ]
        }

        var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
        var pieData        = pieChartData;
        var pieOptions     = {
        maintainAspectRatio : false,
        responsive : true,
        datasetFill : false
        }
    
        new Chart(pieChartCanvas, {
            type: 'pie',
            data: pieData,
            options: pieOptions
        })
  
       
    </script>
    @stack('scripts')
@endsection
