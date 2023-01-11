@extends('admin.layouts.main')
@section('breadcrumb')
FAQ Update
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">FAQ Update</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('faqs')}}" class="btn btn-sm btn-default">List</a>
               </div>
            </div>
         </div>
         <div class="card-body">
            <form method="post" action="{{route('faq-update')}}" enctype="multipart/form-data">
                @csrf
               <h6 class="heading-small text-muted mb-4">FAQ information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           <input type="hidden" name="id" value="{{$faq->id}}">
                           <select name="category_id" id="" class="form-control" required>
                                <option value="">Select Option</option>
                                @foreach($faqcate as $item)
                                <option value="{{$item->id}}" <?php if($item->id == $faq->category_id){echo "selected";}?>>{{$item->title}}</option>
                                @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                           <select name="status" class="form-control" required>
                               <option value="1" <?php if($faq->status == '1'){echo "selected";} ?>>Active</option>
                               <option value="0" <?php if($faq->status == '0'){echo "selected";} ?>>Inactive</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Question</label>
                           <textarea type="text" id="editor10" name="question" cols="6" rows="10" class="form-control" placeholder="Enter Question" value="{{$faq->question}}" required>{{$faq->question}}</textarea>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" >Answer</label>
                            <textarea type="text" id="editor20" name="answer" cols="6" rows="10" class="form-control" placeholder="Enter Answer" value="{{$faq->answer}}" required>{{$faq->answer}}</textarea>
                        </div>
                     </div>

                  </div>
               </div>
               <hr class="my-4" />
               <button type="submit" class="btn btn-sm btn-default">Save</button>
            </form>
         </div>
      </div>
   </div>
</div>
@endsection
