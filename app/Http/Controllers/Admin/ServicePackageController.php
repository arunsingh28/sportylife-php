<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Servicepackages;
use App\Models\Settings;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Servicepackages::where('package_type','android')->get();
        return view('admin.service-packages.index', compact('data'));
    }

    public function show($id)
    {
        $data = Servicepackages::where('id', $id)->first();
        $catedata = Servicepackages::select('id', 'title')->limit(3)->get();
        if ($data) {
            return view('admin.service-packages.show', compact('data', 'catedata'));
        } else {
            return redirect()->route('service-packages')->withError("Not Data Available.");
        }
    }

    public function add()
    {
        $catedata = Servicepackages::select('id', 'title')->where('package_type','android')->where('addon','1')->get();
        return view('admin.service-packages.create', compact('catedata'));
    }

    public function post(Request $request)
    {
        $request->validate([
            'parent_id' => 'nullable|exists:servicepackages,id',
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'duration_type' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('parent_id', 'title', 'price', 'addon_price_type', 'addon_adult_count', 'addon_kid_count', 'description', 'slug', 'duration_type', 'package_duration', 'package_tag', 'sports_count', 'addon', 'service_exclude', 'validity_extend', 'status','ios_package_id');

        $input['slug'] = str_replace(' ', '-', strtolower($request->title));
        $input['description'] = array_values($request->description);
        $input['service_exclude'] = array_values($request->service_exclude);
        $id = $request->only('id');
        $insert = Servicepackages::updateOrCreate($id, $input);

        // if (empty($id)) {
        //     $get_data = Servicepackages::where('id', $insert->id)->first();
        //     $get_data->ios_package_id = 'sporty' . $insert->id . '_' . $request->price;
        //     $get_data->save();
        // }
        // else {
        //     // $input['ios_package_id'] = 'spory_' . $request->price;
        //     $get_data = Servicepackages::where('id', $insert->id)->first();
        //     $get_data->ios_package_id = 'sporty' . $insert->id . '_' . $request->price;
        //     $get_data->save();
        // }

        if ($insert) {
            $message = $request->id ? 'Updated Successfully.' : 'Added Successfully.';
            return redirect()->route('service-packages')->withSuccess($message);
        } else {
            $message = $request->id ? 'Updating Failed.' : 'Adding Failed.';
            return redirect()->route('service-packages')->withError($message);
        }
    }

    public function edit($id)
    {
        $data = Servicepackages::where('id', $id)->first();
        $catedata = Servicepackages::select('id', 'title')->where('package_type','android')->where('addon','1')->get();
        if ($data) {
            return view('admin.service-packages.edit', compact('data', 'catedata'));
        } else {
            return redirect()->route('service-packages')->withError("Not Data Available.");
        }
    }

    public function delete($id)
    {
        $data = Servicepackages::find($id);
        if ($data->delete()) {
            return redirect()->route('service-packages')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('service-packages')->withError("Error! Please Try Again.");
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Servicepackages::find($request->id);
        $data->status = $request->status;
        $data->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
    
    public function changeStatusGrayout(Request $request)
    {
        $data = Servicepackages::find($request->id);
        $data->is_grayed_out = $request->grayed_out_status;
        $data->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
    
    public function changeStatusSportShow(Request $request)
    {
        $data = Servicepackages::find($request->id);
        $data->is_sports_show = $request->is_sports_show;
        $data->save();
        return response()->json(['success' => 'Status change successfully.']);
    }
    
    public function updateFinalAmount(Request $request)
    {
        $price = $request->price;
        $discount = $request->discount;
        
        $gst = Settings::where('id', "1")->where('type', "gst")->first();
        $total_price_after_discount = $price - $discount;
        $gst_amount = ($total_price_after_discount * $gst->value) / 100;
        $final_amount = $total_price_after_discount + $gst_amount;


        return response()->json(['statusCode' => 200, 'message' => 'Data Available.','total_price_after_discount'=>$total_price_after_discount, 'gst_amount'=>$gst_amount,'final_amount'=>$final_amount, ]);

    }
}
