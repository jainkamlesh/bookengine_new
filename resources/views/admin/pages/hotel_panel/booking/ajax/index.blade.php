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
        <tr>
            <td scope="row" data-label="ID">{!! $value->id !!}</td>
            <td data-label="STATUS">
                @if( $value->booking_status == 1 )
                <label class="label label-success"><i class="fa fa-check"></i></label>
                @elseif( $value->booking_status == 2 )
                <label class="label label-danger"><i class="fa fa-close"></i></label>
                @else
                <label class="label label-primary"><i class="fa fa-exclamation"></i></label>
                @endif
            </td>
            <td data-label="CREATE DATE">{!! $value->create_date !!}</td>
            <td data-label="confirm date">{!! $value->confirm_date ?? "N/A" !!}</td>
            <td data-label="referrer">{!! $value->referrer !!}</td>
            <td data-label="email">{!! $value->email !!}</td>
            <td data-label="phone">{!! $value->phone !!}</td>
            {{-- <td data-label="NAME">{!! $value->first_name !!}</td>
            <td data-label="NAME">{!! $value->last_name !!}</td> --}}
            <td data-label="CHECK IN">{!! $value->check_in_date !!}</td>
            <td data-label="CHECK OUT">{!! $value->check_out_date !!}</td>
            <td data-label="Roomtype">{!! $htmlRoom !!}</td>
            <td data-label="deposit amount">{!! $hotelDetail->currency_symbol !!}{!! $value->deposit_amount ?? 0 !!}</td>
            <td data-label="gross amount">{!! $hotelDetail->currency_symbol !!}{!! $value->gross_amount ?? 0 !!}</td>
            <td data-label="paid">
                <label class="switch">
                    <input onchange="change_status('paid','{{$value->id}}')" value="{{ $value->id }}" type="checkbox" <?php if($value->paid == 1) echo "checked";?> >
                    <span class="slider round"></span>
                </label>
            </td>
            <td data-label="Called">
                <label class="switch">
                    <input onchange="change_status('called','{{$value->id}}')" value="{{ $value->id }}" type="checkbox" <?php if($value->is_called == 1) echo "checked";?> >
                    <span class="slider round"></span>
                </label>
            </td>
            <td data-label="WhatsappTemplate">
                   <div class="dropdown">
                    <button type="button" class="btn btn-default btn-save dropdown-toggle" data-toggle="dropdown">
                        Whatsapp
                    </button>
                    <div class="dropdown-menu">
                      @foreach ($whatsapptmps as $key => $whatsapptmp)
                        <a class="dropdown-item" href="https://wa.me/+91{{$value->phone}}?text={{$whatsapptmp->message}}." target="_blank">{{$whatsapptmp->name}}</a>
                      @endforeach
                    </div>
                  </div>
            </td>
            <td data-label="Sent">
                <label class="switch">
                    <input onchange="change_status('sent','{{$value->id}}')" value="{{ $value->id }}" type="checkbox" <?php if($value->is_sent == 1) echo "checked";?> >
                    <span class="slider round"></span>
                </label>
            </td>
            <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                    <a href="{!! route('admin.hotel.detail.booking.data', ['id' => $value->id]) !!}" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.view') }}</div>
                        <i class="fa fa-eye btn-success eye-view"></i>
                    </a>
                    <a href="{!! route('admin.hotel.edit.booking.data', ['id' => $value->id]) !!}" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.edit') }}</div>
                        <i class="fa fa-edit btn-success eye-view"></i>
                    </a>

                    <a href="javascript:void(0)" onclick="delete_reservation('{{$value->id}}')" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.view') }}</div>
                        <i class="fa fa-trash btn-success eye-view"></i>
                    </a>

                    <a href="javascript:void(0)" onclick="duplicat_reservation('{{$value->id}}')" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.duplicate') }}</div>
                        <i class="fa fa-copy btn-success eye-view"></i>
                    </a>

                    {{-- <a href="javascript:void(0)" class="icon edit edit-icon">
                        <div class="tooltip">{{ __('user.view') }}</div>
                            <input type="color" name="" class="color-picker" id="" value="red">
                    </a> --}}
                        <!-- <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                            <button class="repost-icon"><i class="fa fa-cloud-download"></i> Re-Post</button>
                        </div> -->
                </div>
            </td>
        </tr>
    @endforeach
@endif
