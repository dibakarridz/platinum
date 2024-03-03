<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Response;

class TrashedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = User::onlyTrashed()->latest()->get();
        $users = User::latest('id')->get();
        $activeCount = count($users);
        $trashedCount = count($items);
        return view('backend.user.trashed.index',compact(
            'items',
            'activeCount',
            'trashedCount'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function action(Request $request)
    {
        $url = route('admin.trashed.index');
        // 1 is move to restore
        if($request->action_value == 1){
            foreach($request->ids as $id){
                User::onlyTrashed()->find($id)->restore();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
            
        }else{
            foreach($request->ids as $id){
                $user = User::onlyTrashed()->findOrFail($id);
                $user->forceDelete();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
        }
    }

    public function destroy($id)
    {
       
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->back()->with(['success' => "Item(s) deleted successfully"]);
    }

    public function restore($id)
    {
        $user = User::onlyTrashed()->find($id);
        $user->restore();
        return redirect()->route('admin.trashed.index')->with(['success' => "Item(s) restore successfully"]);
    }
}
