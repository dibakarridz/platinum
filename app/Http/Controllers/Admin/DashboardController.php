<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Query;
use App\Models\Domain;
use App\Models\Booking;
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

        $previousYear = Carbon::now()->subYear();
        $newQuotes = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$previousYear)
                    ->where('status',1)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
     
        $quoted = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$previousYear)
                    ->where('status',2)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
       
        $forwarded = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$previousYear)
                    ->where('status',3)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
        $booked = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('datetime',$previousYear)
                    ->where('status',4)
                    ->groupBy('month')
                    ->orderBy('month')
                    ->get();
        $removed = Query::selectRaw('MONTH(datetime) as month, COUNT(*) as count')
                    ->whereYear('deleted_at',$previousYear)
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

    public function create()
    {
        
        return view('backend.quoted-create');
    }

     public function store(Request $request)
     {
        $input = $request->all();
        $getDomain = Domain::select('unique_id','domain_name','success_msg','error_msg')->where('unique_id',$input['website_code'])->first();
    
        $rules = [
            'name-cl1' => 'required',
            'website_code' => 'required',
            'phone-cl1' => 'required',
            'Pickdate-111' => 'required',
        ];
        $customMessages = [
            'name-cl1.required' => 'Full Name',
            'website_code.required' => 'Website Code',
            'phone-cl1.required' => 'Phone Number',
            'Pickdate-111.required' => 'PickUp Date',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            if($input['redirect_url']){
                $redirect_url = $input['redirect_url'];
            }else{
                $redirect_domain = explode('?',$_SERVER['HTTP_REFERER']);
                $redirect_url = $redirect_domain[0];
            }
            return redirect()->away($redirect_url.'?status=error&msg='.$getDomain->error_msg);
        }

        $clientIP = $_SERVER['REMOTE_ADDR'];
        $pickUpDate =  $input['Pickdate-111'] ?? null;
        $pickupHour = $input['ddl-hr'] ?? '00';
        $pickupMin = $input['ddl-minute'] ?? '00';
        $pickupTime = $input['ddl-time'] ?? null;
        if($pickupHour !='' && $pickupMin !='' && $pickupTime !=''){
            $pickUpTimeFormat = $pickupHour.':'.$pickupMin.' '.$pickupTime;
            $pickTime = Carbon::createFromFormat('g:i A', $pickUpTimeFormat)->format('H:i:s');
        }else{
            $pickUpTimeFormat = $pickupHour.':'.$pickupMin.':00';
            $pickTime = Carbon::createFromFormat('H:i:s', $pickUpTimeFormat)->format('H:i:s');
        }
        
        if($pickUpDate != '' && $pickTime !=''){
            $dateFormat = $pickUpDate.' '.$pickTime;
            $pickUpDateFormat = Carbon::createFromFormat('Y-m-d H:i:s', $dateFormat)->format('Y-m-d H:i:s');
        }else{
            $pickUpDateFormat = null;
        }
        if($input['jtype-cl1'] != ''){
            if($input['jtype-cl1'] == 'Yes'){
                $booking_return = 'Return';
            }else if($input['jtype-cl1'] == 'No'){
                $booking_return = 'One Way';
            }else{
                $booking_return = null;
            }
        }else if($input['q8_return'] != ''){
            if($input['q8_return'] == 'Yes'){
                $booking_return = 'Return';
            }else if($input['q8_return'] == 'No'){
                $booking_return = 'One Way';
            }else{
                $booking_return = null;
            }
        }else{
            $booking_return = null;
        }

        $returnDate = $input['Returndate-111'] ?? null;
        $returnHour = $input['Returnddl-hr'] ?? '00';
        $returnMin = $input['Returnddl-minute'] ?? '00';
        $returnTime = $input['Returnddl-time'] ?? null;
        if($returnHour !='' && $returnMin !='' && $returnTime !=''){
            $returnTimeFormat = $returnHour.':'.$returnMin.' '.$returnTime;
            $returningTime = Carbon::createFromFormat('g:i A', $returnTimeFormat)->format('H:i:s');
        }else{
            $returnTimeFormat = $returnHour.':'.$returnMin.':00';
            $returningTime = Carbon::createFromFormat('H:i:s', $returnTimeFormat)->format('H:i:s');
        }
        if($returnDate != '' && $returningTime !=''){
            $returnFormat = $returnDate.' '.$returningTime;
            $returnDateFormat = Carbon::createFromFormat('Y-m-d H:i:s', $returnFormat)->format('Y-m-d H:i:s');
        }else{
            $returnDateFormat = null;
        }
        
        $query = new Query();
        $query->prefix_quoteid = $input['website_code'] ?? null;
        $query->comes_website = $getDomain->domain_name ?? null;
        $query->full_name = $input['name-cl1'] ?? null;
        $query->email = $input['email-cl1'] ?? null;
        $query->phone = $input['phone-cl1'] ?? null;
        $query->mobile = $input['mobile-cl1'] ?? null;
        $query->address = $input['address-cl1'] ?? null;
        $query->city = $input['city'] ?? null;
        $query->postcode = $input['postal'] ?? null;
        $query->booked_comment = null;
        $query->status = 1;
        $query->datetime = Carbon::now();
        $query->ip_address = $clientIP;
        $query->save();

        if($query){
            $booking = new Booking();
            $booking->booking_pickupPoint = $input['pickup-cl1'] ?? null;
            $booking->booking_postcode = $input['pickpostcode-cl1'] ?? null;
            $booking->pick_datetime = $pickUpDateFormat ?? null;
            $booking->noOf_passenger = $input['number-passengers'] ?? null;
            $booking->booking_return = $booking_return ?? null;
            $booking->destination = $input['dest-cl1'] ?? null;
            $booking->destination_postcode = $input['destpostcode-cl1'] ?? null;
            $booking->returning_datetime = $returnDateFormat ?? null;
            $booking->journey_details = $input['journey-details-cl1'] ?? null;
            $booking->occasion = $input['Occasion-cl1'] ?? null;
            $query->booking()->save($booking);
        }
        if($input['redirect_url']){
            $url_is = $input['redirect_url'];
        }else{
            $url = explode('?',$_SERVER['HTTP_REFERER']);
            $url_is = isset($url[0]) ? $url[0] : $_SERVER['HTTP_REFERER'];
        }
        return redirect()->away($url_is.'?status=success&msg='.$getDomain->success_msg);
     }
}
