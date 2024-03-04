@extends('admin.layout.default')

@section('title', 'Booking List')

@section('content')
    <section class="dashboard-wrapper property-wrapper booking-wrapper">
        <div class="container-fluid">
            <ul id="breadcrumb" class="p-0">
                <li><a href="#"><span class="icon icon-home"><i class="fa fa-home" aria-hidden="true"></i> </span></a></li>
                <li><a href="{{route('admin.hotel.booking')}}"><span class="icon icon-beaker"> </span>{{ __('user.calendar') }}</a></li>
            </ul>
        </div>
        <div class="container-fluid calendar-wrapper">
            <div class="calendar-nav d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center nav-br">
                    <div class="form-group my-3">
                        <label class="m-0">{{ __('user.searchby') }} :</label><br>
                        <select class="js-states form-control single" id="select_search_by">
                            <option value="booking_date">{{ __('user.bookingdate') }}</option>
                            <option value="check_in">{{ __('user.checkindate') }}</option>
                            <option value="check_out">{{ __('user.checkoutdate') }}</option>
                            {{--<option value="guest_name">{{ __('user.guestname') }}</option>
                            <option value="boooking_number">{{ __('user.bookingnumber') }}</option>
                            <option value="ota_ref_number">{{ __('user.otarefnumber') }}</option>
                            <option value="booking_status">{{ __('user.bookingstatus') }}</option>--}}
                        </select>
                    </div>
                    <div class="form-group my-3 date-picker">
                        <label class="mb-0">{{ __('user.fromdate') }} :</label>
                        <div class="input-group date">
                            <input type="text" class="form-control" id="from_date" placeholder="FromDate">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                    <div class="form-group my-3">
                        <label class="mb-0">{{ __('user.todate') }} :</label>
                        <div class="input-group date">
                            <input type="text" class="form-control" id="to_date" placeholder="ToDate">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
                        </div>
                    </div>
                    <div class="form-group my-3">

                    </div>
                    <div class="form-group my-3">
                        <button id="search"><i class="fa fa-search" aria-hidden="true"></i></button>
                        <img src="{!! URL::asset('images/loader.svg') !!}" width="60" id="loader" style="position: relative;
              top: 12px; right: 10px;">
                    </div>
                </div>
                <div class="record-block">
                    <div class="form-group mb-0 d-flex">
                        <label class="m-0 mr-1">{{ __('user.recordperpage') }} :</label>
                        <select class="js-states form-control single" id="select_per_page">
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
            <table class="mt-4 pro-table-pg book-table-pg table-hover wrapper" id="table_booking_list">
                <thead>
                <tr class="ft-tr">
                    <th style="width: 3%">{{ __('user.id') }}</th>
                    <th style="width:6%">{{ __('user.status') }}</th>
                    <th style="width:6%">{{ __('user.createdate') }}</th>
                    <th style="width:6%">{{ __('user.confirmdate') }}</th>
                    <th style="width:6%">{{ __('user.referer') }}</th>
                    <th style="width:7%">{{ __('user.email') }}</th>
                    <th style="width:7%">{{ __('user.phone') }}</th>
                    {{-- <th>{{ __('user.firstname') }}</th>
                    <th>{{ __('user.lastname') }}</th> --}}
                    <th style="width:5%">{{ __('user.checkin') }}</th>
                    <th style="width:5%">{{ __('user.checkout') }}</th>
                    <th style="width:7%">{{ __('user.room') }}</th>
                    <th style="width:5%">{{ __('user.deposit') }}</th>
                    <th style="width:5%">{{ __('user.price') }}</th>
                    <th style="width:5%">{{ __('user.paid') }}</th>
                    <th style="width:5%">{{ __('user.called') }}</th>
                    <th style="width:7%">{{ __('user.whatsappmessage') }}</th>
                    <th style="width:5%">{{ __('user.sent') }}</th>
                    <th>{{ __('user.action') }}</th>
                </tr>
                </thead>
                <tbody id="tbody_booking_list">

                </tbody>
            </table>
        </div>

        <div class="pagination-btn text-right">
            @if(isset($totalData) && !empty($totalData))
                <button id="btn_pre">{{ __('user.previous') }}</button>
                <button id="btn_next">{{ __('user.next') }}</button>
            @endif
        </div>

        <div class="delete-modal-main">
            <div class="modal fade" id="promocodedata">
                <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
                    <div class="modal-content">
                        <div class="modal-header mt-2">
                            <h5 class="modal-title">{{ __('user.repost') }}</h5>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <div class="coupon">
                                <h5 class="delete-warning">{{ __('user.booking') }} {{ __('user.reposted') }}, {{ __('user.pmswillgetitwithinminute') }}</h5>
                                <form action="#" class="mt-4 modal-btn">
                                    <button type="button" class="btn btn-default btn-success">{{ __('user.ok') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('footer_content')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script>

    <script>

        $(document).ready(function () {

            var tokenData = '{{ csrf_token() }}';

            $("#loader").hide();

            var totalData = '{!! $totalData !!}';
            totalData = parseInt(totalData);

            var skip = 0;
            var per_page = $('#select_per_page').val();
            per_page = parseInt(per_page);

            function displayListData() {

                $("#loader").show();
                $("#search").hide();

                var urlData = "{!! route('admin.hotel.list.booking.data') !!}";

                var select_search_by = $('#select_search_by').val();
                var from_date = $('#from_date').val();
                var to_date = $('#to_date').val();
                var select_channel = $('#select_channel').val();

                $.ajax
                ({
                    type: "POST",
                    url: urlData,
                    data: {
                        _token: tokenData,
                        data_skip: skip,
                        data_per_page: per_page,
                        data_select_search_by: select_search_by,
                        data_from_date: from_date,
                        data_to_date: to_date,
                        data_select_channel: select_channel,
                    },
                    cache: false,
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log("error");
                    },
                    success: function (result) {

                        $('#tbody_booking_list').html(result);

                        $("#search").show();
                        $("#loader").hide();

                        if (totalData <= per_page) {
                            $("#btn_next").hide();
                        }
                    }
                });
            }

            displayListData();

            $("#search, #btn_pre, #btn_next").click(function () {
                displayListData();
            });

            $("#btn_pre").hide();

            $("#btn_pre").click(function () {

                per_page = $('#select_per_page').val();
                per_page = parseInt(per_page);

                skip = parseInt(skip - per_page);
                if (skip <= 0) {
                    skip = 0;
                }

                if (skip == 0) {

                    $("#btn_pre").hide();
                }

                if (skip <= totalData) {

                    $("#btn_next").show();
                }

                displayListData();
            });

            $("#btn_next").click(function () {

                per_page = $('#select_per_page').val();
                per_page = parseInt(per_page);

                skip = parseInt(skip + per_page);

                $("#btn_pre").show();

                if (skip >= totalData) {

                    $("#btn_next").hide();
                }

                displayListData();
            });

            $('#select_per_page').change(function () {
                skip = 0;
            });

        });
    </script>

    <script>
        $('#from_date,#to_date').datepicker({
            weekStart: 0,
            todayBtn: "linked",
            language: "en",
            orientation: "bottom auto",
            keyboardNavigation: false,
            autoclose: true
        });
    </script>

    <script>
        $(".single").select2({
            allowClear: true
        });
    </script>

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });

        (function () {
            'use strict';

            if (navigator.userAgent.match(/IEMobile\/10\.0/)) {
                var msViewportStyle = document.createElement('style');
                msViewportStyle.appendChild(
                    document.createTextNode(
                        '@-ms-viewport{width:auto!important}'
                    )
                );
                document.head.appendChild(msViewportStyle);
            }
        }());




        function change_status(type,id){
            var tokenData = '{{ csrf_token() }}';
            $.ajax
                ({
                    type: "POST",
                    url: "{!! route('admin.hotel.status.booking.data') !!}",
                    data: {
                        _token: tokenData,
                        id: id,
                        type: type,
                    },
                    cache: false,
                    error: function (jqXHR, textStatus, errorThrown) {
                        sweetAlert('success','Something went wrong');
                    },
                    success: function (result) {
                        if(result == true){
                            sweetAlert('success','Status updated successfully');
                        }else{
                            sweetAlert('success','Something went wrong');
                        }
                        displayListData();
                    }
                });
        }


        function delete_reservation(id){
            var tokenData = '{{ csrf_token() }}';
            $.ajax
                ({
                    type: "POST",
                    url: "{!! route('admin.hotel.delete.booking.data') !!}",
                    data: {
                        _token: tokenData,
                        id: id
                    },
                    cache: false,
                    error: function (jqXHR, textStatus, errorThrown) {
                        sweetAlert('success','Something went wrong');
                    },
                    success: function (result) {
                        if(result == true){
                            sweetAlert('success','Reservation deleted successfully');
                        }else{
                            sweetAlert('success','Something went wrong');
                        }
                        location.reload();
                    }
                });
        }


        function duplicat_reservation(id){
            var tokenData = '{{ csrf_token() }}';
            $.ajax
                ({
                    type: "POST",
                    url: "{!! route('admin.hotel.duplicat.booking.data') !!}",
                    data: {
                        _token: tokenData,
                        id: id
                    },
                    cache: false,
                    error: function (jqXHR, textStatus, errorThrown) {
                        sweetAlert('success','Something went wrong');
                    },
                    success: function (result) {
                        if(result == true){
                            sweetAlert('success','Reservation duplicated successfully');
                        }else{
                            sweetAlert('success','Something went wrong');
                        }
                        location.reload();
                    }
                });
        }

    </script>
@endsection
