<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPasswordMail;
use App\Models\Setting;
use App\Models\User;
use Response,Auth;
use Carbon\Carbon;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        
        if(Auth::user()->type == 1){
            $users = User::latest('id')->get();
            $activeCount = count($users);
            $trashedCount = User::onlyTrashed()->count();
        }else{
            $users = User::where('id',Auth::user()->id)->get();
            $activeCount = 0;
            $trashedCount = 0;
        }
        
        return view('backend.user.index',compact(
            'users',
            'activeCount',
            'trashedCount'
        ));
    }

    public function create()
    {
        return view('backend.user.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'user_type' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'username' => 'required|unique:users,username',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ];
        $customMessages = [
            'user_type.required' => 'This field is required',
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'username.required' => 'This field is required',
            'password.required' => 'This field is required',
            'confirm_password.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        $user = new User();
        $user->type = $request->user_type;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->email_verified_at = Carbon::now();
        $user->save();
        $setting = Setting::find(1);
        $mailData = [
            'file_path' => $setting->file_path,
            'file_url' => $setting->file_url,
            'password' => $request->password,
            'name' => $user->name,
            'username' => $user->username,
            'email' => $user->email,
        ];
        Mail::to($user->email)->send(new SendPasswordMail($mailData));
        return redirect()->route('admin.users.index')->with(['success' => "Item(s) added successfully"]);
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('backend.user.edit',compact(
            'user'
        ));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'username' => 'required|unique:users,email,'.$id,
            'password' => 'required_with:confirm_password|same:confirm_password',
            'password_confirmation' => 'min:6'
        ];
        $customMessages = [
            'name.required' => 'This field is required',
            'email.required' => 'This field is required',
            'username.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        
        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->password = bcrypt($request->password);
        $user->save();
        
        $setting = Setting::find(1);
        if($request->password !=''){
            $mailData = [
                'file_path' => $setting->file_path,
                'file_url' => $setting->file_url,
                'password' => $request->password,
                'name' => $user->name,
                'username' => $user->username,
                'email' => $user->email,
            ];
            Mail::to($user->email)->send(new SendPasswordMail($mailData));
        }
        return redirect()->route('admin.users.index')->with(['success' => "Item(s) added successfully"]);
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('backend.user.view',compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.users.index')->with(['success' => "Item(s) deleted successfully"]);
    }

    public function status(Request $request, $id)
    {
        $user = User::find($id);
        $user->status = $request->status;
        $user->save();
        if ($user) {
            return redirect()->back()->with('success', 'Item(s) status changed Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    

    public function action(Request $request)
    {
       
        $url = route('admin.users.index');
        
        // 1 is move to trashed
        if($request->action_value == 1){
            foreach($request->ids as $id){
                $user = User::findOrFail($id);
                $user->delete();
            }
            
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
            
        }else{
            // delete permanently
            foreach($request->ids as $id){
                $user = User::findOrFail($id);
                $user->forceDelete();
            }
            
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
        }
        
        
    }
}
