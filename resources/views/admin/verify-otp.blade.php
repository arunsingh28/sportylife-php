<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Start your development with a Dashboard for Bootstrap 4.">
    <meta name="author" content="Creative Tim">
    <title>Sporty Life - OTP</title>
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('web/assets/img/favicon.png') }}" type="image/png">
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700">
    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/nucleo/css/nucleo.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/@fortawesome/fontawesome-free/css/all.min.css') }}"
        type="text/css">
    <!-- Argon CSS -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/argon.css?v=1.2.0') }}" type="text/css">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <style>
        .fill-default {
            fill: #212121 !important;
        }

        .bg-gradient-dark {
            background: linear-gradient(87deg, #ef4234 0, #212229 100%) !important;
        }

        .bg-default {
            background-color: #212121 !important;
        }

        .footer-auto-bottom {
            position: relative !important;
        }
    </style>
</head>

<body class="bg-default">
    <!-- Navbar -->
    <nav id="navbar-main" class="navbar navbar-horizontal navbar-transparent navbar-main navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand">
                <!-- <img src="{{ asset('uploads/images/finallogo.png') }}"> -->
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse"
                aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="navbar-collapse navbar-custom-collapse collapse" id="navbar-collapse">
                <div class="navbar-collapse-header">
                    <div class="row">
                        <div class="col-6 collapse-brand">
                            <a href="dashboard.html">
                                <img src="{{ asset('uploads/images/finallogo.png') }}">
                            </a>
                        </div>
                        <div class="col-6 collapse-close">
                            <button type="button" class="navbar-toggler" data-toggle="collapse"
                                data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false"
                                aria-label="Toggle navigation">
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                    </div>
                </div>
                <hr class="d-lg-none" />
            </div>
        </div>
    </nav>
    <!-- Main content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header bg-gradient-dark py-7 py-lg-8 pt-lg-9">
            <div class="container">
                <div class="header-body text-center mb-3">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 px-5">
                            <!-- <h1 class="text-white">Welcome!</h1> -->
                            <!-- <img src="{{ asset('uploads/images/finallogo.png') }}" height="100"> -->
                            <!-- <p class="text-lead text-white">Use these awesome forms to login or create new account in your project for free.</p> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="separator separator-bottom separator-skew zindex-100">
                <svg x="0" y="0" viewBox="0 0 2560 100" preserveAspectRatio="none" version="1.1"
                    xmlns="http://www.w3.org/2000/svg">
                    <polygon class="fill-default" points="2560 0 2560 100 0 100"></polygon>
                </svg>
            </div>
        </div>
        <!-- Page content -->
        <div class="container " style="margin-top:-15rem !important">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-7">
                    <div class="card bg-secondary border-0 mb-0">
                        <div class="card-body px-lg-5">
                            <div class="text-center text-muted">
                                <img src="{{ asset('uploads/images/finallogo.png') }}" height="100">

                                <h4 style="color: #172B4D" class="mt-n-2">OTP</h4>
                            </div>
                            <div class="text-center text-muted mb-4">
                                <small>Verify OTP</small>
                            </div>
                            <form role="form" method="POST" action="{{ route('admin.verify-otp') }}">
                                @csrf
                                <input type="hidden" name="id" value="1">
                                <input type="hidden" name="email" value="{{ $email }}">
                                <input type="hidden" name="password" value="{{ $password }}">
                                <div class="form-group mb-3">
                                    <div class="input-group input-group-merge input-group-alternative">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="ni ni-key-25"></i></span>
                                        </div>
                                        <input type="text" oninput='digitValidate(this)' maxlength="6"
                                            class="form-control" name="otp" placeholder="Enter OTP" required>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-default my-4">Verify</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Footer -->
    <footer id="footer-main">
        <div class="container">
            <div class="row align-items-center justify-content-xl-between">
                <div class="col-xl-12 ">
                    <div class="copyright text-center text-muted mb-2">
                        &copy; 2021 <a href="#!" class="font-weight-bold ml-1">Sporty Life</a>
                    </div>
                </div>
                <!-- <div class="col-xl-6">
               <ul class="nav nav-footer justify-content-center justify-content-xl-end">
                 <li class="nav-item">
                   <a href="#!" class="nav-link">Sporty Life</a>
                 </li>
               </ul>
               </div> -->
            </div>
        </div>
    </footer>
    <!-- Argon Scripts -->
    <!-- Core -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-65HFMEEWGZ"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-65HFMEEWGZ');
    </script>
    <script src="{{ asset('admin/assets/vendor/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/js-cookie/js.cookie.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery.scrollbar/jquery.scrollbar.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendor/jquery-scroll-lock/dist/jquery-scrollLock.min.js') }}"></script>
    <!-- Argon JS -->
    <script src="{{ asset('admin/assets/js/argon.js?v=1.2.0') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
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
        let digitValidate = function(ele) {
            ele.value = ele.value.replace(/[^0-9]/g, '');
        }
    </script>
</body>

</html>
