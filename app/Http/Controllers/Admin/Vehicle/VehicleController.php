<?php

namespace App\Http\Controllers\Admin\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\Vehicle;
use Response;


class VehicleController extends Controller
{
    
    public function index()
    {
        $vehicles = Vehicle::latest()->get();
        $activeCount = count($vehicles);
        $trashedCount = Vehicle::onlyTrashed()->count();
        return view('backend.vehicle.index', compact(
            'vehicles',
            'activeCount',
            'trashedCount'
        ));
    }

    public function create()
    {
        return view('backend.vehicle.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'order_by' => 'required',
        ];
        $customMessages = [
            'name.required' => 'This field is required',
            'description.required' => 'This field is required',
            'order_by.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
        $vehiclesOrderBy = Vehicle::pluck('order_by')->toArray();
        $requestOrderBy = $request->order_by;
        if(in_array($requestOrderBy,$vehiclesOrderBy)){
            return redirect()->back()->with(['error' => "Item(s) order by already exist"]);
        }else{
            $vehicle = new Vehicle();
            $vehicle->name = $request->name;
            $vehicle->description = $request->description;
            $vehicle->order_by = $request->order_by;
            $vehicle->save();
            return redirect()->route('admin.vehicles.index')->with(['success' => "Item(s) added successfully"]);
        }
    }
    

    public function edit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('backend.vehicle.edit',compact(
            'vehicle'
        ));
    }

    public function update(Request $request, $id)
    {
       
        $rules = [
            'name' => 'required',
            'description' => 'required',
            'order_by' => 'required',
        ];
        $customMessages = [
            'name.required' => 'This field is required',
            'description.required' => 'This field is required',
            'order_by.required' => 'This field is required',
        ];
        $validator = Validator::make($request->all(), $rules, $customMessages);
        if ($validator->fails()) {
            return Redirect::back()->withInput()->withErrors($validator);
        }
       
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->name = $request->name;
        $vehicle->description = $request->description;
        $vehicle->save();
        return redirect()->route('admin.vehicles.index')->with(['success' => "Item(s) updated successfully"]);
    
    }

    public function destroy($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        $vehicle->delete();
        return redirect()->route('admin.vehicles.index')->with(['success' => "Item(s) deleted successfully"]);
    }

    public function status(Request $request, $id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle->status = $request->status;
        $vehicle->save();
        if ($vehicle) {
            return redirect()->back()->with('success', 'Item(s) status changed Successfully!');
        } else {
            return redirect()->back()->with('error', 'Something went wrong. Please try again');
        }
    }

    public function action(Request $request)
    {
        $url = route('admin.vehicles.index');
        
        // 1 is move to trashed
        if($request->action_value == 1){
            foreach($request->ids as $id){
                $vehicle = Vehicle::findOrFail($id);
                $vehicle->delete();
            }
            
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
            
        }else{
            // delete permanently
            foreach($request->ids as $id){
                $vehicle = Vehicle::findOrFail($id);
                $vehicle->forceDelete();
            }
            
            return Response::json(['status'=>true,'url'=>$url,'msg'=>'Action has been completed.']);
        }
    }

    public function item()
    {
        $items = Vehicle::latest()->get();

        return view("backend.position", compact("items"));
    }

    public function position_change(Request $request)
    {
        $data = $request->order;
        foreach ($data as $index => $id) {
         
            Vehicle::where('id', $id)->update(['order_by' => $index+1]);
        }
        return  response()->json([
            'message' => 'Vehicle Order changed successfully.',
            'status' => 'success'

        ]);
    }
}
