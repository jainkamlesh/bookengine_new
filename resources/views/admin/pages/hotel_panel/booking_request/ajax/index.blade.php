@if(isset($resultData) && !empty($resultData))
    @foreach($resultData as $key => $value)
        <tr>
            <td scope="row" data-label="ID">{!! @$value->id !!}</td>
            <td data-label="Referer">{!! @$value->referrer !!}</td>
            <td data-label="phone">{!! @$value->phone !!}</td>
            <td data-label="email">{!! @$value->email !!}</td>
            <td data-label="check_in">{!! @$value->check_in !!}</td>
            <td data-label="check_out">{!! @$value->check_out !!}</td>
            <td data-label="adult">{!! @$value->adult !!}</td>
            <td data-label="children">{!! @$value->children !!}</td>
            <td data-label="children">{!! @$value->note !!}</td>
            <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                    <a href="" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.view') }}</div>
                        <i class="fa fa-eye btn-success eye-view"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@endif
