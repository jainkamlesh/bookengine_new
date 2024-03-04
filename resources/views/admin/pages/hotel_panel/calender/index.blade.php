@extends('admin.layout.default')

@section('title', 'Calender')

@section('content')

    <section class="calendar-wrapper  pb-4">
        <div class="container-fluid">
            <ul id="breadcrumb" class="p-0">
                <li><a href="#"><span class="icon icon-home"><i class="fa fa-home" aria-hidden="true"></i> </span></a></li>
                <li><a href="#"><span class="icon icon-beaker"> </span>{{ __('user.calendar') }}</a></li>
            </ul>
            @include('flash-message')
            <div class="calendar-nav d-flex align-items-center booking-wrapper">
                <div class="nav-ft-kk d-flex">
                    <div class="form-group my-3">
                        <select class="js-states form-control chosen-select single" name="select_rates_plan" id="select_rates_plan" data-placeholder="All Rates Availability">
                            <option value="">{{ __('user.allratesavailability') }}</option>
                            @if(isset($ratePlan) && !empty($ratePlan))
                                @foreach($ratePlan as $key => $value)
                                    <option value="{!! $value->id !!}">{!! $value->name !!}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <select class="js-states form-control chosen-select single" name="select_room_type" id="select_room_type" data-placeholder="All Rooms">
                            <option value="">{{ __('user.allroomtypes') }}</option>
                            @if(isset($roomType) && !empty($roomType))
                                @foreach($roomType as $key => $value)
                                    <option value="{!! $value->id !!}">{!! $value->name !!}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="form-group my-3">
                        <?php
                        $month = date("m");
                        $month = (int)$month;

                        $current_month = date('Y-m').'-01';
                        ?>
                        <select class="js-states form-control chosen-select single" name="select_month_year" id="select_month_year" data-placeholder="Select a month-year...">
                            @for($count=0; $count<=18; $count++)
                                <?php
                                //$add_month = "+" . $i . " months";
                                // $key_month = date('m-Y', strtotime($add_month));
                                //  $value_month = date('M-Y', strtotime($add_month));
                                /*sandro changes*/
                                $key_month = date('m-Y', strtotime($current_month.' + '.$count.' Months'));
                                $value_month = date('M-Y', strtotime($current_month.' + '.$count.' Months'));
                                /*sandro changes*/
                                ?>
                                <option value="{!! $key_month !!}">{!! $value_month !!}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                {{--<div class="nav-ft-kk-2 d-flex">
                    <div class="property-wrapper">
                        <button type="button" class="btn_res" data-value="min_stay">{{ __('user.minstay') }}</button>
                    </div>
                    <div class="property-wrapper">
                        <button type="button" class="btn_res" data-value="max_stay">{{ __('user.maxstay') }}</button>
                    </div>
                    <div class="property-wrapper">
                        --}}{{--Closed to Arrival--}}{{--
                        <button type="button" class="btn_res" data-value="cta">{{ __('user.cta') }}</button>
                    </div>
                    <div class="property-wrapper">
                        --}}{{--Closed to Departure--}}{{--
                        <button type="button" class="btn_res" data-value="ctd">{{ __('user.ctd') }}</button>
                    </div>
                </div>--}}
            </div>

            <div class="d-block div_calendar_data" id="div_calendar_data">

            </div>
        </div>

        <button type="button" id="btn_success" data-toggle="modal" data-target="#model_success" aria-hidden="true" style="display: none;">{{ __('user.success') }}</button>

        <div class="delete-modal-main">
            <div class="modal fade" id="model_success">
                <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="couponcode">
                                <img src="../images/3-layer.svg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                            </div>
                            <div class="promocodeapplied2 mt-3">
                                <h4 class="delete-sucess">{{ __('user.dataupdatedsuccessfully') }}.</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('footer_content')

    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-loading-overlay/2.1.5/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@1.6.0/extras/loadingoverlay_progress/loadingoverlay_progress.min.js"></script>--}}

    <script src="{{url('/')}}/plugins/loadingoverlay/loadingoverlay.min.js"></script>
    <script src="{{url('/')}}/plugins/loadingoverlay/loadingoverlay_progress.min.js"></script>

    <script type="text/javascript">

        var chosenCall = '';
        var lodderShow = '';
        var slideCall = '';
        var saveCalendarData = '';

        $(function () {

            "use strict";

            var tokenData = '{{ csrf_token() }}';

            chosenCall = function chosenCall() {
                var config = {
                    '.chosen-select': {},
                    '.chosen-select-deselect': {allow_single_deselect: true},
                    '.chosen-select-no-single': {disable_search_threshold: 10},
                    '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
                    '.chosen-select-width': {width: "95%"}
                };
                for (var selector in config) {
                    $(selector).chosen(config[selector]);
                }

                $('#select_rates_plan, #select_room_type').val('').trigger("chosen:updated");
                $('#select_month_year').val('{!! date("m-Y") !!}').trigger("chosen:updated");
            };
            chosenCall();

            lodderShow = function lodderShow(value) {

                if (value == "hide") {

                    $.LoadingOverlay("hide");

                } else if (value == "show") {

                    $.LoadingOverlay("show");
                } else {

                    $.LoadingOverlay("hide");
                }
            };
            lodderShow("hide");

            function loopPrev2() {
                /*$('.div_calendar_data .div_slid_care').stop().animate({scrollLeft: '-=60'}, 'fast', 'linear', loopPrev2);*/

                $('.div_calendar_data .div_slid_care').each(function () {
                    $(this).stop().animate({scrollLeft: '-=60'}, 'fast', 'linear', loopPrev2);
                });
            }

            function loopNext2() {
                /*$('.div_calendar_data .div_slid_care').stop().animate({scrollLeft: '+=60'}, 'fast', 'linear', loopNext2);*/

                $('.div_calendar_data .div_slid_care').each(function () {
                    $(this).stop().animate({scrollLeft: '+=60'}, 'fast', 'linear', loopNext2);
                });
            }

            function stop2() {
                /*$('.div_calendar_data .div_slid_care').stop();*/

                $('.div_calendar_data .div_slid_care').each(function () {
                    $(this).stop();
                });
            }

            slideCall = function slideCall() {

                var $a_pre = $(".div_calendar_data .a_pre");
                var $a_nxt = $(".div_calendar_data .a_nxt");

                $a_pre.click(function () {
                    var parent_div = $(this).attr("data-parent-div");
                    var $parent_div = $('.' + parent_div);

                    /*$('.div_calendar_data .div_slid_care').stop().animate({scrollLeft: '-=500'}, 'slow', 'linear', loopPrev2);*/

                    $('.div_calendar_data .div_slid_care').each(function () {
                        $(this).stop().animate({scrollLeft: '-=500'}, 'slow', 'linear', loopPrev2);
                    });
                });

                $a_nxt.click(function () {
                    var parent_div = $(this).attr("data-parent-div");
                    var $parent_div = $('.' + parent_div);
                    /*$('.div_calendar_data .div_slid_care').stop().animate({scrollLeft: '+=500'}, 'slow', 'linear', loopNext2);*/

                    $('.div_calendar_data .div_slid_care').each(function () {
                        $(this).stop().animate({scrollLeft: '+=500'}, 'slow', 'linear', loopNext2);
                    });
                });

                $a_nxt.hover(function () {
                    /*loopNext2();*/
                }, function () {
                    stop2();
                });

                $a_pre.hover(function () {
                    /*loopPrev2();*/
                }, function () {
                    stop2();
                });
            };

            slideCall();

            saveCalendarData = function () {

                //

                $('#div_calendar_data .div_calendar_extra_price_data').each(function () {
                    $(this).hide();
                });

                $('#div_calendar_data .btn_calendar_extra_price').each(function () {

                    $(this).click(function () {

                        var $id = $(this).attr("data-id");

                        lodderShow("show");

                        $('#div_calendar_data .div_calendar_extra_price_data_' + $id).each(function () {

                            $(this).toggle();
                        });

                        setTimeout(function () {
                            lodderShow("hide");
                        }, 1200);
                    });
                });

                $('#div_calendar_data .open_close').each(function () {

                    $(this).on('change', function () {

                        if ($(this).prop("checked") == true) {
                            $(this).attr("checked", "checked");
                            $(this).val(0);
                        } else {
                            $(this).removeAttr("checked");
                            $(this).val(1);
                        }
                    });
                });


                $('#div_calendar_data .manage_calender').each(function () {

                    $(this).on('change', function () {

                        $(this).addClass("data-change").css('background', '#C0C0C0');
                    });
                });

                $('#div_calendar_data #btn_update_all').click(function () {

                    $(this).attr("disabled", "disabled");

                    var main_data = {};

                    var update_inventory_data = [];
                    var update_restriction_close_data = [];
                    var update_restriction_cta_data = [];
                    var update_restriction_ctd_data = [];
                    var update_restriction_base_amount_data = [];
                    var update_restriction_min_stay_data = [];
                    var update_restriction_max_stay_data = [];

                    var update_restriction_ext_adult1_amount_data = [];
                    var update_restriction_ext_adult2_amount_data = [];
                    var update_restriction_ext_adult3_amount_data = [];
                    var update_restriction_ext_adult4_amount_data = [];

                    var update_restriction_child_age1_rate_data = [];
                    var update_restriction_child_age2_rate_data = [];
                    var update_restriction_child_age3_rate_data = [];

                    var update_restriction_single_amount_data = [];


                    var ar_restriction_type = [];
                    ar_restriction_type.push('restriction_close');
                    ar_restriction_type.push('restriction_cta');
                    ar_restriction_type.push('restriction_ctd');

                    ar_restriction_type.push('restriction_base_amount');
                    ar_restriction_type.push('restriction_min_stay');
                    ar_restriction_type.push('restriction_max_stay');

                    ar_restriction_type.push('restriction_extra_adult_1_amount');
                    ar_restriction_type.push('restriction_extra_adult_2_amount');
                    ar_restriction_type.push('restriction_extra_adult_3_amount');
                    ar_restriction_type.push('restriction_extra_adult_4_amount');

                    ar_restriction_type.push('restriction_child_age_1_rate');
                    ar_restriction_type.push('restriction_child_age_2_rate');
                    ar_restriction_type.push('restriction_child_age_3_rate');

                    ar_restriction_type.push('restriction_single_amount');

                    $('#div_calendar_data .data-change').each(function () {

                        var type = $(this).attr("data-type");

                        if (type == "inventory") {

                            var value = $(this).val();
                            var room_type_id = $(this).attr("data-room-type-id");
                            var availability_date = $(this).attr("data-availability-date");

                            var raw_data = {};
                            raw_data['value'] = value;
                            raw_data['room_type_id'] = room_type_id;
                            raw_data['date'] = availability_date;

                            update_inventory_data.push(raw_data);
                        }

                        var isExists = 0;
                        isExists = jQuery.inArray(type, ar_restriction_type);
                        if (isExists >= 0) {

                            var value = $(this).val();
                            var room_type_id = $(this).attr("data-room-type-id");
                            var rate_plan_id = $(this).attr("data-rate-plan-id");
                            var availability_date = $(this).attr("data-availability-date");

                            var raw_data = {};
                            raw_data['value'] = value;
                            raw_data['room_type_id'] = room_type_id;
                            raw_data['rate_plan_id'] = rate_plan_id;
                            raw_data['date'] = availability_date;

                            if (type == "restriction_close") {
                                update_restriction_close_data.push(raw_data);
                            }

                            if (type == "restriction_cta") {
                                update_restriction_cta_data.push(raw_data);
                            }

                            if (type == "restriction_ctd") {
                                update_restriction_ctd_data.push(raw_data);
                            }

                            if (type == "restriction_base_amount") {
                                update_restriction_base_amount_data.push(raw_data);
                            }

                            if (type == "restriction_min_stay") {
                                update_restriction_min_stay_data.push(raw_data);
                            }

                            if (type == "restriction_max_stay") {
                                update_restriction_max_stay_data.push(raw_data);
                            }

                            /**************************************************************************************************************************/
                            if (type == "restriction_extra_adult_1_amount") {
                                update_restriction_ext_adult1_amount_data.push(raw_data);
                            }

                            if (type == "restriction_extra_adult_2_amount") {
                                update_restriction_ext_adult2_amount_data.push(raw_data);
                            }

                            if (type == "restriction_extra_adult_3_amount") {
                                update_restriction_ext_adult3_amount_data.push(raw_data);
                            }

                            if (type == "restriction_extra_adult_4_amount") {
                                update_restriction_ext_adult4_amount_data.push(raw_data);
                            }

                            /**************************************************************************************************************************/
                            if (type == "restriction_child_age_1_rate") {
                                update_restriction_child_age1_rate_data.push(raw_data);
                            }

                            if (type == "restriction_child_age_2_rate") {
                                update_restriction_child_age2_rate_data.push(raw_data);
                            }

                            if (type == "restriction_child_age_3_rate") {
                                update_restriction_child_age3_rate_data.push(raw_data);
                            }

                            if (type == "restriction_single_amount") {
                                update_restriction_single_amount_data.push(raw_data);
                            }

                            /**************************************************************************************************************************/
                        }

                    });

                    main_data = {};
                    main_data['inventory'] = update_inventory_data;
                    main_data['restriction_close'] = update_restriction_close_data;
                    main_data['restriction_cta'] = update_restriction_cta_data;
                    main_data['restriction_ctd'] = update_restriction_ctd_data;

                    main_data['restriction_base_amount'] = update_restriction_base_amount_data;
                    main_data['restriction_min_stay'] = update_restriction_min_stay_data;
                    main_data['restriction_max_stay'] = update_restriction_max_stay_data;

                    main_data['restriction_ext_adult1_amount'] = update_restriction_ext_adult1_amount_data;
                    main_data['restriction_ext_adult2_amount'] = update_restriction_ext_adult2_amount_data;
                    main_data['restriction_ext_adult3_amount'] = update_restriction_ext_adult3_amount_data;
                    main_data['restriction_ext_adult4_amount'] = update_restriction_ext_adult4_amount_data;

                    main_data['restriction_child_age1_rate'] = update_restriction_child_age1_rate_data;
                    main_data['restriction_child_age2_rate'] = update_restriction_child_age2_rate_data;
                    main_data['restriction_child_age3_rate'] = update_restriction_child_age3_rate_data;

                    main_data['restriction_single_amount'] = update_restriction_single_amount_data;

                    var urlData = "{!! route('admin.hotel.manage.calendar.data') !!}";

                    $.ajax
                    ({
                        type: "POST",
                        url: urlData,
                        data: {
                            _token: tokenData,
                            data_main_data: main_data,
                        },
                        cache: false,
                        error: function (jqXHR, textStatus, errorThrown) {
                            console.log("error");
                            $(this).removeAttr("disabled");
                        },
                        success: function (result) {

                            $('#div_calendar_data #btn_update_all').removeAttr("disabled");

                            $('#div_calendar_data .data-change').each(function () {

                                $(this).removeClass("data-change").css('background', 'transparent');
                            });

                            $('#btn_success').trigger("click");
                        }
                    });
                });
            };

            saveCalendarData();

            var $select_rates_plan = $('#select_rates_plan');
            var $select_room_type = $('#select_room_type');
            var $select_month_year = $('#select_month_year');

            function displayCalendarData() {

                var $select_rates_plan = $('#select_rates_plan');
                var $select_room_type = $('#select_room_type');
                var $select_month_year = $('#select_month_year');

                var urlData = "{!! route('admin.hotel.get.calender.data') !!}";

                var $value_rates_plan = $select_rates_plan.val();
                var $value_room_type = $select_room_type.val();
                var $value_month_year = $select_month_year.val();

                lodderShow("show");

                $.ajax
                ({
                    type: "POST",
                    url: urlData,
                    data: {
                        _token: tokenData,
                        data_value_rates_plan: $value_rates_plan,
                        data_value_room_type: $value_room_type,
                        data_value_month_year: $value_month_year,
                    },
                    cache: false,
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("error");
                    },
                    success: function (result) {

                        $('#div_calendar_data').html("");
                        $('#div_calendar_data').html(result);

                        slideCall();

                        callIntegerInputMask();

                        callFloatInputMask();

                        saveCalendarData();

                        setTimeout(function () {
                            lodderShow("hide");
                        }, 1200);
                    }
                });
            }

            displayCalendarData();

            $select_rates_plan.change(function () {
                displayCalendarData();
            });

            $select_room_type.change(function () {
                displayCalendarData();
            });

            $select_month_year.change(function () {
                displayCalendarData();
            });
        });
    </script>
@endsection

