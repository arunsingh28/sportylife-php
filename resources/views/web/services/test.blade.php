@extends('layouts.main')
@section('style')

@endsection

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
<style>
    .li-color-blue:hover {
        color: #19a4d2 !important;
    }

    h5 {
        align-items: center;
        text-align: center;
    }

    .items-baseline {
        justify-content: center;
    }

    .select-check-box {
        text-align: center;
        padding-top: 50px;
    }

    .select-check-box input[type="checkbox"] {
        display: none;
    }

    .select-check-box h6 {
        color: #fff;
        font-size: 28px;
        padding-bottom: 20px;
    }

    .select-check-box ul {
        list-style-type: none;
        text-align: center;
    }

    .select-check-box li {
        display: inline-block;
        color: #fff;
        font-size: 18px;
    }



    .select-check-box label {
        padding: 10px;
        display: block;
        position: relative;
        margin: 10px;
        cursor: pointer;
    }

    .select-check-box label:before {
        background-color: white;
        color: white;
        content: " ";
        display: block;
        border-radius: 50%;
        border: 1px solid #5AB6FF;
        position: absolute;
        top: 6px;
        /*left: -5px;*/
        width: 25px;
        height: 25px;
        text-align: center;
        line-height: 28px;
        transition-duration: 0.4s;
        transform: scale(0);
        right: 16px;
        z-index: 9;
    }

    .select-check-box label img {
        height: 100px;
        width: 100px;
        transition-duration: 0.2s;
        transform-origin: 50% 50%;
    }


    .select-check-box h3 {
        color: #fff;
        font-size: 25px;
        font-weight: 700;
    }

    #myBtn {
        display: flex;

    }

    .arraow_ig {
        margin-top: 7px;

    }
</style>
<main id="main" style="overflow-x:hidden;">
    <section id="pricing" class="pricing free_trial">
        <div class="container">
            <!-- <div class="flex flex-col justify-center items-center py-5">
                <div class="h-1 bg-red-600 w-32 rounded-full"></div>
                <h1 class="text-white text-center text-6xl font-extrabold uppercase py-2">pricing</h1>
            </div> -->
            <div class="w-full  border rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700" style="background:#646a8e;">

                <ul class=" text-sm font-medium text-center text-white divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist" style="background:#646a8e;">
                    <li class="w-full">
                        <button id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="true" class="li-color-blue  inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100  dark:bg-gray-700 dark:hover:bg-gray-600 text-white " style="background:#646a8e;">Lifestyle Plans</button>
                    </li>
                    <li class="w-full">
                        <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false" class="li-color-blue inline-block w-full p-4 bg-gray-50 hover:bg-gray-100  dark:bg-gray-700 dark:hover:bg-gray-600 text-white " style="background:#646a8e;">Sports & Wellness Plans
                        </button>
                    </li>
                    <li class="w-full">
                        <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq" aria-selected="false" class="li-color-blue inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100  dark:bg-gray-700 dark:hover:bg-gray-600 text-white " style="background:#646a8e;">Nutrition Plans
                        </button>
                    </li>
                </ul>
                <div id="fullWidthTabContent">
                    <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab" style="background-color: #37455f !important;">
                        <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
                            @if($lifePackagedata->count())
                            @foreach($lifePackagedata as $key => $item)
                            <!-- standred plan -->
                            @if($key == 1)

                            <div class="w-full max-w-sm p-4 rounded-lg shadow-md sm:p-8 
bg-gradient-to-t from-[#000046] to-[#1cb5e0]
scale-115">
                                @else
                                <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
                                    @endif

                                    <form role="form" method="POST" action="{{ url('buynow') }}">
                                        @csrf
                                        <input type="hidden" name="package_id" id="package_id" value="{{$item->id}}">
                                        <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                        <input type="hidden" name="price" value="{{$item->price}}">
                                        <input type="hidden" name="type" value="sport">
                                        <h5 class="mb-4 text-xl font-medium text-white">{{ $item['title'] }}</h5>
                                        <div class="flex items-baseline text-white">
                                            <span class="text-3xl font-semibold">₹</span>
                                            <span class="text-5xl font-extrabold tracking-tight">{{ $item['price'] }}</span>
                                            <!-- <span class="ml-1 text-xl font-normal text-white"> 3 month</span> -->
                                        </div>
                                        <!-- List -->
                                        <ul role="list" class="space-y-5 my-7">


                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">6 Live Sessions per week and Workout Sessions Library</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Yoga (2 Sessions)</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Dance Fitness (2 Sessions)</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Strength and Conditioning (2 Sessions)</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Monthly Aid</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Customised Diet Plan</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Monthly Fitness report card</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Monthly Assessment</span>
                                            </li>
                                            <li class="flex space-x-3">
                                                <!-- Icon -->
                                                <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <title>Check icon</title>
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="text-base font-normal leading-tight text-white">Monthly Video Guidance Call</span>
                                            </li>




                                        </ul>
                                        <button type="submit" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase" name="click_type" value="buynow">Buy
                                            Now</button>
                                    </form>
                                </div>
                                @endforeach
                                @endif




                            </div>
                            <!-- first price close -->
                        </div>
                        <div class="hidden p-4 bg-grey rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel" aria-labelledby="about-tab" style="background-color: #37455f !important;">
                            <div class="flex flex-wrap gap-4 justify-center rounded-xl
                            xl:justify-between
                            lg:justify-between
                            ">
                                @if($sportPackagedata->count())
                                @foreach($sportPackagedata as $key => $item)
                                <!-- standred plan -->
                                @if($key == 1)

                                <div class="w-full max-w-sm p-4 rounded-lg shadow-md sm:p-8 
          bg-gradient-to-t from-[#000046] to-[#1cb5e0]
          scale-115">
                                    @else
                                    <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
                                        @endif

                                        <form role="form" method="POST" action="{{ url('buynow') }}">
                                            @csrf
                                            <input type="hidden" name="package_id" id="package_id" value="{{$item->id}}">
                                            <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                            <input type="hidden" name="price" value="{{$item->price}}">
                                            <input type="hidden" name="type" value="sport">

                                            <h5 class="mb-4 text-xl font-medium text-white">{{ $item['title'] }}</h5>
                                            <div class="flex items-baseline text-white">
                                                <span class="text-3xl font-semibold">₹</span>
                                                <span class="text-5xl font-extrabold tracking-tight">{{ $item['price'] }}</span>
                                                <!-- <span class="ml-1 text-xl font-normal text-white"> 3 month</span> -->
                                            </div>
                                            <!-- List -->
                                            <ul role="list" class="space-y-5 my-7">

                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Learning Management System</span>
                                                </li>

                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Digital Coaching from the Basics</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Etiquettes, Sportsmanship and untold rules of the game</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">6 Live Sessions per week and Workout Sessions Library</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Yoga (2 Sessions)</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Dance Fitness (2 Sessions)</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Strength and Conditioning (2 Sessions)</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Monthly Aid</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Customised Diet Plan</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Monthly Fitness report card</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Monthly Assessment</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Monthly Video Guidance Call</span>
                                                </li>
                                                <li class="flex space-x-3">
                                                    <!-- Icon -->
                                                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                        <title>Check icon</title>
                                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                    </svg>
                                                    <span class="text-base font-normal leading-tight text-white">Complimentary Service : On-ground training will be provided in collaboration with Schools. Our Sports Curriculum will be implemented as a part of the P. E. classes and will be subject to availability of infrastructure in Schools.</span>
                                                </li>



                                            </ul>
                                            <div class="select-check-box pt-0">
                                                <ul>
                                                    @foreach($category as $key1 => $item1)
                                                    <li>
                                                        <input type="checkbox" name="category_data[{{$key1}}][id]" class="row_{{$key}}{{$key1}}" value="{{$item1->id}}">
                                                        <label for="myCheckbox{{$item1->id}}">
                                                            <img style="border-radius: 54%" data-id="{{$key}}{{$key1}}" class="selected_img" src="{{asset($item1->image)}}">
                                                        </label>
                                                        {{$item1->title}}
                                                    </li>

                                                    @endforeach
                                                </ul>
                                            </div>
                                            <button type="submit" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase" name="click_type" value="buynow">Buy
                                                Now</button>
                                        </form>
                                    </div>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                            <div class="hidden p-4  rounded-lg md:p-8 dark:bg-gray-800" id="faq" role="tabpanel" aria-labelledby="faq-tab" style="background-color: #37455f !important;">
                                <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
                                    @if($nutritionPackagedata->count())
                                    @foreach($nutritionPackagedata as $key => $item)
                                    <!-- standred plan -->

                                    @if($key == 1)

                                    <div class="w-full max-w-sm p-4 rounded-lg shadow-md sm:p-8 
bg-gradient-to-t from-[#000046] to-[#1cb5e0]
scale-115">
                                        @else
                                        <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
                                            @endif

                                            <form role="form" method="POST" class="" action="{{ url('buynow') }}">
                                                @csrf
                                                <input type="hidden" name="package_id" id="package_id" value="{{$item->id}}">
                                                <input type="hidden" name="user_id" value="{{auth()->user()->id}}">
                                                <input type="hidden" name="price" value="{{$item->price}}">
                                                <input type="hidden" name="type" value="sport">
                                                <h5 class="mb-4 text-xl font-medium text-white">{{ $item['title'] }}</h5>
                                                <div class="flex items-baseline text-white">
                                                    <span class="text-3xl font-semibold">₹</span>
                                                    <span class="text-5xl font-extrabold tracking-tight">{{ $item['price'] }}</span>
                                                    <!-- <span class="ml-1 text-xl font-normal text-white"> 3 month</span> -->
                                                </div>
                                                <!-- List -->
                                                <ul role="list" class="space-y-5 my-7">


                                                    <li class="flex space-x-3">
                                                        <!-- Icon -->
                                                        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <title>Check icon</title>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-base font-normal leading-tight text-white">Monthly Aid</span>
                                                    </li>
                                                    <li class="flex space-x-3">
                                                        <!-- Icon -->
                                                        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <title>Check icon</title>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-base font-normal leading-tight text-white">Customised Diet Plan</span>
                                                    </li>
                                                    <li class="flex space-x-3">
                                                        <!-- Icon -->
                                                        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <title>Check icon</title>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-base font-normal leading-tight text-white">Monthly Fitness report card</span>
                                                    </li>
                                                    <li class="flex space-x-3">
                                                        <!-- Icon -->
                                                        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <title>Check icon</title>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-base font-normal leading-tight text-white">Monthly Assessment</span>
                                                    </li>
                                                    <li class="flex space-x-3">
                                                        <!-- Icon -->
                                                        <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                            <title>Check icon</title>
                                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                        <span class="text-base font-normal leading-tight text-white">Monthly Video Guidance Call</span>



                                                </ul>
                                                <button type="submit" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase" name="click_type" value="buynow">Buy
                                                    Now</button>
                                            </form>
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>
                                </div>
    </section>

</main>

@endsection
@section('script')
<script type="text/javascript">
    $(document).ready(function() {

        $('.selected_img').click(function() {

            var id = $(this).data('id')
            $(this).css("border", "2px solid #5AB6FF");
            $('.row_' + id).click()
        })
    })
</script>
@endsection