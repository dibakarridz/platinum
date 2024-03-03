<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SocialLink;
use Response;

class TrashedController extends Controller
{
    public function index()
    {
        $socialLinks = SocialLink::onlyTrashed()->latest()->get();
        $activeCount = SocialLink::count();
        $trashedCount = count($socialLinks);
        return view('backend.social-link.trashed.index', compact(
            'socialLinks',
            'activeCount',
            'trashedCount'
        ));
    }

    public function action(Request $request)
    {
        $url = route('admin.social-link.trashed.index');
        // 1 is move to restore
        if($request->action_value == 1){
            foreach($request->ids as $id){
                SocialLink::onlyTrashed()->find($id)->restore();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
            
        }else{
            foreach($request->ids as $id){
                $social = SocialLink::onlyTrashed()->findOrFail($id);
                $social->forceDelete();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
        }
    }

    public function restore($id)
    {
        $social = SocialLink::onlyTrashed()->find($id);
        $social->restore();
        return redirect()->back()->with(['success' => "Item(s) restore successfully"]);
    }

    public function destroy($id)
    {
        $social = SocialLink::onlyTrashed()->findOrFail($id);
        $social->forceDelete();
        return redirect()->back()->with(['success' => "Item(s) deleted successfully"]);
    }
}
