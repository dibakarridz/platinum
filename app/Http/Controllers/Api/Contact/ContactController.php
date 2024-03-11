<?php

namespace App\Http\Controllers\Api\Contact;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Services\ApiResponseService;
use App\Models\Query;
use App\Models\Domain;
use App\Models\Booking;
use Carbon\Carbon;
use DB;

class ContactController extends Controller
{
    public function __construct(
        ApiResponseService $apiResponseService

    ) {
        $this->apiResponseService = $apiResponseService;
    }

    public function store(Request $request)
    {
        $input = $request->all();
        $website_code = Str::upper($input['website_code']);
        $redirect_url = $input['redirect_url'] ?? null;
        $getDomain = Domain::select(
                        'unique_id',
                        'domain_name',
                        'success_msg',
                        'error_msg'
                    )
        ->where('unique_id',$input['website_code'])
        ->first();
        // $validator = Validator::make($request->all(), [
        //     'name' => 'required',
        //     'website_code' => 'required',
        //     'phone' => 'required',
        //     'pickdate' => 'required',
        // ]);
        // if ($validator->fails()) {
        //     $messages = $validator->messages();
        //     // $errors = implode(' ', $messages->all());
        //    // $errors = $messages->all();
        //     return $this->apiResponseService->sendValidationErrorResponse('', $messages);
        // }
        $clientIP = $input['ip_address'];
        $pickUpDate =  $input['pickdate'] ?? null;
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

        $returnDate = $input['returndate'] ?? null;
        $returnHour = $input['returnddl-hr'] ?? '00';
        $returnMin = $input['returnddl-minute'] ?? '00';
        $returnTime = $input['returnddl-time'] ?? null;
        if($returnHour !='' && $returnMin !='' && $returnTime !=''){
            $returnPickUpTimeFormat = $returnHour.':'.$returnMin.' '.$returnTime;
            $returnPickTime = Carbon::createFromFormat('g:i A', $returnPickUpTimeFormat)->format('H:i:s');
        }else{
            $returnPickUpTimeFormat = $returnHour.':'.$returnMin.':00';
            $returnPickTime = Carbon::createFromFormat('H:i:s', $returnPickUpTimeFormat)->format('H:i:s');
        }
        
        if($returnDate != '' && $returnPickTime !=''){
            $returnDateFormat = $returnDate.' '.$returnPickTime;
            $returnPickUpDateFormat = Carbon::createFromFormat('Y-m-d H:i:s', $returnDateFormat)->format('Y-m-d H:i:s');
        }else{
            $returnPickUpDateFormat = null;
        }

        $query = new Query();
        $query->prefix_quoteid = $website_code ?? null;
        $query->comes_website = $getDomain->domain_name ?? null;
        $query->full_name = $input['name'] ?? null;
        $query->email = $input['email'] ?? null;
        $query->phone = $input['phone'] ?? null;
        $query->mobile = $input['mobile'] ?? null;
        $query->address = $input['address'] ?? null;
        $query->city = $input['city'] ?? null;
        $query->postcode = $input['postalcode'] ?? null;
        $query->booked_comment = $input['booked_comment'] ?? null;
        $query->status = 1;
        $query->datetime = Carbon::now();
        $query->ip_address = $clientIP;
        $query->save();
        
        if($query){
            $booking = new Booking();
            $booking->booking_pickupPoint = $input['pickup-point'] ?? null;
            $booking->booking_postcode = $input['pick-postcode'] ?? null;
            $booking->pick_datetime = $pickUpDateFormat ?? null;
            $booking->noOf_passenger = $input['number-passengers'] ?? null;
            $booking->booking_return = $booking_return ?? null;
            $booking->destination = $input['destination'] ?? null;
            $booking->destination_postcode = $input['destination-postcode'] ?? null;
            $booking->returning_datetime = $returnPickUpDateFormat ?? null;
            $booking->journey_details = $input['journey-details'] ?? null;
            $booking->occasion = $input['occasion'] ?? null;
            $query->booking()->save($booking);
        }
        $data = [
            'redirect_url' => $redirect_url,
            'msg' => $getDomain->success_msg,
            'status' => 'success'
            
        ];
        return $this->apiResponseService->sendSuccessResponse($data, 'Success');
    }

    public function refresh() {
        return $this->apiResponseService->sendSuccessResponse($this->respondWithToken($this->guard()->refresh()), 'Success');
    }

    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
