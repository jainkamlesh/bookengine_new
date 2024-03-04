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

        <h2>Logs Date Details - {!! $resultData->date !!}</h2>
        <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
            <div class="d-flex position-relative booking-wrapper align-items-center">
            </div>
        </div>

        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-12">
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
                        </tr>
                        </thead>
                        <tbody>
                        @if(isset($resultData) && !empty($resultData))
                            <?php
                            $last_update = $resultData->created_at;
                            if (!empty($resultData->updated_at)) {

                                $last_update = $resultData->updated_at;
                            }

                            $ar_value = array();
                            $value = array();
                            if (!empty($resultData->value)) {
                                $ar_value = json_decode($resultData->value, true);
                            }

                            if (!empty($ar_value)) {
                                $ar_value = array_reverse($ar_value, true);
                            }
                            ?>
                            @if(isset($ar_value) && !empty($ar_value))
                                @foreach($ar_value as $key => $value)
                                    <?php
                                    $td_logs_from = "";
                                    $td_availability = "";
                                    $td_rate = "";
                                    $td_closed = "";
                                    $td_min_stay = "";
                                    $td_max_stay = "";
                                    $td_ip_address = "";
                                    if (!empty($value)) {

                                        if (isset($value['updated_from']) && !empty($value['updated_from'])) {
                                            $td_logs_from = $value['updated_from'];
                                        }

                                        if (isset($value['ip_address']) && !empty($value['ip_address'])) {
                                            $td_ip_address = $value['ip_address'];
                                        }

                                        if (isset($value['update_type']) && !empty($value['update_type'])) {

                                            $update_type = $value['update_type'];

                                            $old_value = "";
                                            $new_value = "";

                                            if (isset($value['old_value'])) {
                                                $old_value = $value['old_value'];
                                            }

                                            if (isset($value['new_value'])) {
                                                $new_value = $value['new_value'];
                                            }

                                            if ($update_type == "availability") {

                                                $td_availability = $old_value . " / " . $new_value;
                                            }

                                            if ($update_type == "rate") {

                                                $td_rate = $old_value . " / " . $new_value;
                                            }

                                            if ($update_type == "closed") {

                                                if ($old_value == 1) {
                                                    $old_value = "close";
                                                } else {
                                                    $old_value = "open";
                                                }

                                                if ($new_value == 1) {
                                                    $new_value = "close";
                                                } else {
                                                    $new_value = "open";
                                                }

                                                $td_rate = $old_value . " / " . $new_value;
                                            }

                                            if ($update_type == "minstay") {

                                                $td_min_stay = $old_value . " / " . $new_value;
                                            }

                                            if ($update_type == "maxstay") {

                                                $td_max_stay = $old_value . " / " . $new_value;
                                            }
                                        }
                                    }
                                    ?>
                                    <tr>
                                        <td data-for="last_update">{!! $last_update !!}</td>
                                        <td data-for="date">{!! $resultData->date !!}</td>
                                        <td data-for="logs_from">{!! $td_logs_from !!}</td>
                                        <td data-for="inventory">{!! $td_availability !!}</td>
                                        <td data-for="rate">{!! $td_rate !!}</td>
                                        <td data-for="closed">{!! $td_closed !!}</td>
                                        <td data-for="min_stay">{!! $td_min_stay !!}</td>
                                        <td data-for="max_stay">{!! $td_max_stay !!}</td>
                                        <td data-for="ip_address">{!! $td_ip_address !!}</td>
                                    </tr>
                                @endforeach
                            @endif
                        @endif
                        </tbody>
                    </table>
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

@endsection
