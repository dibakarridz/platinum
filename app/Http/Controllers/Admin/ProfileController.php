<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Services\FileService;
use App\Models\User;
use File;
use Hash;

class ProfileController extends Controller
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index(User $user)
    {
        
        $user = Auth::user();
        return view('backend.profile.index',compact('user'));
    }

    
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id.',id'
        ];
        $customMessages = [
            'name.required' => 'This field is required',
            'email.required' => 'This field is required'
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $filename = User::where('id',$id)->value('file_path');
        
        if ($request->hasFile('avatar')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }

            $uploaded_file = $request->file('avatar');
            $file_path = $this->fileService->store($uploaded_file, '/profile');
          
        }else{
            $file_path = $filename;
        }
        
        $user =  User::findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->file_path = $file_path;
        $user->save();

        return redirect()->back()->with(['success' => "Profile has been updated successfully"]);
    }

    public function change_password()
    {
        $user = Auth::user();
        return view('backend.profile.password',compact('user'));
    }

    public function update_password(Request $request,$id=null)
    {
        $rules = [
            'current_password' => 'required',
            'password' => 'required|min:5',
            'confirm_password' => 'required|same:password'
        ];

        $customMessages = [
            'current_password.required' => 'This field is required',
            'password.required' => 'This field is required',
            'confirm_password.required' => 'This field is required'
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $user = User::findOrFail($id);
        if (Hash::check($request->current_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->back()->with(['success' => "Password has been updated successfully",'tab_active' => 'change_password']);
        }else{
            return redirect()->back()->with(['error' => "Current Password Does Not Matched",'tab_active' => 'change_password']);
        }
    }

}
