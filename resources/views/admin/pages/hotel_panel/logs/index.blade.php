@extends('admin.layout.default')

@section('title', 'Logs List')

@section('overWriteCSS')
    <style>
        .datepicker {
            text-align: center;
        }
    </style>
@stop

@section('content')
    <section class="property-wrapper mt-4">

        <h2>{{ __('user.logslist') }}</h2>
        <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
            <div class="d-flex position-relative booking-wrapper align-items-center">
            </div>
        </div>

        <div class="container-fluid">

            @include('flash-message')

            <div class="row">

                <div class="col-sm-3">
                    <div class="form-group my-3 date-picker">
                        <label class="mb-0">{{ __('user.date') }} :</label>
                        <div class="input-group pull-left mr-2" style="width: 48%">
                            <input type="text" class="form-control date" name="from_date" id="from_date_input_date" placeholder="From Date">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-th"></i>
                            </span>
                        </div>
                        <div class="input-group pull-left" style="width: 48%">
                            <input type="text" class="form-control date" name="to_date" id="to_date_input_date" placeholder="To Date">
                            <span class="input-group-addon">
                                <i class="glyphicon glyphicon-th"></i>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group my-3 date-picker">
                        <label class="mb-0">{{ __('user.searchtype') }} :</label>
                        <select class="js-states form-control chosen-select single" name="search_type" id="select_search_type" data-placeholder="Select search type">
                            <option value="inventory">{{ __('user.inventory') }}</option>
                            <option value="restriction">{{ __('user.other') }}</option>
                        </select>
                    </div>
                </div>

                <div class="col-sm-3">
                    <div class="form-group my-3" id="div_room_type">
                        <label class="m-0">{{ __('user.roomtype') }} :</label><br>
                        <select class="js-states form-control chosen-select single" name="room_type" id="select_room_type" data-placeholder="Select room type">
                            @if(isset($roomTypeData) && !empty($roomTypeData))
                                @foreach($roomTypeData as $key => $value)
                                    <option value="{{$value->id}}">{{ ucfirst($value->name) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="form-group my-3" id="div_system_mapping">
                        <label class="m-0">{{ __('user.systemmapping') }} :</label><br>
                        <select class="js-states form-control chosen-select single" name="system_mapping" id="select_system_mapping" data-placeholder="Select rate plan">
                            <option value="" selected>{{ __('user.all') }}</option>
                            @if(isset($ratePlanData) && !empty($ratePlanData))
                                @foreach($ratePlanData as $key => $value)
                                    <option value="{{$value->id}}">{{ ucfirst($value->name) }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-sm-2">
                    <div class="form-group my-2">
                        <label class="mb-0 w-100 d-block"><br/></label>
                        <button type="button" class="btn btn-default btn-save" id="btn_search">{{ __('user.search') }}</button>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table class="mt-4 pro-table-pg table-hover wrapper" id="table_logs">
                            <thead>
                            <tr class="ft-tr">
                                <th style="min-width:250px;">{{ __('user.lastupdate') }}</th>
                                <th style="min-width:150px;">{{ __('user.date') }}</th>
                                <th style="min-width:150px;">{{ __('user.logsfrom') }}</th>
                                <th style="min-width:150px;">{{ __('user.inventory') }}</th>
                                <th style="min-width:150px;">{{ __('user.rate') }}</th>
                                <th style="min-width:150px;">{{ __('user.closed') }}</th>
                                <th style="min-width:150px;">{{ __('user.minstay') }}</th>
                                <th style="min-width:150px;">{{ __('user.maxstay') }}</th>
                                <th style="min-width:250px;">Ip</th>
                                <th>{{ __('user.action') }}</th>
                            </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
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

                /*$('#select_update_type, #select_room_type, #select_system_mapping').val('').trigger("chosen:updated");*/

                $('#from_date_input_date').val('');
                $('#to_date_input_date').val('');
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

            function hideDivData() {

                $('#div_room_type').hide();
                $('#div_system_mapping').hide();

                var select_search_type = $('#select_search_type').val();
                if (select_search_type == "inventory") {

                    $('#div_room_type').show();
                    $('#div_system_mapping').hide();
                } else {
                    $('#div_room_type').hide();
                    $('#div_system_mapping').show();
                }
            }

            hideDivData();

            $('#select_search_type').change(function () {

                hideDivData();
            });


            $('#btn_search').click(function () {

                var $from_date_input_date = $('#from_date_input_date').val();
                var $to_date_input_date = $('#to_date_input_date').val();

                var select_search_type = $('#select_search_type').val();

                var $room_type_id = 0;
                $room_type_id = $('#select_room_type').val();

                var $rate_plan_id = 0;
                $rate_plan_id = $('#select_system_mapping').val();

                if (select_search_type == "inventory") {

                    $rate_plan_id = 0;

                } else {
                    $room_type_id = 0;
                }

                if (($from_date_input_date != '') && ($to_date_input_date != '')) {

                    var urlData = "{!! route('admin.hotel.display.logs.data') !!}";

                    lodderShow("show");

                    $.ajax
                    ({
                        type: "POST",
                        url: urlData,
                        data: {
                            _token: tokenData,
                            data_from_date_input_date: $from_date_input_date,
                            data_to_date_input_date: $to_date_input_date,
                            data_room_type_id: $room_type_id,
                            data_rate_plan_id: $rate_plan_id,
                        },
                        cache: false,
                        error: function (jqXHR, textStatus, errorThrown) {

                            console.log("error");
                            lodderShow("hide");
                        },
                        success: function (result) {

                            lodderShow("hide");

                            $('#table_logs tbody').html(result);
                        }
                    });
                }
            });
        });
    </script>
@endsection
