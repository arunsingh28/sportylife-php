<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- <script defer src="/vendor/js/splider.js"></script> -->
  <!-- <link rel="stylesheet" href="/vendor/css/splider.css"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
    integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <!-- <script id="ze-snippet"
    src="https://static.zdassets.com/ekr/snippet.js?key=95944f8f-52d5-4533-bf96-73d6798c2ac6"> </script> -->
  <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
  <!-- google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700;900&family=Roboto:wght@100&display=swap"
    rel="stylesheet">
  <title>Sportylife</title>
</head>
<style>
  .mobile-menu {
    left: -200%;
    transition: 0.5s;
  }

  .mobile-menu.active {
    left: 0;
  }

  .mobile-menu ul li ul {
    display: none;
  }

  .mobile-menu ul li:hover ul {
    display: block;
  }

  .glass {
    background: rgba(0, 0, 0, 1.33);
    border-radius: 16px;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    backdrop-filter: blur(7.3px);
    -webkit-backdrop-filter: blur(7.3px);
  }

  .active {
    display: block;
  }

  /* hide scrollbar */
  .scroll {
    overflow-y: scroll;
    scrollbar-width: none;
    -ms-overflow-style: none;
  }

  .scroll::-webkit-scrollbar {
    display: none;
  }
</style>

<body class="bg-[#111213]">
  <!-- navbar -->
  <nav class="px-2 sm:px-4 py-2.5 fixed w-full z-20 top-0 left-0">
    <div class="flex flex-wrap items-center h-[70px] justify-around glass mx-auto">
      <a href="/" class="flex items-center">
        <img src="https://sportylife.in/public/web/assets/img/logo-updated3.png" class="h-10" alt="Sportylife Logo">
      </a>
      <div class="flex md:order-2">
        <a href="/login">
          <button type="button"
            class="text-white w-28 bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-4 text-center mr-3 md:mr-0">
            Login</button>
        </a>
        <button data-collapse-toggle="navbar-sticky" onclick="handleHide()" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200
          " aria-controls="navbar-sticky" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <div id="menu" class="items-center justify-between hidden mt-3 rounded-md bg-[#333536] h-[210px] w-full md:flex md:w-auto md:order-1
      xl:bg-transparent xl:h-auto xl:mt-0
      md:bg-transparent md:h-auto md:mt-0
      lg:bg-transparent lg:h-auto lg:mt-0
      " id="navbar-sticky">
        <ul class="flex flex-col p-4 mt-4
          h-14 justify-between items-center
          rounded-xl md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0">
          <li onclick="handleHide()">
            <a href="#home" id="home-menu"
              class="block py-2 pl-3 text-md pr-4 text-gray-400 bg-red-700 rounded md:bg-transparent md:text-white-700 md:p-0 uppercase"
              aria-current="page">Home</a>
          </li>
          <li onclick="handleHide()">
            <a href="#serivces" id="service-menu"
              class="block py-2 pl-3 pr-4 text-gray-400 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-100 md:p-0 uppercase">Services</a>
          </li>
          <li onclick="handleHide()">
            <a href="#price" id="price-menu"
              class="block py-2 pl-3 pr-4 text-gray-400 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-100 md:p-0 uppercase">packages</a>
          </li>
          <li onclick="handleHide()">
            <a href="#About" id="about-menu"
              class="block py-2 pl-3 pr-4 text-gray-400 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-gray-100 md:p-0 uppercase">About</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- end navbar -->



  <section id="home" class="bg-[#111213] container mx-auto mt-36
  md:mt-[100px]
  xl:mt-[100px]
  lg:mt-[100px]
  ">
    <div class="flex flex-col items-center justify-between mx-5
    xl:flex-row
    md:flex-row
    lg:flex-row
    ">
      <!-- aswin poster -->
      <div class="w-[200px]
      md:w-[380px]
      ">
        <img src="https://sportylife.in/public/assets/ashwin.png" alt="Aswin Poster" class="w-full xl:w-96">
      </div>
      <!-- cta -->
      <div class="flex flex-col justify-between items-start gap-5">
        <div class="relative">
          <h1 class="text-6xl font-bold text-white uppercase" style="font-family: 'League Spartan', sans-serif;">
            Redefining
            <img src="https://sportylife.in/public/assets/blue-line.png" style="width: 50%; margin-top: -15px;"
              alt="blur line">
          </h1>
          <br>
          <h1 class="text-7xl font-bold text-white uppercase -mt-6" style="font-family: 'League Spartan', sans-serif;">
            Sports Education</h1>
        </div>
        <p class="text-white uppercase" style="font-family: 'League Spartan', sans-serif;">Sports education, Nutrition &
          Fitness</p>
        <div class="flex flex-col items-center gap-4
        xl:items-start
        md:items-start
        lg:items-start
        ">
          <a href="/login">
            <button type="button"
              class="text-white px-10 py-5 bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-14 py-2 text-center mr-3 md:mr-0 uppercase text-xl">Join
              us</button>
          </a>
          <p class="text-white uppercase" style="font-family: 'League Spartan', sans-serif;">To try our free 7 day trial
            pack</p>
          <p class="text-white" style="font-family: 'League Spartan', sans-serif;">Download our app now!</p>
          <div class="flex justify-center w-full gap-5
          xl:justify-start
          md:justify-start
          lg:justify-start
          ">
          </div>
          <div class="flex gap-1 mx-5 pb-5">
            <a href="https://play.google.com/store/apps/details?id=com.sporty_life_app">
              <div class="android border flex flex-col items-center rounded-md px-2 py-1">
                <!-- <span class="text-white font-thin">Android</span> -->
                <img src="https://sportylife.in/public/web/assets/img/google_play-logo.svg" alt="">
                <!-- <img src="./assets/BitAndroid.png" alt="android qr" class="w-24 h-24 border-2"> -->
              </div>
            </a>
            <a href="https://apps.apple.com/in/app/sporty-life/id1611151967">
              <div class="ios border flex flex-col items-center rounded-md px-2 py-1">
                <!-- <span class="text-white font-thin">iOS</span> -->
                <img src="https://sportylife.in/public/web/assets/img/play-store-logo.svg" alt="">
                <!-- <img src="./assets/BitIos.png" alt="ios qr" class="w-24 h-24 border-2"> -->
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- social link -->
    <div class="flex gap-1
      xl:flex-col
      md:flex-col
      lg:flex-col
      ">
      <a href="https://www.facebook.com/profile.php?id=100075938597149">
        <div class="p-2 rounded-md h-14 w-14 cursor-pointer transition hover:scale-110">
          <img src="https://sportylife.in/public/assets/facebook.png" alt="facebbok">
        </div>
      </a>
      <a href="https://www.youtube.com/@sportylife9675">
        <div class="p-2 rounded-md h-14 w-14 cursor-pointer transition hover:scale-110">
          <img src="https://sportylife.in/public/assets/Youtube.png" alt="youtube">
        </div>
      </a>
      <a href="https://twitter.com/SportyLife01">
        <div class="p-2 rounded-md h-14 w-14 cursor-pointer transition hover:scale-110">
          <img src="https://sportylife.in/public/assets/twitter.png" alt="twitter">
        </div>
      </a>
    </div>
    </div>
    <!-- xl:-mt-20
    md:-mt-20
    lg:-mt-20 -->
    <!-- sports card -->
    <div class="overflow-auto scroll py-5 cursor-move" data-tooltip-target="tooltip-top" data-tooltip-placement="top">
      <div id="tooltip-top" role="tooltip"
        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-red-500 rounded-lg shadow-sm opacity-0 tooltip">
        Scroll Left or Right
        <div class="tooltip-arrow" data-popper-arrow></div>
      </div>
      <div class="mx-10 slider">
        <div class="grid grid-flow-row gap-4 
      xl:justify-between xl:gap-5 xl:grid-flow-col
      md:justify-between md:gap-5 md:grid-flow-col
      lg:justify-between lg:gap-5 lg:grid-flow-col
      ">
          <!-- left arrow icon -->
          <div id="card1" class="w-full rounded-lg bg-white overflow-hidden transition hover:-translate-y-4
        xl:w-72
        md:w-72
        lg:w-72
        ">
            <div class="flex flex-col
          xl:flex-row
          md:flex-row
          lg:flex-row
          ">
              <!-- inner card -->
              <div class="bg-[#3250a4] w-full flex justify-center items-center
            xl:w-[120px]
            md:w-[120px]
            lg:w-[120px]
            ">
                <img src="https://sportylife.in/public/assets/badminton.png" class="flex justify-center items-center p-2
                  
                  ">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl text-center">Badminton</h1>
                  <!-- <p class="text-sm" style="line-height: 14px;">badminton</p> -->
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase"
                    onclick="handleService()">Learn more</button>
                </div>
              </div>
            </div>
          </div>
          <!-- second 2 -->
          <div id="card2" class="w-full rounded-lg bg-white overflow-hidden transition hover:-translate-y-4
        xl:w-72
        md:w-72
        lg:w-72
        ">
            <div class="flex flex-col
          xl:flex-row
          md:flex-row
          lg:flex-row
          ">
              <!-- inner card -->
              <div class="bg-[#3250a4] w-full flex justify-center items-center
            xl:w-[120px]
            md:w-[120px]
            lg:w-[120px]
            ">
                <img src="https://sportylife.in/public/assets/basketball.png"
                  class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl text-center">Basketball</h1>
                  <!-- <p class="text-sm" style="line-height: 14px;">Basketball des.</p> -->
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase"
                    onclick="handleService()">Learn more</button>
                </div>
              </div>
            </div>
          </div>
          <!-- third 3 -->
          <div id="card3" class="w-full rounded-lg bg-white overflow-hidden transition hover:-translate-y-4
        xl:w-72
        md:w-72
        lg:w-72
        ">
            <div class="flex flex-col
          xl:flex-row
          md:flex-row
          lg:flex-row
          ">
              <!-- inner card -->
              <div class="bg-[#3250a4] w-full flex justify-center items-center
            xl:w-[120px]
            md:w-[120px]
            lg:w-[120px]
            ">
                <img src="https://sportylife.in/public/assets/cricket.png" class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl text-center">cricket</h1>
                  <!-- <p class="text-sm" style="line-height: 14px;">cricket</p> -->
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase"
                    onclick="handleService()">learn more</button>
                </div>
              </div>
            </div>
          </div>
          <!-- card 4 -->
          <div id="card4" class="w-full rounded-lg bg-white overflow-hidden transition hover:-translate-y-4
        xl:w-72
        md:w-72
        lg:w-72
        ">
            <div class="flex flex-col
          xl:flex-row
          md:flex-row
          lg:flex-row
          ">
              <!-- inner card -->
              <div class="bg-[#3250a4] w-full flex justify-center items-center
            xl:w-[120px]
            md:w-[120px]
            lg:w-[120px]
            ">
                <img src="https://sportylife.in/public/assets/tennis.png" class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl text-center">Tennis</h1>
                  <!-- <p class="text-sm" style="line-height: 14px;">Tennis</p> -->
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase"
                    onclick="handleService()">learn more</button>
                </div>
              </div>
            </div>
          </div>

          <!-- card 5 -->
          <div id="card5" class="w-full rounded-lg bg-white overflow-hidden transition hover:-translate-y-4
           xl:w-72
           md:w-72
           lg:w-72
           ">
            <div class="flex flex-col
             xl:flex-row
             md:flex-row
             lg:flex-row
             ">
              <!-- inner card -->
              <div class="bg-[#3250a4] w-full flex justify-center items-center
               xl:w-[120px]
               md:w-[120px]
               lg:w-[120px]
               ">
                <img src="https://sportylife.in/public/assets/football.png"
                  class="flex justify-center items-center p-2 h-full">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl text-center">Football</h1>
                  <!-- <p class="text-sm" style="line-height: 14px;">football</p> -->
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase"
                    onclick="handleService()">learn more</button>
                </div>
              </div>
            </div>
          </div>
          <!-- end card -->

        </div>
      </div>
    </div>
  </section>




  <!-- services section -->
  <section id="serivces" class="mx-5 py-20">
    <div class="my-10 flex flex-col items-center" style="font-family: 'League Spartan', sans-serif;">
      <div class="h-1 bg-red-600 w-32 rounded-full"></div>
      <h1 class="text-white  text-6xl font-extrabold uppercase py-5">
        services</h1>
      <p class="text-white text-xl text-center
      
      ">We provide a wide range of Education service, ranging from Nutrition to
        Sports
        and Fitness</p>
    </div>

    <div class="flex gap-10 flex-wrap justify-center items-start">
      <div class="max-w-sm bg-white
      bg-gradient-to-t from-[#111213] to-red-600
      rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="https://sportylife.in/public/assets/taxi-fitness.png" alt="" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-100 uppercase">2D and 3d Fitness
            curriculum
          </h5>
          <p class="mb-3 font-normal text-gray-100">Get your hands on 2D and 3D curriculum in all 5
            Sports on the Learning Management System (LMS).</p>
        </div>
      </div>

      <!-- second feature -->
      <div class="max-w-sm bg-white bg-gradient-to-t from-[#111213] to-[#00bf8f] rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="https://sportylife.in/public/assets/3dyoga.png" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-100 uppercase">Live fitness<br>
            sessions
          </h5>
          <p class="mb-3 font-normal text-gray-100">Catch up on Live and Recorded Fitness Sessions on the SportyLife App
            on Strength and Conditioning, Dance and Yoga.</p>
        </div>
      </div>
      <!-- third -->
      <div class="max-w-sm bg-white
      bg-gradient-to-t from-[#111213] to-blue-600
      rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="https://sportylife.in/public/assets/diet.png" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-100 uppercase"> fitness
            report card <br>(FRC)
          </h5>
          <p class="mb-3 font-normal text-gray-100">Trace your fitness journey through an elaborative Fitness Report
            Card (FRC) calculated based on your Body Mass Index (BMI).</p>
        </div>
      </div>


      <div class="max-w-sm bg-white
      bg-gradient-to-t from-[#111213] to-[#B42B51]
      rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="https://sportylife.in/public/assets/bag.png" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-100 uppercase">Nutrition
            Guidance
          </h5>
          <p class="mb-3 font-normal text-gray-100">Get Nutitional Guidance from expert nutritionists through guidance
            calls and video consultations</p>
        </div>
      </div>

      <div class="max-w-sm bg-white 
      bg-gradient-to-t from-[#111213] to-[#C84B31] rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="https://sportylife.in/public/assets/support.png" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-100 uppercase">Customer
            support
          </h5>
          <p class="mb-3 font-normal text-gray-100">We provide you with the attention that you so deserve.For any
            queries,get in touch with us at<br>
            <a href="mailto:support@sportylife.in" class="text-blue-600 font-semibold">support@sportylife.in</a>
          </p>
        </div>
      </div>
      <!-- end service -->
    </div>
  </section>
  <!-- end of service -->






  <section class="mx-5
  xl:container xl:mx-auto
  lg:container lg:mx-auto
  md:container md:mx-auto
  ">
    <div id="price" class="flex flex-col justify-center items-center py-7">
      <div class="h-1 bg-red-600 w-32"></div>
      <h1 class="text-white text-center text-6xl font-extrabold uppercase py-2">pricings</h1>
    </div>
    <div class="w-full shadow-md
  ">

      <div class="sm:hidden">
        <!-- <label for="plan" class="text-gray-100">Choose the Best Plan</label> -->
        <div class="relative">
          <div onclick="handleChoosePlan()"
            class="h-14 my-4 w-full bg-white flex justify-between items-center px-5 rounded-md" id="placeholder-div">
            <span class="font-bold" id="showPlanName">Sports & Wellness Plans</span>
            <i class="fa-solid fa-arrow-down"></i>
          </div>

          <div class="hidden" id="plan-menu">
            <div onclick="firstPlanShow()"
              class="h-12 w-full mt-1 bg-red-500 rounded-md flex justify-center items-center text-white">
              Lifestyle Plans
            </div>
            <div onclick="secondPlanShow()"
              class="h-12 w-full mt-1 bg-red-500 rounded-md flex justify-center items-center text-white">
              Sports & Wellness Plans
            </div>
            <div onclick="thirdPlanShow()"
              class="h-12 w-full mt-1 bg-red-500 rounded-md  flex justify-center items-center text-white">
              Nutrition
              Plan
            </div>
          </div>

        </div>
      </div>
      <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 sm:flex"
        id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
        <li class="w-full">
          <button id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats"
            aria-selected="false" style="color:#444"
            class="inline-block w-full h-full rounded-tl-lg bg-gray-50 text-[#444] text-[16px]">Lifestyle
            Plans</button>
        </li>
        <li class="w-full flex">
          <button id="about-tab" data-tabs-target="#about" style="color:#fff" type="button" role="tab"
            aria-controls="about" aria-selected="true" class="
          bg-gray-50 w-full h-full text-xl
          bg-red-500 text-[16px]
          ">
            Sports & Wellness
            Plans
          </button>
        </li>
        <li class="w-full">
          <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq"
            aria-selected="false" style="color:#444"
            class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 text-[16px]">Nutrition
            Plan</button>
        </li>
      </ul>
      <div id="fullWidthTabContent" class="border-t border-gray-200">
        <div class="hidden p-4 bg-[#111213] rounded-lg md:p-8" id="stats" role="tabpanel" aria-labelledby="stats-tab">
          <!-- insdie first div -->
          <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
              <h5 class="mb-4 text-xl font-medium text-gray-300">3 Months</h5>
              <div class="flex items-baseline text-gray-100">
                <span class="text-3xl font-semibold text-gray-100">???</span>
                <span class="text-5xl text-gray-100 font-extrabold tracking-tight">1749</span>
                <!-- <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span> -->
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Yoga (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400 ">Dance Fitness (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400 ">Strength and
                    Conditioning (2 Sessions)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Customized Diet Plan</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Fitness Report Card
                    (FRC)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Assessment</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Video Guidance Call</span>
                </li>
              </ul>
              <button onclick="handleService()" type="button"
                class="text-red-600 border
                border-red-600 hover:text-white
                hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>

            <!-- start -->


            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8
              bg-gradient-to-t from-[#000000] to-[#d5291c]
              ">
              <h5 class="mb-4 text-xl font-medium text-white">6 Months</h5>
              <div class="flex items-baseline text-gray-100">
                <span class="text-3xl font-semibold">???</span>
                <span class="text-5xl font-extrabold tracking-tight">2999</span>
                <!-- <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span> -->
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Yoga (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100 " fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Dance Fitness (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Strength and
                    Conditioning (2 Sessions)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Customized Diet Plan</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Fitness Report Card
                    (FRC)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Assessment</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Video Guidance Call</span>
                </li>
              </ul>
              <button onclick="handleService()" type="button"
                class="text-white border
                border-white hover:text-white
                hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>
            <!-- end 2nd price of lifestyle -->

            <!-- start 3 price of lifestyle -->

            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
              <h5 class="mb-4 text-xl font-medium text-gray-300">12 Months</h5>
              <div class="flex items-baseline text-gray-100">
                <span class="text-3xl font-semibold text-gray-100">???</span>
                <span class="text-5xl font-extrabold tracking-tight text-gray-100">5499</span>
                <!-- <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span> -->
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Yoga (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Dance Fitness (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Strength and
                    Conditioning (2 Sessions)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Customized Diet Plan</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Fitness Report Card
                    (FRC)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Assessment</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Video Guidance Call</span>
                </li>
              </ul>
              <button onclick="handleService()" type="button"
                class="text-red-500 border
                border-red-600 hover:text-white
                hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>
          </div>

          <!-- end of first div -->
        </div>

        <!-- second section -->
        <div class="hidden p-4 bg-[#111213] rounded-lg md:p-8" id="about" role="tabpanel" aria-labelledby="about-tab">

          <!-- inside second div -->
          <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
              <h5 class="mb-4 text-xl font-medium text-gray-100">3 Months</h5>
              <div class="flex items-baseline text-gray-100">
                <span class="text-3xl font-semibold">???</span>
                <span class="text-5xl font-extrabold tracking-tight">2249</span>
                <!-- <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span> -->
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Learning Management
                    System (LMS)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coaching from
                    the Basics</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Etiquettes,
                    Sportsmanship and untold rules of the game
                  </span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Yoga (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Dance Fitness (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Strength and
                    Conditioning (2 Sessions)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Customized Diet Plan</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Fitness Report Card
                    (FRC)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Assessment</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Video Guidance Call</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Complimentary Service: on-ground
                    training
                    will be provided in collaboration with Schools.Our Sports Curriculum will be implemented as a part
                    of
                    the P.E classes and will be subjected to availability of infrastucture in Schools.</span>
                </li>
              </ul>
              <button onclick="handleService()" type="button"
                class="text-red-600 border
                border-red-600 hover:text-white
                hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>


            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8
              bg-gradient-to-t from-[#000000] to-[#d5291c]
              ">
              <h5 class="mb-4 text-xl font-medium text-white">6 Months</h5>
              <div class="flex items-baseline text-gray-100">
                <span class="text-3xl font-semibold">???</span>
                <span class="text-5xl font-extrabold tracking-tight">3999</span>
                <!-- <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span> -->
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200 ">Learning Management
                    System (LMS)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Digital Coaching from
                    the Basics</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Etiquettes,
                    Sportsmanship and untold rules of the game
                  </span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Yoga (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100 " fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Dance Fitness (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Strength and
                    Conditioning (2 Sessions)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Customized Diet Plan</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Fitness Report Card
                    (FRC)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Assessment</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Video Guidance Call</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Complimentary Service: on-ground
                    training
                    will be provided in collaboration with Schools.Our Sports Curriculum will be implemented as a part
                    of
                    the P.E classes and will be subjected to availability of infrastucture in Schools.</span>
                </li>
              </ul>
              <button onclick="handleService()" type="button"
                class="text-white border
                border-white hover:text-white
                hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>
            <!-- end 2nd price of lifestyle -->

            <!-- start 3 price of lifestyle -->

            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
              <h5 class="mb-4 text-xl font-medium text-gray-100">12 Months</h5>
              <div class="flex items-baseline text-gray-100">
                <span class="text-3xl font-semibold">???</span>
                <span class="text-5xl font-extrabold tracking-tight">6999</span>
                <!-- <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span> -->
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Learning Management
                    System (LMS)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coaching from
                    the Basics</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Etiquettes,
                    Sportsmanship and untold rules of the game
                  </span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Yoga (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Dance Fitness (2
                    Sessions)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Strength and
                    Conditioning (2 Sessions)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Customized Diet Plan</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Fitness Report Card
                    (FRC)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Assessment</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.41 4l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Video Guidance Call</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-red-400" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Complimentary Service: on-ground
                    training
                    will be provided in collaboration with Schools.Our Sports Curriculum will be implemented as a part
                    of
                    the P.E classes and will be subjected to availability of infrastucture in Schools.</span>
                </li>
              </ul>
              <button onclick="handleService()" type="button"
                class="text-red-500 border
                border-red-600 hover:text-white
                hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>
          </div>


          <!-- upper is second div -->
        </div>




        <!-- third section -->
        <div class="hidden p-4 bg-[#111213] rounded-lg md:p-8" id="faq" role="tabpanel" aria-labelledby="faq-tab">
          <!-- insdie third div -->
          <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 rounded-lg shadow-md sm:p-8 
          bg-gradient-to-t from-[#000000] to-[#d5291c]
          mx-auto ">
              <h5 class="mb-4 text-xl font-medium text-gray-100">6 Months</h5>
              <div class="flex items-baseline text-gray-100">
                <span class="text-3xl font-semibold">???</span>
                <span class="text-5xl font-extrabold tracking-tight">2499</span>
                <!-- <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span> -->
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Customised Diet
                    Plan</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Fitness
                    Report Card (FRC)</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Assessment
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-100" fill="currentColor"
                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd"
                      d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                      clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-200">Monthly Video Guidance Call</span>
                </li>
              </ul>
              <button onclick="handleService()" type="button"
                class="text-red-600 border
                border-red-600 hover:text-white
                hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>


          </div>
        </div>
        <!-- upper in this third div -->
      </div>
    </div>
    </div>

  </section>

  <!-- end of http price -->







  <!-- about -->
  <section id="About" class="py-8 mx-5
  xl:container xl:mx-auto
  md:container md:mx-auto
  lg:container lg:mx-auto
  ">
    <div class="flex flex-col justify-center items-center py-5">
      <div class="h-1 bg-red-600 w-32 rounded-full"></div>
      <h1 class="text-white text-center text-6xl font-extrabold uppercase py-2">about</h1>
    </div>

    <div id="accordion-open" data-accordion="open">
      <h2 id="accordion-open-heading-1">
        <button type="button"
          class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 hover:bg-gray-700"
          data-accordion-target="#accordion-open-body-1" aria-expanded="true" aria-controls="accordion-open-body-1">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                clip-rule="evenodd"></path>
            </svg> What is Sportylife?</span>
          <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
        <div class="p-5 font-light border border-b-0 border-gray-200">
          <p class="mb-2 text-gray-500"> Mission Sports Private Limited is a 10 years 7 months old
            Private Company incorporated on 22 May 2012. Its registered office is in Bangalore, Karnataka, india. The
            Company's status is Active, and it has filed its Annual Returns and Financial Statements up to 31 Mar 2021
            (FY 2020-2021).
          </p>
        </div>
      </div>
      <h2 id="accordion-open-heading-2">
        <button type="button"
          class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-700"
          data-accordion-target="#accordion-open-body-2" aria-expanded="false" aria-controls="accordion-open-body-2">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                clip-rule="evenodd"></path>
            </svg>Can i have a nutrition consultation at my convenience ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-2" class="hidden" aria-labelledby="accordion-open-heading-2">
        <div class="p-5 font-light border border-b-0 border-gray-200">
          <p class="mb-2 text-gray-500 ">At SportyLife, you will be provided with a monthly guidance
            call and quarterly nutritional video consultation by our expert nutritionists and they will get back to you
            within 48 working hours.</p>
        </div>
      </div>
      <h2 id="accordion-open-heading-3">
        <button type="button"
          class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-700"
          data-accordion-target="#accordion-open-body-3" aria-expanded="false" aria-controls="accordion-open-body-3">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                clip-rule="evenodd"></path>
            </svg> How does Fitness Report Card work ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-3" class="hidden" aria-labelledby="accordion-open-heading-3">
        <div class="p-5 font-light border border-t-0 border-gray-200">
          <p class="mb-2 text-gray-500 ">The Fitness Report Card is a new and unique concept that we
            provide with regards to the data entered by you to check the Ideal Body Weight and Body Mass Index and track
            water and calorie intake.</p>
        </div>
      </div>

      <h2 id="accordion-open-heading-4">
        <button type="button"
          class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-700"
          data-accordion-target="#accordion-open-body-4" aria-expanded="false" aria-controls="accordion-open-body-4">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                clip-rule="evenodd"></path>
            </svg> Why should i choose Nutrition at Sportylife ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-4" class="hidden" aria-labelledby="accordion-open-heading-3">
        <div class="p-5 font-light border border-t-0 border-gray-200 ">
          <p class="mb-2 text-gray-500">At SportyLife, the Nutrition package is curated premised on
            evidence-based practice which includes taking into consideration your BMI index and other parameters. At
            SportyLife, we intend to make qualitative changes in your diet to provide wholesome nutritional assistance
            to you.</p>
        </div>
      </div>


      <h2 id="accordion-open-heading-5">
        <button type="button"
          class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 hover:bg-gray-700 "
          data-accordion-target="#accordion-open-body-5" aria-expanded="false" aria-controls="accordion-open-body-5">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z"
                clip-rule="evenodd"></path>
            </svg> Why do i need BMI ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-5" class="hidden" aria-labelledby="accordion-open-heading-3">
        <div class="p-5 font-light border border-t-0 border-gray-200">
          <p class="mb-2 text-gray-500">At SportyLife, the Nutrition package is Your BMI (Body Mass
            Index) is one of the parameters to analyse the nutritional requirements of a person. It is an indispensable
            primary step. The information on BMI helps our nutritionists to plan diet charts that assist our users with
            their nutritional goals.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- footer -->

  <footer class="p-4 md:px-6 md:py-8 bg-gradient-to-t from-[#000000] to-[#d5291c] mt-10">
    <div class="sm:flex sm:items-center sm:justify-between">
      <a href="/" class="flex items-center mb-4 sm:mb-0">
        <img src="https://sportylife.in/public/web/assets/img/logo-updated3.png" class="h-16 mr-3"
          alt="Sportylife Logo">
      </a>
      <ul class="flex flex-wrap items-center mb-6 text-sm text-gray-300 sm:mb-0 ">
        <li>
          <a href="#home" class="mr-4 hover:underline md:mr-6 ">Home</a>
        </li>
        <li>
          <a href="#About" class="mr-4 hover:underline md:mr-6 ">About</a>
        </li>
        <li>
          <a href="#serivces" class="mr-4 hover:underline md:mr-6">Service</a>
        </li>
        <li>
          <a href="#price" class="mr-4 hover:underline md:mr-6 ">Package</a>
        </li>
        <!-- <li>
          <a href="#" class="hover:underline">Contact</a>
        </li> -->
      </ul>
    </div>
    <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
    <span class="block text-sm text-gray-500 text-center sm:text-center text-gray-300">?? 2023 <a href="/"
        class="hover:underline">SportyLife.in</a>. All Rights Reserved.
    </span>
  </footer>
  <script>
    const mobile_icon = document.getElementById('mobile-icon');
    const mobile_menu = document.getElementById('mobile-menu');
    const hamburger_icon = document.querySelector("#mobile-icon i");

    const life = document.getElementById('stats-tab')
    const sport = document.getElementById('about-tab')
    const nutrition = document.getElementById('faq-tab')

    sport.style.background = "#ca3a31"
    sport.style.color = "#fff"

    life.addEventListener('click', () => {
      // life.classList.add('bg-red-500')
      life.style.background = "#ca3a31"
      life.style.color = "#fff"

      // sport.classList.remove('bg-red-500')
      sport.style.background = "#fff"
      sport.style.color = "#444"
      // nutrition.classList.remove('bg-red-500')
      nutrition.style.background = "#fff"
      nutrition.style.color = "#444"
    })

    sport.addEventListener('click', () => {
      // sport.classList.add('bg-red-500')
      sport.style.background = "#ca3a31"
      sport.style.color = "#fff"

      // life.classList.remove('bg-red-500')
      life.style.background = "#fff"
      life.style.color = "#444"
      // nutrition.classList.remove('bg-red-500')
      nutrition.style.background = "#fff"
      nutrition.style.color = "#444"
    })

    nutrition.addEventListener('click', () => {
      // nutrition.classList.add('bg-red-500')
      nutrition.style.background = "#ca3a31"
      nutrition.style.color = "#fff"

      // life.classList.remove('bg-red-500')
      life.style.background = "#fff"
      life.style.color = "#444"
      // sport.classList.remove('bg-red-500')
      sport.style.background = "#fff"
      sport.style.color = "#444"
    })


    function openCloseMenu() {
      mobile_menu.classList.toggle('block');
      mobile_menu.classList.toggle('active');
    }

    function changeIcon(icon) {
      icon.classList.toggle("fa-xmark");
    }

    const handleService = () => {
      window.location.href = '/login'
    }
    const handleHide = () => {
      const menu = document.getElementById('menu')
      menu.classList.toggle('hidden')
    }

    const about = document.getElementById('about-menu')
    const price = document.getElementById('price-menu')
    const home = document.getElementById('home-menu')
    const service = document.getElementById('service-menu')

    // service
    service.addEventListener('click', () => {
      service.style.color = "#fff"
      service.style.fontSize = "20px"
      home.style.color = "#81868f"
      home.style.fontSize = "15px"
      price.style.color = "#81868f"
      price.style.fontSize = "15px"
      about.style.color = "#81868f"
      about.style.fontSize = "15px"
    })

    // home
    home.addEventListener('click', () => {
      home.style.color = "#fff"
      home.style.fontSize = "20px"
      service.style.color = "#81868f"
      service.style.fontSize = "15px"
      price.style.color = "#81868f"
      price.style.fontSize = "15px"
      about.style.color = "#81868f"
      about.style.fontSize = "15px"
    })

    // price
    price.addEventListener('click', () => {
      price.style.color = "#fff"
      price.style.fontSize = "20px"
      service.style.color = "#81868f"
      service.style.fontSize = "15px"
      home.style.color = "#81868f"
      home.style.fontSize = "15px"
      about.style.color = "#81868f"
      about.style.fontSize = "15px"
    })

    // about
    about.addEventListener('click', () => {
      about.style.color = "#fff"
      about.style.fontSize = "20px"
      service.style.color = "#81868f"
      service.style.fontSize = "15px"
      price.style.color = "#81868f"
      price.style.fontSize = "15px"
      home.style.color = "#81868f"
      home.style.fontSize = "15px"
    })

    const stats = document.getElementById('stats')
    const abouts = document.getElementById('abouts')
    const faq = document.getElementById('faq')

    const fitnessPlan = document.getElementById('firstPlan-id')
    const secondPlan = document.getElementById('secondPlan-id')
    const thirdPlan = document.getElementById('thirdPlan-id')


    const handleChoosePlan = () => {
      const menu = document.getElementById('plan-menu')
      menu.classList.toggle('hidden')
    }



    const firstPlanShow = () => {
      let placeHolder = document.getElementById('showPlanName')
      const stats = document.getElementById('stats')
      const about = document.getElementById('about')
      const faq = document.getElementById('faq')
      placeHolder.innerHTML = "LifeStyle Plans"
      stats.classList.remove('hidden')
      about.classList.add('hidden')
      faq.classList.add('hidden')
      handleChoosePlan()
    }
    const secondPlanShow = () => {
      let placeHolder = document.getElementById('showPlanName')
      const about = document.getElementById('about')
      const faq = document.getElementById('faq')
      const stats = document.getElementById('stats')
      placeHolder.innerHTML = "Sports & Wellness Plans"
      about.classList.remove('hidden')
      stats.classList.add('hidden')
      faq.classList.add('hidden')
      handleChoosePlan()
    }
    const thirdPlanShow = () => {
      let placeHolder = document.getElementById('showPlanName')
      const faq = document.getElementById('faq')
      const stats = document.getElementById('stats')
      const about = document.getElementById('about')
      placeHolder.innerHTML = "Nutrition Plans"
      faq.classList.remove('hidden')
      about.classList.add('hidden')
      stats.classList.add('hidden')
      handleChoosePlan()
    }
  </script>
</body>

</html>