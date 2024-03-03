<?php

namespace App\Http\Controllers\Admin\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vehicle;
use Response;

class TrashedController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::onlyTrashed()->latest()->get();
        $activeCount = Vehicle::count();
        $trashedCount = count($vehicles);
        return view('backend.vehicle.trashed.index', compact(
            'vehicles',
            'activeCount',
            'trashedCount'
        ));
    }

    public function action(Request $request)
    {
        $url = route('admin.vehicle.trashed.index');
        // 1 is move to restore
        if($request->action_value == 1){
            foreach($request->ids as $id){
                Vehicle::onlyTrashed()->find($id)->restore();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
            
        }else{
            foreach($request->ids as $id){
                $vehicle = Vehicle::onlyTrashed()->findOrFail($id);
                $vehicle->forceDelete();
            }
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
        }
    }

    public function restore($id)
    {
        $vehicle = Vehicle::onlyTrashed()->find($id);
        $vehicle->restore();
        return redirect()->back()->with(['success' => "Item(s) restore successfully"]);
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::onlyTrashed()->findOrFail($id);
        $vehicle->forceDelete();
        return redirect()->back()->with(['success' => "Item(s) deleted successfully"]);
    }
}
