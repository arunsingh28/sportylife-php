<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Nutrition_quotes;
use Illuminate\Http\Request;

class NutritionQuoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $data = Nutrition_quotes::orderBy("created_at","desc")->get();
        return view('admin.nutrition-quote.index', compact('data'));
    }

    public function add()
    {
        return view('admin.nutrition-quote.create');
    }

    public function post(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only( 'title', 'status',);
        $id = $request->only('id');
        $insert = Nutrition_quotes::updateOrCreate($id, $input);
        if ($insert) {
            $message = $request->id ? 'Updated Successfully.' : 'Added Successfully.';
            return redirect()->route('nutrition-quote')->withSuccess($message);
        } else {
            $message = $request->id ? 'Updating Failed.' : 'Adding Failed.';
            return redirect()->route('nutrition-quote')->withError($message);
        }
    }

    public function edit($id)
    {
        $data = Nutrition_quotes::where('id', $id)->first();
        if ($data) {
            return view('admin.nutrition-quote.edit', compact('data'));
        } else {
            return redirect()->route('nutrition-quote')->withError("Not Data Available.");
        }
    }

    public function delete($id)
    {
        $data = Nutrition_quotes::find($id);
        if ($data->delete()) {
            return redirect()->route('nutrition-quote')->withSuccess("Deleted Successfully.");
        } else {
            return redirect()->route('nutrition-quote')->withError("Error! Please Try Again.");
        }
    }

    public function changeStatus(Request $request)
    {
        $data = Nutrition_quotes::find($request->id);
        $data->status = $request->status;
        $data->save();

        return response()->json(['success'=>'Status change successfully.']);
    }
}
