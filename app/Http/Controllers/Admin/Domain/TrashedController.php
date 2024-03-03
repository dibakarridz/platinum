<?php

namespace App\Http\Controllers\Admin\Domain;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Domain;
use Response;

class TrashedController extends Controller
{
    public function index()
    {
        $domains = Domain::onlyTrashed()->latest()->get();
        $activeCount = Domain::count();
        $trashedCount = count($domains);
        return view('backend.domain.trashed.index', compact(
            'domains',
            'activeCount',
            'trashedCount'
        ));
    }

    public function action(Request $request)
    {
        $url = route('admin.domain.trashed.index');
        // 1 is move to restore
        if($request->action_value == 1){
            foreach($request->ids as $id){
                Domain::onlyTrashed()->find($id)->restore();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
            
        }else{
            foreach($request->ids as $id){
                $domain = Domain::onlyTrashed()->findOrFail($id);
                $domain->forceDelete();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
        }
    }

    public function restore($id)
    {
        $domain = Domain::onlyTrashed()->find($id);
        $domain->restore();
        return redirect()->back()->with(['success' => "Item(s) restore successfully"]);
    }

    public function destroy($id)
    {
        $domain = Domain::onlyTrashed()->findOrFail($id);
        $domain->forceDelete();
        return redirect()->back()->with(['success' => "Item(s) deleted successfully"]);
    }
}
