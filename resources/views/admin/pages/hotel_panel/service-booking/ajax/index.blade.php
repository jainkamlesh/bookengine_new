@if(isset($resultData) && !empty($resultData))
    @foreach($resultData as $key => $value)
        <?php
        $ar_name = array();
        if (isset($value->first_name) && !empty($value->first_name)) {
            array_push($ar_name, $value->first_name);
        }

        if (isset($value->last_name) && !empty($value->last_name)) {
            array_push($ar_name, $value->last_name);
        }
        ?>
        <tr>
            <td scope="row" data-label="ID">{!! $value->id !!}</td>
            <td data-label="STATUS">
                @if( $value->booking_status == 1 )
                <label class="label label-success">{{ __('user.confirm') }}</label>
                @elseif( $value->booking_status == 2 )
                <label class="label label-danger">{{ __('user.cancel') }}</label>
                @endif
            </td>
            <td data-label="CREATE DATE">{!! $value->create_date !!}</td>
            <td data-label="NAME">{!! $value->first_name !!}</td>
            <td data-label="NAME">{!! $value->last_name !!}</td>
            <td data-label="CHECK IN">{!! $value->email !!}</td>
            <td data-label="CHECK OUT">{!! $value->phone !!}</td>
            <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                    <a href="{!! route('admin.service.detail.booking.data', ['id' => $value->id]) !!}" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.view') }}</div>
                        <i class="fa fa-eye btn-success eye-view"></i>
                    </a>
                        <!-- <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                            <button class="repost-icon"><i class="fa fa-cloud-download"></i> Re-Post</button>
                        </div> -->
                </div>
            </td>
        </tr>
    @endforeach
@endif