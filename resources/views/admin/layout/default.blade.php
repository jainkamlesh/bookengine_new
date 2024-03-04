<?php
$currentPage = Route::currentRouteName();
?>
        <!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Rubik:400,700|Crimson+Text:400,400i" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="{{url('/')}}/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="{{url('/')}}/css/magnific-popup.css">
    <link rel="stylesheet" href="{{url('/')}}/css/jquery-ui.css">
    <link rel="stylesheet" href="{{url('/')}}/css/owl.carousel.min.css">
    <link rel="stylesheet" href="{{url('/')}}/css/owl.theme.default.min.css">
    <link rel="stylesheet" href="{{url('/')}}/css/aos.css">
    <link rel="stylesheet" href="{{url('/')}}/plugins/chosen/chosen.css">
    <link rel="stylesheet" href="{{url('/')}}/css/style.css">
    <link rel="stylesheet" href="{{url('/')}}/css/responsive.css">

    <link rel="stylesheet" href="{{url('/')}}/css/datetimepicker.css">
    <link rel="stylesheet" href="{{url('/')}}/css/select2.min.css">

    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.css"
          integrity="sha512-GgUcFJ5lgRdt/8m5A0d0qEnsoi8cDoF0d6q+RirBPtL423Qsj5cI9OxQ5hWvPi5jjvTLM/YhaaFuIeWCLi6lyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.css"
          integrity="sha512-GgUcFJ5lgRdt/8m5A0d0qEnsoi8cDoF0d6q+RirBPtL423Qsj5cI9OxQ5hWvPi5jjvTLM/YhaaFuIeWCLi6lyQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

          <link href="https://cdn.jsdelivr.net/npm/@sweetalert2/theme-minimal@4/minimal.css" rel="stylesheet">
         <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>
    @yield('pageCSS')

    @yield('overWriteCSS')

    <script type="text/javascript">
        var SITE_URL = {!! json_encode(url('/')) !!};
    </script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>

<div class="site-wrap">
    <div class="site-navbar">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-between">
                <div class="logo">
                    <div class="site-logo">
                        <a href="#" class="js-logo-clone">
                            <i class="fa fa-ravelry" aria-hidden="true" style="font-size: 30px;"></i>
                            <span style="color: #ff7c48;"> Booking</span>
                            <span style="color: #543a9b;">Engine</span>
                        </a>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="main-nav d-none d-lg-block">

                        <!-- admin nav bar -->
                        @if(Auth::guard('admin')->user()->role_id == 1)
                            <nav class="site-navigation text-right text-md-center" role="navigation">
                                <ul class="site-menu js-clone-nav d-none d-lg-block">
                                    <li id="close-btn"><i class="fa fa-times js-logo-clone js-menu-toggle close-icn" aria-hidden="true"></i></li>
                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotels', 'admin.add.hotel', 'admin.hotel.edit');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotels')}}">{{ __('label.hotellist') }}</a>
                                    </li>

									<?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotelgroup', 'admin.add.hotelgroup', 'admin.hotelgroup.edit');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotelgroup')}}">{{ __('label.hotelgroup') }}</a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.currency', 'admin.add.currency', 'admin.currency.edit');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.currency')}}">{{ __('label.currencylist') }}</a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.room-option', 'admin.add.room-option', 'admin.room-option.edit');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.room-option')}}">{{ __('label.roomfacility') }}</a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.whatsapp-template', 'admin.add.whatsapp-template', 'admin.whatsapp-template.edit');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.whatsapp-template')}}">{{ __('label.whatsapptemplate') }}</a>
                                    </li>
                                    <li class="d-none"><a href="user_list.html">{{ __('label.userlist') }}</a></li>
                                </ul>
                            </nav>
                        @endif

                        <!-- hotel panel nav bar -->


                        @if(Auth::guard('admin')->user()->role_id == 2)
                            <nav class="site-navigation text-right text-md-center" role="navigation">
                                <ul class="site-menu js-clone-nav d-none d-lg-block">
                                    <li id="close-btn"><i class="fa fa-times js-logo-clone js-menu-toggle close-icn" aria-hidden="true"></i></li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotel.booking');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotel.booking')}}">{{ __('user.bookings') }}</a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotel.requests');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotel.requests')}}">{{ __('label.requests') }}</a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.service.booking');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.service.booking')}}">{{ __('user.servicebookings') }}</a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotel.calender');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotel.calender')}}">{{ __('user.calendar') }}</a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotel.bulk.update');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotel.bulk.update')}}">{{ __('user.bulkupdate') }}</a>
                                    </li>

                                    {{--<li class="dropdown ">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{ __('user.logs') }}
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <div class="dropdown-menu logs-drop-menu">
                                                <a class="dropdown-item" href="">{{ __('user.otalogs') }}</a>
                                                <a class="dropdown-item" href="">{{ __('user.apilogs') }}</a>
                                            </div>
                                        </a>
                                    </li>--}}

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotel.logs');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <!-- <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotel.logs')}}">Logs</a>
                                    </li> -->

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array(
                                        'admin.hotel.profile',
                                        'admin.room-type', 'admin.add.room-type', 'admin.room-type.edit',
                                        'admin.rate-type', 'admin.add.rate-type', 'admin.rate-type.edit',
                                        'admin.rate-plan', 'admin.add.rate-plan', 'admin.rate-plan.edit',
                                        'admin.extra', 'admin.add.extra', 'admin.extra.edit',
                                        'admin.coupon', 'admin.add.coupon', 'admin.coupon.edit',
                                        'admin.offer', 'admin.add.offer', 'admin.offer.edit',
                                        'admin.download.hotel.widget','admin.service','admin.add.service','admin.service.edit'
                                    );
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="dropdown {!! $activeClass !!}">
                                        <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">{{ __('user.configuration') }}
                                            <i class="fa fa-chevron-down" aria-hidden="true"></i>
                                            <div class="dropdown-menu logs-drop-menu">
                                                <a class="dropdown-item" href="{{route('admin.hotel.profile')}}">{{ __('user.hotelprofile') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.room-type')}}">{{ __('user.roomtype') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.rate-type')}}">{{ __('user.ratetype') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.rate-plan')}}">{{ __('user.rateplan') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.extra')}}">{{ __('user.extra') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.coupon')}}">{{ __('user.coupon') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.offer')}}">{{ __('user.offer') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.service')}}">{{ __('user.service') }}</a>
                                                <a class="dropdown-item" href="{{route('admin.download.hotel.widget')}}">{{ __('user.downloadwidget') }}</a>
                                            </div>
                                        </a>
                                    </li>

                                    <li class="{{$activeClass}}">
                                        <a href="https://www.booking-engine.it/Scripts/index.pl?hotel_id={{ Auth::guard('admin')->user()->hotel_id }}" target="_blank">{{ __('user.preview') }} ></a>
                                    </li>

                                    <?php
                                    $activeClass = '';
                                    $currentPage_ar = array('admin.hotel.reports');
                                    if (in_array($currentPage, $currentPage_ar)) {
                                        $activeClass = 'active';
                                    }
                                    ?>
                                    <li class="{{$activeClass}}">
                                        <a href="{{route('admin.hotel.reports')}}">{{ __('label.reports') }}</a>
                                    </li>

                                    <!--  {{ env('APP_URL') }}/ -->


                                </ul>
                            </nav>
                        @endif


                    </div>
                    <div class="icons d-flex align-items-center user-dropdown">
                        <a href="#" class="site-menu-toggle js-menu-toggle ml-3 d-inline-block d-lg-none"><img src="{{url('/')}}/images/menu-icn.svg" width="20"></a>
                        <div class="dropdown" style="margin-left: 20px;">
                            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown"><img src="{{url('/')}}/images/profile.svg" width="30">
                            </a>

                            @if(Auth::guard('admin')->user()->role_id == 1)
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('admin.aditProfile')}}">{{ __('label.editprofile') }}</a>
                                    <a class="dropdown-item" href="{{route('admin.logout')}}">{{ __('label.logout') }}</a>
                                </div>
                            @endif

                            @if(Auth::guard('admin')->user()->role_id == 3)
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('admin.editHotelGroupProfile')}}">{{ __('label.editprofile') }}</a>
                                    <a class="dropdown-item" href="{{route('admin.logout')}}">{{ __('label.logout') }}</a>
                                </div>
                            @endif

                            @if(Auth::guard('admin')->user()->role_id == 2)
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('admin.hotel.edit_profile')}}">{{ __('label.editprofile') }}</a>
                                    <a class="dropdown-item" href="{{route('admin.hotel.changePassword')}}">{{ __('label.changepassword') }}</a>
                                    <a class="dropdown-item" href="{{route('admin.logout')}}">{{ __('label.logout') }}</a>
                                </div>
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @yield('content')
</div>
<script src="{{url('/')}}/js/jquery-3.3.1.min.js"></script>
<script src="{{url('/')}}/js/jquery-ui.js"></script>
<script src="{{url('/')}}/js/popper.min.js"></script>
<script src="{{url('/')}}/js/bootstrap.min.js"></script>
<script src="{{url('/')}}/js/owl.carousel.min.js"></script>
<script src="{{url('/')}}/js/jquery.magnific-popup.min.js"></script>
<script src="{{url('/')}}/js/aos.js"></script>
<script src="{{url('/')}}/plugins/chosen/chosen.jquery.js"></script>

<script src="{{url('/')}}/plugins/inputmask/jquery.inputmask.js"></script>
{{--<script src="{{url('/')}}/plugins/inputmask/jquery.inputmask.numeric.extensions.min.js"></script>--}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>
<script src="https://cdn2.hubspot.net/hubfs/476360/Chart.js"></script>
<script src="https://cdn2.hubspot.net/hubfs/476360/utils.js"></script>


<script src="{{url('/')}}/js/main.js"></script>


<script type="text/javascript">

    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 46 || charCode > 57)) {
            return false;
        }
        return true;
    }

    function onlyIntegerNumber(evt) {

        evt = (evt) ? evt : window.event;

        //Only ASCII character in that range allowed
        var ASCIICode = (evt.which) ? evt.which : evt.keyCode;
        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57)) {
            return false;
        }
        return true;
    }

    var callIntegerInputMask = '';
    var callFloatInputMask = '';

    $(function () {

        callIntegerInputMask = function () {

            $(".text_int").inputmask({
                'alias': 'integer',
                'min': 0,
                'allowMinus': 'false',
                'allowPlus': 'false',
                'rightAlign': false,
            });
        };
        callIntegerInputMask();

        callFloatInputMask = function () {

            $(".text_float").inputmask({
                'alias': 'decimal',
                'min': 0.0,
                'allowMinus': 'false',
                'allowPlus': 'false',
                'rightAlign': false,
                'autoGroup': true,
            });
        };
        callFloatInputMask();
    });

    function sweetAlert(type,message){
        Swal.fire({
            position: "top-end",
            icon: type,
            title: message,
            showConfirmButton: false,
            timer: 1500
        });
    }
</script>

<script>
    $(document).ready(function () {

        @yield('validations')
    });
</script>

@yield('footer_content')

</body>

</html>
