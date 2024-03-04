@if(isset($resultData) && !empty($resultData))
    @foreach($resultData as $key => $value)
        <?php

        $last_update = $value->created_at;
        if (!empty($value->updated_at)) {

            $last_update = $value->updated_at;
        }

        $ar_value = array();
        $ar_last_value = array();
        if (!empty($value->value)) {
            $ar_value = json_decode($value->value, true);
        }

        if (!empty($ar_value)) {
            $total = count($ar_value);

            $ar_last_value = $ar_value[($total - 1)];
        }

        $td_logs_from = "";
        $td_availability = "";
        $td_rate = "";
        $td_closed = "";
        $td_min_stay = "";
        $td_max_stay = "";
        $td_ip_address = "";
        if (!empty($ar_last_value)) {

            if (isset($ar_last_value['updated_from']) && !empty($ar_last_value['updated_from'])) {
                $td_logs_from = $ar_last_value['updated_from'];
            }

            if (isset($ar_last_value['ip_address']) && !empty($ar_last_value['ip_address'])) {
                $td_ip_address = $ar_last_value['ip_address'];
            }

            if (isset($ar_last_value['update_type']) && !empty($ar_last_value['update_type'])) {

                $update_type = $ar_last_value['update_type'];

                $old_value = "";
                $new_value = "";

                if (isset($ar_last_value['old_value'])) {
                    $old_value = $ar_last_value['old_value'];
                }

                if (isset($ar_last_value['new_value'])) {
                    $new_value = $ar_last_value['new_value'];
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
        $view_url = route('admin.hotel.logs.details', ['id' => base64_encode($value->id)])
        ?>
        <tr>
            <td data-for="last_update">{!! $last_update !!}</td>
            <td data-for="date">{!! $value->date !!}</td>
            <td data-for="logs_from">{!! $td_logs_from !!}</td>
            <td data-for="inventory">{!! $td_availability !!}</td>
            <td data-for="rate">{!! $td_rate !!}</td>
            <td data-for="closed">{!! $td_closed !!}</td>
            <td data-for="min_stay">{!! $td_min_stay !!}</td>
            <td data-for="max_stay">{!! $td_max_stay !!}</td>
            <td data-for="ip_address">{!! $td_ip_address !!}</td>
            <td data-for="action" style="text-align: center">
                <a href="{!! $view_url !!}" target="_blank"><i class="fa fa-eye"></i></a>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td rowspan="10">{{ __('user.norecordfound') }}</td>
    </tr>
@endif