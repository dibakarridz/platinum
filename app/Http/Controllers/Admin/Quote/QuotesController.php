<?php

namespace App\Http\Controllers\Admin\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Query;
use App\Models\Vehicle;
use App\Models\Booking;
use Carbon\Carbon;
use DataTables,Auth;

class QuotesController extends Controller
{
   
    public function index(Request $request)
    {
       
        if ($request->ajax()) {
            $query = Query::select(
                'id',
                'prefix_quoteid',
                'full_name',
                'email',
                'phone',
                'mobile',
                'city',
                'postcode'
            )
            ->with(['booking' => function($query) {
                return $query->select(
                    'id',
                    'query_id',
                    'destination',
                    'booking_pickupPoint',
                    'booking_postcode',
                    'pick_datetime',
                    'destination',
                    'destination_postcode'
                );
            }]);
            $data = $query->where('status',1);
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('quote_id', function ($data) {
                    return ($data->prefix_quoteid.''.$data->booking->query_id);
                })
                ->addColumn('user_details', function ($data) {
                    $user = '<strong> <i class="fa fa-user"></i> '.$data->full_name.'</strong><br>';
                    $user .= '<i class="fa fa-phone"></i> '.$data->phone.' <br>';
                    $user .= '<i class="fa fa-mobile"></i> '.$data->mobile.' <br>';
                    $user .= '<i class="fa fa-envelope"></i> '.$data->email;
                    return $user ;
                })
                
                ->addColumn('pickup_point', function ($data) {
                    if($data->booking->booking_pickupPoint == ''){
                        $pickup_point = $data->booking->booking_postcode;
                    }else if($data->booking->booking_postcode == ''){
                        $pickup_point = $data->booking->booking_pickupPoint;
                    }else if($data->booking->booking_pickupPoint != '' && $data->booking->booking_postcode != ''){
                        $pickup_point = $data->booking->booking_pickupPoint.'<br>'.$data->booking->booking_postcode;
                    }else{
                        $pickup_point = null;
                    }
                    return $pickup_point ;
                })
                ->addColumn('pickup_datetime', function ($data) {
                    if($data->booking->pick_datetime !=''){
                        $pickup_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $data->booking->pick_datetime)->format('D d M Y');
                    }else{
                        $pickup_datetime = '';
                    }
                    return $pickup_datetime;
                   
                })
                ->addColumn('destination', function ($data) {
                    if($data->booking->destination == ''){
                        $destination = $data->booking->destination_postcode;
                    }else if($data->booking->destination_postcode == ''){
                        $destination = $data->booking->destination;
                    }else if($data->booking->destination != '' && $data->booking->destination_postcode != ''){
                        $destination = $data->booking->destination.'<br>'.$data->booking->destination_postcode;
                    }else{
                        $destination = null;
                    }
                    return $destination;
                   
                })
                ->addColumn('action', function($data){
                    $showUrl = route('admin.quotes.show',['quote' => $data->id]);
                    $quotedUrl = route('admin.quotes.quoted.show',$data->id);
                    $bookedUrl = route('admin.quotes.book',$data->id);
                    $forwardUrl = route('admin.quotes.forward',$data->id);
                    $printUrl = route('admin.quotes.print.view',$data->id);
                    $deleteUrl = route('admin.quotes.destroy',['quote' => $data->id]);
                    $deleteHtml = '<a class="dropdown-item" data-bs-target="#deleteConfirm" data-bs-toggle="modal" title="Delete" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure you, want to delete?\')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>';
                    $actionBtn = '<div class="dropdown ms-auto text-right" style="cursor: pointer;"><div class="btn-link" data-bs-toggle="dropdown"><svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></div><div class="dropdown-menu dropdown-menu-right">';
                    $actionBtn .= '<a class="dropdown-item" href="'.$showUrl.'" title="View"><i class="fas fa-list" style="color: #363062;"></i> View</a><a class="dropdown-item" href="'.$quotedUrl.'" title="Quoted"><i class="fas fa-question" style="color: #E28743;"></i> Quote</a><a class="dropdown-item" href="'.$bookedUrl.'" title="Book"><i class="fas fa-check" style="color: #49be25;"></i> Book</a><a class="dropdown-item" href="'.$forwardUrl.'" title="Forward"><i class="fas fa-share" style="color: #5050d0 !important;"></i> Forward</a><a class="dropdown-item" href="'.$printUrl.'" title="Print" target="_blank"><i class="fas fa-print" style="color: #563d7c;"></i> Print</a>'.$deleteHtml;
                    $actionBtn .= '</div></div>';
                    
                    return $actionBtn;
                })
                ->rawColumns([
                    'action',
                    'quote_id',
                    'user_details',
                    'pickup_point',
                    'pickup_datetime',
                    'destination'
                ])
                ->make(true);
        }
        return view('backend.quotes.index');
    }

    public function show($id)
    {
        $vehicle_details_array = [];
        $quoted = [];
        $allQuery = Query::with('booking','quoted')->where('id',$id)->withTrashed()->first();
        if($allQuery->deleted_at == null){
            $query = Query::with('booking','quoted')->where('id',$id)->first();
        }else{
            $query = Query::with('booking','quoted')->where('id',$id)->onlyTrashed()->first();
        }

        if(!empty($query)){
            foreach($query->quoted as $quote){
                foreach($quote->prices as $price){
                    $vehicle_details = Vehicle::whereNull('deleted_at')->where('id',$price['vehicle_id'])->first();
                    if(!empty($vehicle_details)){
                        $vehicle_details_array[] = [
                            'vehicle_name' => $vehicle_details['name'] ?: '',
                            'quote_price' => $price['price'] ?: '',
                        ];
                    }
                }

                $quoted[] = [
                    'id'=> $quote->id,
                    'quotation_details'=> $quote->quotation_details,
                    'quote_details_price'=> $vehicle_details_array,
                    'datetime'=> $quote->datetime,
                ];
            }
        }
        
        return view('backend.quotes.show',compact(
            'query',
            'quoted'
        ));
    }

    public function edit($id)
    {
        $query = Query::with('booking','quoted')->findOrFail($id);   
        return view('backend.quotes.edit',compact(
            'query'
        ));
    }

    public function update(Request $request,$id)
    {
        $rules = [
            'full_name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'address' => 'required',
            'city' => 'required',
            'postcode' => 'required',
            'status' => 'required',
            'booking_pickupPoint' => 'required',
            'booking_postcode' => 'required',
            'pick_datetime' => 'required',
            'noOf_passenger' => 'required',
            'booking_return' => 'required',
            'destination' => 'required',
            'destination_postcode' => 'required',
            'returning_datetime' => 'required',
            'occasion' => 'required',
            'journey_details' => 'required',
        ];
        $customMessages = [
            'full_name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'address.required' => 'This field is required',
            'city.required' => 'This field is required',
            'postcode.required' => 'This field is required',
            'status.required' => 'This field is required',
            'booking_pickupPoint.required' => 'This field is required',
            'booking_postcode.required' => 'This field is required',
            'pick_datetime.required' => 'This field is required',
            'noOf_passenger.required' => 'This field is required',
            'booking_return.required' => 'This field is required',
            'destination.required' => 'This field is required',
            'destination_postcode.required' => 'This field is required',
            'returning_datetime.required' => 'This field is required',
            'occasion.required' => 'This field is required',
            'journey_details.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        /* update queries table */
        $query = Query::findOrFail($id);
        $query->full_name = $request->full_name;
        $query->email = $request->email;
        $query->phone = $request->phone;
        $query->mobile = $request->mobile;
        $query->address = $request->address;
        $query->city = $request->city;
        $query->postcode = $request->postcode;
        $query->status = $request->status;
        $query->save();

        /* update booking table */
        $bookingID = Booking::where('query_id',$id)->value('id');
        $booking = Booking::findOrFail($bookingID);
        $booking->booking_pickupPoint = $request->booking_pickupPoint;
        $booking->booking_postcode = $request->booking_postcode;
        $booking->pick_datetime = $request->pick_datetime;
        $booking->noOf_passenger = $request->noOf_passenger;
        $booking->booking_return = $request->booking_return;

        $booking->destination = $request->destination;
        $booking->destination_postcode = $request->destination_postcode;
        $booking->returning_datetime = $request->returning_datetime;
        $booking->occasion = $request->occasion;
        $booking->journey_details = $request->journey_details;
        $booking->save();

        return redirect()->back()->with(['success' => "Item(s) updated successfully"]);
    }

    public function destroy($id)
    {
        $query = Query::findOrFail($id);
        $query->delete();
        return redirect()->back()->with(['success' => "Item(s) deleted successfully"]);
    }

    public function status(Request $request, $id)
    {
        $quote = Query::find($id);
        $quote->status = $request->status;
        $quote->save();
        if ($quote) {
            return redirect()->back()->with(['success' => 'Item(s) status changed Successfully!']);
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function printView($id)
    {
        $vehicle_details_array = [];
        $quoted = [];
        $allQuery = Query::with('booking','quoted')->where('id',$id)->withTrashed()->first();
        if( $allQuery->deleted_at == null){
            $query = Query::with('booking','quoted')->where('id',$id)->first();
        }else{
            $query = Query::with('booking','quoted')->where('id',$id)->onlyTrashed()->first();
        }
        if(!empty($query)){
            foreach($query->quoted as $quote){
                foreach($quote->prices as $price){
                    $vehicle_details = Vehicle::whereNull('deleted_at')->where('id',$price['vehicle_id'])->first();
                    if(!empty($vehicle_details)){
                        $vehicle_details_array[] = [
                            'vehicle_name' => $vehicle_details['name'] ?: '',
                            'quote_price' => $price['price'] ?: '',
                        ];
                    }
                }

                $quoted[] = [
                    'id'=> $quote->id,
                    'quotation_details'=> $quote->quotation_details,
                    'quote_details_price'=> $vehicle_details_array,
                    'datetime'=> $quote->datetime,
                ];
            }
        }
        return view('backend.quotes.print',compact(
            'query',
            'quoted'
        ));
    }
}
