<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nutrition_recipe_categories;
use App\Models\Nutrition_recipes;
use App\Models\Servicecategories;
use Illuminate\Http\Request;

class ServiceCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Servicecategories::all();
        return view('admin.service-categories.index', compact('data'));
    }

    public function changeStatus(Request $request)
    {
        $data = Servicecategories::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status change successfully.']);
    }

    public function edit($id)
    {
        $data = Servicecategories::where('id',$id)->first();
        if($data) {
            return view('admin.service-categories.edit',compact('data'));
        }else{
            return redirect()->route('service-categories')->withError("Not Slider Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'image' => 'mimes:jpg,png,jpeg'
        ]);
        // dd($request->all());
        if ($request->image) {
            $imageName = $request->image->store('/images');
            $input['image'] = 'uploads/'. $imageName;
        }
        $insert = Servicecategories::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('service-categories')->withSuccess("Slider Update Successfully.");
        }else{
            return redirect()->route('service-categories')->withError("Updation Failed.");
        }
    }
}
