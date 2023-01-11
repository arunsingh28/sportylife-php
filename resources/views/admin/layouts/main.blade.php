@inject('Roles', 'App\Models\Roles')
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="SportyLife">
    <meta name="author" content="SportyLife">
    <title>Sporty Life</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('web/assets/img/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">

    <!-- Page plugins -->
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('css/magnific-popup.css') }}">
    @yield('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 22px !important;
        }

        .select2-container--default .select2-selection--single {
            height: auto !important;
        }

    </style>
    <style>
        .navbar-vertical .navbar-nav .nav-link[data-toggle='collapse'][aria-expanded='true']:after {
            color: #ffffff !important;
        }

        .navbar-vertical.navbar-expand-xs .navbar-nav>.nav-item>.nav-link.active {
            height: 51px !important;
        }
        

    </style>
</head>

<body>
    <!-- Sidenav -->
    <nav class="sidenav navbar navbar-vertical  fixed-left  navbar-expand-xs navbar-light bg-white" id="sidenav-main">
        <div class="scrollbar-inner" style="background: #212121 !important;border-radius: 10px;">
            <!-- Brand -->
            <div class="sidenav-header  align-items-center">
                <a class="navbar-brand" href="javascript:void(0)">
                    <img src="{{ asset('web/assets/img/logo-new1.png') }}" class="navbar-brand-img" alt="Logo">
                    <!-- <h1 style="color:white !important">Sporty Life</h1> -->
                </a>
            </div>
            <div class="navbar-inner"> 

                <div class="collapse navbar-collapse" id="sidenav-collapse-main">
                    <?php @$roles_data = $Roles->where('id', auth()->user()->role_id)->first(); ?>
                    <ul class="navbar-nav">
                        @if(auth()->user()->role_id == "1" ) 
                         <li class="nav-item">
                             <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                 href="{{ route('dashboard') }}">
                                 <i class="fas fa-home text-white"></i>
                                 <span class="nav-link-text">Dashboard</span>
                             </a>
                         </li>
                        @endif
                        
                        <!-- @if(auth()->user()->role_id == "1")  -->
                        <!-- @endif -->
                        @if( auth()->user()->role_id != "4" && auth()->user()->role_id != "5" && $roles_data->type != "new")  
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users') || request()->routeIs('user-edit') || request()->routeIs('user-view') ? 'active' : '' }}"
                                href="{{ route('users') }}">
                                <i class="fas fa-users text-white"></i>
                                <span class="nav-link-text">Users</span>
                            </a>
                        </li>
                         @endif 
                        <!-- @if(auth()->user()->role_id == "1")  -->
                        <!-- @endif -->
                        @if( auth()->user()->role_id != "3" && $roles_data->type != "new")  
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('roles') || request()->routeIs('role-add') || request()->routeIs('role-edit') ? 'active' : '' }}"
                                href="#role" data-toggle="collapse"
                                aria-expanded="{{ request()->routeIs('roles') || request()->routeIs('role-add') || request()->routeIs('role-edit') ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <i class="fas fa-users text-white"></i>
                                <span class="nav-link-text">Roles</span>
                            </a>
                            <ul class="navbar-nav list-unstyled collapse {{ request()->routeIs('roles') || request()->routeIs('role-add')  || request()->routeIs('role-edit') ? 'show' : '' }}"
                                id="role">
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('roles') || request()->routeIs('role-edit') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('roles') }}">
                                        <span class="nav-link-text">List</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('role-add') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('role-add') }}">
                                        <span class="nav-link-text">Add</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif

                         @if(auth()->user()->role_id != "10" && auth()->user()->role_id != "3"&& auth()->user()->role_id != "4"&& auth()->user()->role_id != "5" && $roles_data->type != "new")  
                         
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('role-base-user') || request()->routeIs('role-base-user-*') ? 'active' : '' }}"
                                href="#rolebase" data-toggle="collapse"
                                aria-expanded="{{ request()->routeIs('role-base-user') || request()->routeIs('role-base-user-*') ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <i class="fas fa-users text-white"></i>
                                <span class="nav-link-text">Sub Admins</span>
                            </a>
                            <ul class="navbar-nav list-unstyled collapse {{ request()->routeIs('role-base-user') || request()->routeIs('role-base-user-*') ? 'show' : '' }}"
                                id="rolebase">
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('role-base-user') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('role-base-user') }}">
                                        <span class="nav-link-text">List</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('role-base-user-add') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('role-base-user-add') }}">
                                        <span class="nav-link-text">Add</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif 
                        @if( auth()->user()->role_id != "3")  
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('news-feed') || request()->routeIs('news-feed-*') ? 'active' : '' }}"
                                href="#newsfeed" data-toggle="collapse"
                                aria-expanded="{{ request()->routeIs('news-feed') || request()->routeIs('news-feed-*') ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <i class="fas fa-newspaper text-white"></i>
                                <span class="nav-link-text">News Feed</span>
                            </a>
                            <ul class="navbar-nav list-unstyled collapse {{ request()->routeIs('news-feed') || request()->routeIs('news-feed-*') ? 'show' : '' }}"
                                id="newsfeed">
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('news-feed') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('news-feed') }}">
                                        <span class="nav-link-text">List</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('news-feed-add') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('news-feed-add') }}">
                                        <span class="nav-link-text">Add</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif 
                        @if(auth()->user()->role_id != "5" && auth()->user()->role_id != "3" && $roles_data->type != "new")
                        

                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('service-categories') || request()->routeIs('service-categories-*') || request()->routeIs('service-packages') || request()->routeIs('service-packages-*')|| request()->routeIs('service-packages-ios') || request()->routeIs('service-packages-ios-*') ? 'active' : '' }}"
                                href="#service" data-toggle="collapse"
                                aria-expanded="{{ request()->routeIs('service-categories') || request()->routeIs('service-categories-*') || request()->routeIs('service-packages') || request()->routeIs('service-packages-*') ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <i class="fas fa-home text-white"></i>
                                <span class="nav-link-text">Packages</span>
                            </a>
                            <ul class="navbar-nav list-unstyled collapse {{ request()->routeIs('service-categories') || request()->routeIs('service-categories-*') || request()->routeIs('service-packages') || request()->routeIs('service-packages-ios') || request()->routeIs('service-packages-*')|| request()->routeIs('service-packages-ios-*') ? 'show' : '' }}"
                                id="service">
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('service-categories') || request()->routeIs('service-categories-*') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('service-categories') }}">
                                        <span class="nav-link-text">Categories</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('service-packages') || request()->routeIs('service-packages-add') || request()->routeIs('service-packages-edit') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('service-packages') }}">
                                        <span class="nav-link-text">Packages</span>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('service-packages-ios') || request()->routeIs('service-packages-ios-*') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('service-packages-ios') }}">
                                        <span class="nav-link-text">IOS Packages</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif 
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3"|| auth()->user()->role_id == "10" || $roles_data->type == "new")
                        <li class="nav-item">
                            <a class="nav-link collapsed {{ request()->routeIs('nutrition-diet') || request()->routeIs('nutrition-diet-*') || request()->routeIs('meals') || request()->routeIs('meals-*') || request()->routeIs('nutri-diet-frequency') || request()->routeIs('nutri-diet-frequency-*') || request()->routeIs('nutri-recipe-categories') || request()->routeIs('nutri-recipe-categories-*') || request()->routeIs('nutrition-recipes') || request()->routeIs('nutrition-recipe-*') || request()->routeIs('nutrition-blogs') || request()->routeIs('nutrition-blog-*') ? 'active' : '' }}"
                                href="#nutrition" data-toggle="collapse"
                                aria-expanded="{{ request()->routeIs('nutrition-diet') || request()->routeIs('nutrition-diet-*') || request()->routeIs('meals') || request()->routeIs('meals-*') || request()->routeIs('nutri-diet-frequency') || request()->routeIs('nutri-diet-frequency-*') || request()->routeIs('nutri-recipe-categories') || request()->routeIs('nutri-recipe-categories-*') || request()->routeIs('nutrition-recipes') || request()->routeIs('nutrition-recipe-*') || request()->routeIs('nutrition-blogs') || request()->routeIs('nutrition-blog-*') ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <i class="fas fa-home text-white"></i>
                                <span class="nav-link-text">Nutrition</span>
                            </a>
                            <ul class="navbar-nav list-unstyled collapse {{ request()->routeIs('nutrition-diet') || request()->routeIs('nutrition-diet-*') || request()->routeIs('meals') || request()->routeIs('meals-*') || request()->routeIs('nutri-diet-frequency') || request()->routeIs('nutri-diet-frequency-*') || request()->routeIs('nutri-recipe-categories') || request()->routeIs('nutri-recipe-categories-*') || request()->routeIs('nutrition-recipes') || request()->routeIs('nutrition-recipe-*') || request()->routeIs('nutrition-blogs') || request()->routeIs('nutrition-blog-*') ? 'show' : '' }}"
                                id="nutrition">
                                
                                @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3"|| auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('nutri-diet-frequency') || request()->routeIs('nutri-diet-frequency-add') || request()->routeIs('nutri-diet-frequency-edit') || request()->routeIs('nutri-diet-frequency-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('nutri-diet-frequency') }}">
                                        <span class="nav-link-text">Nutrition Diet Frequency</span>
                                    </a>
                                </li>
                                @endif
                                @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                                <li class="nav-item">
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('meals') || request()->routeIs('meals-add') || request()->routeIs('meals-edit') || request()->routeIs('meals-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('meals') }}">
                                        <span class="nav-link-text">Meals</span>
                                    </a>
                                </li>
                                 @endif
                                    @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3"|| auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                                    <li class="nav-item">
                                        <a class="nav-link ml-5"
                                            style="{{ request()->routeIs('nutrition-diet') || request()->routeIs('nutrition-diet-add') || request()->routeIs('nutrition-diet-edit') || request()->routeIs('nutrition-diet-view') ? 'color: #e84434 !important;' : '' }}"
                                            href="{{ route('nutrition-diet') }}">
                                            <span class="nav-link-text">User Diet Chart</span>
                                        </a>
                                    </li>
                                    @endif
                                     @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('nutri-recipe-categories') || request()->routeIs('nutri-recipe-categories-add') || request()->routeIs('nutri-recipe-categories-edit') || request()->routeIs('nutri-recipe-categories-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('nutri-recipe-categories') }}">
                                        <span class="nav-link-text">Nutrition Recipe Categories</span>
                                    </a>
                                </li>
                                
                                <li class="nav-item">
                                    <a class="nav-link ml-5"
                                        style="{{ request()->routeIs('ingredients') || request()->routeIs('ingredients-add') || request()->routeIs('ingredients-edit') || request()->routeIs('ingredients-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('ingredients') }}">
                                        <span class="nav-link-text">Ingredients</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('nutrition-recipes') || request()->routeIs('nutrition-recipe-add') || request()->routeIs('nutrition-recipe-edit') || request()->routeIs('nutrition-recipe-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('nutrition-recipes') }}">
                                        <span class="nav-link-text">Nutrition Recipes</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('nutrition-blogs') || request()->routeIs('nutrition-blog-add') || request()->routeIs('nutrition-blog-edit') || request()->routeIs('nutrition-blog-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('nutrition-blogs') }}">
                                        <span class="nav-link-text">Nutrition Blogs</span>
                                    </a>
                                </li>
                                @endif
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                        <li class="nav-item">
                            <a class="nav-link collapsed {{ request()->routeIs('about-us') ||request()->routeIs('invite-history') || request()->routeIs('faq-category') || request()->routeIs('faq-category-*') || request()->routeIs('settings') || request()->routeIs('setting-*') || request()->routeIs('sliders') || request()->routeIs('slider-*') || request()->routeIs('home-category') || request()->routeIs('home-category-*') || request()->routeIs('nutrition-quote') || request()->routeIs('nutrition-quote-*') || request()->routeIs('faqs') || request()->routeIs('faq-*') ? 'active' : '' }}"
                                href="#settings" data-toggle="collapse"
                                aria-expanded="{{ request()->routeIs('invite-history') || request()->routeIs('faq-category') || request()->routeIs('faq-category-*') || request()->routeIs('settings') || request()->routeIs('setting-*') || request()->routeIs('sliders') || request()->routeIs('slider-*') || request()->routeIs('home-category') || request()->routeIs('home-category-*') || request()->routeIs('nutrition-quote') || request()->routeIs('nutrition-quote-*') || request()->routeIs('faqs') || request()->routeIs('faq-*') ? 'true' : 'false' }}"
                                class="dropdown-toggle">
                                <i class="fas fa-cog text-white"></i>
                                <span class="nav-link-text">Settings</span>
                            </a>
                            <ul class="navbar-nav list-unstyled collapse {{ request()->routeIs('about-us') ||request()->routeIs('invite-history') || request()->routeIs('faq-category') || request()->routeIs('faq-category-*') || request()->routeIs('settings') || request()->routeIs('setting-*') || request()->routeIs('sliders') || request()->routeIs('slider-*') || request()->routeIs('home-category') || request()->routeIs('home-category-*') || request()->routeIs('nutrition-quote') || request()->routeIs('nutrition-quote-*') || request()->routeIs('faqs') || request()->routeIs('faq-*') ? 'show' : '' }}"
                                id="settings">
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('header-footer')  || request()->routeIs('header-footer-edit') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('header-footer') }}">
                                        <span class="nav-link-text">Header & Footer</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('nutrition-quote') || request()->routeIs('nutrition-quote-add') || request()->routeIs('nutrition-quote-edit') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('nutrition-quote') }}">
                                        <span class="nav-link-text">Nutrition Quote</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('home-category') || request()->routeIs('home-category-edit') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('home-category') }}">
                                        <span class="nav-link-text">Home Category</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('sliders') || request()->routeIs('slider-add') || request()->routeIs('slider-edit') || request()->routeIs('slider-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('sliders') }}">
                                        <span class="nav-link-text">Sliders</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('faqs') || request()->routeIs('faq-add') || request()->routeIs('faq-edit') || request()->routeIs('faq-view') || request()->routeIs('faq-category') || request()->routeIs('faq-category-add') || request()->routeIs('faq-category-edit') || request()->routeIs('faq-category-view') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('faqs') }}">
                                        <span class="nav-link-text">FAQ</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('settings') || request()->routeIs('setting-edit') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('settings') }}">
                                        <span class="nav-link-text">Settings</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('invite-history') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('invite-history') }}">
                                        <span class="nav-link-text">Invite History</span>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link ml-5 "
                                        style="{{ request()->routeIs('about-us') ? 'color: #e84434 !important;' : '' }}"
                                        href="{{ route('about-us') }}">
                                        <span class="nav-link-text">About us</span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "5" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('workoutvideos') || request()->routeIs('workout-video-add') || request()->routeIs('workout-video-edit') || request()->routeIs('workout-category') || request()->routeIs('workout-category-add') || request()->routeIs('workout-category-edit') ? 'active' : '' }}"
                                href="{{ route('workoutvideos') }}">
                                <i class="fas fa-cog text-white"></i>
                                <span class="nav-link-text">Workout Video</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('live-videos') || request()->routeIs('live-video-add') || request()->routeIs('live-video-edit') ? 'active' : '' }}"
                                href="{{ route('live-videos') }}">
                                <i class="fas fa-cog text-white"></i>
                                <span class="nav-link-text">Live Sessions</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "10" || $roles_data->type != "new") 
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('sports-curriculum') || request()->routeIs('sports-curriculum-add') || request()->routeIs('sports-curriculum-edit') ? 'active' : '' }}"
                                href="{{ route('sports-curriculum') }}">
                                <i class="fas fa-cog text-white"></i>
                                <span class="nav-link-text">Sports Curriculum (Trial Pack)</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3" || auth()->user()->role_id == "10" || $roles_data->type != "new") 
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('users-frc') || request()->routeIs('users-frc-view') ? 'active' : '' }}"
                                href="{{ route('users-frc') }}">
                                <i class="fas fa-cog text-white"></i>
                                <span class="nav-link-text">FRC</span>
                            </a>
                        </li>
                        @endif
                        <!-- <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('live-videos') || request()->routeIs('live-video-add') || request()->routeIs('live-video-edit') ? 'active' : '' }}"
                           href="{{ route('live-videos') }}">
                            <i class="fas fa-cog text-white"></i>
                            <span class="nav-link-text">Live Videos</span>
                        </a>
                    </li> -->
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "4" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('contact-us') || request()->routeIs('contact-us-reply') || request()->routeIs('contact-us-view') ? 'active' : '' }}"
                                href="{{ route('contact-us') }}">
                                <i class="fas fa-file-csv text-white"></i>
                                <span class="nav-link-text">Contact Us</span>
                            </a>
                        </li>
                        @endif
                        @if(auth()->user()->role_id == "1" || auth()->user()->role_id == "3" || auth()->user()->role_id == "10" || $roles_data->type == "new") 
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('notifications') ? 'active' : '' }}"
                                href="{{ route('notifications') }}">
                                <i class="fas fa-bell text-white"></i>
                                <span class="nav-link-text">Notifications</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="main-content" id="panel">
        <!-- Topnav -->
        <nav class="navbar navbar-top navbar-expand navbar-dark bg-primary border-bottom"
            style="background: linear-gradient(87deg, #EF4232, #212121 100%) !important;border-radius: 10px;">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Search form -->
                    <!-- <form class="navbar-search navbar-search-light form-inline mr-sm-3" id="navbar-search-main">
                   <div class="form-group mb-0">
                     <div class="input-group input-group-alternative input-group-merge">
                       <div class="input-group-prepend">
                         <span class="input-group-text"><i class="fas fa-search"></i></span>
                       </div>
                       <input class="form-control" placeholder="Search" type="text">
                     </div>
                   </div>
                   <button type="button" class="close" data-action="search-close" data-target="#navbar-search-main" aria-label="Close">
                     <span aria-hidden="true">×</span>
                   </button>
                   </form> -->
                    <!-- Navbar links -->
                    <ul class="navbar-nav align-items-center ml-sm-auto ">
                        {{-- <li class="nav-item d-xl-none">
                        <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                             data-target="#sidenav-main">
                            <div class="sidenav-toggler-inner">
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                                <i class="sidenav-toggler-line"></i>
                            </div>
                        </div>
                    </li> --}}
                    </ul>
                    <ul class="navbar-nav align-items-center  ml-auto ml-md-0 ">
                        <li class="nav-item d-xl-none">
                            <div class="pr-3 sidenav-toggler sidenav-toggler-dark" data-action="sidenav-pin"
                                data-target="#sidenav-main">
                                <div class="sidenav-toggler-inner">
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                    <i class="sidenav-toggler-line"></i>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <div class="media align-items-center">
                                    <span class="avatar avatar-sm rounded-circle">
                                        <img alt="" src="{{ asset(auth()->user()->image ?? 'img/default-user.png') }}">
                                    </span>
                                    <div class="media-body  ml-2  d-none d-lg-block">
                                        <span class="mb-0 text-sm  font-weight-bold"
                                            style="color: aliceblue;">{{ auth()->user()->name }}</span>
                                    </div>
                                </div>
                            </a>
                            <div class="dropdown-menu  dropdown-menu-right ">
                                <div class="dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome!</h6>
                                </div>
                                <!-- <a href="#!" class="dropdown-item">
                            <i class="ni ni-single-02"></i>
                            <span>My profile</span>
                            </a> -->
                                <!-- <div class="dropdown-divider"></div> -->
                                <a class="dropdown-item" href="{{ route('admin.change-password') }}">
                                    <i class="ni ni-key-25"></i>
                                    <span>Profile Update</span>
                                </a>
                                <a href="#!" class="dropdown-item" href="{{ route('admin.logout') }}"
                                    onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                    <i class="ni ni-user-run"></i>
                                    <span>Logout</span>
                                </a>
                                
                                <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                    class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Header -->
        <!-- Header -->
        <div class="header bg-primary pb-6"
            style="background: linear-gradient(87deg, #EF4232, #212121 100%) !important;border-radius: 10px;">
            <div class="container-fluid">
                <div class="header-body">
                    <div class="row align-items-center py-4">
                        <div class="col-lg-6 col-7">
                            <!-- <h6 class="h2 text-white d-inline-block mb-0">@yield('breadcrumb')</h6> -->
                            <nav aria-label="breadcrumb" class="d-none d-md-inline-block md-4">
                                <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}"
                                            class="colorblack"><i class="fas fa-home"></i></a></li>
                                    <li class="breadcrumb-item active"><a href="#!"
                                            class="colorblack">@yield('breadcrumb')</a></li>
                                    <!-- <li class="breadcrumb-item active" aria-current="page">Default</li> -->
                                </ol>
                            </nav>
                        </div>
                    </div>
                    @yield('dashboarddata')
                </div>
            </div>
        </div>
        <div class="container-fluid mt--6">
            @yield('content')
            <footer class="footer pt-0">
                <div class="row align-items-center justify-content-lg-between">
                    <div class="col-lg-6">
                        <div class="copyright text-center  text-lg-left  text-muted">
                            &copy; 2021 <a href="#!" class="font-weight-bold ml-1 colorblack">Sporty Life</a>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                            © 2021, made by<a href="https://jploft.com/" style="color:#EF4232 !important"
                                class="nav-link" target="_blank"> JPLoft Solutions PVT LTD.</a>
                            <li class="nav-item">
                            </li>
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-65HFMEEWGZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-65HFMEEWGZ');
    </script>
    <script src="{{ asset('admin/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <!-- Optional JS -->
    <script src="{{ asset('admin/assets/vendor/chart.js/dist/Chart.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/chart.js/dist/Chart.extension.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('admin/assets/js/argon.js?v=1.2.0') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.17.1/full/ckeditor.js"></script>
    <script src="{{ asset('admin/assets/js/custom.js') }}"></script>
    <script src="{{ asset('js/jquery.magnific-popup.min.js') }}"></script>
    <script type="text/javascript">
        let digitValidate = function(ele) {
            ele.value = ele.value.replace(/[^0-9]/g, '');
        }
        $(document).on('click', '.ply-btn-video', function(e) {
            e.preventDefault();
            $(this).magnificPopup({
                disableOn: 700,
                type: 'iframe',
                mainClass: 'mfp-fade',
                removalDelay: 160,
                preloader: false,
                fixedContentPos: false
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
    @php
        $mymeals = '';
        $mycatedata = '';
        $meals = $meals ?? [];
        $catedata = $catedata ?? [];
    @endphp
    @if ($meals)
        @foreach ($meals as $meal)
            @php
                $mymeals .= '<option value="' . $meal->id . '">' . $meal->title . '</option>';
            @endphp
        @endforeach
    @endif
    @if ($catedata)
        @foreach ($catedata as $cat)
            @php
                $mycatedata .= '<option value="' . $cat->id . '">' . $cat->title . '</option>';
            @endphp
        @endforeach
    @endif
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });
    </script>
    <script type="text/javascript">
        //addmoreingredient
        $(document).on('click', '#addmoreingredient', function() {
            var i = $('#id_value').val();
            i++;
            var data = '<tr><td><div class="form-group">' +
                '<select name="store[' + i +
                '][name]" style="width: -webkit-fill-available;" class="form-control-sm js-example-basic-single" placeholder="Name" required>' +
                '<option value="">-- Select a Ingredients --</option>' +
                '<?php echo $mymeals ?? ''; ?>' +
                '</select></div></td><td><div class="form-group"><input type="text" name="store[' + i +
                '][quantity]" style="width: -webkit-fill-available;"  class="form-control-sm" placeholder="Quantity" required></div></td><td><button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button></td></tr>';

            // var data = '<tr><td><div class="form-group">' +
            // '<input type="text" name="store[' + i + '][name]" style="width: -webkit-fill-available;"  class="form-control-sm" placeholder="Name" required></div></td><td><div class="form-group"><input type="text" name="store[' + i + '][quantity]" style="width: -webkit-fill-available;"  class="form-control-sm" placeholder="Quantity" required></div></td><td><button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button></td></tr>';
            $('#id_value').val(i);
            $('#addmoreingredientsection').append(data);
            $('.js-example-basic-single').select2();
        });

        $(document).on('click', '#addmorediet', function() {
            var i = $('#id_value').val();
            i++;
            var data = '<tr><td><div class="form-group">' +
                '<select name="store[' + i + '][frequency_id]" id="frequency_id' + i + '" onchange="getMeal(' + i +
                ')"  style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Name" required>' +
                '<option value="">--- Select a Frequency ---</option>' +
                '<?php echo $mycatedata ?? ''; ?>' +
                '</select></div></td><td><div class="form-group">' +
                '<select name="store[' + i + '][meal]" id="meal' + i +
                '" style="width: -webkit-fill-available;" class="form-control-sm" placeholder="Name" required>' +
                '<option value="">--- Select a Meal ---</option>' +

                '</select></div></td><td><div class="form-group"><input type="text" name="store[' + i +
                '][quantity]" style="width: -webkit-fill-available;"  oninput="digitValidate(this)" class="form-control-sm" placeholder="Quantity" required></div></td><td><button type="button" class="btn btn-sm btn-danger removeingredient">Remove</button></td></tr>';
            $('#id_value').val(i);
            $('#addmoredietsection').append(data);
            let digitValidate = function(ele) {
                ele.value = ele.value.replace(/[^0-9]/g, '');
            }
        });

        function getMeal(id) {
            var frq_id = $('#frequency_id' + id).val();
            $.ajax({
                url: '{{ url('admin/getMeal') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    frq_id: frq_id
                },
                success: function(data) {
                    $('#meal' + id).html(data);
                }
            });
        }

        $(document).on('change', 'select[id="recipes_meals"]', function() {
            var id = parseInt($(this).val());
            $.ajax({
                url: '{{ url('admin/getrecipeMeal') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(res) {
                    $('#title').empty();
                    $('#calorie').empty();
                    $('#protein').empty();
                    $('#carbs').empty();
                    $('#fats').empty();
                    $('#title').val(res.data.title);
                    $('#calorie').val(res.data.calorie);
                    $('#protein').val(res.data.protein);
                    $('#carbs').val(res.data.carbs);
                    $('#fats').val(res.data.fats);
                }
            });
        });

        $(document).on('change', 'select[id="recipe_detail_id"]', function() {
            var id = parseInt($(this).val());
            $.ajax({
                url: '{{ url('admin/getrecipeDetails') }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id
                },
                success: function(res) {
                    $('#title').empty();
                    $('#calorie').empty();
                    $('#protein').empty();
                    $('#carbs').empty();
                    $('#fats').empty();
                    $('#title').val(res.data.title);
                    $('#calorie').val(res.data.calorie);
                    $('#protein').val(res.data.protein);
                    $('#carbs').val(res.data.carbs);
                    $('#fats').val(res.data.fats);
                    //  $('#fats').val(res.data.fats.replace(/[^\d.-]/g, ''));
                }
            });
        });

        //ckeditor
        CKEDITOR.replace('editor1');
        CKEDITOR.replace('editor2');
        //ckeditor
        //datatable
        $(document).ready(function() {
            $('#myTable').DataTable({
                // "lengthMenu": [1, 10, 25, 50, 100],
                // "pageLength": 1
            });
        });
        $(document).ready(function() {
            $('#myTable1').DataTable({
                // "lengthMenu": [1, 10, 25, 50, 100],
                // "pageLength": 1
            });
        });
        //datatable
        //message
        @if (Session()->has('success'))
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-left",
            }
            toastr.success('{{ Session('success') }}')
        @endif
        @if (Session()->has('info'))
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-left",
            }
            toastr.info('{{ Session('info') }}')
        @endif
        @if (Session()->has('error'))
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-left",
            }
            toastr.error('{{ Session('error') }}')
        @endif
        @if (Session()->has('warning'))
            toastr.options = {
                "progressBar": true,
                "positionClass": "toast-bottom-left",
            }
            toastr.warning('{{ Session('warning') }}')
        @endif
        //message
    </script>
    @yield('script')
</body>

</html>
