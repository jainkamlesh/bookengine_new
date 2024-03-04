@extends('admin.layout.default')

@section('title', 'Bulk Update')

@section('overWriteCSS')
    <style>
        .datepicker {
            text-align: center;
        }

        .datepicker-days .disabled {
            color: #cccccc;
        }
    </style>
@stop

@section('content')
    <section class="dashboard-wrapper property-wrapper booking-wrapper">

        <div class="container-fluid">
            <ul id="breadcrumb" class="p-0">
                <li><a href="#"><span class="icon icon-home"><i class="fa fa-home" aria-hidden="true"></i> </span></a></li>
                <li><a href="#"><span class="icon icon-beaker"> </span>{{ __('user.bookings') }}</a></li>
            </ul>
        </div>

        <form method="post">
            @csrf
            <div class="container-fluid calendar-wrapper">
                <div class="calendar-nav d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center nav-br">

                        <div class="form-group my-3">
                            <label class="m-0">{{ __('user.updatetype') }} :</label><br>
                            <select class="js-states form-control chosen-select single" id="select_update_type" name="select_update_type" data-placeholder="Select update type">

                                <option value="inventory">{{ __('user.inventory') }}</option>
                                <option value="rate">{{ __('user.rate') }}</option>
                                <option value="single_rate">{{ __('user.singleprice') }}</option>
                                <option value="ext_adult1_rate">1st {{ __('user.adultextrarate') }}</option>
                                <option value="ext_adult2_rate">2nd {{ __('user.adultextrarate') }}</option>
                                <option value="ext_adult3_rate">3rd {{ __('user.adultextrarate') }}</option>
                                <option value="ext_adult4_rate">4th {{ __('user.adultextrarate') }}</option>
                                <option value="child_age1_rate">{{ __('user.childage') }}1 {{ __('user.rate') }}</option>
                                <option value="child_age2_rate">{{ __('user.childage') }}2 {{ __('user.rate') }}</option>
                                <option value="child_age3_rate">{{ __('user.childage') }}3 {{ __('user.rate') }}</option>
                                <option value="closed">{{ __('user.closed') }}</option>
                                <option value="minstay">{{ __('user.minstay') }}</option>
                                <option value="maxstay">{{ __('user.maxstay') }}</option>

                                <option value="cta">{{ __('user.cta') }}</option>
                                <option value="ctd">{{ __('user.ctd') }}</option>
                            </select>
                        </div>

                        <div class="form-group my-3" id="div_room_type">
                            <label class="m-0">{{ __('user.roomtype') }} :</label><br>
                            <select class="js-states form-control chosen-select single" name="room_type" id="select_room_type" data-placeholder="Select room type">
                                @if($countRoomType > 0)
                                    @foreach($roomType as $key => $value)
                                        <option value="{{$value->id}}">{{ ucfirst($value->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="form-group my-3" id="div_system_mapping">
                            <label class="m-0">{{ __('user.systemmapping') }} :</label><br>
                            <select class="js-states form-control chosen-select single" name="system_mapping" id="select_system_mapping" data-placeholder="Select rate plan">
                                @if($countRatePlan > 0)
                                    @foreach($ratePlan as $key => $value)
                                        <option value="{{$value->id}}">{{ ucfirst($value->name) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                    </div>
                </div>

                <table class="mt-4 pro-table-pg bulk-table-pg table-hover wrapper" id="table_input_data">
                    <thead id="myTable">
                    <tr class="ft-tr">
                        <th>{{ __('user.fromdate') }}</th>
                        <th>{{ __('user.todate') }}</th>
                        <th></th>
                        <th>{{ __('user.sun') }}</th>
                        <th>{{ __('user.mon') }}</th>
                        <th>{{ __('user.tue') }}</th>
                        <th>{{ __('user.wed') }}</th>
                        <th>{{ __('user.thu') }}</th>
                        <th>{{ __('user.fri') }}</th>
                        <th>{{ __('user.sat') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td scope="row" data-label="From date">
                            <div class="form-group my-3 date-picker">
                                <div class="input-group">
                                    <input type="text" class="form-control date" name="from_date" id="from_date_input_date" placeholder="FromDate">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td data-label="To date">
                            <div class="form-group my-3 date-picker">
                                <div class="input-group">
                                    <input type="text" class="form-control date" name="to_date" id="to_date_input_date" placeholder="ToDate">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>&nbsp;</td>
                        <td data-label="Sun">
                            <div class="bulk-body">
                                <input type="text" class="form-control bulk-text price_text" id="price_text_sun" name="sun" placeholder="0" onkeypress="return isNumber(event)">
                            </div>
                        </td>
                        <td data-label="Mon">
                            <div class="bulk-body">
                                <input type="text" class="form-control bulk-text price_text" id="price_text_mon" name="mon" placeholder="0" onkeypress="return isNumber(event)">
                            </div>
                        </td>
                        <td data-label="Tue">
                            <div class="bulk-body">
                                <input type="text" class="form-control bulk-text price_text" id="price_text_tue" name="tue" placeholder="0" onkeypress="return isNumber(event)">
                            </div>
                        </td>
                        <td data-label="Wed">
                            <div class="bulk-body">
                                <input type="text" class="form-control bulk-text price_text" id="price_text_wed" name="wed" placeholder="0" onkeypress="return isNumber(event)">
                            </div>
                        </td>
                        <td data-label="Thu">
                            <div class="bulk-body">
                                <input type="text" class="form-control bulk-text price_text" id="price_text_thu" name="thu" placeholder="0" onkeypress="return isNumber(event)">
                            </div>
                        </td>
                        <td data-label="Fri">
                            <div class="bulk-body">
                                <input type="text" class="form-control bulk-text price_text" id="price_text_fri" name="fri" placeholder="0" onkeypress="return isNumber(event)">
                            </div>
                        </td>
                        <td data-label="Sat">
                            <div class="bulk-body">
                                <input type="text" class="form-control bulk-text price_text" id="price_text_sat" name="sat" placeholder="0" onkeypress="return isNumber(event)">
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>

                <table class="mt-4 pro-table-pg bulk-table-pg table-hover wrapper colors" id="table_open_close">
                    <thead>
                    <tr class="ft-tr">
                        <th>{{ __('user.fromdate') }}</th>
                        <th>{{ __('user.todate') }}</th>
                        <th></th>
                        <th>{{ __('user.sun') }} <i class="fa fa-file copy-icon" aria-hidden="true"></i></th>
                        <th>{{ __('user.mon') }} <i class="fa fa-file copy-icon" aria-hidden="true"></i></th>
                        <th>{{ __('user.tue') }} <i class="fa fa-file copy-icon" aria-hidden="true"></i></th>
                        <th>{{ __('user.wed') }} <i class="fa fa-file copy-icon" aria-hidden="true"></i></th>
                        <th>{{ __('user.thu') }} <i class="fa fa-file copy-icon" aria-hidden="true"></i></th>
                        <th>{{ __('user.fri') }} <i class="fa fa-file copy-icon" aria-hidden="true"></i></th>
                        <th>{{ __('user.sat') }} <i class="fa fa-file copy-icon" aria-hidden="true"></i></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td scope="row" data-label="From date">
                            <div class="form-group my-3 date-picker">
                                <div class="input-group">
                                    <input type="text" class="form-control date" id="from_date_open_close" placeholder="FromDate">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td data-label="To date">
                            <div class="form-group my-3 date-picker">
                                <div class="input-group">
                                    <input type="text" class="form-control date" id="to_date_open_close" placeholder="ToDate">
                                    <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-th"></i>
                                    </span>
                                </div>
                            </div>
                        </td>
                        <td>&nbsp;</td>
                        <td data-label="Sun">
                            <div class="toggle-group bulk-open">
                                <input type="checkbox" name="on-off-switch" id="on_off_switch_sun" checked="" tabindex="1">
                                <label for="on_off_switch_sun">
                                    <span class="aural"></span>
                                </label>
                                <div class="onoffswitch pull-right" aria-hidden="true">
                                    <div class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Mon">
                            <div class="toggle-group bulk-open">
                                <input type="checkbox" name="on-off-switch" id="on_off_switch_mon" checked="" tabindex="1">
                                <label for="on_off_switch_mon">
                                    <span class="aural"></span>
                                </label>
                                <div class="onoffswitch pull-right" aria-hidden="true">
                                    <div class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Tue">
                            <div class="toggle-group bulk-open">
                                <input type="checkbox" name="on-off-switch" id="on_off_switch_tue" checked="" tabindex="1">
                                <label for="on_off_switch_tue">
                                    <span class="aural"></span>
                                </label>
                                <div class="onoffswitch pull-right" aria-hidden="true">
                                    <div class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Wed">
                            <div class="toggle-group bulk-open">
                                <input type="checkbox" name="on-off-switch" id="on_off_switch_wed" checked="" tabindex="1">
                                <label for="on_off_switch_wed">
                                    <span class="aural"></span>
                                </label>
                                <div class="onoffswitch pull-right" aria-hidden="true">
                                    <div class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Thu">
                            <div class="toggle-group bulk-open">
                                <input type="checkbox" name="on-off-switch" id="on_off_switch_thu" checked="" tabindex="1">
                                <label for="on_off_switch_thu">
                                    <span class="aural"></span>
                                </label>
                                <div class="onoffswitch pull-right" aria-hidden="true">
                                    <div class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Fri">
                            <div class="toggle-group bulk-open">
                                <input type="checkbox" name="on-off-switch" id="on_off_switch_fri" checked="" tabindex="1">
                                <label for="on_off_switch_fri">
                                    <span class="aural"></span>
                                </label>
                                <div class="onoffswitch pull-right" aria-hidden="true">
                                    <div class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td data-label="Sat">
                            <div class="toggle-group bulk-open">
                                <input type="checkbox" name="on-off-switch" id="on_off_switch_sat" checked="" tabindex="1">
                                <label for="on_off_switch_sat">
                                    <span class="aural"></span>
                                </label>
                                <div class="onoffswitch pull-right" aria-hidden="true">
                                    <div class="onoffswitch-label">
                                        <div class="onoffswitch-inner"></div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-save" id="btn_save">{{ __('user.save') }}</button>
                <!--<button type="button" class="btn btn-default btn-close" data-dismiss="modal">Cancel</button>-->

                <button type="button" id="btn_success" data-toggle="modal" data-target="#model_success" aria-hidden="true" style="display: none;">{{ __('user.success') }}</button>
            </div>
        </form>


        <div class="delete-modal-main">
            <div class="modal fade" id="model_success">
                <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center">
                            <div class="couponcode">
                                <img src="../images/3-layer.svg" alt="Circle Image" class="img-raised rounded-circle img-fluid">
                            </div>
                            <div class="promocodeapplied2 mt-3">
                                <h4 class="delete-sucess">{{ __('user.savesuccessfully') }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection

@section('footer_content')

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/locales/bootstrap-datepicker.es.min.js"></script>

    <script src="{{url('/')}}/plugins/loadingoverlay/loadingoverlay.min.js"></script>
    <script src="{{url('/')}}/plugins/loadingoverlay/loadingoverlay_progress.min.js"></script>

    <script type="text/javascript">
        var chosenCall = '';
        var lodderShow = '';
        var saveBulkCalendarData = '';

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

                $('#select_update_type, #select_room_type, #select_system_mapping').val('').trigger("chosen:updated");

                $('#from_date_input_date').val('');
                $('#to_date_input_date').val('');

                $('#from_date_open_close').val('');
                $('#to_date_open_close').val('');
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

            $('.date').datepicker({
                weekStart: 0,
                todayBtn: "linked",
                language: "en",
                orientation: "bottom auto",
                keyboardNavigation: false,
                autoclose: true,
                format: 'yyyy-mm-dd',
                startDate: '-0m'
            });

            function process(date) {
                var parts = date.split("-");
                return new Date(parts[2], parts[1] - 1, parts[0]);
            }

            function changeEndDate(from_date_input_date, to_date_input_date) {

                var fromDate = $('#' + from_date_input_date).val();

                var toDate = $('#' + to_date_input_date).val();

                var fromDate_p = process(fromDate);
                var toDate_p = process(toDate);

                if ((fromDate_p > toDate_p) || (toDate == '')) {

                    var parts = fromDate.split('-');

                    var dd = ("0" + parts[2]).slice(-2);
                    var mm = ("0" + (parts[1])).slice(-2);
                    var y = parts[0];
                    var fromDate_new = mm + '/' + dd + '/' + y;

                    var date = new Date(fromDate_new);
                    var newDate = new Date(date);

                    newDate.setDate(newDate.getDate());

                    var dd = newDate.getDate();
                    var mm = (newDate.getMonth() + 1);
                    var y = newDate.getFullYear();

                    dd = ("0" + dd).slice(-2);
                    mm = ("0" + mm).slice(-2);

                    var someFormattedDate = y + '-' + mm + '-' + dd;

                    $('#' + to_date_input_date).val(someFormattedDate);

                }

                $('#' + to_date_input_date).datepicker("update");
            }

            $('#from_date_input_date').datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function (e) {
                changeEndDate('from_date_input_date', 'to_date_input_date');
            });

            $('#to_date_input_date').datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function (e) {
                changeEndDate('from_date_input_date', 'to_date_input_date');
            });

            $('#from_date_open_close').datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function (e) {
                changeEndDate('from_date_open_close', 'to_date_open_close');
            });

            $('#to_date_open_close').datepicker({
                format: 'yyyy-mm-dd'
            }).on('changeDate', function (e) {
                changeEndDate('from_date_open_close', 'to_date_open_close');
            });


            $('#price_text_sun').click(function () {

                $(this).val('');

                $(this).removeClass("text_int");
                $(this).removeClass("text_float");

                $(this).on('keyup', function () {

                    $('.price_text').val($(this).val());
                });
            });


            $('#on_off_switch_sun').click(function () {
            
                
                    if ($("#on_off_switch_sun").prop("checked") == true) {

                        $("#on_off_switch_sun").prop("checked", true);
                        $("#on_off_switch_mon").prop("checked", true);
                        $("#on_off_switch_tue").prop("checked", true);
                        $("#on_off_switch_wed").prop("checked", true);
                        $("#on_off_switch_thu").prop("checked", true);
                        $("#on_off_switch_fri").prop("checked", true);
                        $("#on_off_switch_sat").prop("checked", true);

                    } else {

                        $("#on_off_switch_sun").prop("checked", false);
                        $("#on_off_switch_mon").prop("checked", false);
                        $("#on_off_switch_tue").prop("checked", false);
                        $("#on_off_switch_wed").prop("checked", false);
                        $("#on_off_switch_thu").prop("checked", false);
                        $("#on_off_switch_fri").prop("checked", false);
                        $("#on_off_switch_sat").prop("checked", false);
                    }
                
            });

            function hideData() {
                $('#div_room_type').hide();
                $('#div_system_mapping').hide();

                $('#table_input_data').hide();
                $('#table_open_close').hide();
            }

            hideData();

            function addInputMask() {

                $('.price_text').each(function () {

                    $(this).val("");

                    $(this).removeClass("text_int");
                    $(this).removeClass("text_float");
                });

                var select_update_type = $('#select_update_type').val();

                if ((select_update_type == "inventory") || (select_update_type == "minstay") || (select_update_type == "maxstay")) {

                    $('.price_text').each(function () {
                        $(this).addClass("text_int");
                    });

                    /*callIntegerInputMask();*/

                    $('.text_int').each(function () {
                        $(this).inputmask({
                            'alias': 'integer',
                            'min': 0,
                            'allowMinus': 'false',
                            'allowPlus': 'false',
                            'rightAlign': false,
                        });
                    });

                } else {

                    $('.price_text').each(function () {
                        $(this).addClass("text_float");
                    });

                    /*callFloatInputMask();*/

                    $('.text_float').each(function () {
                        $(this).inputmask({
                            'alias': 'decimal',
                            'min': 0.0,
                            'allowMinus': 'false',
                            'allowPlus': 'false',
                            'rightAlign': false,
                            'autoGroup': true,
                        });
                    });
                }
            }

            addInputMask();

            var ar_update_type_price = [];
            ar_update_type_price.push('inventory');
            ar_update_type_price.push('rate');
            ar_update_type_price.push('single_rate');
            ar_update_type_price.push('ext_adult1_rate');
            ar_update_type_price.push('ext_adult2_rate');
            ar_update_type_price.push('ext_adult3_rate');
            ar_update_type_price.push('ext_adult4_rate');
            ar_update_type_price.push('child_age1_rate');
            ar_update_type_price.push('child_age2_rate');
            ar_update_type_price.push('child_age3_rate');
            ar_update_type_price.push('minstay');
            ar_update_type_price.push('maxstay');

            $('#select_update_type').change(function (v) {

                hideData();

                addInputMask();

                var select_update_type = $(this).val();

                var isExists = 0;
                isExists = jQuery.inArray(select_update_type, ar_update_type_price);
                if (isExists >= 0) {

                    if (select_update_type == "inventory") {

                        $('#div_room_type').show();

                    } else {

                        $('#div_system_mapping').show();
                    }
                    $('#table_input_data').show();

                } else {

                    $('#div_system_mapping').show();
                    $('#table_open_close').show();
                }
            });

            saveBulkCalendarData = function saveBulkCalendarData() {

                var $from_date_input_date = $('#from_date_input_date').val();
                var $to_date_input_date = $('#to_date_input_date').val();

                var $from_date_open_close = $('#from_date_open_close').val();
                var $to_date_open_close = $('#to_date_open_close').val();

                var select_update_type = $('#select_update_type').val();

                var main_data = {};
                var update_inventory_data = [];
                var update_restriction_data = [];


                var pass = 0;

                if (select_update_type != "") {

                    if (select_update_type == "inventory") {

                        var room_type_id = $('#select_room_type').val();

                        if (room_type_id != "") {

                            if (($from_date_input_date != '') && ($to_date_input_date != '')) {

                                var value_data = $('#price_text_sun').val();
                                var days_vals = {};
                                days_vals['sun'] = $('#price_text_sun').val();
                                days_vals['mon'] = $('#price_text_mon').val();
                                days_vals['tue'] = $('#price_text_tue').val();
                                days_vals['wed'] = $('#price_text_wed').val();
                                days_vals['thu'] = $('#price_text_thu').val();
                                days_vals['fri'] = $('#price_text_fri').val();
                                days_vals['sat'] = $('#price_text_sat').val();

                                if (value_data != "") {

                                    var raw_data = {};
                                    raw_data['update_type'] = select_update_type;
                                    raw_data['room_type_id'] = room_type_id;
                                    raw_data['from_date'] = $from_date_input_date;
                                    raw_data['to_date'] = $to_date_input_date;
                                    raw_data['value'] = value_data;
                                    raw_data['days_vals'] = days_vals;
                                    
                                    update_inventory_data.push(raw_data);

                                    pass = 1;
                                }
                            }
                        }
                    } else {

                        var rate_plan_id = $('#select_system_mapping').val();

                        if (rate_plan_id != "") {

                            var from_date = "";
                            var to_date = "";

                            var value_data = "";
                            var days_vals = {};
                            if (select_update_type == "closed" || select_update_type == "cta" || select_update_type == "ctd") {

                                value_data = "close";
                                if ($("#on_off_switch_sun").prop("checked") == true) {
                                    value_data = "open";
                                }
                                days_vals['sun'] = value_data;

                                value_data = "close";
                                if ($("#on_off_switch_mon").prop("checked") == true) {
                                    value_data = "open";
                                }
                                days_vals['mon'] = value_data;

                                value_data = "close";
                                if ($("#on_off_switch_tue").prop("checked") == true) {
                                    value_data = "open";
                                }
                                days_vals['tue'] = value_data;

                                value_data = "close";
                                if ($("#on_off_switch_wed").prop("checked") == true) {
                                    value_data = "open";
                                }
                                days_vals['wed'] = value_data;

                                value_data = "close";
                                if ($("#on_off_switch_thu").prop("checked") == true) {
                                    value_data = "open";
                                }
                                days_vals['thu'] = value_data;

                                value_data = "close";
                                if ($("#on_off_switch_fri").prop("checked") == true) {
                                    value_data = "open";
                                }
                                days_vals['fri'] = value_data;

                                value_data = "close";
                                if ($("#on_off_switch_sat").prop("checked") == true) {
                                    value_data = "open";
                                }
                                days_vals['sat'] = value_data;

                                from_date = $from_date_open_close;
                                to_date = $to_date_open_close;

                            } else {

                                days_vals['sun'] = $('#price_text_sun').val();
                                days_vals['mon'] = $('#price_text_mon').val();
                                days_vals['tue'] = $('#price_text_tue').val();
                                days_vals['wed'] = $('#price_text_wed').val();
                                days_vals['thu'] = $('#price_text_thu').val();
                                days_vals['fri'] = $('#price_text_fri').val();
                                days_vals['sat'] = $('#price_text_sat').val();

                                value_data = $('#price_text_sun').val();
                                from_date = $from_date_input_date;
                                to_date = $to_date_input_date;
                            }

                            if ((from_date != '') && (to_date != '')) {

                                if (value_data != "") {

                                    var raw_data = {};
                                    raw_data['update_type'] = select_update_type;
                                    raw_data['rate_plan_id'] = rate_plan_id;
                                    raw_data['from_date'] = from_date;
                                    raw_data['to_date'] = to_date;
                                    raw_data['value'] = value_data;
                                    raw_data['days_vals'] = days_vals;

                                    update_restriction_data.push(raw_data);

                                    pass = 1;
                                }
                            }
                        }
                    }

                    if (pass == 1) {

                        main_data = {};
                        main_data['inventory'] = update_inventory_data;
                        main_data['restriction'] = update_restriction_data;

                        var urlData = "{!! route('admin.hotel.manage.bulk.calendar.data') !!}";

                        lodderShow("show");

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
                                lodderShow("hide");
                            },
                            success: function (result) {

                                lodderShow("hide");

                                if (result == "success") {

                                    $('#btn_success').trigger("click");
                                } else {
                                    alert("Something went to wrong!");
                                }
                            }
                        });
                    }
                }
            };

            $('#btn_save').click(function () {
                saveBulkCalendarData();
            });
        });
    </script>
@endsection