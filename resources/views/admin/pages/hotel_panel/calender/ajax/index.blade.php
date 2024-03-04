@if($roomTypeCnt > 0)
    <?php $no = 2; ?>
    @foreach($roomType as $key => $value)
        <?php
        $ratePlan = \App\Models\RatePlan::join('room_types', 'rate_plans.room_type_id', '=', 'room_types.id')
            ->where('rate_plans.hotel_id', $hotel_id)
            ->where(function ($query) use ($value_rates_plan, $value) {
                if (!empty($value_rates_plan)) {
                    $query->where('rate_plans.id', $value_rates_plan);
                }

                if (!empty($value)) {
                    $query->where('rate_plans.room_type_id', $value->id);
                }

            })->orderBy('rate_plans.id', 'ASC')->select('rate_plans.*')->get();

        $ar_defaultRatePlanData = array();
        if (isset($ratePlan) && !empty($ratePlan)) {

            foreach ($ratePlan as $a_key => $a_value) {

                $rp_id = $a_value->id;
                $rp_room_type_id = $a_value->room_type_id;
                $rp_rate_type_id = $a_value->rate_type_id;

                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['room_price'] = $a_value->room_price;

                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['min_nights'] = $a_value->min_nights;
                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['max_nights'] = $a_value->max_nights;

                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['single_stay'] = $a_value->single_stay;
                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['single_price'] = $a_value->single_price;

                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['ext_adult1_rate'] = $a_value->ext_adult1_rate;
                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['ext_adult2_rate'] = $a_value->ext_adult2_rate;
                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['ext_adult3_rate'] = $a_value->ext_adult3_rate;
                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['ext_adult4_rate'] = $a_value->ext_adult4_rate;

                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['child_age1_rate'] = $a_value->child_age1_rate;
                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['child_age2_rate'] = $a_value->child_age2_rate;
                $ar_defaultRatePlanData[$rp_id][$rp_room_type_id]['child_age3_rate'] = $a_value->child_age3_rate;
            }
        }
        ?>
        <div class="row calenadr-main-sec m-0 mt-3 mb-5">
            <div class="col-lg-2 p-0 per-cal-col">
                <div class="upadate-box">
                    <button type="button" id="btn_update_all">{{ __('user.updateall') }}</button>
                    {{--<i class="fa fa-angle-double-left" aria-hidden="true"></i> <i class="fa fa-angle-double-right" aria-hidden="true"></i>--}}
                </div>
                <!-- single room start-->
                <div class="room-div room-ft-div" data-original-title="Single room( Room Type Id : {{$value->id}})" data-placement="top"
                     data-toggle="tooltip" data-room-title="{{$value->name}}">
                    <h5><i class="fa fa-bed" aria-hidden="true"></i> {{$value->name}}</h5>
                </div>
                {{--RatePlan Data Display--}}
                @foreach($ratePlan as $inner_key => $inner_val)
                    <div class="room-div rateplan_div">
                        <h5 class="sub-cnt">
                            <i class="fa fa-pie-chart" data-original-title="single airbnb bb( Rate Plan Id : 152)" data-placement="top" data-toggle="tooltip"></i>
                            {{$inner_val->name}}
                        </h5>
                    </div>
                    <div class="room-div">
                        <button class="btn btn-xs btn-primary btn_calendar_extra_price" data-id="{{ $inner_val->id }}"
                                style="font-size: 10px; background-color: #FF7C48;color: #ffffff;border:none;">{{ __('user.extraprice') }}/restr</button>
                    </div>
                    <div class="room-div">
                        <h5 class="sub-cnt"><i class="fa fa-money" aria-hidden="true"></i>{{ __('user.price') }}</h5>
                    </div>
                    <div class="room-div div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }}">
                        <h5 class="sub-cnt"><i class="fa fa-money" aria-hidden="true"></i>{{ __('user.singleprice') }}</h5>
                    </div>
                    @for($a_no=1; $a_no<=4; $a_no++)
                        <div class="room-div div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }}">
                            <h5 class="sub-cnt"><i class="fa fa-money" aria-hidden="true"></i>{{ __('user.extraadult') }} {!! $a_no !!}</h5>
                        </div>
                    @endfor
                    @for($a_no=1; $a_no<=3; $a_no++)
                        <div class="room-div div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }}">
                            <h5 class="sub-cnt"><i class="fa fa-money" aria-hidden="true"></i>{{ __('user.childage') }}{!! $a_no !!} {{ __('user.rate') }}</h5>
                        </div>
                    @endfor
                    <div class="room-div">
                        <h5 class="sub-cnt"><i class="fa fa-superpowers" aria-hidden="true"></i>{{ __('user.minstay') }}</h5>
                    </div>
                    <div class="room-div div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }}">
                        <h5 class="sub-cnt"><i class="fa fa-cube" aria-hidden="true"></i>{{ __('user.maxstay') }}</h5>
                    </div>
                    <div class="room-div div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }}">
                        <h5 class="sub-cnt"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>{{ __('user.cta') }}</h5>
                    </div>
                    <div class="room-div div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }}">
                        <h5 class="sub-cnt"><i class="fa fa-dot-circle-o" aria-hidden="true"></i>{{ __('user.ctd') }}</h5>
                    </div>
                @endforeach
            </div>
            <div class="col-lg-10 p-0 per-cal-col-2">
                <div class="m-0 div_slid_care" id="care_{!! $no !!}">
                    <div class="carousel-item active h-100">
                        <div class="d-flex-01 ft-week">
                            @for ($i = 0; $i < 31; $i++)
                                <?php
                                $new_set_global_date = "";
                                /*$new_set_global_date = "+".$i."days";*/
                                $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));;
                                ?>
                                <div class="week-nav-0ff">
                                    <div class="day text-center">@php echo date('D', strtotime($new_set_global_date)) @endphp</div>
                                    <div class="num text-center">@php echo date('d', strtotime($new_set_global_date)) @endphp</div>
                                    <div class="month text-center">@php echo date('M-Y', strtotime($new_set_global_date)) @endphp</div>
                                </div>
                            @endfor
                        </div>
                        <!-- single room start-->
                        <div class="d-flex-01">
                            @for ($i = 0; $i < 31; $i++)
                                <?php
                                $new_set_global_date = "";
                                $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                $class_day_off = "";
                                $which_days = date("w", strtotime($new_set_global_date));
                                if ($which_days == 0 || $which_days == 6) {
                                    $class_day_off = "day_off";
                                }
                                ?>
                                <div class="week-nav-0ff-filed {!! $class_day_off !!}">
                                    <?php
                                    $availability_date = date('Y-m-d', strtotime($new_set_global_date));

                                    $value_availability = 0;

                                    $str_old_date = strtotime($availability_date);
                                    if (isset($ar_inventoryMaster) && !empty($ar_inventoryMaster)) {

                                        if (isset($ar_inventoryMaster[$value->id]) && !empty($ar_inventoryMaster[$value->id])) {

                                            if (isset($ar_inventoryMaster[$value->id][$str_old_date]) && !empty($ar_inventoryMaster[$value->id][$str_old_date])) {

                                                $value_availability = $ar_inventoryMaster[$value->id][$str_old_date];
                                            }
                                        }
                                    }

                                    $meta = "";
                                    $meta .= " data-room-type-id=\"$value->id\" ";
                                    $meta .= " data-availability-date=\"$availability_date\" ";
                                    $meta .= " data-type=\"inventory\" ";
                                    ?>
                                    <input type="text" class="manage_calender inventory_availability text_int" name="availability[{{ $value->id }}]"
                                           value="{!! $value_availability !!}"
                                           placeholder="0" {!! $meta !!} onkeypress="return isNumber(event)">
                                    <input type="hidden" class="inventory_availability_date" name="availability_date[{{ $value->id }}]" value="{!! $availability_date !!}">
                                    <input type="hidden" class="inventory_room_type_id" name="room_type_id[{{ $value->id }}]" value="{{ $value->id }}">
                                </div>
                            @endfor
                        </div>

                        {{--RatePlan Data Display--}}
                        @foreach($ratePlan as $inner_key => $inner_val)
                            <div class="d-flex-01 div_open_close">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $availability_date = date('Y-m-d', strtotime($new_set_global_date));

                                    $meta = "";
                                    $meta .= " data-room-type-id=\"$value->id\" ";
                                    $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                    $meta .= " data-availability-date=\"$availability_date\" ";
                                    $meta .= " data-type=\"restriction_close\" ";

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }

                                    $value_open_close = 0;
                                    $str_old_date = strtotime($availability_date);
                                    if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                        if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                            if (isset($ar_rateRestrictionData[$value->id][$inner_val->id]) && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                    && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                    $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                    if (isset($get_data['closed'])) {
                                                        $value_open_close = $get_data['closed'];
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $is_close = "";
                                    $checked = " checked=\"checked\" ";
                                    if ($value_open_close == 1) {
                                        $is_close = "is_close";
                                        $checked = "";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed data-open-close data-rate {!! $class_day_off !!}">
                                        <div class="toggle-group">
                                            <input type="checkbox" class="manage_calender open_close {!! $is_close !!}"
                                                   name="closed[{{$value->id}}]" id="on-off-switch_{{$inner_val->id}}_{{$i}}"
                                                   value="{!! $value_open_close !!}" {!! $checked !!} tabindex="1" {!! $meta !!}>
                                            <input type="hidden" name="room_type_id_inner[{{$value->id}}]" value="{{$value->id}}">
                                            <input type="hidden" name="rate_plan_id[{{$value->id}}]" value="{{$inner_val->id}}">
                                            <input type="hidden" name="availability_inner_date[{{$value->id}}]" value="{!! $availability_date !!}">

                                            <label for="on-off-switch_{{$inner_val->id}}_{{$i}}"> <span class="aural"></span></label>
                                            <div class="onoffswitch pull-right" aria-hidden="true">
                                                <div class="onoffswitch-label">
                                                    <div class="onoffswitch-inner {!! $is_close !!}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="d-flex-01 div_calendar_extra_price_btn">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed {!! $class_day_off !!}">&nbsp;</div>
                                @endfor
                            </div>

                            <div class="d-flex-01 ms-div">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed {!! $class_day_off !!}">
                                        <?php
                                        $value_base_amount = 0;
                                        if (isset($ar_defaultRatePlanData) && !empty($ar_defaultRatePlanData)) {

                                            if (isset($ar_defaultRatePlanData[$inner_val->id]) && !empty($ar_defaultRatePlanData[$inner_val->id])) {

                                                if (isset($ar_defaultRatePlanData[$inner_val->id][$value->id]) && !empty($ar_defaultRatePlanData[$inner_val->id][$value->id])) {

                                                    $get_data = $ar_defaultRatePlanData[$inner_val->id][$value->id];
                                                    if (isset($get_data['room_price']) && !empty($get_data['room_price'])) {
                                                        $value_base_amount = $get_data['room_price'];
                                                    }
                                                }
                                            }
                                        }

                                        $availability_date = date('Y-m-d', strtotime($new_set_global_date));
                                        $str_old_date = strtotime($availability_date);

                                        if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                            if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                                if (isset($ar_rateRestrictionData[$value->id][$inner_val->id])
                                                    && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                    if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                        && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                        $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                        if (isset($get_data['base_amount']) && !empty($get_data['base_amount'])) {
                                                            $value_base_amount = $get_data['base_amount'];
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $meta = "";
                                        $meta .= " data-room-type-id=\"$value->id\" ";
                                        $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                        $meta .= " data-availability-date=\"$availability_date\" ";
                                        $meta .= " data-type=\"restriction_base_amount\" ";
                                        ?>
                                        <input type="text" class="manage_calender text_float" name="base_amount[]" value="{!! $value_base_amount !!}"
                                               placeholder="0" {!! $meta !!} onkeypress="return isNumber(event)">
                                        <input type="hidden" name="room_type_id_inner[]" value="{{$value->id}}">
                                        <input type="hidden" name="rate_plan_id[]" value="{{$inner_val->id}}">
                                        <input type="hidden" name="availability_inner_date[]" value="{!! $availability_date !!}">
                                    </div>
                                @endfor
                            </div>

                            <div class="d-flex-01 div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }}">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed {!! $class_day_off !!}">
                                        <?php
                                        $value_single_amount = 0;
                                        if (isset($ar_defaultRatePlanData) && !empty($ar_defaultRatePlanData)) {

                                            if (isset($ar_defaultRatePlanData[$inner_val->id]) && !empty($ar_defaultRatePlanData[$inner_val->id])) {

                                                if (isset($ar_defaultRatePlanData[$inner_val->id][$value->id])
                                                    && !empty($ar_defaultRatePlanData[$inner_val->id][$value->id])) {

                                                    $get_data = $ar_defaultRatePlanData[$inner_val->id][$value->id];
                                                    if (isset($get_data['single_price']) && !empty($get_data['single_price'])) {
                                                        $value_single_amount = $get_data['single_price'];
                                                    }
                                                }
                                            }
                                        }

                                        $availability_date = date('Y-m-d', strtotime($new_set_global_date));
                                        $str_old_date = strtotime($availability_date);
                                        if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                            if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                                if (isset($ar_rateRestrictionData[$value->id][$inner_val->id])
                                                    && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                    if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                        && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                        $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];


                                                        if (isset($get_data['single_amount']) && !empty($get_data['single_amount'])) {
                                                            $value_single_amount = $get_data['single_amount'];
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $meta = "";
                                        $meta .= " data-room-type-id=\"$value->id\" ";
                                        $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                        $meta .= " data-availability-date=\"$availability_date\" ";
                                        $meta .= " data-type=\"restriction_single_amount\" ";
                                        ?>
                                        <input type="text" class="manage_calender text_float" name="single_amount[]" value="{!! $value_single_amount !!}"
                                               placeholder="0" {!! $meta !!} onkeypress="return isNumber(event)">
                                        <input type="hidden" name="room_type_id_inner[]" value="{{$value->id}}">
                                        <input type="hidden" name="rate_plan_id[]" value="{{$inner_val->id}}">
                                        <input type="hidden" name="availability_inner_date[]" value="{!! $availability_date !!}">
                                    </div>
                                @endfor
                            </div>

                            @for ($a_no = 1; $a_no <=4; $a_no++)
                                <div class="d-flex-01 div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }} div_calendar_extra_adult{!! $a_no !!}">
                                    @for ($i = 0; $i < 31; $i++)
                                        <?php
                                        $new_set_global_date = "";
                                        $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));
                                        $availability_date = date('Y-m-d', strtotime($new_set_global_date));

                                        $class_day_off = "";
                                        $which_days = date("w", strtotime($new_set_global_date));
                                        if ($which_days == 0 || $which_days == 6) {
                                            $class_day_off = "day_off";
                                        }
                                        ?>
                                        <div class="week-nav-0ff-filed {!! $class_day_off !!} div_adult{!! $a_no !!}">
                                            <?php
                                            $label_type = "restriction_extra_adult_" . $a_no . "_amount";
                                            $label_name = "extra_adult_" . $a_no . "_amount[]";

                                            $value_data = 0;
                                            if (isset($ar_defaultRatePlanData) && !empty($ar_defaultRatePlanData)) {

                                                if (isset($ar_defaultRatePlanData[$inner_val->id]) && !empty($ar_defaultRatePlanData[$inner_val->id])) {

                                                    if (isset($ar_defaultRatePlanData[$inner_val->id][$value->id])
                                                        && !empty($ar_defaultRatePlanData[$inner_val->id][$value->id])) {

                                                        $get_data = $ar_defaultRatePlanData[$inner_val->id][$value->id];

                                                        $adult_rate_key = "ext_adult" . $a_no . "_rate";

                                                        if (isset($get_data[$adult_rate_key]) && !empty($get_data[$adult_rate_key])) {
                                                            $value_data = $get_data[$adult_rate_key];
                                                        }
                                                    }
                                                }
                                            }

                                            $str_old_date = strtotime($availability_date);
                                            if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                                $adult_rate_key = "extra_adult_" . $a_no . "_amount";

                                                if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                                    if (isset($ar_rateRestrictionData[$value->id][$inner_val->id])
                                                        && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                        if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                            && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                            $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                            if (isset($get_data[$adult_rate_key]) && !empty($get_data[$adult_rate_key])) {
                                                                $value_data = $get_data[$adult_rate_key];
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            $meta = "";
                                            $meta .= " data-room-type-id=\"$value->id\" ";
                                            $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                            $meta .= " data-availability-date=\"$availability_date\" ";
                                            $meta .= " data-type=\"$label_type\" ";
                                            ?>
                                            <input type="text" class="manage_calender text_float" name="{!! $label_name !!}" value="{!! $value_data !!}"
                                                   placeholder="0" {!! $meta !!} onkeypress="return isNumber(event)">
                                            <input type="hidden" name="room_type_id_inner[]" value="{{$value->id}}">
                                            <input type="hidden" name="rate_plan_id[]" value="{{$inner_val->id}}">
                                            <input type="hidden" name="availability_inner_date[]" value="{!! $availability_date !!}">
                                        </div>
                                    @endfor
                                </div>
                            @endfor
                            @for ($a_no = 1; $a_no <=3; $a_no++)
                                <div class="d-flex-01 div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }} div_calendar_extra_child{!! $a_no !!}">
                                    @for ($i = 0; $i < 31; $i++)
                                        <?php
                                        $new_set_global_date = "";
                                        $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));
                                        $availability_date = date('Y-m-d', strtotime($new_set_global_date));

                                        $class_day_off = "";
                                        $which_days = date("w", strtotime($new_set_global_date));
                                        if ($which_days == 0 || $which_days == 6) {
                                            $class_day_off = "day_off";
                                        }
                                        ?>
                                        <div class="week-nav-0ff-filed {!! $class_day_off !!} div_child{!! $a_no !!}">
                                            <?php
                                            $label_type = "restriction_child_age_" . $a_no . "_rate";
                                            $label_name = "child_age_" . $a_no . "_rate[]";

                                            $value_data = 0;
                                            if (isset($ar_defaultRatePlanData) && !empty($ar_defaultRatePlanData)) {

                                                if (isset($ar_defaultRatePlanData[$inner_val->id]) && !empty($ar_defaultRatePlanData[$inner_val->id])) {

                                                    if (isset($ar_defaultRatePlanData[$inner_val->id][$value->id])
                                                        && !empty($ar_defaultRatePlanData[$inner_val->id][$value->id])) {

                                                        $get_data = $ar_defaultRatePlanData[$inner_val->id][$value->id];

                                                        $child_rate_key = "child_age" . $a_no . "_rate";

                                                        if (isset($get_data[$child_rate_key]) && !empty($get_data[$child_rate_key])) {
                                                            $value_data = $get_data[$child_rate_key];
                                                        }
                                                    }
                                                }
                                            }

                                            $str_old_date = strtotime($availability_date);
                                            if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                                $child_rate_key = "child_age_" . $a_no . "_rate";

                                                if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                                    if (isset($ar_rateRestrictionData[$value->id][$inner_val->id])
                                                        && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                        if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                            && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                            $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                            if (isset($get_data[$child_rate_key]) && !empty($get_data[$child_rate_key])) {
                                                                $value_data = $get_data[$child_rate_key];
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            $meta = "";
                                            $meta .= " data-room-type-id=\"$value->id\" ";
                                            $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                            $meta .= " data-availability-date=\"$availability_date\" ";
                                            $meta .= " data-type=\"$label_type\" ";
                                            ?>
                                            <input type="text" class="manage_calender text_float" name="{!! $label_name !!}" value="{!! $value_data !!}"
                                                   placeholder="0" {!! $meta !!} onkeypress="return isNumber(event)">
                                            <input type="hidden" name="room_type_id_inner[]" value="{{$value->id}}">
                                            <input type="hidden" name="rate_plan_id[]" value="{{$inner_val->id}}">
                                            <input type="hidden" name="availability_inner_date[]" value="{!! $availability_date !!}">
                                        </div>
                                    @endfor
                                </div>
                            @endfor

                            <div class="d-flex-01 mis-div">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed {!! $class_day_off !!}">
                                        <?php
                                        $value_min_stay = 0;
                                        if (isset($ar_defaultRatePlanData) && !empty($ar_defaultRatePlanData)) {

                                            if (isset($ar_defaultRatePlanData[$inner_val->id]) && !empty($ar_defaultRatePlanData[$inner_val->id])) {

                                                if (isset($ar_defaultRatePlanData[$inner_val->id][$value->id])
                                                    && !empty($ar_defaultRatePlanData[$inner_val->id][$value->id])) {

                                                    $get_data = $ar_defaultRatePlanData[$inner_val->id][$value->id];
                                                    if (isset($get_data['min_nights']) && !empty($get_data['min_nights'])) {
                                                        $value_min_stay = $get_data['min_nights'];
                                                    }
                                                }
                                            }
                                        }

                                        $availability_date = date('Y-m-d', strtotime($new_set_global_date));
                                        $str_old_date = strtotime($availability_date);
                                        if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                            if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                                if (isset($ar_rateRestrictionData[$value->id][$inner_val->id])
                                                    && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                    if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                        && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                        $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                        if (isset($get_data['minstay']) && !empty($get_data['minstay'])) {
                                                            $value_min_stay = $get_data['minstay'];
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $meta = "";
                                        $meta .= " data-room-type-id=\"$value->id\" ";
                                        $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                        $meta .= " data-availability-date=\"$availability_date\" ";
                                        $meta .= " data-type=\"restriction_min_stay\" ";
                                        ?>
                                        <input type="text" class="manage_calender text_int" name="minstay[]" placeholder="0"
                                               value="{!! $value_min_stay !!}" {!! $meta !!} onkeypress="return isNumber(event)">
                                        <input type="hidden" name="room_type_id_inner[]" value="{{$value->id}}">
                                        <input type="hidden" name="rate_plan_id[]" value="{{$inner_val->id}}">
                                        <input type="hidden" name="availability_inner_date[]" value="{!! $availability_date !!}">
                                    </div>
                                @endfor
                            </div>

                            <div class="d-flex-01 div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }} ">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed {!! $class_day_off !!}">
                                        <?php
                                        $value_max_stay = 0;
                                        if (isset($ar_defaultRatePlanData) && !empty($ar_defaultRatePlanData)) {

                                            if (isset($ar_defaultRatePlanData[$inner_val->id]) && !empty($ar_defaultRatePlanData[$inner_val->id])) {

                                                if (isset($ar_defaultRatePlanData[$inner_val->id][$value->id])
                                                    && !empty($ar_defaultRatePlanData[$inner_val->id][$value->id])) {

                                                    $get_data = $ar_defaultRatePlanData[$inner_val->id][$value->id];
                                                    if (isset($get_data['max_nights']) && !empty($get_data['max_nights'])) {
                                                        $value_max_stay = $get_data['max_nights'];
                                                    }
                                                }
                                            }
                                        }

                                        $availability_date = date('Y-m-d', strtotime($new_set_global_date));
                                        $str_old_date = strtotime($availability_date);
                                        if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                            if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                                if (isset($ar_rateRestrictionData[$value->id][$inner_val->id])
                                                    && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                    if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                        && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                        $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                        if (isset($get_data['maxstay']) && !empty($get_data['maxstay'])) {
                                                            $value_max_stay = $get_data['maxstay'];
                                                        }
                                                    }
                                                }
                                            }
                                        }

                                        $meta = "";
                                        $meta .= " data-room-type-id=\"$value->id\" ";
                                        $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                        $meta .= " data-availability-date=\"$availability_date\" ";
                                        $meta .= " data-type=\"restriction_max_stay\" ";
                                        ?>
                                        <input type="text" class="manage_calender text_int" name="maxstay[]" placeholder="0"
                                               value="{!! $value_max_stay !!}" {!! $meta !!} onkeypress="return isNumber(event)">
                                        <input type="hidden" name="room_type_id_inner[]" value="{{$value->id}}">
                                        <input type="hidden" name="rate_plan_id[]" value="{{$inner_val->id}}">
                                        <input type="hidden" name="availability_inner_date[]" value="{!! $availability_date !!}">
                                    </div>
                                @endfor
                            </div>

                            <div class="d-flex-01 div_open_close div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }} ">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $availability_date = date('Y-m-d', strtotime($new_set_global_date));

                                    $meta = "";
                                    $meta .= " data-room-type-id=\"$value->id\" ";
                                    $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                    $meta .= " data-availability-date=\"$availability_date\" ";
                                    $meta .= " data-type=\"restriction_cta\" ";

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }

                                    $value_open_close = 0;
                                    $str_old_date = strtotime($availability_date);
                                    if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                        if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                            if (isset($ar_rateRestrictionData[$value->id][$inner_val->id]) && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                    && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                    $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                    if (isset($get_data['cta'])) {
                                                        $value_open_close = $get_data['cta'];
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $is_close = "";
                                    $checked = " checked=\"checked\" ";
                                    if ($value_open_close == 1) {
                                        $is_close = "is_close";
                                        $checked = "";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed data-open-close data-rate {!! $class_day_off !!}">
                                        <div class="toggle-group">
                                            <input type="checkbox" class="manage_calender open_close {!! $is_close !!}"
                                                   name="closed[{{$value->id}}]" id="on-off-switch_cta_{{$inner_val->id}}_{{$i}}"
                                                   value="{!! $value_open_close !!}" {!! $checked !!} tabindex="1" {!! $meta !!}>
                                            <input type="hidden" name="room_type_id_inner[{{$value->id}}]" value="{{$value->id}}">
                                            <input type="hidden" name="rate_plan_id[{{$value->id}}]" value="{{$inner_val->id}}">
                                            <input type="hidden" name="availability_inner_date[{{$value->id}}]" value="{!! $availability_date !!}">

                                            <label for="on-off-switch_cta_{{$inner_val->id}}_{{$i}}"> <span class="aural"></span></label>
                                            <div class="onoffswitch pull-right" aria-hidden="true">
                                                <div class="onoffswitch-label">
                                                    <div class="onoffswitch-inner {!! $is_close !!}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>

                            <div class="d-flex-01 div_open_close div_calendar_extra_price_data div_calendar_extra_price_data_{{ $inner_val->id  }} ">
                                @for ($i = 0; $i < 31; $i++)
                                    <?php
                                    $new_set_global_date = "";
                                    $new_set_global_date = date('Y-m-d H:i:s', strtotime($set_global_date . " +" . $i . "days"));

                                    $availability_date = date('Y-m-d', strtotime($new_set_global_date));

                                    $meta = "";
                                    $meta .= " data-room-type-id=\"$value->id\" ";
                                    $meta .= " data-rate-plan-id=\"$inner_val->id\" ";
                                    $meta .= " data-availability-date=\"$availability_date\" ";
                                    $meta .= " data-type=\"restriction_ctd\" ";

                                    $class_day_off = "";
                                    $which_days = date("w", strtotime($new_set_global_date));
                                    if ($which_days == 0 || $which_days == 6) {
                                        $class_day_off = "day_off";
                                    }

                                    $value_open_close = 0;
                                    $str_old_date = strtotime($availability_date);
                                    if (isset($ar_rateRestrictionData) && !empty($ar_rateRestrictionData)) {

                                        if (isset($ar_rateRestrictionData[$value->id]) && !empty($ar_rateRestrictionData[$value->id])) {

                                            if (isset($ar_rateRestrictionData[$value->id][$inner_val->id]) && !empty($ar_rateRestrictionData[$value->id][$inner_val->id])) {

                                                if (isset($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])
                                                    && !empty($ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date])) {

                                                    $get_data = $ar_rateRestrictionData[$value->id][$inner_val->id][$str_old_date];

                                                    if (isset($get_data['ctd'])) {
                                                        $value_open_close = $get_data['ctd'];
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $is_close = "";
                                    $checked = " checked=\"checked\" ";
                                    if ($value_open_close == 1) {
                                        $is_close = "is_close";
                                        $checked = "";
                                    }
                                    ?>
                                    <div class="week-nav-0ff-filed data-open-close data-rate {!! $class_day_off !!}">
                                        <div class="toggle-group">
                                            <input type="checkbox" class="manage_calender open_close {!! $is_close !!}"
                                                   name="closed[{{$value->id}}]" id="on-off-switch_ctd_{{$inner_val->id}}_{{$i}}"
                                                   value="{!! $value_open_close !!}" {!! $checked !!} tabindex="1" {!! $meta !!}>
                                            <input type="hidden" name="room_type_id_inner[{{$value->id}}]" value="{{$value->id}}">
                                            <input type="hidden" name="rate_plan_id[{{$value->id}}]" value="{{$inner_val->id}}">
                                            <input type="hidden" name="availability_inner_date[{{$value->id}}]" value="{!! $availability_date !!}">

                                            <label for="on-off-switch_ctd_{{$inner_val->id}}_{{$i}}"> <span class="aural"></span></label>
                                            <div class="onoffswitch pull-right" aria-hidden="true">
                                                <div class="onoffswitch-label">
                                                    <div class="onoffswitch-inner {!! $is_close !!}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                    @endforeach
                    <!-- single room end -->
                    </div>
                </div>
                <!-- Left and right controls -->
                <a class="carousel-control-prev a_pre" href="javascript:;" data-slide="prev_{!! $no !!}" title="previous" id="prev_{!! $no !!}"
                   data-parent-div="care_{!! $no !!}">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="carousel-control-next a_nxt" href="javascript:;" data-slide="next_{!! $no !!}" title="next" id="next_{!! $no !!}" data-parent-div="care_{!! $no !!}">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </div>
        <?php $no++; ?>
    @endforeach
@endif