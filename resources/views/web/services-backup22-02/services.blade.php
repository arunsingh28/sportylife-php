@extends('layouts.main')
@section('style')
<style type="text/css">
         img {
         height: 350px; 
         object-fit: cover;
         }

.box:hover {
   transform: scale(1.2);
    -webkit-transform: scale(1.1);
    -moz-transform: scale(1.2);
    border: 5px solid #ef4234;
}

.pricing .box {
   transition-duration: 2s;
}
.free_trial .select_port {
    padding-top: 0px;
}
.free_trial .select_port ul {
    text-align: center;
}
.pricing .btn-buy:hover {
    color: #212121 !important;
}
      </style>
@endsection
@section('content')
<main id="main" style="overflow-x:hidden;">
   <section id="pricing" class="pricing free_trial">
      <div class="container" data-aos="fade-up">
         <h2>Unlimited access to all stuff with a single membership</h2>
         <div id="carouselExample" class="carousel slide w-100" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
               <?php $array1 = array_chunk($packagedata->toArray(),3);?>
               @foreach($array1 as $key => $item)
               <div class="carousel-item <?php if($key == "0"){echo "active";} ?>">
                  <div class="row">
                     @foreach($item as $key1 => $item1)
                     <div class="col-md-4 text-end" style="display: inherit;">
                        @if(auth()->user()->is_complete_freetrial == "1" || auth()->user()->is_active_freetrial == "1")
                           <a href="{{url('service-details/'.$item1['slug'])}}">
                        @else
                           <a href="#!">
                        @endif
                        <div class="box mt-2">
                           <div class="pac-ttl">
                              <img src="{{asset('web/assets/img/basic-pack.svg')}}" alt="" class="img-fluid">                
                              <div class="pac-txt">
                                 <h3>{{$item1['title']}}</h3>
                                 <!-- <h3>{!! \Str::limit($item1['title'], 10, ' ...') !!}</h3> -->
                                 <h4><sup><img src="{{asset('web/assets/img/rupees.svg')}}" alt="" class="img-fluid"></sup>{{$item1['price']}}<span> / {{$item1['duration_type']}}</span></h4>
                              </div>
                           </div>
                           
                           <ul>
                              @foreach($item1['description'] as $key2 => $item2)
                                @if($key2 < 3)
                                    <li><img src="{{asset('web/assets/img/meeting-point-b.svg')}}" alt="" class="img-fluid"> {!! \Str::limit($item2, 35, ' ...') !!}</li>
                                @endif
                              @endforeach
                           </ul>
                           <div class="btn-wrap">
                              @if(auth()->user()->is_complete_freetrial == "1" || auth()->user()->is_active_freetrial == "1")
                              <a href="{{url('service-details/'.$item1['slug'])}}" style="background: yellow !important;" class="btn-buy">Know More </a>
                              @else
                              <a href="#!" style="background: yellow !important;" class="btn-buy"  data-toggle="modal" data-target="#freetiralmodel">Know More </a>
                              @endif
                           </div>
                        </div>
                        </a>
                     </div>
                     @endforeach
                  </div>
               </div>
               @endforeach
            </div>
            <button class="carousel-control-prev" data-bs-target="#carouselExample" type="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" data-bs-target="#carouselExample" type="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
            </button>
         </div>
      </div>
   </section>
   <div class="row">
         <div class="col-md-12">
            <h3 class="frc-h3">Sports we offer</h3> 
         </div>
   </div>
   <div class="row">
      <div class="col-lg-2 col-md-0">
      </div>
      <div class="col-lg-8 col-md-12">
         <div class="row">
            <div class="col-md-12">
               <div class="select_port" style="padding-top: 0px !important;">
                  <ul>
                     @foreach($category as $key1 => $item1)
                     <li>
                        <!-- <input type="checkbox" value="{{$item1->id}}" id="myCheckbox{{$item1->id}}"> -->
                        <label for="myCheckbox{{$item1->id}}">
                        <img style="border-radius: 54%" src="{{asset($item1->image)}}">
                        </label>
                        {{$item1->title}}
                     </li>
                     @endforeach
                  </ul>
                  <br>
                  <div class="row">
                     <div class="col-md-12 mt-2">
                        <!-- <a href="{{route('free-trial')}}" style="color:#212121" ><button class="add_cart fre-trl"> 7 Day free trial </button></a> -->
                        <a href="{{route('free-trial')}}" style="color:#212121"><button class="add_cart fre-trl"> 7 Day free trial </button></a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-2 col-md-0">
      </div>
   </div>
</main>
@endsection
@section('script')
@endsection