@extends('admin.layouts.main')
@section('breadcrumb')
FAQ Details
@endsection
@section('content')
<div class="row">
   <div class="col-xl-12 order-xl-1">
      <div class="card">
         <div class="card-header">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">FAQ Details</h3>
               </div>
               <div class="col-4 text-right">
                  <a href="{{route('faqs')}}" class="btn btn-sm btn-default">List</a>
               </div>
            </div>
         </div>
         <div class="card-body">
            <!-- <form method="post" action="{{route('faq-update')}}" enctype="multipart/form-data">
                @csrf -->
               <h6 class="heading-small text-muted mb-4">FAQ information</h6>
               <div class="pl-lg-4">
                  <div class="row">
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Category</label>
                           <input type="hidden" name="id" value="{{$faq->id}}">
                            @foreach($faqcate as $item)
                            <h4><?php if($item->id == $faq->category_id){echo $item->title;}?></h4>
                            @endforeach
                        </div>
                     </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                           <label class="form-control-label" >Status</label>
                               <h4><?php if($faq->status == '1'){echo "Active";} ?></h4>
                               <h4><?php if($faq->status == '0'){echo "Inactive";} ?></h4>
                        </div>
                     </div>
                     <div class="col-lg-12">
                        <div class="form-group">
                           <label class="form-control-label" >Question</label><br/>
                           {!! $faq->question !!}
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <label class="form-control-label" >Answer</label><br/>
                            {!! $faq->answer !!}
                        </div>
                     </div>

                  </div>
               </div>
               <!-- <hr class="my-4" />
               <button type="submit" class="btn btn-sm btn-default">Save</button>
            </form> -->
         </div>
      </div>
   </div>
</div>
@endsection
