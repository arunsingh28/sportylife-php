cvb
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <script defer src="/vendor/js/splider.js"></script>
  <link rel="stylesheet" href="style.css">
  <link rel="stylesheet" href="/vendor/css/splider.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <script id="ze-snippet" src="https://static.zdassets.com/ekr/snippet.js?key=95944f8f-52d5-4533-bf96-73d6798c2ac6"> </script>
  <script src="https://unpkg.com/flowbite@1.6.0/dist/flowbite.min.js"></script>
  <!-- google font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=League+Spartan:wght@700;900&family=Roboto:wght@100&display=swap" rel="stylesheet">
  <!-- slider -->
  <!-- jquery -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
  <script defer src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>
  <title>Sportylife</title>
</head>

<body class="bg-[#111213]">
  <!-- navbar -->
  <nav class="px-2 sm:px-4 py-2.5 fixed w-full z-20 top-0 left-0">
    <div class="flex flex-wrap items-center h-[70px] justify-around glass mx-auto">
      <a href="/" class="flex items-center">
        <img src="https://sportylife.in/public/web{{ asset('/assets/img/logo-updated3.png')}}" class="h-10 mr-3 sm:h-9" alt="Sportylife Logo">
      </a>
      <div class="flex md:order-2">
        <a href="/login">
          <button type="button" class="text-white w-28 bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-4 text-center mr-3 md:mr-0">
            Login</button>
        </a>
        <button data-collapse-toggle="navbar-sticky" type="button" class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-sticky" aria-expanded="false">
          <span class="sr-only">Open main menu</span>
          <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </div>
      <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-sticky">
        <ul class="flex flex-col p-4 mt-4 border
          h-14 w-[450px] justify-between items-center
          border-gray-100 rounded-xl md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium md:border-0">
          <li>
            <a href="#home" class="block py-2 pl-3 text-xl pr-4 text-white bg-red-700 rounded md:bg-transparent md:text-white-700 md:p-0 uppercase" aria-current="page">Home</a>
          </li>
          <li>
            <a href="#about" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 uppercase">About</a>
          </li>
          <li>
            <a href="#serivces" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 uppercase">Services</a>
          </li>
          <li>
            <a href="#price" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 uppercase">packages</a>
          </li>
          <li>
            <a href="#contact" class="block py-2 pl-3 pr-4 text-gray-700 rounded hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-white dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700 uppercase">Contact</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- end navbar -->



  <section id="home" class="bg-[#111213] container mx-auto ">
    <div class="flex flex-col items-center justify-between h-screen mx-5
    xl:flex-row
    md:flex-row
    lg:flex-row
    ">
      <!-- aswin poster -->
      <div class="w-[380px]">
        <img src="{{ asset('/assets/ashwin.png')}}" alt="Aswin Poster" class="w-full xl:w-96">
      </div>
      <!-- cta -->
      <div class="flex flex-col mx-10 justify-between items-start gap-5">
        <div class="relative">
          <h1 class="text-6xl font-bold text-white uppercase" style="font-family: 'League Spartan', sans-serif;">
            Redefining
            <img src="{{ asset('/assets/blue-line.png')}}" style="width: 50%;" alt="blur line">
          </h1>
          <br>
          <h1 class="text-7xl font-bold text-white uppercase -mt-6" style="font-family: 'League Spartan', sans-serif;">
            Sports Education</h1>
        </div>
        <p class="text-white uppercase" style="font-family: 'League Spartan', sans-serif;">Sports education, Nutrition &
          Fitness</p>
        <a href="/login">
          <button type="button" class="text-white px-10 py-5 bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-14 py-2 text-center mr-3 md:mr-0 uppercase text-xl">Join
            us</button>
        </a>
        <p class="text-white uppercase" style="font-family: 'League Spartan', sans-serif;">To try our free 7 day trial
          pack</p>
        <p class="text-white -mt-5" style="font-family: 'League Spartan', sans-serif;">Download our app now!</p>
        <div class="flex justify-center w-full gap-5
        xl:justify-start
        md:justify-start
        lg:justify-start
        ">
          <a href="https://play.google.com/store/apps/details?id=com.sporty_life_app">
            <div class="android border flex flex-col items-center rounded-md px-2 py-1">
              <!-- <span class="text-white font-thin">Android</span> -->
              <img src="https://sportylife.in/public/web/assets/img/google_play-logo.svg" alt="">
            </div>
          </a>
          <a href="https://apps.apple.com/in/app/sporty-life/id1611151967">
            <div class="ios border flex flex-col items-center rounded-md px-2 py-1">
              <!-- <span class="text-white font-thin">iOS</span> -->
              <img src="https://sportylife.in/public/web/assets/img/play-store-logo.svg" alt="">
            </div>
          </a>
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
            <img src="{{ asset('/assets/facebook.png')}}" alt="facebbok">
          </div>
        </a>
        <a href="https://www.youtube.com/@sportylife9675">
          <div class="p-2 rounded-md h-14 w-14 cursor-pointer transition hover:scale-110">
            <img src="{{ asset('/assets/Youtube.png')}}" alt="youtube">
          </div>
        </a>
        <a href="https://twitter.com/SportyLife01">
          <div class="p-2 rounded-md h-14 w-14 cursor-pointer transition hover:scale-110">
            <img src="{{ asset('/assets/twitter.png')}}" alt="twitter">
          </div>
        </a>
      </div>
    </div>
    <!-- sports card -->
    <div class="relative">
      <div class="flex w-16 justify-between font-thin absolute right-12 -top-10">
        <button id="back">
          <i class="fa-solid fa-chevron-left text-white text-xl cursor-pointer hidden 
    xl:block md:block lg:block
    "></i>
        </button>
        <button id="next">
          <i class="fa-solid fa-chevron-right text-white text-xl cursor-pointer hidden 
    xl:block md:block lg:block
    "></i>
        </button>
      </div>

      <div class="mx-10 slider overflow-hidden
    xl:-mt-[80px]
    md:-mt-[80px]
    lg:-mt-[80px]
    ">

        <div class="justify-center items-center grid grid-flow-col gap-4
      xl:justify-between xl:gap-5
      md:justify-between md:gap-5
      lg:justify-between lg:gap-5
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
                <img src="{{ asset('/assets/badminton.png')}}" class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl">Badminton</h1>
                  <p class="text-sm" style="line-height: 14px;">Football</p>
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase">Learn more</button>
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
                <img src="{{ asset('/assets/basketball.png')}}" class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl">Baskitball</h1>
                  <p class="text-sm" style="line-height: 14px;">baskitball des.</p>
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase">Learn more</button>
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
                <img src="{{ asset('/assets/cricket.png')}}" class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl">cricket</h1>
                  <p class="text-sm" style="line-height: 14px;">Football</p>
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase">learn more</button>
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
                <img src="{{ asset('/assets/tennis.png')}}" class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl">Tennis</h1>
                  <p class="text-sm" style="line-height: 14px;">Tennis</p>
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase">learn more</button>
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
                <img src="{{ asset('/assets/tennis.png')}}" class="flex justify-center items-center p-2">
              </div>
              <div>
                <div class="mx-2">
                  <h1 class="uppercase font-semibold pt-2 text-xl">5 sport</h1>
                  <p class="text-sm" style="line-height: 14px;">5 sport</p>
                  <button class="bg-black text-white rounded-md px-6 py-2 my-2 uppercase">learn more</button>
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
  <section id="serivces" class="container mx-auto py-20">
    <div class="my-10 flex flex-col items-center" style="font-family: 'League Spartan', sans-serif;">
      <div class="h-1 bg-red-600 w-32 rounded-full"></div>
      <h1 class="text-white  text-6xl font-extrabold uppercase py-5">
        service</h1>
      <p class="text-white text-xl">We provide a wide range of Education service, ranging from Nutrition to
        Sports
        and Fitness</p>
    </div>

    <div class="flex gap-10 flex-wrap justify-center items-start">
      <div class="max-w-sm bg-white
      bg-gradient-to-t from-[#111213] to-red-600
      rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="{{ asset('/assets/taxi-fitness.png')}}" alt="" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white uppercase">2D and 3d Fitness
            curriculum
          </h5>
          <p class="mb-3 font-normal text-gray-100">Get your hands on 2D and 3D curriculum in all 5
            Sports on the Learning Management System(LMS).</p>
        </div>
      </div>

      <!-- second feature -->
      <div class="max-w-sm bg-white bg-gradient-to-t from-[#111213] to-[#00bf8f] rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="{{ asset('/assets/3dyoga.png')}}" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white uppercase">Live fitness<br>
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
        <img class="rounded-t-lg mx-auto h-48" src="{{ asset('/assets/diet.png')}}" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white uppercase"> fitness
            report card <br>(FRC)
          </h5>
          <p class="mb-3 font-normal text-gray-100">Trace your fitness journey through an elaborative Fitness Report
            Card (FRC) calculated based on your Body Mass Index (BMI).</p>
        </div>
      </div>


      <div class="max-w-sm bg-white
      bg-gradient-to-t from-[#111213] to-[#B42B51]
      rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="{{ asset('/assets/bag.png')}}" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white uppercase">Nutitional
            gauidance
          </h5>
          <p class="mb-3 font-normal text-gray-100">Get Nutitional Guidance from expert nutritionists through guidance
            calls and video consultations</p>
        </div>
      </div>

      <div class="max-w-sm bg-white 
      bg-gradient-to-t from-[#111213] to-[#C84B31] rounded-lg shadow-md">
        <img class="rounded-t-lg mx-auto h-48" src="{{ asset('/assets/support.png')}}" alt="yoga" />
        <div class="p-5">
          <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white uppercase">Customer
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


  <!-- pricing section with other prices -->
  <section id="price" class="container mx-auto mb-10">
    <div class="flex flex-col justify-center items-center py-5">
      <div class="h-1 bg-red-600 w-32 rounded-full"></div>
      <h1 class="text-white text-center text-6xl font-extrabold uppercase py-2">pricing</h1>
    </div>
    <div class="w-full bg-white border rounded-lg shadow-md dark:bg-gray-800 dark:border-gray-700">
      <div class="sm:hidden">
        <label for="tabs" class="sr-only">Select tab</label>
        <select id="tabs" class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
          <option>Statistics</option>
          <option>Services</option>
          <option>FAQ</option>
        </select>
      </div>
      <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
        <li class="w-full">
          <button id="stats-tab" data-tabs-target="#stats" type="button" role="tab" aria-controls="stats" aria-selected="true" class="inline-block w-full p-4 rounded-tl-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Basic
            Plans</button>
        </li>
        <li class="w-full">
          <button id="about-tab" data-tabs-target="#about" type="button" role="tab" aria-controls="about" aria-selected="false" class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Standred
            Plan</button>
        </li>
        <li class="w-full">
          <button id="faq-tab" data-tabs-target="#faq" type="button" role="tab" aria-controls="faq" aria-selected="false" class="inline-block w-full p-4 rounded-tr-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Fitness
            Plans</button>
        </li>
      </ul>
      <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
        <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="stats" role="tabpanel" aria-labelledby="stats-tab">
          <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
              <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Standard plan</h5>
              <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-3xl font-semibold">?</span>
                <span class="text-5xl font-extrabold tracking-tight">1749</span>
                <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                    Curriculum</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                    a
                    week
                    (Yoga, Strength and Conditioning and Dance Fitness)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">LMS</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">3 weekly recorded Sessions</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">Customized Diet Chart</span>
                </li>
              </ul>
              <button type="button" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>

            <!-- price 2 -->
            <div class="w-full max-w-sm p-4 rounded-lg shadow-md sm:p-8 
          bg-gradient-to-t from-[#000046] to-[#1cb5e0]
          scale-115">
              <h5 class="mb-4 text-xl font-medium text-gray-300">Fitness And Nutrition plan</h5>
              <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-3xl font-semibold">?</span>
                <span class="text-5xl font-extrabold tracking-tight">1749</span>
                <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                    Curriculum</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                    a
                    week
                    (Yoga, Strength and Conditioning and Dance Fitness)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">LMS</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">3 weekly recorded Sessions</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Customized Diet Chart</span>
                </li>
              </ul>
              <button type="button" class="text-white border
              border-white hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Try
                7 day</button>
            </div>

            <!-- third price -->
            <div class="w-full max-w-sm p-4 bg-transparent rounded-lg shadow-md sm:p-8">
              <h5 class="mb-4 text-xl font-medium text-gray-500">Nutrition plan</h5>
              <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-3xl font-semibold">?</span>
                <span class="text-5xl font-extrabold tracking-tight">1749</span>
                <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                    Curriculum</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                    a
                    week
                    (Yoga, Strength and Conditioning and Dance Fitness)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">LMS</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">3 weekly recorded Sessions</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">Customized Diet Chart</span>
                </li>
              </ul>
              <button type="button" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Bye
                plan</button>
            </div>
          </div>
          <!-- first price close -->
        </div>
        <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="about" role="tabpanel" aria-labelledby="about-tab">
          <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
            <!-- standred plan -->
            <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
              <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Standard plan</h5>
              <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-3xl font-semibold">?</span>
                <span class="text-5xl font-extrabold tracking-tight">1749</span>
                <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                    Curriculum</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                    a
                    week
                    (Yoga, Strength and Conditioning and Dance Fitness)
                  </span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">LMS</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">3 weekly recorded Sessions</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">Customized Diet Chart</span>
                </li>
              </ul>
              <button type="button" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                Plan</button>
            </div>

            <!-- price 2 -->
            <div class="w-full max-w-sm p-4 rounded-lg shadow-md sm:p-8 
          bg-gradient-to-t from-[#000046] to-[#1cb5e0]
          scale-115">
              <h5 class="mb-4 text-xl font-medium text-gray-300">Fitness And Nutrition plan</h5>
              <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-3xl font-semibold">?</span>
                <span class="text-5xl font-extrabold tracking-tight">1749</span>
                <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                    Curriculum</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                    a
                    week
                    (Yoga, Strength and Conditioning and Dance Fitness)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">LMS</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">3 weekly recorded Sessions</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Customized Diet Chart</span>
                </li>
              </ul>
              <button type="button" class="text-white border
              border-white hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Try
                7 day</button>
            </div>

            <!-- third price -->
            <div class="w-full max-w-sm p-4 bg-transparent rounded-lg shadow-md sm:p-8">
              <h5 class="mb-4 text-xl font-medium text-gray-500">Nutrition plan</h5>
              <div class="flex items-baseline text-gray-900 dark:text-white">
                <span class="text-3xl font-semibold">?</span>
                <span class="text-5xl font-extrabold tracking-tight">1749</span>
                <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
              </div>
              <!-- List -->
              <ul role="list" class="space-y-5 my-7">
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                    Curriculum</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                </li>
                <li class="flex space-x-3">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                    a
                    week
                    (Yoga, Strength and Conditioning and Dance Fitness)</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                </li>
                <li class="flex space-x-3 decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">LMS</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">3 weekly recorded Sessions</span>
                </li>
                <li class="flex space-x-3 line-through decoration-gray-500">
                  <!-- Icon -->
                  <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <title>Check icon</title>
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                  </svg>
                  <span class="text-base font-normal leading-tight text-gray-500">Customized Diet Chart</span>
                </li>
              </ul>
              <button type="button" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Bye
                plan</button>
            </div>
          </div>
          <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="faq" role="tabpanel" aria-labelledby="faq-tab">
            <div class="flex flex-wrap gap-4 justify-center rounded-xl
        xl:justify-between
        lg:justify-between
        ">
              <!-- standred plan -->
              <div class="w-full max-w-sm p-4 bg-white rounded-lg shadow-md sm:p-8 bg-transparent">
                <h5 class="mb-4 text-xl font-medium text-gray-500 dark:text-gray-400">Standard plan</h5>
                <div class="flex items-baseline text-gray-900 dark:text-white">
                  <span class="text-3xl font-semibold">?</span>
                  <span class="text-5xl font-extrabold tracking-tight">1749</span>
                  <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
                </div>
                <!-- List -->
                <ul role="list" class="space-y-5 my-7">
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                      Curriculum</span>
                  </li>
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                  </li>
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                      a
                      week
                      (Yoga, Strength and Conditioning and Dance Fitness)
                    </span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                  </li>
                  <li class="flex space-x-3 line-through decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500">LMS</span>
                  </li>
                  <li class="flex space-x-3 line-through decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500">3 weekly recorded Sessions</span>
                  </li>
                  <li class="flex space-x-3 line-through decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500">Customized Diet Chart</span>
                  </li>
                </ul>
                <button type="button" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Buy
                  Plan</button>
              </div>

              <!-- price 2 -->
              <div class="w-full max-w-sm p-4 rounded-lg shadow-md sm:p-8 
          bg-gradient-to-t from-[#000046] to-[#1cb5e0]
          scale-115">
                <h5 class="mb-4 text-xl font-medium text-gray-300">Fitness And Nutrition plan</h5>
                <div class="flex items-baseline text-gray-900 dark:text-white">
                  <span class="text-3xl font-semibold">?</span>
                  <span class="text-5xl font-extrabold tracking-tight">1749</span>
                  <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
                </div>
                <!-- List -->
                <ul role="list" class="space-y-5 my-7">
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                      Curriculum</span>
                  </li>
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                  </li>
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                      a
                      week
                      (Yoga, Strength and Conditioning and Dance Fitness)</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-500 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">LMS</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">3 weekly recorded Sessions</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">Customized Diet Chart</span>
                  </li>
                </ul>
                <button type="button" class="text-white border
              border-white hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Try
                  7 day</button>
              </div>

              <!-- third price -->
              <div class="w-full max-w-sm p-4 bg-transparent rounded-lg shadow-md sm:p-8">
                <h5 class="mb-4 text-xl font-medium text-gray-500">Nutrition plan</h5>
                <div class="flex items-baseline text-gray-900 dark:text-white">
                  <span class="text-3xl font-semibold">?</span>
                  <span class="text-5xl font-extrabold tracking-tight">1749</span>
                  <span class="ml-1 text-xl font-normal text-gray-500 dark:text-gray-400"> 3 month</span>
                </div>
                <!-- List -->
                <ul role="list" class="space-y-5 my-7">
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Sports
                      Curriculum</span>
                  </li>
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">Fitness</span>
                  </li>
                  <li class="flex space-x-3">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-blue-600 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500 dark:text-gray-400">3 Live Sessions in
                      a
                      week
                      (Yoga, Strength and Conditioning and Dance Fitness)</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">Digital Coach</span>
                  </li>
                  <li class="flex space-x-3 decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-blue-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-400">Monthly Guidance Call</span>
                  </li>
                  <li class="flex space-x-3 line-through decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500">LMS</span>
                  </li>
                  <li class="flex space-x-3 line-through decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500">3 weekly recorded Sessions</span>
                  </li>
                  <li class="flex space-x-3 line-through decoration-gray-500">
                    <!-- Icon -->
                    <svg aria-hidden="true" class="flex-shrink-0 w-5 h-5 text-gray-400 dark:text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                      <title>Check icon</title>
                      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="text-base font-normal leading-tight text-gray-500">Customized Diet Chart</span>
                  </li>
                </ul>
                <button type="button" class="text-blue-500 border
              border-blue-600 hover:text-white
              hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-200 font-medium rounded-xl text-sm px-5 py-4 inline-flex justify-center w-full text-center uppercase">Bye
                  plan</button>
              </div>
            </div>
          </div>
        </div>
      </div>
  </section>









  <!-- about -->
  <section id="about" class="container py-8 mx-auto splide__slide">
    <h1 class="text-white text-center text-6xl my-10 font-extrabold uppercase py-5">about</h1>

    <div id="accordion-open" data-accordion="open">
      <h2 id="accordion-open-heading-1">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 rounded-t-xl focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-1" aria-expanded="true" aria-controls="accordion-open-body-1">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg> What is Sportylife?</span>
          <svg data-accordion-icon class="w-6 h-6 rotate-180 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-1" class="hidden" aria-labelledby="accordion-open-heading-1">
        <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700 dark:bg-gray-900">
          <p class="mb-2 text-gray-500 dark:text-gray-400"> Mission Sports Private Limited is a 10 years 7 months old
            Private Company incorporated on 22 May 2012. Its registered office is in Bangalore, Karnataka, india. The
            Company's status is Active, and it has filed its Annual Returns and Financial Statements up to 31 Mar 2021
            (FY 2020-2021).
          </p>
        </div>
      </div>
      <h2 id="accordion-open-heading-2">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-b-0 border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-2" aria-expanded="false" aria-controls="accordion-open-body-2">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg>Can i have a nutrition consultation at my convenience ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-2" class="hidden" aria-labelledby="accordion-open-heading-2">
        <div class="p-5 font-light border border-b-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">At SportyLife, you will be provided with a monthly guidance
            call and quarterly nutritional video consultation by our expert nutritionists and they will get back to you
            within 48 working hours.</p>
        </div>
      </div>
      <h2 id="accordion-open-heading-3">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-3" aria-expanded="false" aria-controls="accordion-open-body-3">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg> How does Fitness Report Card work ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-3" class="hidden" aria-labelledby="accordion-open-heading-3">
        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">The Fitness Report Card is a new and unique concept that we
            provide with regards to the data entered by you to check the Ideal Body Weight and Body Mass Index and track
            water and calorie intake.</p>
        </div>
      </div>

      <h2 id="accordion-open-heading-4">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-4" aria-expanded="false" aria-controls="accordion-open-body-4">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg> Why should i choose Nutrition at Sportylife ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-4" class="hidden" aria-labelledby="accordion-open-heading-3">
        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">At SportyLife, the Nutrition package is curated premised on
            evidence-based practice which includes taking into consideration your BMI index and other parameters. At
            SportyLife, we intend to make qualitative changes in your diet to provide wholesome nutritional assistance
            to you.</p>
        </div>
      </div>


      <h2 id="accordion-open-heading-5">
        <button type="button" class="flex items-center justify-between w-full p-5 font-medium text-left text-gray-500 border border-gray-200 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-open-body-5" aria-expanded="false" aria-controls="accordion-open-body-5">
          <span class="flex items-center"><svg class="w-5 h-5 mr-2 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
            </svg> Why do i need BMI ?</span>
          <svg data-accordion-icon class="w-6 h-6 shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
          </svg>
        </button>
      </h2>
      <div id="accordion-open-body-5" class="hidden" aria-labelledby="accordion-open-heading-3">
        <div class="p-5 font-light border border-t-0 border-gray-200 dark:border-gray-700">
          <p class="mb-2 text-gray-500 dark:text-gray-400">At SportyLife, the Nutrition package is Your BMI (Body Mass
            Index) is one of the parameters to analyse the nutritional requirements of a person. It is an indispensable
            primary step. The information on BMI helps our nutritionists to plan diet charts that assist our users with
            their nutritional goals.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- footer -->

  <footer class="p-4 bg-white rounded-lg shadow md:px-6 md:py-8 dark:bg-gray-900">
    <div class="sm:flex sm:items-center sm:justify-between">
      <a href="https://flowbite.com/" class="flex items-center mb-4 sm:mb-0">
        <img src="https://sportylife.in/public/web{{ asset('/assets/img/logo-updated3.png" class="h-12 mr-3"
          alt="Sportylife Logo">
      </a>
      <ul class="flex flex-wrap items-center mb-6 text-sm text-gray-500 sm:mb-0 dark:text-gray-400">
        <li>
          <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
        </li>
        <li>
          <a href="#" class="mr-4 hover:underline md:mr-6">Privacy Policy</a>
        </li>
        <li>
          <a href="#" class="mr-4 hover:underline md:mr-6 ">Licensing</a>
        </li>
        <li>
          <a href="#" class="hover:underline">Contact</a>
        </li>
      </ul>
    </div>
    <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
    <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">� 2022 <a href="/"
        class="hover:underline">sportylife.in</a>. All Rights Reserved.
    </span>
  </footer>
  <script defer src="/main.js"></script>
</body>

</html>