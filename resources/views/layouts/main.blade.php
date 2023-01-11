@inject('Setting', 'App\Models\Settings')
@inject('Header_footers', 'App\Models\Header_footers')
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Sporty Life</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <!-- Favicons -->
    <link href="{{ asset('web/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('web/assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;300;400;600;700;800;900&display=swap"
        rel="stylesheet">
    <!-- <link href="https://use.typekit.net/wrn2kps.css" rel="stylesheet"> -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- Vendor CSS Files -->
    <link href="{{ asset('web/assets/vendor/animate.css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ asset('web/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('web/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ asset('web/assets/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
    <link href="{{ asset('web/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link href="{{ asset('web/assets/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    <link href="{{ asset('web/custom.css') }}" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .profile_img {
            height: 27px !important;
        }

        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
            /* display: none; */
        }

        ::-webkit-scrollbar-track {
            background: var(--lightestgrey);
        }

        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        .mfp-iframe-holder {
            padding-top: 150px !important;
            padding-bottom: 40px;
            height: auto !important;
        }

        .Workout_Videos img {
            width: 100%;
            height: 200px;
            border-radius: 20px;
            object-fit: cover;
        }

        #social-links ul li {
            display: inline-block;
            margin-left: 7px;
        }

        .pd45 {
            padding-right: 45px !important;
        }

        .ft15 {
            font-size: 15px !important;
        }

        /* model */
        .modal-content {
            background-color: #373737 !important;
        }

        .modal-title {
            color: white !important;
        }

        .btn-secondary {
            background-color: #373737 !important;
        }

        .modal-header {
            border-bottom: 1px solid #6D6D6D !important;
        }

        .modal-footer {
            border-top: 1px solid #6D6D6D !important;
        }

        /* model */
        .parent {
            overflow: hidden;
            margin-top: 20px;
        }

        .child {
            float: left;
            margin-right: 15px;
            text-align: center;
            line-height: 18px;
            cursor: pointer;
            background-color: transparent;
            padding: 6px 20px;
            border-radius: 22px;
            border: 1px solid #848C97;
            color: #fff;
        }

        .child.bak img {
            filter: invert(1);
        }

        .bak {
            background-color: #fff;
            color: #000;
        }

        .parent h6 {
            color: #fff;
            text-align: left;
            font-size: 16px;
        }

        select.one {
            border: 1px solid #ccc;
            background: url("assets/img/arr.png") no-repeat;
            border: 1px solid #6d6d6d;
            width: 100%;
            color: #a8a8a8;
            border-radius: 35px;
            font-size: 13px;
            height: 50px;
            margin-top: 15px;
            outline: none;
            padding: 15px 15px;
        }

        select.one,
        select.two,
        select.three {
            background-size: 16px;
            background-position: calc(100% - 20px) 17px;
            background-repeat: no-repeat;
        }

        select {
            width: 100%;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            padding: 10px;
            margin: 20px 0;
        }

        .height {
            background: #373737;
            border: 1px solid #6D6D6D;
            border-radius: 30px;
            line-height: 50px;
        }

        .height input.otp {
            background: transparent;
            text-align: center;
            color: #ffff;
            border-bottom: none;
            border-top: none;
            border-right-color: #6d6d6d;
            border-left: none;
            outline: none;
            height: 30px;
            width: 40%;
        }

        h6.hgt_sec {
            color: #fff;
            text-align: left;
            font-size: 16px;
            margin-top: 15px;
        }

        .select2-container--default .select2-selection--single {
            background-color: #373737 !important;
            border: 1px solid #6D6D6D !important;
            border-radius: 37px !important;
            height: 49px !important;
            width: 100% !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: white !important;
            line-height: 49px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 26px !important;
            position: absolute !important;
            top: 11px !important;
            right: 18px !important;
            width: 20px !important;
        }

        .datepicker table tr td.day:hover,
        .datepicker table tr td.day.focused {
            background: #ef4234 !important;
            cursor: pointer;
            color: white;
        }

        .datepicker-dropdown {
            color: white !important;
            background: #212121 !important;
            /* font-size: 20px !important; */
        }

        .datepicker .datepicker-switch:hover,
        .datepicker .prev:hover,
        .datepicker .next:hover,
        .datepicker tfoot tr th:hover,
        .datepicker table tr td span:hover,
        .datepicker table tr td span.focused {
            background: #ef4234 !important;
        }

        .datepicker table tr td.day,
        .datepicker table tr td.day:hover,
        .datepicker table tr td.day.focused {
            padding: 7px;
        }

        .datepicker .datepicker-switch,
        .datepicker .datepicker-switch:hover {
            height: 37px;
        }

        .freetrial-popup {
            margin-top: 12%;
            max-width: 1000px;
        }

        .add-diary-mobile {
            display: none;
        }

        #loading {
            display: block;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 999;
            width: 100%;
            height: 100%;
            background-color: #000;
            /* background-image: url("public/web/assets/img/loader.gif"); */
        }

        #loading .loader-gif-img {
            width: 10%;
            height: 100%;
            margin: auto;
            display: flex;
            text-align: center;

            align-items: center;
            justify-content: center;
        }

        #loading .loader-gif-img img {
            width: 100%;
            border-radius: 100%;
            height: auto;
        }

        .modal {
            top: 30px !important;
        }

        #expertrons_pop_up {
            right: 54px !important;
        }

    </style>
    @yield('style')
</head>

<body>
    <!-- ======= Header ======= -->
    <!-- ======= abc ======= -->
    <!-- <div id="preloder">
         <img class="loader" src="{{ asset('web/assets/img/loader.gif') }}" alt="" class="img-fluid">
      </div> -->
    <header id="header" class="fixed-top">
        <div class="container-fluid d-flex align-items-center">
            <h1 class="logo me-auto">
                <a href="{{ route('index') }}">
                    <?php @$header_logo = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'logo')
                        ->first(); ?>
                    @if ($header_logo->status == '1')
                        <img src="{{ asset($header_logo->value) }}" alt="" class="img-fluid">
                    @endif
                </a>
            </h1>
            <!-- Uncomment below if you prefer to use an image logo -->
            <!-- <a href="index.html" class="logo me-auto me-lg-0"><img src="assets/img/logo.png" alt="" class="img-fluid"></a>-->
            <nav id="navbar" class="navbar order-last order-lg-0">
                <!-- <ul>
                  <li><a href="index.html" class="active">Home</a></li>
                  <li><a href="nutrition.html">Nutrition</a></li>
                  <li class="dropdown"><a href="#"><span>Services</span> <i class="bi bi-chevron-down"></i></a>
                      <ul>
                          <li><a href="services_details.html">Services</a></li>
                          <li><a href="">Services</a></li>
                          <li><a href="">Services</a></li>
                      </ul>
                  </li>
                  <li><a href="workout_videos.html">Workout Videos</a></li>
                  <li><a href="community.html">Community</a></li>
                  </ul> -->
                <ul>

                    <?php @$header_home = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'home')
                        ->first(); ?>
                    <?php @$header_nutrition = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'nutrition')
                        ->first(); ?>
                    <?php @$header_frc = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'frc')
                        ->first(); ?>
                    <?php @$header_packages = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'packages')
                        ->first(); ?>
                    <?php @$header_sportylive = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'sportylive')
                        ->first(); ?>
                    <?php @$header_workoutvideos = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'workout-videos')
                        ->first(); ?>
                    <?php @$header_newsfeeds = $Header_footers
                        ->where('type', 'header')
                        ->where('title_slug', 'news-feeds')
                        ->first(); ?>

                    @if ($header_home->status == '1')
                        <li><a href="{{ route($header_home->value) }}"
                                class="{{ request()->routeIs('index') ? 'active' : '' }}">{{ $header_home->title }}</a>
                        </li>
                    @endif
                    @if ($header_nutrition->status == '1')
                        <li><a href="{{ route($header_nutrition->value) }}"
                                class="{{ request()->routeIs('nutrition') || request()->routeIs('recipes') || request()->routeIs('web-nutrition-blogs') || request()->routeIs('diary') ? 'active' : '' }}">{{ $header_nutrition->title }}</a>
                        </li>
                    @endif
                    @if ($header_frc->status == '1')
                        <li><a href="{{ route($header_frc->value) }}"
                                class="{{ request()->routeIs('frc') ? 'active' : '' }}">{{ $header_frc->title }}</a>
                        </li>
                    @endif
                    @if ($header_packages->status == '1')
                        <li><a href="{{ route($header_packages->value) }}"
                                class="{{ request()->routeIs('services') ? 'active' : '' }}">{{ $header_packages->title }}</a>
                        </li>
                    @endif
                    @if ($header_sportylive->status == '1')
                        <li><a class="{{ request()->routeIs('live-sessions') ? 'active' : '' }}"
                                href="{{ route($header_sportylive->value) }}">{{ $header_sportylive->title }}</a></li>
                    @endif
                    

                    <li class="add-diary-mobile"><a class="" href="{{ route('diary') }}">My Diary</a></li>

                    @if ($header_workoutvideos->status == '1')
                        <li><a href="{{ route($header_workoutvideos->value) }}"
                                class="{{ request()->routeIs('workout-videos') ? 'active' : '' }}">{{ $header_workoutvideos->title }}</a>
                        </li>
                    @endif
                    @if ($header_newsfeeds->status == '1')
                        <li><a class="{{ request()->routeIs('news-feeds') ? 'active' : '' }}"
                                href="{{ route($header_newsfeeds->value) }}">{{ $header_newsfeeds->title }}</a></li>
                    @endif
                    <li><a href="{{ route('web.faq') }}"
                            class="{{ request()->routeIs('web.faq') ? 'active' : '' }}">FAQ</a>
                    </li>
                </ul>
                <i class="bi bi-list mobile-nav-toggle"></i>
            </nav>
            <div class="header-social-links d-flex">

                @if (auth()->user())


                    <div class="dropdown">
                        <button id="myBtn" class="dropbtn" style="width: max-content !important;"><img
                                src="{{ asset(auth()->user()->image ?? '') }}" alt=""
                                class="img-fluid profile_img" style="border-radius: 20px;">
                            <span>{{ auth()->user()->first_name ?? 'User' }}</span> <img
                                src="{{ asset('web/assets/img/dwn-aro.svg') }}" alt=""
                                class="img-fluid arraow_ig"></button>
                        <div id="myDropdown" class="dropdown-content">

                            <?php @$header_myplans = $Header_footers
                                ->where('type', 'header')
                                ->where('title_slug', 'my-plans')
                                ->first(); ?>
                            <?php @$header_myfamily = $Header_footers
                                ->where('type', 'header')
                                ->where('title_slug', 'my-family')
                                ->first(); ?>
                            <?php @$header_profile = $Header_footers
                                ->where('type', 'header')
                                ->where('title_slug', 'profile')
                                ->first(); ?>
                            <?php @$header_setting = $Header_footers
                                ->where('type', 'header')
                                ->where('title_slug', 'settings')
                                ->first(); ?>

                            @if ($header_myplans->status == '1')
                                <a href="{{ route($header_myplans->value) }}"
                                    style="width: max-content !important;">{{ $header_myplans->title }}</a>
                            @endif
                            @if ($header_myfamily->status == '1')
                                <a href="{{ route($header_myfamily->value) }}"
                                    style="width: max-content !important;">{{ $header_myfamily->title }}</a>
                            @endif
                            @if ($header_profile->status == '1')
                                <a href="{{ route($header_profile->value) }}">{{ $header_profile->title }}</a>
                            @endif
                            @if ($header_setting->status == '1')
                                <a href="{{ route($header_setting->value) }}">{{ $header_setting->title }}</a>
                            @endif

                            <!-- <a href="#!"onclick="logout()">Logout</a> -->
                            <a
                                href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
                        </div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                @endif
                <a class="profle-hd" href=""></a>
                <?php @$header_search = $Header_footers
                    ->where('type', 'header')
                    ->where('title_slug', 'search')
                    ->first(); ?>
                <?php @$header_notification = $Header_footers
                    ->where('type', 'header')
                    ->where('title_slug', 'notification')
                    ->first(); ?>
                <?php @$header_cart = $Header_footers
                    ->where('type', 'header')
                    ->where('title_slug', 'cart')
                    ->first(); ?>

                @if ($header_search->status == '1')
                    <a href="{{ route($header_search->value) }}" class="facebook">
                        <img src="{{ asset('web/assets/img/search.svg') }}" alt="" class="img-fluid">
                    </a>
                @endif
                @if ($header_notification->status == '1')
                    <a href="{{ route($header_notification->value) }}" class="twitter">
                        <img src="{{ asset('web/assets/img/notification1.svg') }}" alt="" class="img-fluid">
                    </a>
                @endif
                @if ($header_cart->status == '1')
                    <a href="{{ route($header_cart->value) }}" class="instagram">
                        <img src="{{ asset('web/assets/img/shopping-cart.svg') }}" alt=""class="img-fluid">
                    </a>
                @endif
            </div>
        </div>
    </header>
    <div id="loading">
        <div class="loader-gif-img">
            <img src="{{ asset('web/assets/img/loader.gif') }}" alt="">
        </div>
    </div>
    <!-- End Header -->
    @yield('content')
    <!-- model -->
    @php
        $freepackagedata = $freepackagedata ?? [];
        $is_usefreetrial = auth()->user()->is_complete_freetrial ?? '';
        $is_active_freetrial = auth()->user()->is_active_freetrial ?? '';
    @endphp
    @if ($freepackagedata && ($is_usefreetrial != '1' && $is_active_freetrial != '1'))
        <div class="modal fade" id="freetiralmodel" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog freetrial-popup" role="document">
                <div class="modal-content" style="border-radius: 2.3rem !important;">
                    <!-- <div class="modal-content" onclick="freetrial()" style="border-radius: 2.3rem !important;"> -->
                    <div class="trail_sec">
                        <span style="color:white;position: absolute;top: 10px;right: 19px;cursor:pointer;">
                            <i class="fa fa-times" onclick="closeModal();"></i>
                        </span>
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <div class="start_pages" style="border-right: 0px solid #30323E !important;">
                                    <img style="height: auto;" src="{{ asset('web/assets/img/start_up.png') }}">
                                    <h5>{{ $freepackagedata->title }}<br> <img style="height:20px;"
                                            src="{{ asset('web/assets/img/rs.svg') }}"> {{ $freepackagedata->price }}
                                        <span style="font-size: 22px;font-weight: 400;"> /
                                            {{ $freepackagedata->duration_type }}</span>
                                    </h5>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="consultation" style="border-left: 1px solid #30323E;">
                                    <a class="secure-payment" href="{{ route('free-trial') }}">
                                        {{ $freepackagedata->package_tag }} </a>
                                    <ul>
                                        @foreach ($freepackagedata->description as $key => $item)
                                            @if ($key < 3)
                                                <li><a href="#!"> <img style="height:20px;"
                                                            src="{{ asset('web/assets/img/meeting-point.svg') }}">
                                                        &nbsp;&nbsp;&nbsp; {{ $item }}</a></li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div style="text-align: center;" class="mt-2">
                            <a href="{{ route('free-trial') }}" style="color:#212121" data-toggle="modal"
                                data-target="#freetiralmodel"><button class="add_cart  freetrial-btn"
                                    style="margin-bottom: 0px !important;" onclick="freetrial()"> Read More
                                </button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- model -->
    <!-- ======= Footer ======= -->
    <footer id="footer">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 footer-links">
                        <ul>
                            <?php @$footers_about_us = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'about-us')
                                ->first(); ?>
                            <?php @$footers_contactus = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'contact-us')
                                ->first(); ?>
                            <?php @$footers_tnc = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'terms-of-service')
                                ->first(); ?>
                            <?php @$footers_privacy = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'privacy-policy')
                                ->first(); ?>
                            @if ($footers_about_us->status == '1')
                                <li><a
                                        href="{{ route($footers_about_us->value) }}">{{ $footers_about_us->title }}</a>
                                </li>
                            @endif
                            @if ($footers_contactus->status == '1')
                                <li><a
                                        href="{{ route($footers_contactus->value) }}">{{ $footers_contactus->title }}</a>
                                </li>
                            @endif
                            @if ($footers_tnc->status == '1')
                                <li><a href="{{ url($footers_tnc->value) }}"
                                        target="_blank">{{ $footers_tnc->title }}</a></li>
                            @endif
                            <?php $setting = $Setting->where('type', 'privacy_policy_content')->first(); ?>
                            @if ($footers_privacy->status == '1')
                                <li><a href="{{ url($footers_privacy->value) }}"
                                        target="_blank">{{ $footers_privacy->title }}</a></li>
                            @endif
                          
                            <li><a href="{{ url('refund-cancellation ') }}" target="_blank">Refund and cancellation policy</a>
                            </li>
                            <li><a href="{{ url('shipping-delivery') }}" target="_blank">Shipping and delivery policy</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-12 text-center">
                        <?php @$footers_logo = $Header_footers
                            ->where('type', 'footer')
                            ->where('title_slug', 'logo')
                            ->first(); ?>
                        @if ($footers_logo->status == '1')
                            <a href="#"><img src="{{ asset($footers_logo->value) }}" alt=""
                                    style="width:23% !important" class="img-fluid"></a>
                        @endif
                        <!-- <a class="mail-ft" href="mailto:support@sportylife.com">support@sportylife.com</a> -->
                    </div>
                    <div class="col-md-12">
                        <div class="social-links text-center text-md-right pt-3 pt-md-0">
                            <?php @$footers_facebook = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'facebook')
                                ->first(); ?>
                            <?php @$footers_instagram = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'instagram')
                                ->first(); ?>
                            <?php @$footers_linked_in = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'linked-in')
                                ->first(); ?>
                            <?php @$footers_youtube = $Header_footers
                                ->where('type', 'footer')
                                ->where('title_slug', 'youtube')
                                ->first(); ?>
                            @if ($footers_facebook->status == '1')
                                <a href="{{ $footers_facebook->value }}" target="_blank" class="facebook"><i
                                        class="fa fa-facebook"></i></a>
                            @endif
                            <!-- <a href="https://www.facebook.com/SportyLife-109159588213838" target="_blank" class="facebook"><i class="bx bxl-facebook"></i></a> -->
                            @if ($footers_instagram->status == '1')
                                <a href="{{ $footers_instagram->value }}" target="_blank" class="instagram"><i
                                        class="fa fa-instagram"></i></a>
                            @endif
                            @if ($footers_linked_in->status == '1')
                                <a href="{{ $footers_linked_in->value }}" target="_blank" class="linkedin"><i
                                        class="fa fa-linkedin"></i></a>
                            @endif
                            @if ($footers_youtube->status == '1')
                                <a href="{{ $footers_youtube->value }}" target="_blank" class="youtube"><i
                                        class="fa fa-youtube-play"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- End Footer -->
    <a class="back-to-top d-flex align-items-center justify-content-center"><i class="fa fa-arrow-up"></i></a>
    <!-- Vendor JS Files -->
    <script src="{{ asset('web/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ asset('web/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('web/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('web/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('web/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('web/assets/vendor/waypoints/noframework.waypoints.js') }}"></script>
    <script src="{{ asset('web/assets/vendor/php-email-form/validate.js') }}"></script>
    <!-- Template Main JS File -->
    <script src="{{ asset('web/assets/js/main.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.js"></script>
    <script>
        //loader
        function onReady(callback) {
            var intervalID = window.setInterval(checkReady, 1000);

            function checkReady() {
                if (document.getElementsByTagName('body')[0] !== undefined) {
                    window.clearInterval(intervalID);
                    callback.call(this);
                }
            }
        }

        function show(id, value) {
            document.getElementById(id).style.display = value ? 'block' : 'none';
        }

        function closeModal() {
            $("#freetiralmodel").modal("hide");
        }
        onReady(function() {
            show('loading', false);
        });
        //loader

        window.onpageshow = function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        };

        $('.back-to-top').click(function() {
            console.log("!23");
            // $('#bi-arrow-up-short').tooltip('hide');
            $('body,html').animate({
                scrollTop: 0
            }, 1);
            return false;
        });


        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script>
        $('#dob').datepicker({
            format: "dd-mm-yyyy",
            autoclose: true
        });

        $(document).ready(function() {
            $("#freetiralmodel").modal("show");
        });

        function emptyval() {
            $(".newuser").val('');
        }

        function freetrial() {
            window.location.href = "{{ route('free-trial') }}";
        }
    </script>
    <script type="text/javascript">
        $(document).on('click', '.ply-btn-video', function(e) {
            e.preventDefault();
            $(this).magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: true,
            }).magnificPopup('open');
        });
        $(document).on('click', '.ply-btn', function(e) {
            e.preventDefault();
            $(this).magnificPopup({
                type: 'image',
                closeOnContentClick: true,
                mainClass: 'mfp-img-mobile',
                image: {
                    verticalFit: true
                }
            }).magnificPopup('open');
        });
    </script>

    <script type="text/javascript">
        $('#myNavTabs a').click(function(evt) {
            evt.preventDefault();
            $(this).tab('show');
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            //new tab
            console.log(e.target);

            //previous tab
            console.log(e.relatedTarget);
        })
    </script>
    <script type="text/javascript">
        // Get the button, and when the user clicks on it, execute myFunction
        document.getElementById("myBtn").onclick = function() {
            myFunction();
        };

        /* myFunction toggles between adding and removing the show class, which is used to hide and show the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }
        $("#myBtn").click(function(e) {
            e.stopPropagation();
        });

        window.onclick = (e) => {
            if (document.getElementById("myDropdown").classList.length == 2) {
                myFunction();
            }
            // document.getElementById('#navbar').classList.toggle('navbar-mobile')
            // document.getElementsByClassName(".mobile-nav-toggle").classList.toggle('bi-list')
            // document.getElementsByClassName(".mobile-nav-toggle").classList.toggle('bi-x')
        }

        function mobilenav() {
            var element = document.getElementById("navbar");
            if (element.classList.contains("navbar-mobile") === false) {
                element.classList.remove("navbar-mobile");
            } else {
                element.classList.add("navbar-mobile");
            }
        }
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script type="text/javascript">
        @if ($errors->any())
            // {!! implode('', $errors->all('<div class="alert alert-warning" role="alert">:message</div>')) !!}
            @foreach ($errors->all() as $error)
                var abc = '<?php echo $error; ?>';
                console.log(abc);
                toastr.options = {
                    "progressBar": true
                }
                toastr.error(abc)
            @endforeach
        @endif
        @if (Session()->has('success'))
            toastr.options = {
                "progressBar": true
            }
            toastr.success('{{ Session('success') }}')
        @endif
        @if (Session()->has('info'))
            toastr.options = {
                "progressBar": true
            }
            toastr.info('{{ Session('info') }}')
        @endif
        @if (Session()->has('error'))
            toastr.options = {
                "progressBar": true
            }
            toastr.error('{{ Session('error') }}')
        @endif
        @if (Session()->has('warning'))
            toastr.options = {
                "progressBar": true
            }
            toastr.warning('{{ Session('warning') }}')
        @endif
    </script>
    <script>
        function logout() {
            $.ajax({
                url: "{{ url('api/logout') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    // 'password':password,
                },
                headers: {
                    "Authorization": "Bearer ",
                },
                success: function(data) {
                    console.log(data);
                    //destroysession
                    $.ajax({
                        url: "{{ url('/sessiondatadestroy') }}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            // 'data':data,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {}
                    });
                    //destroysession
                    if (data.statusCode == "200") {
                        toastr.success(data.message)
                        window.location.href = "{{ url('/login') }}";
                    } else {
                        toastr.error(data.message)
                    }
                },
                error: function(data) {
                    console.log(data.status);
                    //destroysession
                    $.ajax({
                        url: "{{ url('/sessiondatadestroy') }}",
                        type: 'post',
                        dataType: 'json',
                        data: {
                            // 'data':data,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {}
                    });
                    //destroysession
                    window.location.href = "{{ url('/login') }}";
                }
            });
        }
    </script>
    <!-- <script src="https://b2b.expertrons.com/expertronsEmbedVideoBot/aiBotParentScript.js" id="expertons_video_bot_root"
        data-main="Mbp-5e96330e8a278ejgge004394" data-content="62fe2afd549e31476914f03e"></script> -->
    @yield('script')
</body>

</html>
