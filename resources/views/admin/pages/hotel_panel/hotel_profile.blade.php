@extends('admin.layout.default')

@section('title', 'Hotel Profile')

@section('content')

<style>
  label{
    font-size:12px;
  }
  input,select{
    border:1px solid #000000 !important;
  }
</style>

    <section class="property-wrapper mt-4">
        <h2 class="list-heading">{{ __('user.hotelprofile') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">

    @include('flash-message')

        <h4>Gallery</h4>
       
        <form class="modal-body p-0" method="post" action="{{route('admin.hotel.profile.store')}}" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="id" value="{{$hotel_data->id}}">

            <div style="background:lightgray;padding:10px">
              <div class="row">
                  
                  <div class="col-sm-4 mt-3">
                      <label>{{ __('user.bannerimage') }}</label>
                      <input type="file" class="form-control" name="banner_image">
                  </div>
                  <div class="col-sm-4 mt-3">
                      <label>{{ __('user.logoimage') }}</label>
                      <input type="file" class="form-control" name="logo_image">
                  </div>
                  <div class="col-sm-4 mt-3">
                      <label>{{ __('user.grouphotelpreview') }}</label>
                      <input type="file" class="form-control" name="group_preview_image">
                  </div>

                  @if($hotel_data->banner_image)
                      <div class="col-sm-4 mt-3">
                          <img src="{{url('public/images/hotel_banner/')}}/{{$hotel_data->banner_image}}" width="100" height="100">
                      </div>
                  @endif
                  @if($hotel_data->logo_image)
                      <div class="col-sm-4 mt-3">
                          <img src="{{url('public/images/hotel_logo/')}}/{{$hotel_data->logo_image}}" width="100" height="100">
                      </div>
                  @endif
                  @if($hotel_data->group_preview_image)
                      <div class="col-sm-4 mt-3">
                          <img src="{{url('public/images/hotel_group_preview/')}}/{{$hotel_data->group_preview_image}}" width="100" height="100">
                      </div>
                  @endif
              </div>
            </div>

  <br>
            <h4>{{ __('user.generalinfo') }}</h4>
            <div class="row">
                <div class="col-sm-6 mt-3">
                    <label for="Hotel Name"><b>{{ __('user.hotelname') }} :</b></label>
                    <input type="text" class="form-control" id="HotelName" name="name" value="{{$hotel_data->name}}">
                </div>
                <div class="col-sm-3 mt-3 ">
                    <label>{{ __('user.hotelcategory') }} :</label>
                    <select name="category" class="form-control">
                        <option selected="selected" disabled="disabled">-- {{ __('user.selecthotelcategory') }} --</option>
                        <option value="Hotel" @if($hotel_data->category == 'Hotel') selected @endif>Hotel</option>
                        <option value="Motel" @if($hotel_data->category == 'Motel') selected @endif>Motel</option>
                        <option value="Resort hotel" @if($hotel_data->category == 'Resort hotel') selected @endif>Resort hotel</option>
                        <option value="Inn" @if($hotel_data->category == 'Inn') selected @endif>Inn</option>
                        <option value="Extended stay hotel" @if($hotel_data->category == 'Extended stay hotel') selected @endif>Extended stay hotel (Aparthotel)</option>
                        <option value="Guest house" @if($hotel_data->category == 'Guest house') selected @endif>Guest house</option>
                        <option value="Bed and breakfast" @if($hotel_data->category == 'Bed and breakfast') selected @endif>Bed and breakfast</option>
                        <option value="Farm stay" @if($hotel_data->category == 'Farm stay') selected @endif>Farm stay</option>
                        <option value="Hostel" @if($hotel_data->category == 'Hostel') selected @endif>Hostel</option>
                        <option value="Dharamshala" @if($hotel_data->category == 'Dharamshala') selected @endif>Dharamshala</option>
                        <option value="Japanese Inn" @if($hotel_data->category == 'Japanese Inn') selected @endif>Japanese Inn</option>
                        <option value="Mountain hut" @if($hotel_data->category == 'Mountain hut') selected @endif>Mountain hut</option>
                        <option value="Capsule hotel" @if($hotel_data->category == 'Capsule hotel') selected @endif>Capsule hotel</option>
                        <option value="Love hotel" @if($hotel_data->category == 'Love hotel') selected @endif>Love hotel</option>
                        <option value="Camping cabins" @if($hotel_data->category == 'Camping cabins') selected @endif>Camping cabins</option>
                    </select>
                </div>

                <div class="col-sm-3 mt-3 ">
                    <label>{{ __('user.starrating') }} :</label>
                    <select name="star_rating" class="form-control">
                        <option selected="selected" disabled="disabled">-- {{ __('user.selecthotelstarrating') }} --</option>
                        <option value="1" @if($hotel_data->star_rating == '1') selected @endif>1 Star</option>
                        <option value="2" @if($hotel_data->star_rating == '2') selected @endif>2 Star</option>
                        <option value="3" @if($hotel_data->star_rating == '3') selected @endif>3 Star</option>
                        <option value="4" @if($hotel_data->star_rating == '4') selected @endif>4 Star</option>
                        <option value="5" @if($hotel_data->star_rating == '5') selected @endif>5 Star</option>
                    </select>
                </div>

                <div class="col-sm-3 mt-3">
                    <label for="Address">{{ __('user.address') }} :</label>
                    <input value="{{$hotel_data->address}}" class="form-control"   name="address" id="Address"> 
                </div>
                <div class="col-sm-3 mt-3 ">
                    <label>{{ __('user.city') }} :</label>
                    <input type="text" class="form-control" name="city" value="{{$hotel_data->city}}">
                </div>
                <div class="col-sm-2 mt-3">
                    <label>{{ __('user.postalcode') }}:</label>
                    <input type="text" class="form-control" name="postal_code" value="{{$hotel_data->postal_code}}">
                </div>
                <div class="col-sm-2 mt-3 ">
                    <label>{{ __('user.state') }} :</label>
                    <input type="text" class="form-control" name="state" value="{{$hotel_data->state}}">
                </div>
                <div class="col-sm-2 mt-3">
                    <label>{{ __('user.country') }} :  <small>esempio:  IT</small></label>
                    <input type="text" class="form-control" id="country" value="{{$hotel_data->country}}" name="country">
                   
                </div>

                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.latitude') }} :</label>
                    <input type="text" class="form-control" id="latitude" value="{{$hotel_data->latitude}}" name="latitude">
                    <a target="_blank" href="https://www.latlong.net/">recupera coordinate</a>
                </div>
                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.longitude') }} :</label>
                    <input type="text" class="form-control" value="{{$hotel_data->longtiude}}" id="longtiude" name="longtiude">
                </div>
                <div class="col-sm-2 mt-3">
                    <label>{{ __('user.mobile') }} :</label>
                    <input type="text" class="form-control" id="mobile" name="mobile" value="{{$hotel_data->mobile}}">
                </div>
                <div class="col-sm-2 mt-3">
                    <label>{{ __('user.phone') }} :</label>
                    <input type="text" class="form-control" name="phone" value="{{$hotel_data->phone}}">
                </div>
                <div class="col-sm-2 mt-3">
                    <label>{{ __('user.whatsapp') }} :</label>
                    <input type="text" class="form-control" name="whatsapp" value="{{$hotel_data->whatsapp}}">
                </div>
              
                <div class="col-sm-3 mt-3">
                    <label>{{ __('user.reservationemail') }} :</label>
                    <input type="text" class="form-control" name="reservation_email" value="{{$hotel_data->reservation_email}}">
                </div>
                <div class="col-sm-3 mt-3">
                    <label>{{ __('user.websiteurl') }} :</label>
                    <input type="text" class="form-control" name="website_url" value="{{$hotel_data->website_url}}">
                </div>
                
                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.contactemail') }} :</label>
                    <input type="text" class="form-control" id="contact_email" name="contact_email" value="{{$hotel_data->contact_email}}">
                </div> 
                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.contactname') }} :</label>
                    <input type="text" class="form-control" name="contact_name" value="{{$hotel_data->contact_name}}">
                </div> 

                
               
                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.depositpercentage') }} :</label>
                    <input type="text" class="form-control" name="deposit_percentage" value="{{$hotel_data->deposit_percentage}}">
                </div>
                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.currencysymbol') }} :</label>
                    <select name="currency_symbol" class="form-control">
                        <option selected="selected" disabled="disabled">-- {{ __('user.currencylist') }} --</option>
                        <option value="€" @if($hotel_data->currency_symbol == '€') selected @endif>Euro</option>
                        <option value="$" @if($hotel_data->currency_symbol == '$') selected @endif>Dollar</option>
                        <option value="£" @if($hotel_data->currency_symbol == '£') selected @endif>Pound</option>
                    </select>
                </div>

                
                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.citytax') }} :</label>
                    <input type="text" class="form-control" id="city_tax" name="city_tax" value="{{$hotel_data->city_tax}}">
                </div> 
                <div class="col-sm-6 mt-3">
                    <label>{{ __('user.paidmaxnights') }} :</label>
                    <input type="text" class="form-control" id="paid_max_nights" name="paid_max_nights" value="{{$hotel_data->paid_max_nights}}">
                </div> 

                <div class="col-sm-6 mt-3">
                    <label>Review Hotel ID :
                        <i class="fa fa-info-circle" data-toggle="tooltip"
                           title="Please enter hotel id which is from review system so we can show review summary on booking engine"></i>
                    </label>
                    <input type="text" class="form-control" name="review_hotel_id" value="{{$hotel_data->review_hotel_id}}">
                </div>

                <div class="col-sm-6 mt-3">
                    <label>Google Analytics Tag ID :
                        <i class="fa fa-info-circle" data-toggle="tooltip"
                           title="Enter google analytics tag id so we can add google analytics script in your booking engine page"></i>
                    </label>
                    <input type="text" class="form-control" name="google_analytics_tag_id" value="{{$hotel_data->google_analytics_tag_id}}">
                </div>

                <div class="col-sm-6 mt-3">
                    <label>Facebook Pixel ID :
                        <i class="fa fa-info-circle" data-toggle="tooltip"
                           title="Enter Facebook Pixel ID so we can add facebook analytics script in your booking engine page"></i>
                    </label>
                    <input type="text" class="form-control" name="facebook_pixel_id" value="{{$hotel_data->facebook_pixel_id}}">
                </div>
                <?php
                    $cm_checked = "";
                    $cm_value = "N";
                    if ( isset($hotel_data->is_channel_manager_active) && !empty($hotel_data->is_channel_manager_active) ) {
                        if ( $hotel_data->is_channel_manager_active == 'Y' ) {
                            $cm_checked = "checked";
                        }
                    }
                ?>

                <div class="form-check form-check-inline">
                    <input class="form-check-input is_channel_manager_active" type="checkbox" name="is_channel_manager_active" value="Y" id="is_channel_manager_active" {{ $cm_checked }}>
                    <label class="form-check-label" for="">
                        Channel Manager
                    </label>
                </div>
</div>
<br>
<h4>{{ __('user.childagerange') }}</h4>
 

                @php
                    $hotel_data->child_age = json_decode($hotel_data->child_age, true);
                    $age_data = $hotel_data->child_age;
                @endphp
                 
                    @for($i=0; $i<3; $i++)
                        <?php
                        $start_age = "";
                        $end_age = "";

                        if (isset($age_data) && !empty($age_data)) {

                            if (isset($age_data[$i]['start_age'])) {
                                $start_age = $age_data[$i]['start_age'];
                            }

                            if (isset($age_data[$i]['end_age'])) {
                                $end_age = $age_data[$i]['end_age'];
                            }
                        }
                        ?>
                        <div class="row mt-3">
                            <label class="col-sm-3">{{ __('user.childagerange') }} {!! ($i+1) !!} :</label>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">{{ __('user.min') }}</span>
                                    </div>
                                    <input type="text" class="form-control" name="start_age[]" value="{!! $start_age !!}" maxlength="2" onkeypress="return onlyIntegerNumber(event)" style="height: 38px;">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">{{ __('user.max') }}</span>
                                    </div>
                                    <input type="text" class="form-control" name="end_age[]" value="{!! $end_age !!}" maxlength="2" onkeypress="return onlyIntegerNumber(event)" style="height: 38px;">
                                </div>
                            </div>
                        </div>
                    @endfor
                 

                    <h4>{{ __('user.checkintime') }} {{ __('user.checkouttime') }}</h4>

                    <div class="row">

                <div class="col-sm-6 ">
                    <label>{{ __('user.checkintime') }} :</label>
                    <input type="text" class="form-control" id="xinput_starttime" name="check_in" value="{{$hotel_data->check_in}}">
                </div>

                <div class="col-sm-6 ">
                    <label>{{ __('user.checkouttime') }} :</label>
                    <input type="text" class="form-control" id="xinput_endtime" name="check_out" value="{{$hotel_data->check_out}}">
                </div>

             </div>

             <h4>{{ __('user.settings') }}</h4>

                    <div class="row">

                <div class="col-sm-3 ">
                    <label>{{ __('user.minadvancedays') }} :</label>
                    <input type="text" class="form-control" id="min_advance_days" name="min_advance_days" value="@if( isset($hotel_setting->min_advance_days)) {{ $hotel_setting->min_advance_days }} @endif">
                </div>

                <div class="col-sm-3 ">
                    <label>{{ __('user.checkouttime') }} :</label>
                    <input type="text" class="form-control" id="max_advance_days" name="max_advance_days" value="@if( isset($hotel_setting->max_advance_days)) {{$hotel_setting->max_advance_days}} @endif">
                </div>

             </div>

                 <br> 
                <h4>PAGAMENTI ACCETTATI</h4>

                <?php
                    $pre_define_types = [
                        'VISA',
                        'MASTERCARD',
                        'AMEX',
                        'Diners Club',
                        'JCB',
                        'EUROCARD'
                    ];
                    $ar_room_facilities = array();
                    $set_cards = array();
                    if (isset($hotel_data->accepted_cards) && !empty($hotel_data->accepted_cards)) {

                        $set_cards = json_decode($hotel_data->accepted_cards, true);
                    }
                ?>

              <div class="row">
                <div class="col-sm-12 mt-3 ">
                    <label>{{ __('user.acceptedcards') }} :</label> <br>
                    
                        @foreach($pre_define_types as $key => $value)

                        <?php
                            $checked = "";
                            if ( isset($set_cards) && !empty($set_cards) ) {
                                if (in_array($value, $set_cards)) {
                                    $checked = "checked";
                                }
                            }
                        ?>

                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox"
                                   name="accepted_cards[]" value="{{ $value }}" id="" {!! $checked !!}>
                            <label class="form-check-label" for="">
                                {{ $value }}
                            </label>
                        </div>
                        @endforeach
                    
                </div>

                <div class="col-sm-12 mt-3 ">
                    <label>{{ __('user.banktransfer') }} :</label>
                    <?php
                        $bank_transfer_checked = '';
                        $bank_transfer_value = 0;
                        if (isset($hotel_data->bank_transfer) && $hotel_data->bank_transfer == 1 ) {
                            $bank_transfer_checked = 'checked';
                            $bank_transfer_value = 1;
                        }
                    ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"
                               name="bank_transfer" value="{!! $bank_transfer_value !!}" id="bank_transfer" {!! $bank_transfer_checked !!}>
                    </div>
                    <!-- <label>Bank Transfer Description :</label> -->
                    <input type="text" class="form-control" id="bank_transfer_desc" placeholder="Bank Transfer Description / info bonifico - intestatario - iban" name="bank_transfer_desc" value="{{$hotel_data->bank_transfer_desc}}">
                </div>

                <div class="col-sm-12 mt-3 ">
                    <label>Paypal :</label>
                    <?php
                        $paypal_checked = '';
                        $paypal_value = 0;
                        if (isset($hotel_data->paypal) && $hotel_data->paypal == 1 ) {
                            $paypal_checked = 'checked';
                            $paypal_value = 1;
                        }
                    ?>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox"
                               name="paypal" value="{!! $paypal_value !!}" id="paypal" {!! $paypal_checked !!}>
                    </div>
                    <br/>
                    <label>Paypal Client ID :</label>
                    <input type="text" class="form-control" id="paypal_client_id" placeholder="Paypal Client ID" name="paypal_client_id" value="{{$hotel_data->paypal_client_id}}">
                    <label>Paypal Client Secret :</label>
                    <input type="text" class="form-control" id="paypal_client_secret" placeholder="Paypal Client Secret" name="paypal_client_secret" value="{{$hotel_data->paypal_client_secret}}">
                </div>

                <hr/>
                <br/>
            </div>

            
            <br/>
            <h4>Info importanti (che appariranno sopra le camere)</h4>

            <div class="row mt-5">
               
                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="special_note_tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="special_note_tab1" data-toggle="tab" href="#special_note" role="tab" aria-controls="special_note" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="special_note_tab2" data-toggle="tab" href="#special_note_it" role="tab" aria-controls="special_note_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="special_note_tab3" data-toggle="tab" href="#special_note_fr" role="tab" aria-controls="special_note_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="special_note_tab4" data-toggle="tab" href="#special_note_es" role="tab" aria-controls="special_note_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="special_note_tab5" data-toggle="tab" href="#special_note_de" role="tab" aria-controls="special_note_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="special_note" id="special_note" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->special_note}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="special_note_it" id="special_note_it" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->special_note_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="special_note_fr" id="special_note_fr" role="tabpanel" aria-labelledby="special_note_tab3">{{$hotel_data->special_note_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="special_note_es" id="special_note_es" role="tabpanel" aria-labelledby="special_note_tab4">{{$hotel_data->special_note_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="special_note_de" id="special_note_de" role="tabpanel" aria-labelledby="special_note_tab5">{{$hotel_data->special_note_de}}</textarea>
                    </div>
                </div>
            </div>

            <br/>
            <h4>Condizioni carta di credito (se diverso da quello standard)</h4>

            <div class="row mt-5">
               
                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="cc" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="cc1" data-toggle="tab" href="#cc_policy" role="tab" aria-controls="cc" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cc2" data-toggle="tab" href="#cc_policy_it" role="tab" aria-controls="cc_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cc3" data-toggle="tab" href="#cc_policy_fr" role="tab" aria-controls="cc_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cc4" data-toggle="tab" href="#cc_policy_es" role="tab" aria-controls="cc_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cc5" data-toggle="tab" href="#cc_policy_de" role="tab" aria-controls="cc_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="cc_policy" id="cc_policy" role="tabpanel" aria-labelledby="cc_tab1">{{$hotel_data->cc_policy}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cc_policy_it" id="cc_policy_it" role="tabpanel" aria-labelledby="cc_tab1">{{$hotel_data->cc_policy_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cc_policy_fr" id="cc_policy_fr" role="tabpanel" aria-labelledby="cc_tab3">{{$hotel_data->cc_policy_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cc_policy_es" id="cc_policy_es" role="tabpanel" aria-labelledby="cc_tab4">{{$hotel_data->cc_policy_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cc_policy_de" id="cc_policy_de" role="tabpanel" aria-labelledby="cc_tab5">{{$hotel_data->cc_policy_de}}</textarea>
                    </div>
                </div>
            </div>

            

            <br/>
            <h4>{{ __('user.privacypolicy') }}</h4>
            <div class="row mt-2">
              
                <a href="javascript:void(0);" onclick="importa_privacy($('#HotelName').val(),$('#Address').val(),$('#mobile').val(),$('#contact_email').val())";>importa privacy</a>

                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="policy_tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="policy_tab1" data-toggle="tab" href="#policy" role="tab" aria-controls="policy" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="policy_tab2" data-toggle="tab" href="#policy_it" role="tab" aria-controls="policy_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="policy_tab3" data-toggle="tab" href="#policy_fr" role="tab" aria-controls="policy_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="policy_tab4" data-toggle="tab" href="#policy_es" role="tab" aria-controls="policy_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="policy_tab5" data-toggle="tab" href="#policy_de" role="tab" aria-controls="policy_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="policy" id="policy" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->policy}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="policy_it" id="policy_it" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->policy_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="policy_fr" id="policy_fr" role="tabpanel" aria-labelledby="special_note_tab3">{{$hotel_data->policy_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="policy_es" id="policy_es" role="tabpanel" aria-labelledby="special_note_tab4">{{$hotel_data->policy_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="policy_de" id="policy_de" role="tabpanel" aria-labelledby="special_note_tab5">{{$hotel_data->policy_de}}</textarea>
                    </div>
                </div>

            </div>

            <br>
            <h4>Politiche generali di cancellazione</h4>
            <div class="row mt-2">
                

                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="cancellation_policy_tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="cancellation_policy_tab1" data-toggle="tab" href="#cancellation_policy" role="tab" aria-controls="cancellation_policy" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cancellation_policy_tab2" data-toggle="tab" href="#cancellation_policy_it" role="tab" aria-controls="cancellation_policy_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cancellation_policy_tab3" data-toggle="tab" href="#cancellation_policy_fr" role="tab" aria-controls="cancellation_policy_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cancellation_policy_tab4" data-toggle="tab" href="#cancellation_policy_es" role="tab" aria-controls="cancellation_policy_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="cancellation_policy_tab5" data-toggle="tab" href="#cancellation_policy_de" role="tab" aria-controls="cancellation_policy_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="cancellation_policy" id="cancellation_policy" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->cancellation_policy}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cancellation_policy_it" id="cancellation_policy_it" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->cancellation_policy_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cancellation_policy_fr" id="cancellation_policy_fr" role="tabpanel" aria-labelledby="special_note_tab3">{{$hotel_data->cancellation_policy_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cancellation_policy_es" id="cancellation_policy_es" role="tabpanel" aria-labelledby="special_note_tab4">{{$hotel_data->cancellation_policy_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="cancellation_policy_de" id="cancellation_policy_de" role="tabpanel" aria-labelledby="special_note_tab5">{{$hotel_data->cancellation_policy_de}}</textarea>
                    </div>
                </div>

            </div>
           <!-- <div class="row mt-2">
                <h4>{{ __('user.parkinginfopolicy') }}</h4>

                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="parking_info_tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="parking_info_tab1" data-toggle="tab" href="#parking_info" role="tab" aria-controls="parking_info" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="parking_info_tab2" data-toggle="tab" href="#parking_info_it" role="tab" aria-controls="parking_info_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="parking_info_tab3" data-toggle="tab" href="#parking_info_fr" role="tab" aria-controls="parking_info_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="parking_info_tab4" data-toggle="tab" href="#parking_info_es" role="tab" aria-controls="parking_info_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="parking_info_tab5" data-toggle="tab" href="#parking_info_de" role="tab" aria-controls="parking_info_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="parking_info" id="parking_info" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->parking_info}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="parking_info_it" id="parking_info_it" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->parking_info_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="parking_info_fr" id="parking_info_fr" role="tabpanel" aria-labelledby="special_note_tab3">{{$hotel_data->parking_info_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="parking_info_es" id="parking_info_es" role="tabpanel" aria-labelledby="special_note_tab4">{{$hotel_data->parking_info_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="parking_info_de" id="parking_info_de" role="tabpanel" aria-labelledby="special_note_tab5">{{$hotel_data->parking_info_de}}</textarea>
                    </div>
                </div>
            </div>
                      -->
                      <h4>Check-in policy</h4>
            <div class="row mt-2">
               

                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="wifi_info_tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="wifi_info_tab1" data-toggle="tab" href="#wifi_info" role="tab" aria-controls="wifi_info" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="wifi_info_tab2" data-toggle="tab" href="#wifi_info_it" role="tab" aria-controls="wifi_info_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="wifi_info_tab3" data-toggle="tab" href="#wifi_info_fr" role="tab" aria-controls="wifi_info_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="wifi_info_tab4" data-toggle="tab" href="#wifi_info_es" role="tab" aria-controls="wifi_info_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="wifi_info_tab5" data-toggle="tab" href="#wifi_info_de" role="tab" aria-controls="wifi_info_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="wifi_info" id="wifi_info" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->wifi_info}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="wifi_info_it" id="wifi_info_it" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->wifi_info_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="wifi_info_fr" id="wifi_info_fr" role="tabpanel" aria-labelledby="special_note_tab3">{{$hotel_data->wifi_info_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="wifi_info_es" id="wifi_info_es" role="tabpanel" aria-labelledby="special_note_tab4">{{$hotel_data->wifi_info_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="wifi_info_de" id="wifi_info_de" role="tabpanel" aria-labelledby="special_note_tab5">{{$hotel_data->wifi_info_de}}</textarea>
                    </div>
                </div>
            </div>
            <!--
            <div class="row mt-2">
                <h4>{{ __('user.childrenpolicy') }}</h4>

                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="childress_policy_tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="childress_policy_tab1" data-toggle="tab" href="#childress_policy" role="tab" aria-controls="childress_policy" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="childress_policy_tab2" data-toggle="tab" href="#childress_policy_it" role="tab" aria-controls="childress_policy_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="childress_policy_tab3" data-toggle="tab" href="#childress_policy_fr" role="tab" aria-controls="childress_policy_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="childress_policy_tab4" data-toggle="tab" href="#childress_policy_es" role="tab" aria-controls="childress_policy_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="childress_policy_tab5" data-toggle="tab" href="#childress_policy_de" role="tab" aria-controls="childress_policy_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="childress_policy" id="childress_policy" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->childress_policy}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="childress_policy_it" id="childress_policy_it" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->childress_policy_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="childress_policy_fr" id="childress_policy_fr" role="tabpanel" aria-labelledby="special_note_tab3">{{$hotel_data->childress_policy_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="childress_policy_es" id="childress_policy_es" role="tabpanel" aria-labelledby="special_note_tab4">{{$hotel_data->childress_policy_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="childress_policy_de" id="childress_policy_de" role="tabpanel" aria-labelledby="special_note_tab5">{{$hotel_data->childress_policy_de}}</textarea>
                    </div>
                </div>
            </div>
 -->
 <h4>City tax info</h4>
            <div class="row mt-2">
               

                <div class="col-sm-12 mt-3">
                    <ul class="nav nav-tabs" id="other_info_tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" id="other_info_tab1" data-toggle="tab" href="#other_info" role="tab" aria-controls="other_info" aria-selected="true"><label for="Policy">English</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="other_info_tab2" data-toggle="tab" href="#other_info_it" role="tab" aria-controls="other_info_it" aria-selected="false"><label for="Policy">Italian</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="other_info_tab3" data-toggle="tab" href="#other_info_fr" role="tab" aria-controls="other_info_fr" aria-selected="false"><label for="Policy">French</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="other_info_tab4" data-toggle="tab" href="#other_info_es" role="tab" aria-controls="other_info_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link" id="other_info_tab5" data-toggle="tab" href="#other_info_de" role="tab" aria-controls="other_info_de" aria-selected="false"><label for="Policy">German</label></a>
                      </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                      <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="other_info" id="other_info" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->other_info}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="other_info_it" id="other_info_it" role="tabpanel" aria-labelledby="special_note_tab1">{{$hotel_data->other_info_it}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="other_info_fr" id="other_info_fr" role="tabpanel" aria-labelledby="special_note_tab3">{{$hotel_data->other_info_fr}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="other_info_es" id="other_info_es" role="tabpanel" aria-labelledby="special_note_tab4">{{$hotel_data->other_info_es}}</textarea>
                      <textarea class="tab-pane fade form-control form-textarea" rows="6" name="other_info_de" id="other_info_de" role="tabpanel" aria-labelledby="special_note_tab5">{{$hotel_data->other_info_de}}</textarea>
                    </div>
                </div>
            </div>
           
            

            <br> 
         <button type="submit" class="btn btn-default btn-save btn-block">{{ __('user.save') }}</button>
                  
        </form>
    </div>
    <div class="toast-message">
        <span class="close"></span>
        <div class="message">
            This is an Alert! But these are some junks to see how alert looks in long messages.
        </div>
    </div>
    <br><br><br>

@endsection

@section('footer_content')
    <!-- JQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.js" integrity="sha512-17lKwKi7MLRVxOz4ttjSYkwp92tbZNNr2iFyEd22hSZpQr/OnPopmgH8ayN4kkSqHlqMmefHmQU43sjeJDWGKg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-timepicker/1.13.18/jquery.timepicker.min.js" integrity="sha512-WHnaxy6FscGMvbIB5EgmjW71v5BCQyz5kQTcZ5iMxann3HczLlBHH5PQk7030XmmK5siar66qzY+EJxKHZTPEQ=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
    <script type="text/javascript">


          function importa_privacy(nome,indirizzo,telefono,email){
  
            $.ajax({
                url : "https://www.phpbookinghotel.it/privacy.php?titolare="+nome+"&indirizzo="+indirizzo+"&email="+email+"&telefono="+telefono,
                success : function (data,stato) {
  
                  $("#policy").text(data);
                  $("#policy_it").text(data);
                  $("#policy_es").text(data);
                  $("#policy_de").text(data);
                  $("#policy_fr").text(data);
                     
                },
                error : function (richiesta,stato,errori) {
                    alert("E' evvenuto un errore. Il stato della chiamata: "+stato);
                }
            });
          }


        $(document).ready(function () {

            $("#paypal").click(function () {
                if($("#paypal").prop('checked') == true){
                    $("#paypal").val(1);
                }
                else {
                    $("#paypal").val(0);
                }
            });


            $('#summernote').summernote({
                height: 600,   // To adjust height (don't use px)
            });

            $('#summernote1').summernote({
                height: 600,   // To adjust height (don't use px)
            });

            $('#summernote2').summernote({
                height: 600,   // To adjust height (don't use px)
            });

            $('#input_starttime').timepicker();
            $('#input_endtime').timepicker();

            $("#bank_transfer").click(function() {
                if ($("#bank_transfer").val() == 0 ) {
                    $("#bank_transfer").val(1);
                }
                else {
                    $("#bank_transfer").val(0);    
                }
            });

        });
    </script>
@endsection

