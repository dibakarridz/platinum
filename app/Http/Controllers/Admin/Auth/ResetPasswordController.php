<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\PasswordReset;

class ResetPasswordController extends Controller
{
    
    public function showResetForm(Request $request, $token = null)
    {
        try {
            return view('backend.auth.passwords.reset',compact('token'));
        } catch (DecryptException $e) {
            return redirect()->route('admin.password.reset')->with('warning', "token is expired");
        }
    }

    public function reset(Request $request){
        $token = $request->get('token');
        $id = decrypt($token);
        try {
                $rules = [
                    'password' => 'required',
                    'confirm_password' => 'required|same:password',
                ];

                $customMessages = [
                    'password.required' => 'This field is required',
                    'confirm_password.required' => 'This field is required'
                ];

                $validator = Validator::make($request->all(), $rules, $customMessages);
                if ($validator->fails()) {
                    return Redirect::back()->withInput()->withErrors($validator);
                }

                $checkData = PasswordReset::where('token',$token)->count();
                if($checkData > 0){
                    $user = User::find($id);
                    $user->password = bcrypt($request->password);
                    $user->save();
                    PasswordReset::where('token',$token)->delete();
                    return redirect()->route('admin.login')->with('success', "Password has been changed successfully");
                }else{
                    return redirect()->route('admin.login')->with('warning', "invalid Url Link");
                }

        } catch (DecryptException $e) {
            return redirect()->route('admin.login')->with('warning', "invalid Url Link");
        }
    }
}
