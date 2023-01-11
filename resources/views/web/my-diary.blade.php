@extends('layouts.main')
@section('style')
@endsection
@section('content')
<div class="my_dairy">
   <div class="container">
      <h2>My Favourite</h2>
      <div class="row">
         <div class="col-lg-1 col-md-0"></div>
         <div class="col-lg-10 col-md-12">
            <div class="row">
                @foreach($data as $item)
               <div class="col-lg-3 col-md-6 portfolio-item filter-app">
                  @if(@$item->recipedata->slug != NULL)
                  <a href="{{url('recipe-details/?id='.$item->recipedata->id)}}">
                  @else
                  <a >
                  @endif
                     <!-- <img src="{{asset('web/assets/img/tamoto.png')}}" class="img-fluid" alt=""> -->
                     @if(@$item->recipedata->type == 'image')
                    <img src="{{asset($item->recipedata->uploads)}}" class="img-fluid" style="object-fit: cover !important;height: 100% !important;border-radius: 10px;" alt="">
                    @else
                    <img src="{{asset(@$item->recipedata->thumbnail)}}" class='img-fluid' style="object-fit: cover;height: 100%;border-radius: 10px;" alt=''>
                    @endif
                     <div class="stage">
                        <div class="heart is-active"></div>
                     </div>
                     <div class="portfolio-info">
                        <h4>{{@$item->recipedata->title}}</h4>
                  <a href="">{{@$item->recipedata->calorie}} cal </a>
                  </div>
                  </a>
               </div>
               @endforeach
            </div>
         </div>
         <div class="col-lg-1 col-md-0"></div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script type="text/javascript">
//    $(function() {
//    $(".heart").on("click", function() {
//        $(this).toggleClass("is-active");
//    });
//    });
</script>
@endsection