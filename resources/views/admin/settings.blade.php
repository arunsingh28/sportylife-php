@extends('admin.layouts.main')
@section('breadcrumb')
Settings
@endsection
@section('style')
<style>
.whitespace{
   white-space: inherit !important;
}
</style>
@endsection

@section('content')
<div class="row">
   <div class="col">
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Settings </h3>
               </div>
               <!-- <div class="col-4 text-right">
                  <a href="{{route('slider-add')}}" class="btn btn-sm btn-default float-right">Add</a>
               </div> -->
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush" id="myTable">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Title</th>
                     <th>Data</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody class="list">
                   <?php $i = 1;?>
                   @foreach($settings as $key => $item )
                  <tr>
                     <th>
                        {{$i}}
                     </th>
                     <td>
                        {{ucfirst($item->title)}}
                     </td>
                     @if($item->type == "splash")
                     <td class="whitespace"> 
                             <a href="{{ asset($item->value ?? '') }}" class="ply-btn-video" data-id="{{ $item->id ?? '' }}">

                             <img src="{{asset($item->thumbnail)}}" height="50" alt="">
                             </a>
                     </td>
                     @elseif($item->type == "profile_comming_soon_image")
                     <td class="whitespace"> 
                             <a href="{{ asset($item->value ?? '') }}" target="_blank">
                             <img src="{{asset($item->value)}}" height="50" alt="">
                             </a>
                     </td>
                     @elseif($item->type == "mission" || $item->type == "terms_conditions_content" || $item->type == "vision" || $item->type == "privacy_policy_content")
                     @if ($item->type == "terms_conditions_content")
                         <td class="whitespace" id="terms_conditions_content"> 
                           T&C Content
                        </td>
                     @endif
                     @if ($item->type == "vision")
                        <td class="whitespace" id="vision"> 
                           Vision Content 
                        </td>    
                     @endif
                     @if ($item->type == "mission")
                        <td class="whitespace" id="mission"> 
                           Mission Content
                        </td>
                         
                     @endif
                     @if ($item->type == "privacy_policy_content")
                        <td class="whitespace" id="mission"> 
                           Privacy Policy Content
                        </td>
                         
                     @endif
                     
                     @else
                     <td class="whitespace"> 
                        {!! \Str::limit($item->value, 80, $end='...') !!}
                     </td>
                     @endif
                     </td>
                     <td>
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10")
                        <a href="{{url('/admin/setting-edit',$item->id)}}" class="btn btn-sm btn-primary">Edit</a>
                        @endif
                     </td>
                  </tr>
                  
                  <?php $i++;?>
                  @endforeach
               </tbody>
            </table>
         </div>
      </div>
      <div class="card">
         <div class="card-header border-0">
            <div class="row align-items-center">
               <div class="col-8">
                  <h3 class="mb-0">Admin Commission </h3>
               </div>
               <!-- <div class="col-4 text-right">
                  <a href="{{route('slider-add')}}" class="btn btn-sm btn-default float-right">Add</a>
               </div> -->
            </div>
         </div>
         <div class="table-responsive">
            <table class="table align-items-center table-flush">
               <thead class="thead-light">
                  <tr>
                     <th>Sr. No</th>
                     <th>Title</th>
                     <th>Data</th>
                     <th>Action</th>
                  </tr>
               </thead>
               <tbody class="list">
                  <tr>
                     <th>
                        1
                     </th>
                     <td>
                        {{ucfirst($gst->title)}}
                     </td>
                     <td>
                        {{$gst->value}}
                     </td>
                     <td>
                        <a href="{{url('/admin/setting-edit',$gst->id)}}" class="btn btn-sm btn-primary">Edit</a>
                     </td>
                  </tr>
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script>



   // var text = $('#terms_conditions_content').html();
   // var count = 80;

   // var result = text.slice(0, count) + (text.length > count ? "..." : "");
   // console.log(result);
</script>
@endsection
