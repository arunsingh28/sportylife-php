@extends('layouts.main')
@section('style')
    <style type="text/css">
        .validation-sapn {
            color: red;
            /* float: left; */
            margin-bottom: 10px;
            margin-top: 5px;
        }
    </style>
@endsection
@section('content')
    <main id="main">
        <section class="login update_pages" style="height: auto;">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-2 col-md-12 p-0 text-end">
                        <!-- <div class="mbl-img">
                        <img src="assets/img/mobile-img.png" class="img-fluid" alt="">
                        </div> -->
                    </div>
                    <div class="col-lg-8 col-md-12 text-center logn-rght mt-5"
                        style="height: auto;background: transparent;">
                        <div class="sign_up">
                            <form role="form" method="POST" action="{{ route('profile-edit') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <h3>Profile</h3>
                                <div class="avatar-upload">
                                    <div class="avatar-edit">
                                        <input type='file' id="imageUpload" name="image" accept=".png, .jpg, .jpeg" />
                                        <label for="imageUpload"></label>
                                    </div>
                                    <div class="avatar-preview">
                                        <div id="imagePreview" style="background-image: url({{ asset($user->image) }});">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <input type="hidden" name="page_type" class="form-control" value="{{ $type }}">
                                    <h6 class="hgt_sec">First Name <span class="validation-sapn">* </span></h6>
                                    <input id="name" type="text" name="first_name" class="form-control"
                                        value="{{ $user->first_name }}" placeholder="First Name" required="required">
                                    {{-- <span class="validation-sapn">* First Name </span> --}}
                                </div>
                                <div class="form-group">
                                    <h6 class="hgt_sec">Last Name <span class="validation-sapn">* </span></h6>
                                    <input id="name" type="text" name="last_name" class="form-control"
                                        value="{{ $user->last_name }}" placeholder="Last Name" required="required">
                                    {{-- <span class="validation-sapn">* Last Name </span>                      --}}
                                </div>
                                <div class="form-group">
                                    <h6 class="hgt_sec">E-mail</h6>
                                    <input id="name" type="email" name="email" class="form-control"
                                        value="{{ $user->email }}" placeholder="Email ID" readonly>
                                </div>
                                <div class="form-group">
                                    <h6 class="hgt_sec">Country Code <span class="validation-sapn">* </span></h6>
                                    <select class="one mb-0 mt-0 js-example-basic-single" name="country_code"
                                        value="{{ old('country_code') }}" id="country_code">
                                        <option selected="selected" value=""> Select Country </option>
                                        @foreach ($phonecode_data as $item)
                                            <option value="{{ $item->phone_code }}" <?php if ($item->phone_code == $user->country_code) {
                                                echo 'selected';
                                            } ?>>
                                                {{ $item->country_name }} ({{ $item->phone_code }})</option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="validation-sapn">* Country Code </span>                      --}}
                                </div>

                                <div class="form-group">
                                    <h6 class="hgt_sec">Mobile</h6>
                                    <input id="name" type="text" name="phone" class="form-control"
                                        value="{{ $user->phone }}" placeholder="Phone" readonly>
                                </div>
                                <div class="form-group">
                                    <h6 class="hgt_sec">DOB <span class="validation-sapn">* </span></h6>
                                    <input id="dob" type="text" autocomplete="off" onchange="getUserAge()"
                                        name="dob" class="form-control"
                                        value="{{ date('d-m-Y', strtotime($user->dob)) }}" placeholder="dd-mm-yyyy"
                                        required="required">
                                    <p style="color:white;text-align: left;" class="mt-1 mb-0" id="ageText"></p>
                                    {{-- <span class="validation-sapn">* DOB </span>      --}}
                                </div>
                                <div class="form-group">
                                    <div class="parent">
                                        <h6 class="hgt_sec">Gender <span class="validation-sapn">* </span></h6>
                                        <label class="child <?php if ($user->gender == 'male') {
                                            echo 'bak';
                                        } ?>" for="male">
                                            <img src="{{ asset('web/assets/img/toilet.svg') }}">
                                            Male
                                        </label>
                                        <input style="display:none;" type="radio" id="male" name="gender"
                                            value="male" <?php if ($user->gender == 'male') {
                                                echo 'checked';
                                            } ?>>
                                        <label class="child <?php if ($user->gender == 'female') {
                                            echo 'bak';
                                        } ?>" for="female">
                                            <img src="{{ asset('web/assets/img/female.svg') }}">
                                            Female
                                        </label>
                                        <input style="display:none;" type="radio" id="female" name="gender"
                                            value="female" <?php if ($user->gender == 'female') {
                                                echo 'checked';
                                            } ?>>
                                        <label class="child <?php if ($user->gender == 'other') {
                                            echo 'bak';
                                        } ?>" for="other">
                                            <img src="{{ asset('web/assets/img/other.svg') }}">
                                            Other
                                        </label>
                                        <input style="display:none;" type="radio" id="other" name="gender"
                                            value="gender" <?php if ($user->gender == 'other') {
                                                echo 'checked';
                                            } ?>>
                                        <!-- <div class="child"> <img src="{{ asset('web/assets/img/other.svg') }}"> Other</div> -->
                                    </div>
                                    {{-- <span class="validation-sapn">* Gender </span>      --}}
                                </div>
                                <input type="hidden" name="height_type" value="Centimeter">
                                <!-- <div class="form-group">
                                    <h6 class="hgt_sec">Height Type <span class="validation-sapn">* </span></h6>
                                    <select name="height_type" required class="one mb-0 mt-0 js-example-basic-single"
                                        id="height_type">
                                        <option value="Inch" <?php if ($user->height_type == 'Inch') {
                                            echo 'selected';
                                        } ?>>Inch</option>
                                        <option value="Centimeter" <?php if ($user->height_type == 'Centimeter') {
                                            echo 'selected';
                                        } ?>>Centimeter</option>
                                    </select>
                                    {{-- <span class="validation-sapn">* Height Type </span>      --}}
                                </div> -->
                                <div class="form-group">
                                    <h6 class="hgt_sec">Height <span class="validation-sapn">* </span></h6>
                                    <div class="height">
                                        <input class="otp" id="height_feet" name="height_feet"
                                            oninput='digitValidateCM(this)' value="{{ $user->height_feet }}"
                                            type="text" placeholder="cm" maxlength="3">
                                        <input class="otp" id="height_inch" name="height_inch"
                                            oninput='digitValidateMM(this)' value="{{ $user->height_inch }}"
                                            style="border-right: none;" type="text" placeholder="mm" maxlength="2">
                                    </div>
                                    {{-- <span class="validation-sapn">* Height </span>      --}}
                                </div>
                                <input type="hidden" name="weight_type" value="kg">
                               
                                <div class="form-group " style="position: relative;">
                                    <h6 class="hgt_sec">Weight <span class="validation-sapn">* </span></h6>
                                    <input id="name" type="text" name="weight" pattern="\d{1,3}(\.\d{1,2})?$"
                                        value="{{ $user->weight }}" class="form-control" placeholder="Weight"
                                        required="required">
                                    <a href="#!">
                                        <h6 class="kg" style="width: 30% !important;top: 44px!important;">{{ $user->weight_type }}</h6>
                                    </a>
                                    {{-- <span class="validation-sapn">* Weight </span>      --}}
                                </div>
                                <!-- <div class="form-group">
                                    <input id="name" type="text" name="city" value="{{ $user->city }}" class="form-control" placeholder="City" required="required">
                                    <h6 class="hgt_sec">City <span class="validation-sapn">* </span></h6>
                                    <select class="one mb-0 mt-0 js-example-basic-single" id="city" name="city">
                                        @foreach ($city_data as $item)
                                            <option value="{{ $item->name }}" <?php if ($user->city == $item->name) {
                                                echo 'selected';
                                            } ?>>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="validation-sapn">* City </span> --}}
                                </div> -->
                                <!-- <div class="form-group">
                                    <h6 class="hgt_sec">State <span class="validation-sapn">* </span></h6>
                                    <input id="name" type="text" name="state" value="{{ $user->state }}" class="form-control" placeholder="State" required="required">
                                    <select class="one mb-0 mt-0 js-example-basic-single" id="state" name="state">
                                        @foreach ($state_data as $item)
                                            <option value="{{ $item->name }}" <?php if ($user->state == $item->name) {
                                                echo 'selected';
                                            } ?>>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    {{-- <span class="validation-sapn">* State </span> --}}
                                </div> -->
                                {{-- <div class="form-group">
                            <h6 class="hgt_sec">School Name</h6>
                            <input id="school_name" type="text" name="school_name" value="{{$user->school_name}}" class="form-control" placeholder="School Name">
                        </div>
                        <div class="form-group">
                            <h6 class="hgt_sec">School Address</h6>
                            <textarea id="school_address" style="border-radius: 15px;height: auto;padding: 14px;" name="school_address" class="form-control" placeholder="School Address"  value="{{$user->school_address}}" rows="5" cols="5">{{$user->school_address}}</textarea>
                        </div> --}}
                                <!-- <div class="form-group">
                                    <h6 class="hgt_sec mt-5"> Unique Number</h6>
                                    <input id="school_unique_id" type="text" name="school_unique_id"
                                        value="{{ $user->school_unique_id }}" class="form-control"
                                        placeholder="Unique Number">
                                </div> -->
                                <div class="form-group">
                                    <h6 class="hgt_sec">Pin Code</h6>
                                    <input id="zipcode" type="text" name="zipcode" value="{{ $user->zipcode }}"
                                        class="form-control" placeholder="Zip Code">
                                </div>
                                <h6 class="hgt_sec">Preferred languages</h6>
                                <div class="form-group">
                                    <select class="one js-example-basic-single" name="language_id">
                                        @foreach ($languages as $item)
                                            <option value="{{ $item->id }}" <?php if ($user->language_id == $item->id) {
                                                echo 'selected';
                                            } ?>>
                                                {{ $item->language_title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <a href="#!"> <input type="submit" class="btn-send" value="Update Profile"> </a>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-12 p-0 text-end">
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
@section('script')
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

        let digitValidateCM = function(e) {
            //   console.log(ele.value);
            var t = e.value.replace(/[^0-9\.]/g, '');
            e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 4)) : t;
            //   ele.value = ele.value.replace(/[^[0-9]*(\.[0-9]{0,2})]/g,'');
        }

        let digitValidateMM = function(e) {
            //   console.log(ele.value);
            var t = e.value.replace(/[^0-9\.]/g, '');
            e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
            //   ele.value = ele.value.replace(/[^[0-9]*(\.[0-9]{0,2})]/g,'');
        }
    </script>

    <script type="text/javascript">
        var elements = document.getElementsByClassName("child");
        for (var i = 0; i < elements.length; i++) {
            elements[i].onclick = function() {

                // remove class from sibling

                var el = elements[0];
                while (el) {
                    if (el.tagName === "LABEL") {
                        //remove class
                        el.classList.remove("bak");

                    }
                    // pass to the new sibling
                    el = el.nextSibling;
                }

                this.classList.add("bak");
            };
        }
    </script>
    <script type="text/javascript">
        $("#weight_type").change(function() {
            $(".kg").html(this.value);
        });
        $("#height_type").change(function() {
            if (this.value == "Centimeter") {
                $("#height_feet").attr("placeholder", 'cm');
                $("#height_inch").attr("placeholder", 'mm');
            } else if (this.value == "Inch") {
                $("#height_feet").attr("placeholder", 'Feet');
                $("#height_inch").attr("placeholder", 'Inch');

            } else {
                $("#height_feet").attr("placeholder", '');
                $("#height_inch").attr("placeholder", '');
            }
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
                    $('#imagePreview').hide();
                    $('#imagePreview').fadeIn(650);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imageUpload").change(function() {
            readURL(this);
        });

        $(document).ready(function() {
            getUserAge();
        });

        function getUserAge() {
            var dob = $("#dob").val();
            $.ajax({
                url: "{{ url('checkPersonType') }}",
                type: 'post',
                dataType: 'json',
                data: {
                    'dob': dob,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(data) {
                    if (data.statusCode == "200") {
                        $('#ageText').html("Age: " + data.age + " Years");
                    } else {
                        $('#ageText').html('');
                    }
                },
                error: function() {

                }
            });
        }
    </script>
@endsection
