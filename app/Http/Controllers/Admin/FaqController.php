<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faqdatas;
use App\Models\Faqcategories;

class FaqController extends Controller
{
    public function __construct()
    {
        $this->middleware('checkAdmin');
    }

    public function index()
    {
        $faqs = Faqdatas::with('faqcategorydata')->get();
        return view('admin.faqs',compact('faqs'));
    }
    public function add()
    {
        $faqcate = Faqcategories::where('status','1')->get();
        return view('admin.faqAdd',compact('faqcate'));
    }
    public function post(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'question' => 'required',
            // 'answer' => 'required',
        ]);
        $input = $request->only('category_id', 'question', 'answer','status');
        $insert = Faqdatas::create($input);
        if($insert) {
            return redirect()->route('faqs')->withSuccess("FAQ Added Successfully.");
        }else{
            return redirect()->route('faqs')->withError("Not Added Successfully.");
        }
    }
    public function edit($id)
    {
        $faq = Faqdatas::where('id',$id)->first();
        $faqcate = Faqcategories::all();
        if($faq) {
            return view('admin.faqUpdate',compact('faq','faqcate'));
        }else{
            return redirect()->route('faqs')->withError("Not Faq Available.");
        }
    }
    public function view($id)
    {
        $faq = Faqdatas::where('id',$id)->first();
        $faqcate = Faqcategories::all();
        if($faq) {
            return view('admin.faqView',compact('faq','faqcate'));
        }else{
            return redirect()->route('faqs')->withError("Not faq Available.");
        }
    }
    public function update(Request $request)
    {
        $request->validate([
           'category_id' => 'required',
            'question' => 'required',
        ]);
        $input = $request->only('category_id', 'question','answer', 'status');
        $insert = Faqdatas::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('faqs')->withSuccess("FAQ Update Successfully.");
        }else{
            return redirect()->route('faqs')->withError("Updation Failed.");
        }
    }
    public function delete($id)
    {
        $faqdatas = Faqdatas::find($id);
        if($faqdatas->delete()) {
            return redirect()->route('faqs')->withSuccess("FAQ Deleted Successfully.");
        }else{
            return redirect()->route('faqs')->withError("Error! Please Try Again.");
        }
    }
    public function changeFAQStatus(Request $request)
    {
        $faqdatas = Faqdatas::find($request->id);
        $faqdatas->status = $request->status;
        $faqdatas->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
    
    //faq category
    public function category()
    {
        $faqcats = Faqcategories::all();
        return view('admin.faqCategory',compact('faqcats'));
    }
    public function categoryAdd()
    {
        return view('admin.faqCategoryAdd');
    }
    public function categoryPost(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'status');
        $insert = Faqcategories::create($input);
        if($insert) {
            return redirect()->route('faq-category')->withSuccess("FAQ Category Added Successfully.");
        }else{
            return redirect()->route('faq-category')->withError("Not Added Successfully.");
        }
    }
    public function categoryEdit($id)
    {
        $faqcat = Faqcategories::where('id',$id)->first();
        if($faqcat) {
            return view('admin.faqCategoryUpdate',compact('faqcat'));
        }else{
            return redirect()->route('faq-category')->withError("Not Faq Available.");
        }
    }
    public function categoryView($id)
    {
        $faqcat = Faqcategories::where('id',$id)->first();
        if($faqcat) {
            return view('admin.faqCategoryView',compact('faqcat'));
        }else{
            return redirect()->route('faq-category')->withError("Not faq Available.");
        }
    }
    public function categoryUpdate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);
        $input = $request->only('title', 'status');
        $insert = Faqcategories::where('id',$request->id)->update($input);
        if($insert) {
            return redirect()->route('faq-category')->withSuccess("Update Successfully.");
        }else{
            return redirect()->route('faq-category')->withError("Updation Failed.");
        }
    }
    public function categoryDelete($id)
    {
        $faqcate = Faqcategories::find($id);
        if($faqcate->delete()) {
            return redirect()->route('faq-category')->withSuccess("Deleted Successfully.");
        }else{
            return redirect()->route('faq-category')->withError("Error! Please Try Again.");
        }
    }
    public function changeFAQCategoryStatus(Request $request)
    {
        $faqcate = Faqcategories::find($request->id);
        $faqcate->status = $request->status;
        $faqcate->save();
  
        return response()->json(['success'=>'Status change successfully.']);
    }
}
