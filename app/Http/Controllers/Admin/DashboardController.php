<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Query;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        $countDataArray = [];
        $newQuotesCountData = Query::where('status',1)->count();
        $quotedCountData = Query::where('status',2)->count();
        $forwardCountData = Query::where('status',3)->count();
        $bookedCountData = Query::where('status',4)->count();
        $removedCountData = Query::onlyTrashed()->count();
        $countDataArray['countData'] = [
            'newQuotes' => $newQuotesCountData,
            'quoted' => $quotedCountData,
            'forwarded' => $forwardCountData,
            'booked' => $bookedCountData,
            'removed' => $removedCountData
        ];

        $currentYear = Carbon::now()->year;
        $newQuotes = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$currentYear)
                    ->where('status',1)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
     
        $quoted = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$currentYear)
                    ->where('status',2)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
       
        $forwarded = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$currentYear)
                    ->where('status',3)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
        $booked = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$currentYear)
                    ->where('status',4)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
        $removed = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('deleted_at',$currentYear)
                    ->onlyTrashed()
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
       
                    
        $labels = [];
        $quotesData = [];
        $quotedData = [];
        $bookedData = [];
        $removedData = [];
        $forwardData = [];
        for ($m=1; $m<=12; $m++) {
            $month = date('F', mktime(0,0,0,$m, 1));
          
            $quotesCount = 0;
            foreach($newQuotes as $newData){
                if($newData->month == $m){
                    $quotesCount = $newData->count;
                    break;
                }
            }
            array_push($labels,$month);
            array_push($quotesData,$quotesCount);
            $quoteCount = 0;
            foreach($quoted as $quote){
                if($quote->month == $m){
                    $quoteCount = $quote->count;
                    break;
                }
            }
            array_push($quotedData,$quoteCount);
            $bookedCount = 0;
            foreach($booked as $book){
                if($book->month == $m){
                    $bookedCount = $book->count;
                    break;
                }
            }
            array_push($bookedData,$bookedCount);
            $removedCount = 0;
            foreach($removed as $remove){
                if($remove->month == $m){
                    $removedCount = $remove->count;
                    break;
                }
            }
            array_push($removedData,$removedCount);
            $forwardCount = 0;
            foreach($forwarded as $forward){
                if($forward->month == $m){
                    $forwardCount = $forward->count;
                    break;
                }
            }
            array_push($forwardData,$forwardCount);
        }

        $pieLabels = ['New Quotes', 'Quoted', 'Booked', 'Removed', 'Forward'];
        $colors = [];
        $pieDataArray = [];

        foreach($pieLabels as $key => $pie){
            if($pie == 'New Quotes'){
                $pieDataArray[] = $newQuotesCountData;
                $colors[] = '#FF0000';
            }
            if($pie == 'Quoted'){
                $pieDataArray[] = $quotedCountData;
                $colors[] = '#E28743';
              
            }
            if($pie == 'Booked'){
                $pieDataArray[] = $bookedCountData;
                $colors[] = '#49be25';
            }
            if($pie == 'Removed'){
                $pieDataArray[] = $removedCountData;
                $colors[] = '#676d66';
            }
            if($pie == 'Forward'){
                $pieDataArray[] = $forwardCountData;
                $colors[] = '#5050d0';
            }
        }
       
        $pieData = [
            'labels' => $pieLabels,
            'backgroundColor' => $colors,
            'data' => $pieDataArray,
        ];
        return view('backend.dashboard',compact(
            'countDataArray',
            'labels',
            'quotesData',
            'quotedData',
            'bookedData',
            'removedData',
            'forwardData',
            'pieData'
        ));
    }
}
