<?php

namespace App\Http\Controllers\Admin\Quote;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use App\Models\Query;
use App\Models\Vehicle;
use App\Models\Domain;
use App\Models\Quoted;
use Carbon\Carbon;
use DataTables,Auth;

class QuotedController extends Controller
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
                    'destination'
                );
            }])
            ->with(['quoted' => function($query) {
                return $query->select(
                    'id',
                    'query_id'
                );
            }]);
            $data = $query->where('status',2)
                    ->get();
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
                        $pickup_point = $data->booking->booking_pickupPoint.','.$data->booking->booking_postcode;
                    }else{
                        $pickup_point = null;
                    }
                    return $pickup_point ;
                })
                ->addColumn('pickup_datetime', function ($data) {
                    return Carbon::createFromFormat('Y-m-d H:i:s', $data->booking->pick_datetime)->format('D d M Y');
                   
                })
                ->addColumn('destination', function ($data) {
                    return $data->booking->destination;
                   
                })
                ->addColumn('action', function($data){
                    $showUrl = route('admin.quotes.show',['quote' => $data->id]);
                    $quotedUrl = route('admin.quotes.quoted.show',$data->id);
                    $bookedUrl = route('admin.quotes.book',$data->id);
                    $forwardUrl = route('admin.quotes.forward',$data->id);
                    $resendQuoteUrl = '';
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
        return view('backend.quoted.index');
    }

    public function show($id)
    {
        $vehicle_details_array = [];
        $quoted = [];
        $allQuery = Query::with('booking')->where('id',$id)->withTrashed()->first();
        if($allQuery->deleted_at == null){
            $query = Query::with('booking')->where('id',$id)->first();
        }else{
            $query = Query::with('booking')->where('id',$id)->onlyTrashed()->first();
        }

        $quotedData = Quoted::where('query_id',$id)->latest()->get()->toArray();
        foreach($quotedData as $key => $row){
            $vehicle_details_array = [];
            $prices = $row['prices'];
            foreach ($prices as $keyPrice => $price){
               $priceQuotedCount = count($price);
               $vehicle_details = Vehicle::select('id','name')
                                    ->where('id',$price['vehicle_id'])
                                    ->first();
                if(is_null($vehicle_details)) {
                    $vehicle_details_array[] = [
                        'vehicle_name' => $price['name'],
                        'quote_price' => $price['price'],
                    ];
                }else{
                    $vehicle_details_array[] = [
                        'vehicle_name' => $vehicle_details['name'],
                        'quote_price' => $price['price'],
                    ];
                }
             
               
            }
           
            $quoted[] = [
                'id'=> $row['id'],
                'prices'=> $row['prices'],
                'quotation_details'=> $row['quotation_details'],
                'quote_details_price'=> $vehicle_details_array,
                'datetime'=> $row['datetime'],
            ];
        }
        $vehicles = Vehicle::where('status',1)->orderBy('order_by','ASC')->get();
        return view('backend.quoted.show',compact(
            'query',
            'quoted',
            'vehicles'
        ));
    }

    public function send(Request $request, $id)
    {
     
        $rules = [
            'quotation_details' => 'required',
        ];
        $customMessages = [
            'quotation_details.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
     
       $inputArray = [];
       foreach($request->quotePrice as $key => $val){
                $inputArray[] = $val['price'];
            //echo '<pre>';print_r($val);
       }
       
       $filteredArray = array_filter($inputArray, function($value) {
            return !is_null($value);
        });
       if(empty($filteredArray)){
            return redirect()->back()->withInput()->withErrors(['error_price' => 'Any one price field is required']);
       }

       $allQuery = Query::with('booking')->where('id',$id)->withTrashed()->first();
       if($allQuery->deleted_at == null){
        $getQueryDetail = Query::with('booking')->where('id',$id)->first();
       }else{
        $getQueryDetail = Query::with('booking')->where('id',$id)->onlyTrashed()->first();
       }

       $getDomain = Domain::where('unique_id',$getQueryDetail->prefix_quoteid)
                   ->where('status',1)
                   ->first();
       if(empty($getDomain)){
           return redirect()->back()->with(['error' => 'Domain or smtp not existing']);
       }
        
        $prices_array = [];
        $quote_price = '<ul>';
        if(!empty($request->quotePrice)){
            foreach ($request->quotePrice as $vehicleID => $prices){
                $vehicle_details = Vehicle::where('id',$vehicleID)->first();
                foreach($prices as $priceVal){
                    if(isset($vehicle_details['id']) && !empty($priceVal)){
                        $quote_price .= '<li>'.$vehicle_details->name.' <b>&pound;'.$priceVal.'</b></li>';
						$prices_array[] = [
							'vehicle_id' => $vehicleID,
                            'name' => $vehicle_details->name,
							'price' => $priceVal,
						];
                    }
                }
            }
        }
       
        $quote_price .= '</ul>';
        $quotationDetails = $request->quotation_details;
        $domain_template = $getDomain->template;
        $quote = '<table>
                    <tbody>
                        <tr>
                          <td colspan="2"><h2>Quotation ID : '.$getQueryDetail->prefix_quoteid.''.$getQueryDetail->query_id.'</h2></td>
                      </tr>
                      
                        <tr>
                          <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Personal Details</h4></td>
                      </tr>
                        <tr>
                            <td>Name</td>
                            <td>'.$getQueryDetail->full_name.'</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>'.$getQueryDetail->email.'</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>'.$getQueryDetail->phone.'</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>'.$getQueryDetail->mobile.'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>'.$getQueryDetail->address.'</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>'.$getQueryDetail->city.'</td>
                        </tr>
                        <tr>
                            <td>Post Code</td>
                            <td>'.$getQueryDetail->postcode.'</td>
                        </tr>
                        
                        
                        <tr>
                          <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Booking Details</h4></td>
                        </tr>
                              
                        <tr>
                            <td>Pickup Point</td>
                            <td>'.$getQueryDetail->booking->booking_pickupPoint.'</td>
                        </tr>
                        <tr>
                            <td>Postcode</td>
                            <td>'.$getQueryDetail->booking->booking_postcode.'</td>
                        </tr>
                        <tr>
                            <td>Pick Datetime</td>
                            <td>'. Carbon::createFromFormat('Y-m-d H:i:s', $getQueryDetail->booking->pick_datetime)->format('D d M Y h:i A').'</td>
                        </tr>
                        <tr>
                            <td>No of Passenger</td>
                            <td>'.$getQueryDetail->booking->noOf_passenger.'</td>
                        </tr>
                        <tr>
                            <td>Return</td>
                            <td>'.$getQueryDetail->booking->booking_return.'</td>
                        </tr>
                        <tr>
                            <td>Destination</td>
                            <td>'.$getQueryDetail->booking->destination.'</td>
                        </tr>
                        <tr>
                            <td>Destination Postcode</td>
                            <td>'.$getQueryDetail->booking->destination_postcode.'</td>
                        </tr>';
        if(!empty($getQueryDetail->booking->returning_datetime) && $getQueryDetail->booking->returning_datetime !='0000-00-00 00:00:00') {
            $quote .= '<tr>
                        <td>Returning Datetime</td>
                        <td>' . Carbon::createFromFormat('Y-m-d H:i:s', $getQueryDetail->booking->returning_datetime)->format('D d M Y h:i A') . '</td>
                    </tr>';
        }
        $quote .= '<tr>
                    <td>Occasion</td>
                    <td>'.$getQueryDetail->booking->occasion.'</td>
                    </tr>
                    <tr>
                        <td>Journey Details</td>
                        <td>'.$getQueryDetail->booking->journey_details.'</td>
                    </tr>
                </tbody>
            </table>';
            
        $replace_vehicle = str_replace('[Vehicle]',$quote_price,$domain_template);
        $replace_quote_form = str_replace('[QuoteDetails]',$quote,$replace_vehicle);
        $message = str_replace('[QuotationDetails]',$quotationDetails,$replace_quote_form);

        if(empty($getDomain->email_title)){
            $subject = $getDomain->domain.'-Online Quotation Form';
        }else{
            $subject = $getDomain->email_title;
        }
		if (strlen($subject) < 50) {
            $subject = substr($subject, 0, 50);
        }
       //dd($prices_array);
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        try{
            $mail = new PHPMailer();
            $mail->Mailer = $getDomain->protocol;
            $mail->Host = $getDomain->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $getDomain->smtp_username;
            $mail->Password =  $getDomain->smtp_password;
            $mail->SMTPSecure = $getDomain->encryption;
            $mail->Port = $getDomain->smtp_port;
            $mail->SMTPDebug = 0;
            $mail->isHTML(true);

            $mail->setFrom($getDomain->reply_email, $getDomain->domain);
            $mail->addAddress($getQueryDetail->email);
            $mail->Subject = $subject;
            $mail->Body = $message;

            if( !$mail->send() ) {
                return back()->with(["error" => "Email not sent."])->withErrors($mail->ErrorInfo);
            }
              
            else {
                $quoted = new Quoted();
                $quoted->query_id = $id;
                $quoted->prices = $prices_array;
                $quoted->quotation_details = $request->quotation_details;
                $quoted->datetime = Carbon::now();
                $quoted->save();

                $allUpdateQuery = Query::where('id',$id)->withTrashed()->first();
                if($allUpdateQuery->deleted_at == null){
                    $query = Query::findOrFail($id);
                }else{
                    $query = Query::where('id',$id)->onlyTrashed()->first();
                }
                $query->status = 2;
                $query->deleted_at = null;
                $query->save();

                return redirect()->back()->with(['success' => "The query has been quoted successfully"]);
            }

        } catch (Exception $e) {
             return back()->with(['error' => 'Message could not be sent.']);
        }
        
    }

    public function resend($qouteID,$quotedID)
    {
        //dd($qouteID);
        $prices_array = [];
        $allQuery = Query::with('booking')->where('id',$qouteID)->withTrashed()->first();
        if($allQuery->deleted_at == null){
            $getQueryDetail = Query::with('booking')->where('id',$qouteID)->first();
        }else{
            $getQueryDetail = Query::with('booking')->where('id',$qouteID)->onlyTrashed()->first();
        }
        
        $getDomain = Domain::where('unique_id',$getQueryDetail->prefix_quoteid)->where('status',1)->first();
        if(empty($getDomain)){
            return redirect()->back()->with(['error' => 'Domain or smtp not existing']);
        }

        $quote_price = '<ul>';
        $sendQuotationDetails = Quoted::where([
            ['id', '=', $quotedID],
            ['query_id', '=', $qouteID]
        ])->first();
        if(!empty($sendQuotationDetails->prices)) {
            $quotePrices = $sendQuotationDetails->prices;
            foreach ($quotePrices as $quotePrice){
                $vehicleDetails = Vehicle::select('id','name')
                ->where('id',$quotePrice['vehicle_id'])
                ->first();
                if(is_null($vehicleDetails)) {
                    $prices_array[] = [
                        'vehicle_id'=>$quotePrice['vehicle_id'],
                        'name' => '',
                        'price'=>$quotePrice['price']
                    ];
                }else{
                    $prices_array[] = [
                        'vehicle_id'=>$quotePrice['vehicle_id'],
                        'name' => $quotePrice['name'],
                        'price'=>$quotePrice['price']
                    ];
                }
                
               
                if(isset($vehicleDetails['id']) && !empty($quotePrice['price']) && !empty($quotePrice['name'])){
                    $quote_price .= '<li>'.$vehicleDetails['name'].' <b>&pound;'.$quotePrice['price'].'</b></li>';
                }
            }
        }
        $quote_price .= '</ul>';
        $domain_template = $getDomain->template;
        $quotationDetails = $sendQuotationDetails->quotation_details;
        $quote = '<table>
                    <tbody>
                        <tr>
                          <td colspan="2"><h2>Quotation ID : '.$getQueryDetail->prefix_quoteid.''.$getQueryDetail->query_id.'</h2></td>
                      </tr>
                      
                        <tr>
                          <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Personal Details</h4></td>
                      </tr>
                        <tr>
                            <td>Name</td>
                            <td>'.$getQueryDetail->full_name.'</td>
                        </tr>
                        <tr>
                            <td>Email Address</td>
                            <td>'.$getQueryDetail->email.'</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>'.$getQueryDetail->phone.'</td>
                        </tr>
                        <tr>
                            <td>Mobile</td>
                            <td>'.$getQueryDetail->mobile.'</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>'.$getQueryDetail->address.'</td>
                        </tr>
                        <tr>
                            <td>City</td>
                            <td>'.$getQueryDetail->city.'</td>
                        </tr>
                        <tr>
                            <td>Post Code</td>
                            <td>'.$getQueryDetail->postcode.'</td>
                        </tr>
                        
                        
                        <tr>
                          <td colspan="2"><h4><i class="fa fa-arrow-circle-right"></i> Booking Details</h4></td>
                        </tr>
                              
                        <tr>
                            <td>Pickup Point</td>
                            <td>'.$getQueryDetail->booking->booking_pickupPoint.'</td>
                        </tr>
                        <tr>
                            <td>Postcode</td>
                            <td>'.$getQueryDetail->booking->booking_postcode.'</td>
                        </tr>
                        <tr>
                            <td>Pick Datetime</td>
                            <td>'. Carbon::createFromFormat('Y-m-d H:i:s', $getQueryDetail->booking->pick_datetime)->format('D d M Y h:i A').'</td>
                        </tr>
                        <tr>
                            <td>No of Passenger</td>
                            <td>'.$getQueryDetail->booking->noOf_passenger.'</td>
                        </tr>
                        <tr>
                            <td>Return</td>
                            <td>'.$getQueryDetail->booking->booking_return.'</td>
                        </tr>
                        <tr>
                            <td>Destination</td>
                            <td>'.$getQueryDetail->booking->destination.'</td>
                        </tr>
                        <tr>
                            <td>Destination Postcode</td>
                            <td>'.$getQueryDetail->booking->destination_postcode.'</td>
                        </tr>';
        if(!empty($getQueryDetail->booking->returning_datetime) && $getQueryDetail->booking->returning_datetime !='0000-00-00 00:00:00') {
            $quote .= '<tr>
                        <td>Returning Datetime</td>
                        <td>' . Carbon::createFromFormat('Y-m-d H:i:s', $getQueryDetail->booking->returning_datetime)->format('D d M Y h:i A') . '</td>
                    </tr>';
        }
        $quote .= '<tr>
                    <td>Occasion</td>
                    <td>'.$getQueryDetail->booking->occasion.'</td>
                    </tr>
                    <tr>
                        <td>Journey Details</td>
                        <td>'.$getQueryDetail->booking->journey_details.'</td>
                    </tr>
                </tbody>
            </table>';
            
        $replace_vehicle = str_replace('[Vehicle]',$quote_price,$domain_template);
        $replace_quote_form = str_replace('[QuoteDetails]',$quote,$replace_vehicle);
        $message = str_replace('[QuotationDetails]',$quotationDetails,$replace_quote_form);

        if(empty($getDomain->email_title)){
            $subject = $getDomain->domain.'-Online Quotation Form';
        }else{
            $subject = $getDomain->email_title;
        }
		if (strlen($subject) < 50) {
            $subject = substr($subject, 0, 50);
        }
       //dd($prices_array);
        require base_path("vendor/autoload.php");
        $mail = new PHPMailer(true);
        // try{
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = $getDomain->smtp_host;
            $mail->SMTPAuth = true;
            $mail->Username = $getDomain->smtp_username;
            $mail->Password = $getDomain->smtp_password;
            $mail->SMTPSecure = $getDomain->encryption;
            $mail->Port = $getDomain->smtp_port;
   
            $mail->setFrom($getDomain->reply_email, $getDomain->domain);
            $mail->addAddress($getQueryDetail->email);
   
            $mail->isHTML(true);
   
            $mail->Subject = $subject;
            $mail->Body = $message;

            if( !$mail->send() ) {
                return back()->with(["error" => "Email not sent."])->withErrors($mail->ErrorInfo);
            }
              
            else {
                $quoted = new Quoted();
                $quoted->query_id = $qouteID;
                $quoted->prices = $prices_array;
                $quoted->quotation_details = $quotationDetails;
                $quoted->datetime = Carbon::now();
                $quoted->save();
                
                $query = Query::findOrFail($qouteID);
                $query->status = 2;
                $query->deleted_at = null;
                $query->save();

                return redirect()->back()->with(['success' => "The query has been quoted resend successfully"]);
            }

        // } catch (Exception $e) {
        //      return back()->with(['error' => 'Message could not be sent.']);
        // }


    }
}
