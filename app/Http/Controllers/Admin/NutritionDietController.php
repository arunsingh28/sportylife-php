<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;
use App\Models\Nutrition_diet_frequencies;
use App\Models\Nutrition_diet_datas;
use App\Models\User;
use PDF;


class NutritionDietController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {   
        
        // $data = Nutrition_diet_datas::with( 'userdata')->get();
        $data =  Nutrition_diet_datas::with('userdata')
        ->whereHas('userdata',function($query) {
            $query->where('status','1');
        })->get();
        return view('admin.nutritionDiet',compact('data'));
    }
    public function add()
    {
       
        $meals=Meal::where('status', '1')->get();
        $arr = [];
        $existuser=Nutrition_diet_datas::all();
        foreach ($existuser as $key => $value) {
            array_push($arr, $value->user_id);
        }
        $userdata = User::where('role_id', '!=', '1')->whereNotIn('id', $arr)->where('status','1')->get();
        $catedata = Nutrition_diet_frequencies::where('status','1')->get();
        return view('admin.nutritionDietAdd',compact('catedata', 'userdata', 'meals'));
    }
    public function getMeal(Request $request)
    {
        $frq_id=$request->frq_id;
        $meals=Meal::where('frequency_id', $frq_id)->get();
        $str = "<option value=''>--- Select a Meal ---</option>";
        foreach ($meals as $key => $value) {
            $str .= "<option value='{$value->id}'>{$value->title}</option>";
        }
        return $str;
    }

    
    
    public function post(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'store.*.quantity' => 'numeric',
            // 'frequency_id' => 'required',
            // 'day_name' => 'required',
        ],[
            'store.*.quantity' => "Must be numeric",
        ]);
      

        $input = $request->only('user_id', 'frequency_id', 'day_name');
        $input['diet'] = array_values($request->store);
        $insert = Nutrition_diet_datas::create($input);
        if($insert) {
            $this->createDietChart($request->user_id);
            $this->shareOnCreate($insert->id);
            return redirect()->route('nutrition-diet')->withSuccess("Added Successfully.");
        }else{
            return redirect()->route('nutrition-diet')->withError("Not Added Successfully.");
        }
    }
    public function edit($id)
    {
        $meals=Meal::where('status', '1')->get();
        $filtermeal = [];
        foreach ($meals as $key => $value) {
            $filtermeal[$value->frequency_id][] = $value;
        }
        

        $data = Nutrition_diet_datas::where('id',$id)->first();
        $userdata = User::where('role_id', '!=', '1')->where('status', '1')->get();
        $catedata = Nutrition_diet_frequencies::all();
        if($data) {
            $this->createDietChart($data->user_id);
            return view('admin.nutritionDietUpdate',compact('data','catedata', 'userdata', 'meals','filtermeal'));
        }else{
            return redirect()->route('nutrition-recipes')->withError("Not Data Available.");
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'user_id' => 'required',
            'store.*.quantity' => 'numeric',
            // 'frequency_id' => 'required',
            // 'day_name' => 'required',
        ],[
            'store.*.quantity' => "Must be numeric",
        ]);
        $input = $request->only('user_id', 'frequency_id', 'day_name');
        $input['diet'] = array_values($request->store);
        $insert = Nutrition_diet_datas::where('id',$request->id)->update($input);
        if($insert) {
            // $insertData = Nutrition_diet_datas::where('id',$request->id)->first();
            // $this->shareOnCreate($insertData->id);

            return redirect()->route('nutrition-diet')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('nutrition-diet')->withError("Updation Failed.");
        }
    }
    public function delete($id)
    {
        $data = Nutrition_diet_datas::find($id);
        if($data->delete()) {
            return redirect()->route('nutrition-diet')->withSuccess("Deleted Successfully.");
        }else{
            return redirect()->route('nutrition-diet')->withError("Error! Please Try Again.");
        }
    }

    public function shareOnCreate($id)
    {
        $data = Nutrition_diet_datas::where('id',$id)->first();
        $user = User::where('id',$data->user_id)->first();
        if (!empty($user)) {
            if (!empty($user->dietchart_pdf)) {
                $pdfurl = public_path($user->dietchart_pdf);

                \Mail::raw('Your Diet Chart PDF ' , function ($message) use($user,$pdfurl) {
                    $message->to($user->email)
                    ->subject("Diet Chart")
                    ->attach($pdfurl);
                });
                return true;
            }else{
                return false;
                // return redirect()->route('nutrition-diet')->withError("Diet Chart Not Available!");
            }
        }else{
            return false;
            // return redirect()->route('nutrition-diet')->withError("Error! Please Try Again.");
        }
    }
    
    public function share($id)
    {
        $data = Nutrition_diet_datas::where('id',$id)->first();
        $user = User::where('id',$data->user_id)->first();
        if (!empty($user)) {
            if (!empty($user->dietchart_pdf)) {
                $pdfurl = public_path($user->dietchart_pdf);

                \Mail::raw('Your Diet Chart PDF ' , function ($message) use($user,$pdfurl) {
                    $message->to($user->email)
                    ->subject("Diet Chart")
                    ->attach($pdfurl);
                });
                return redirect()->route('nutrition-diet')->withSuccess("Diet Chart Shared Successfully");
            }else{
                return redirect()->route('nutrition-diet')->withError("Diet Chart Not Available!");
            }
        }else{
            return redirect()->route('nutrition-diet')->withError("Error! Please Try Again.");
        }
    }

    public function createDietChart($user_id) 
    {
        $user = User::where('id',$user_id)->first();
        $data =  Nutrition_diet_datas::where('user_id', '=', $user->id)->get();
        $frqudata =  Nutrition_diet_frequencies::all();
        $mealdata =  Meal::all();
        $frqudata_arr = [];
        $mealdata_arr = [];
        foreach ($frqudata as $key => $value) {
            $frqudata_arr[$value->id] = $value->title;
        }
        foreach ($mealdata as $key => $value) {
            $mealdata_arr[$value->id] = $value->title;
        }
        
        foreach ($data as $key => $value) {
            $customarr = [];
            foreach ($value['diet'] as $key1 => $value1) {
                $customarr[$value1['frequency_id']][] = $value1;  
            }
            $customarr1 = [];
            foreach ($customarr as $key4 => $value4) {
                $customarr1[ $key4]['frequency_id'] = $value4[0]['frequency_id']; 
                $customarr1[ $key4]['frequency_name'] = $frqudata_arr[$value4[0]['frequency_id']]; 
                $customarr2 = [];
                foreach ($value4 as $key2 => $value2) {
                        $customarr2[$key2]['meal'] =$value2['meal']; 
                        $customarr2[$key2]['quantity'] = $value2['quantity']; 
                        $customarr2[$key2]['meal_name'] =$mealdata_arr[$value2['meal']] ?? "N/A"; 
                }
                $customarr1[$key4]['meal'] =   $customarr2;
        }
            $customarr1 = array_values($customarr1);
        }
        
        if (!empty($data[0])) {
            $data1 = [
                'title' => $user->name ?? 'Sportylife',
                'date' => date('m/d/Y'),
                'customarr1' => $customarr1
            ];
            $my_pdf_name = 'uploads/dietchart' . $user->id . '.pdf';
            $my_pdf_path = 'public/'.$my_pdf_name;
            $pdf = PDF::loadView('dietPDF', $data1)->save($my_pdf_path);
            // $user = Auth::user();
            $user->dietchart_pdf = $my_pdf_name;
            $user->save();
            $pdfurl = asset($user->dietchart_pdf);
            return true;
        }
        return false;
    }
}
