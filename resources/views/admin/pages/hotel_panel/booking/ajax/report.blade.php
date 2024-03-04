@if(isset($resultData) && !empty($resultData))
    @foreach($resultData as $key => $value)
        <tr>
            @php
                $room_type=array();
                if(isset($value->selected_room_type) && $value->selected_room_type!=""){
                    $roomtype=json_decode($value->selected_room_type);
                    if(!empty($roomtype)){
                          foreach ($roomtype as $key => $roomset) {
                             if(isset($roomset->room_type->name)){
                                $room_type[]=$roomset->room_type->name;
                             }
                          }
                    }
                }
                $htmlRoom="";
                if(isset($room_type) && !empty($room_type)){
                    foreach ($room_type as $key => $room_name) {
                        $htmlRoom.='<label class="label label-success">'.$room_name.'</label> <br>';
                    }
                }
            @endphp
            <td scope="row" data-label="ID">{!! @$value->id !!}</td>
            <td data-label="Referer">{!! @$value->referrer ?? "N/A" !!}</td>
            <td data-label="CHECK IN">{!! @$value->check_in_date !!}</td>
            <td data-label="CHECK OUT">{!! @$value->check_out_date !!}</td>
            <td data-label="Audult">{!! @$value->no_of_adult !!}</td>
            <td data-label="Children">{!! @$value->no_of_child !!}</td>
            <td data-label="Roomtype">{!! $htmlRoom !!}</td>
            <td data-label="Phone">{!! @$value->phone !!}</td>
            <td data-label="Note">{!! @$value->note ?? "N/A" !!}</td>
            <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                    <a href="{!! route('admin.hotel.detail.booking.data', ['id' => @$value->id]) !!}" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.view') }}</div>
                        <i class="fa fa-eye tn-warning eye-view"></i>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@endif
