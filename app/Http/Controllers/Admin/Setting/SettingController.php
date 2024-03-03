<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Services\FileService;
use App\Models\Setting;
use Artisan;
use DateTimeZone;
use Carbon\Carbon;
use Config;

class SettingController extends Controller
{
    private $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

   
    public function edit($id)
    {
      
        $setting = Setting::find(1);      
        return view('backend.setting.edit',compact('setting'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'address' => 'required',
            'copyright' => 'required',
            'developed' => 'required'
        ];
        $customMessages = [
            'title.required' => 'This field is required',
            'email.required' => 'This field is required',
            'phone.required' => 'This field is required',
            'address.required' => 'This field is required',
            'copyright.required' => 'This field is required',
            'developed.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }

        $filename = Setting::where('id',$id)->value('file_path');
        
        if ($request->hasFile('image')) {
            if($filename!='') {
                if(Storage::exists($filename)){
                    Storage::delete($filename);
                }
            }

            $uploaded_file = $request->file('image');
            $file_path = $this->fileService->store($uploaded_file, '/logo');
           
        }else{
            $file_path = $filename;
        }
        
        $setting =  Setting::findOrFail($id);
        $setting->title = $request->title;
        $setting->email = $request->email;
        $setting->mobile_number = $request->phone;
        $setting->address = $request->address;
        $setting->copyright = $request->copyright;
        $setting->developed_by = $request->developed;
        $setting->file_path = $file_path;
        $setting->save();

        return redirect()->back()->with(['success' => "Item(s) updated successfully"]);
    }

    public function cacheSettings()
    {
        return view('backend.setting.cache-setting.index');
    }

    public function cacheUpdate($id)
    {
        if($id == 1){
            Artisan::call('view:clear');
            return redirect()->back()->with(['success' => "Views cache cleared successfully"]);
        }else if($id == 2){
            Artisan::call('route:clear');
            return redirect()->back()->with(['success' => "Route cache cleared successfully"]);
        }else if($id == 3){
            //Artisan::call('config:cache');
            Artisan::call('config:clear');
            return redirect()->back()->with(['success' => "Configuration cache cleared successfully"]);
        }else if($id == 4){
            Artisan::call('cache:clear');
            return redirect()->back()->with(['success' => "Application cache cleared successfully"]);
        }else if($id == 5){
            $dirname = public_path("storage");
            if(Storage::exists($dirname)){
                rmdir($dirname);
            }
            Artisan::call('storage:link');
            return redirect()->back()->with(['success' => "Application storage linked successfully"]);
        }else{
            return redirect()->back()->with(['error' => "Something went wrong"]);
        }
        
    }
}
