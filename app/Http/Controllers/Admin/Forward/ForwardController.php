<?php

namespace App\Http\Controllers\Admin\Forward;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Query;
use App\Models\Domain;
use App\Models\Forward;
use Carbon\Carbon;
use DataTables;

class ForwardController extends Controller
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
            }]);
            $data = $query->where('status',3);
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
                    $actionBtn = '<div class="dropdown ms-auto text-right" style="cursor: pointer;"><div class="btn-link" data-bs-toggle="dropdown"><svg width="24px" height="24px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></div><div class="dropdown-menu dropdown-menu-right">';
                    $actionBtn .= '<a class="dropdown-item" href="'.$showUrl.'" title="View"><i class="fas fa-list" style="color: #363062;"></i> View</a><a class="dropdown-item" href="'.$quotedUrl.'" title="Quoted"><i class="fas fa-question" style="color: #E28743;"></i> Quote</a><a class="dropdown-item" href="'.$bookedUrl.'" title="Book"><i class="fas fa-check" style="color: #49be25;"></i> Book</a><a class="dropdown-item" href="'.$forwardUrl.'" title="Forward"><i class="fas fa-share" style="color: #5050d0 !important;"></i> Forward</a><a class="dropdown-item" href="'.$printUrl.'" title="Print" target="_blank"><i class="fas fa-print" style="color: #563d7c;"></i> Print</a><a class="dropdown-item" data-bs-target="#deleteConfirm" data-bs-toggle="modal" title="Delete" onclick="deleteConfirm(\''. $deleteUrl .'\', \'Are you sure you, want to delete?\')"><i class="fa fa-trash" style="color: red;"></i> Delete</a>';
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
                ->toJson(true);
        }
        return view('backend.forward.index');
    }

    public function forward($id)
    {
        
        $allQuery = Query::where('id',$id)->withTrashed()->first();
        if($allQuery->deleted_at == null){
            $query = Query::with('booking','forward')->where('id',$id)->first();
        }else{
            $query = Query::with('booking','forward')->where('id',$id)->onlyTrashed()->first();
        }
       
        return view('backend.forward.show',compact(
            'query'
        ));
    }

    public function store(Request $request, $id)
    {
        $rules = [
            'email' => 'required|email',
        ];
        $customMessages = [
            'email.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $email = $request->email;
        $query = Query::where('id',$id)->withTrashed()->first();
        if(!empty($query)){
            $get_details = Query::with('booking')->findOrFail($id);
        }else{
            $get_details = Query::with('booking')->where('id',$id)->onlyTrashed()->first();
        }
        
        $DomainDetails = Domain::where('unique_id',$get_details->prefix_quoteid)->first();
        $subject = $DomainDetails->domain.' - Quotation Forward';

        $mail = new PHPMailer();
        $mail->Mailer = $DomainDetails->protocol;
        $mail->Host = $DomainDetails->smtp_host;
        $mail->SMTPAuth = true;
        $mail->Username = $DomainDetails->smtp_username;
        $mail->Password =  $DomainDetails->smtp_password;
        $mail->SMTPSecure = $DomainDetails->encryption;
        $mail->Port = $DomainDetails->smtp_port;
        $mail->SMTPDebug = 0;
        $mail->isHTML(true);
        $mail->setFrom($DomainDetails->reply_email,$DomainDetails->domain);
        $mail->AddAddress($email, "");
        $mail->Subject = ($subject);
        $mail->Body = view('Mail.forward', ['data' => $get_details,'email' => $email])->render();
       
        if(!$mail->send() ) {
            return back()->with(["error" => "Email not sent."])->withErrors($mail->ErrorInfo);
        }else {
            $forward = new Forward();
            $forward->query_id = $id;
            $forward->forwarded_email = $email;
            $forward->datetime = Carbon::now();
            $forward->save();
            
            $allUpdateQuery = Query::where('id',$id)->withTrashed()->first();
            if($allUpdateQuery->deleted_at == null){
                $updateQuery = Query::findOrFail($id);
            }else{
                $updateQuery = Query::where('id',$id)->onlyTrashed()->first();
            }
            
            $updateQuery->status = 3;
            $updateQuery->deleted_at = null;
            $updateQuery->save();

            return redirect()->back()->with(['success' => "The query has been forward successfully"]);
        }
       

    }

}
