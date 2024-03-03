<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotpasswordMail;
use Auth;
use App\Models\User;
use App\Models\PasswordReset;
use App\Models\Setting;

class ForgotPasswordController extends Controller
{
   
    public function showLinkRequestForm()
    {
        if(Auth::check()){
            return redirect()->route('admin.dashboard.index');
        }

        return view('backend.auth.passwords.email');
    }

    public function sendResetLinkEmail(Request $request)
    {
        $rules = [
            'email' => 'required|email|exists:users,email'
        ];

        $customMessages = [
            'email.required' => 'This field is required'
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $user = User::where('email',$request->email)->whereIn('type',[1,2])->first();
        if($user){
            $token = encrypt($user->id);
            $reset = PasswordReset::where('email',$user->email)->first();
            if($reset){
                $query = PasswordReset::where('email', $user->email)
                                    ->update([
                                        'token' => $token,
                                        'updated_at' => date('Y-m-d h:i:s')
                                    ]);
            }else{
                $query = new PasswordReset();
                $query->token = $token;
                $query->email = $request->email;
                $query->save();
            }
            $setting = Setting::find(1);
            $request_sent = [
                'file_path' => $setting->file_path,
                'file_url' => $setting->file_url,
                'token' => $token,
                'name' => $user->name,
                'email' => $user->email,
            ];
            Mail::to($user->email)->send(new ForgotpasswordMail($request_sent));
            return redirect()->back()->with('success', "we have send the reset password link to your register email address");

        }else{
            return redirect()->back()->with('error', "This email is not a admin");
        }
    }
}
