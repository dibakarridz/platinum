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
use DataTables,Auth,DB;

class QuotedController extends Controller
{
    public function index(Request $request)
    {
       if ($request->ajax()) {
            $query = Query::select(
                'id',
                'prefix_quoteid',
				DB::raw("CONCAT(queries.full_name,'-',queries.email,'-',queries.phone,'-',queries.mobile) as user_details"),
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
					DB::raw("CONCAT(bookings.booking_pickupPoint,'-',bookings.booking_postcode) as pickup_point"),
                    'booking_pickupPoint',
                    'booking_postcode',
                    'pick_datetime',
<<<<<<< HEAD
                    'destination',
                    'destination_postcode'
                );
            }]);
            $data = $query->where('status',2);
            return Datatables::of($data)->addIndexColumn()
=======
					DB::raw("CONCAT(bookings.destination,'-',bookings.destination_postcode) as destination"),
                    'destination',
					'destination_postcode'
                );
            }]);
            $data = $query->where('status',2)->latest('id');
		return DataTables::of($data)->addIndexColumn()
                ->filterColumn('user_details', function($query, $keyword) {
                    $sql = "CONCAT(queries.full_name,'-',queries.email,'-',queries.phone,'-',queries.mobile)  like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('pickup_point', function($query, $keyword) {
                    $query->whereHas('booking', function($query) use ($keyword){
                        $sql = "CONCAT(bookings.booking_pickupPoint,'-',bookings.booking_postcode)  like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    });
                })
                ->filterColumn('destination', function($query, $keyword) {
                    $query->whereHas('booking', function($query) use ($keyword){
                        $sql = "CONCAT(bookings.destination,'-',bookings.destination_postcode)  like ?";
                        $query->whereRaw($sql, ["%{$keyword}%"]);
                    });
                })
>>>>>>> cdf5ca0 (design changes issue fixed)
                ->addColumn('quote_id', function ($data) {
                    return ($data->prefix_quoteid.''.$data->booking->query_id);
                })
                ->addColumn('user_details', function ($data) {
                    $user = '<strong><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path d="M16 7C16 9.20914 14.2091 11 12 11C9.79086 11 8 9.20914 8 7C8 4.79086 9.79086 3 12 3C14.2091 3 16 4.79086 16 7Z" stroke="#7e7e7e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M12 14C8.13401 14 5 17.134 5 21H19C19 17.134 15.866 14 12 14Z" stroke="#7e7e7e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>'.$data->full_name.'</strong><br>';
                    $user .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M17.3545 22.2323C15.3344 21.7262 11.1989 20.2993 7.44976 16.5502C3.70065 12.8011 2.2738 8.66559 1.76767 6.6455C1.47681 5.48459 2.00058 4.36434 2.88869 3.72997L5.21694 2.06693C6.57922 1.09388 8.47432 1.42407 9.42724 2.80051L10.893 4.91776C11.5152 5.8165 11.3006 7.0483 10.4111 7.68365L9.24234 8.51849C9.41923 9.1951 9.96939 10.5846 11.6924 12.3076C13.4154 14.0306 14.8049 14.5807 15.4815 14.7576L16.3163 13.5888C16.9517 12.6994 18.1835 12.4847 19.0822 13.1069L21.1995 14.5727C22.5759 15.5257 22.9061 17.4207 21.933 18.783L20.27 21.1113C19.6356 21.9994 18.5154 22.5232 17.3545 22.2323ZM8.86397 15.136C12.2734 18.5454 16.0358 19.8401 17.8405 20.2923C18.1043 20.3583 18.4232 20.2558 18.6425 19.9488L20.3056 17.6205C20.6299 17.1665 20.5199 16.5348 20.061 16.2171L17.9438 14.7513L17.0479 16.0056C16.6818 16.5182 16.0047 16.9202 15.2163 16.7501C14.2323 16.5378 12.4133 15.8569 10.2782 13.7218C8.1431 11.5867 7.46219 9.7677 7.24987 8.7837C7.07977 7.9953 7.48181 7.31821 7.99439 6.95208L9.24864 6.05618L7.78285 3.93893C7.46521 3.48011 6.83351 3.37005 6.37942 3.6944L4.05117 5.35744C3.74413 5.57675 3.64162 5.89565 3.70771 6.15943C4.15989 7.96418 5.45459 11.7266 8.86397 15.136Z" fill="#7e7e7e"/>
                    </svg>' .$data->phone. '<br>';
                    $user .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path d="M11 18H13M9.2 21H14.8C15.9201 21 16.4802 21 16.908 20.782C17.2843 20.5903 17.5903 20.2843 17.782 19.908C18 19.4802 18 18.9201 18 17.8V6.2C18 5.0799 18 4.51984 17.782 4.09202C17.5903 3.71569 17.2843 3.40973 16.908 3.21799C16.4802 3 15.9201 3 14.8 3H9.2C8.0799 3 7.51984 3 7.09202 3.21799C6.71569 3.40973 6.40973 3.71569 6.21799 4.09202C6 4.51984 6 5.07989 6 6.2V17.8C6 18.9201 6 19.4802 6.21799 19.908C6.40973 20.2843 6.71569 20.5903 7.09202 20.782C7.51984 21 8.07989 21 9.2 21Z" stroke="#7e7e7e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>'.$data->mobile.'<br>';
                    $user .= '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none">
                    <path d="M21 8L17.4392 9.97822C15.454 11.0811 14.4614 11.6326 13.4102 11.8488C12.4798 12.0401 11.5202 12.0401 10.5898 11.8488C9.53864 11.6326 8.54603 11.0811 6.5608 9.97822L3 8M6.2 19H17.8C18.9201 19 19.4802 19 19.908 18.782C20.2843 18.5903 20.5903 18.2843 20.782 17.908C21 17.4802 21 16.9201 21 15.8V8.2C21 7.0799 21 6.51984 20.782 6.09202C20.5903 5.71569 20.2843 5.40973 19.908 5.21799C19.4802 5 18.9201 5 17.8 5H6.2C5.0799 5 4.51984 5 4.09202 5.21799C3.71569 5.40973 3.40973 5.71569 3.21799 6.09202C3 6.51984 3 7.07989 3 8.2V15.8C3 16.9201 3 17.4802 3.21799 17.908C3.40973 18.2843 3.71569 18.5903 4.09202 18.782C4.51984 19 5.07989 19 6.2 19Z" stroke="#7e7e7e" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>' .$data->email;
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
                    return $pickup_point;
                })
<<<<<<< HEAD
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
=======
                ->addColumn('pick_datetime', function ($data) {
                    
					if($data->booking->pick_datetime !=''){
                    	$pick_datetime = Carbon::createFromFormat('Y-m-d H:i:s', $data->booking->pick_datetime)->format('D d M Y');
					}else{
						$pick_datetime = '';
					}
					return $pick_datetime;
                   
                })
                ->addColumn('destination', function ($data) {
                     if($data->booking->destination == ''){
>>>>>>> cdf5ca0 (design changes issue fixed)
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
                    $last_quoted_id = Quoted::where('query_id',$data->id)->latest()->value('id');
                    $showUrl = route('admin.quotes.show',['quote' => $data->id]);
                    $quotedUrl = route('admin.quotes.quoted.show',$data->id);
                    $bookedUrl = route('admin.quotes.book',$data->id);
                    $forwardUrl = route('admin.quotes.forward',$data->id);
                    $resendQuoteUrl = route('admin.quotes.resend.quotation',['quote' => $data->id, 'quoted' => $last_quoted_id]);
                    $printUrl = route('admin.quotes.print.view',$data->id);
                    $deleteUrl = route('admin.quotes.destroy',['quote' => $data->id]);
                    if($last_quoted_id != ''){
                        $resendHtml = '<a class="dropdown-item" data-bs-target="#resendConfirm" data-bs-toggle="modal" title="Resend Quote" onclick="resendConfirm(\''. $resendQuoteUrl .'\',\''. $data->id .'\',\''.$last_quoted_id.'\', \'Are you sure do you want resend this quotation again?\')"><i class="fa fa-redo" style="color: red;"></i> Resend Last Quote</a>';
                    }else{
                        $resendHtml = '';
                    }
                    $deleteHtml = '<a class="dropdown-item" data-bs-target="#deleteConfirm" data-bs-toggle="modal" title="Delete" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure you, want to delete?\')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>';                    
                    $actionBtn = '<div class="dropdown ms-auto text-right" style="cursor: pointer;"><div class="btn-link" data-bs-toggle="dropdown"><svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></div><div class="dropdown-menu dropdown-menu-right">';
                    $actionBtn .= '<a class="dropdown-item" href="'.$showUrl.'" title="View"><i class="fas fa-list" style="color: #363062;"></i> View</a><a class="dropdown-item" href="'.$quotedUrl.'" title="Quoted"><i class="fas fa-question" style="color: #E28743;"></i> Quote</a><a class="dropdown-item" href="'.$bookedUrl.'" title="Book"><i class="fas fa-check" style="color: #49be25;"></i> Book</a><a class="dropdown-item" href="'.$forwardUrl.'" title="Forward"><i class="fas fa-share" style="color: #5050d0 !important;"></i> Forward</a>'.$resendHtml.'<a class="dropdown-item" href="'.$printUrl.'" title="Print" target="_blank"><i class="fas fa-print" style="color: #563d7c;"></i> Print</a>'.$deleteHtml;
                    $actionBtn .= '</div></div>';
                    
                    return $actionBtn;
                })
                ->rawColumns([
                    'quote_id',
                    'user_details',
                    'pickup_point',
                    'pick_datetime',
                    'destination',
                    'action'
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
