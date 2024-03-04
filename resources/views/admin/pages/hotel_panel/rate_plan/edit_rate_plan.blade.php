@extends('admin.layout.default')

@section('title', 'Edit Rate Plan')

@section('content')

    <section class="property-wrapper mt-4">
        <a href="{{route('admin.rate-plan')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.editrateplan') }}</h2>
    </section>

    <form class="row modal-body p-0" method="post" action="{{route('admin.rate-plan.store')}}" enctype='multipart/form-data'>
        @csrf
        <div class="col-sm-12">
            <div class="property-wrapper container mt-5">

                @include('flash-message')
                <div class="modal-body">
                    <input type="hidden" name="id" value="{{$ratePlan->id}}">
                    <?php 
                        if( isset($ratePlan->master_plan_id) ) {
                            $master_plan_id = $ratePlan->master_plan_id;
                        }
                        else {
                            $master_plan_id = 0;
                        }
                    ?>
                    <input type="hidden" name="master_plan_id" value="{{$master_plan_id}}">

                    <div class="row mt-5">
                        <h4>{{ __('user.name') }}</h4>
                        <div class="col-sm-12 mt-3">
                            <ul class="nav nav-tabs" id="name_tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="name_tab1" data-toggle="tab" href="#name" role="tab" aria-controls="name" aria-selected="true"><label for="Policy">English</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="name_tab2" data-toggle="tab" href="#name_it" role="tab" aria-controls="name_it" aria-selected="false"><label for="Policy">Italian</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="name_tab3" data-toggle="tab" href="#name_fr" role="tab" aria-controls="name_fr" aria-selected="false"><label for="Policy">French</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="name_tab4" data-toggle="tab" href="#name_es" role="tab" aria-controls="name_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="name_tab5" data-toggle="tab" href="#name_de" role="tab" aria-controls="name_de" aria-selected="false"><label for="Policy">German</label></a>
                              </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <input type="text" class="tab-pane fade show active form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name', $ratePlan->name) !!}">
                                <input type="text" class="tab-pane fade form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it', $ratePlan->name_it) !!}">
                                <input type="text" class="tab-pane fade form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr', $ratePlan->name_fr) !!}">
                                <input type="text" class="tab-pane fade form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es', $ratePlan->name_es) !!}">
                                <input type="text" class="tab-pane fade form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de', $ratePlan->name_de) !!}">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- <div class="col-sm-6 mt-3 ">
                            <label>Name (En):</label>
                            <input type="text" class="form-control" name="name" value="{!! old('name', $ratePlan->name) !!}">
                        </div>
                        <div class="col-sm-6 mt-3 ">
                            <label>Name (It):</label>
                            <input type="text" class="form-control" name="name_it" value="{!! old('name_it', $ratePlan->name_it) !!}">
                        </div>
                        <div class="col-sm-6 mt-3 ">
                            <label>Name (Fr):</label>
                            <input type="text" class="form-control" name="name_fr" value="{!! old('name_fr', $ratePlan->name_fr) !!}">
                        </div>
                        <div class="col-sm-6 mt-3 ">
                            <label>Name (Es):</label>
                            <input type="text" class="form-control" name="name_es" value="{!! old('name_es', $ratePlan->name_es) !!}">
                        </div>
                        <div class="col-sm-6 mt-3 ">
                            <label>Name (De):</label>
                            <input type="text" class="form-control" name="name_de" value="{!! old('name_de', $ratePlan->name_de) !!}">
                        </div> -->

                        <div class="col-sm-4 mt-3 ">
                            <label>{{ __('user.roomtype') }} :</label>
                            <select name="room_type_id" class="form-control">
                                <option selected="selected" disabled="disabled">-- {{ __('user.selectroomtype') }} --</option>
                                @if($roomTypeCnt > 0)
                                    @foreach($roomType as $key => $value)
                                        <option value="{{$value->id}}" {{$ratePlan->room_type_id == $value->id  ? 'selected' : ''}}>{{$value->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-4 mt-3 ">
                            <label>{{ __('user.ratetype') }} :</label>
                            <select name="rate_type_id" class="form-control">
                                <option selected="selected" disabled="disabled">-- {{ __('user.selectratetype') }} --</option>
                                @if($rateTypeCnt > 0)
                                    @foreach($rateType as $key => $value)
                                        <option value="{{$value->id}}" {{$ratePlan->rate_type_id == $value->id  ? 'selected' : ''}}>{{$value->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-4 mt-3 ">
                            <label>{{ __('user.roombaseprice') }} :</label>
                            <input type="text" class="form-control text_float" name="room_price" value="{!! old('room_price', $ratePlan->room_price) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>
                         

                    </div>
                    <br>
                        <h4>Prezzo di default per occupanti extra</h4>
                        questo prezzo verrà applicato a questo piano tariffario

                        <div class="row">

                        <div class="col-sm-3 mt-3 ">
                            <label>1st {{ __('user.extraadultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult1_rate" value="{!! old('ext_adult1_rate', $ratePlan->ext_adult1_rate) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label>2nd {{ __('user.extraadultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult2_rate" value="{!! old('ext_adult2_rate', $ratePlan->ext_adult2_rate) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label>3rd {{ __('user.extraadultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult3_rate" value="{!! old('ext_adult3_rate', $ratePlan->ext_adult3_rate) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label>4rd {{ __('user.extradultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult4_rate" value="{!! old('ext_adult4_rate', $ratePlan->ext_adult4_rate) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>

                        </div>

                        <div class="row">
                        
                            @for($i=0; $i<3; $i++)
                                <?php
                                $rate_value = "";
                                if ($i == 0) {
                                    $rate_value = $ratePlan->child_age1_rate;
                                }
                                if ($i == 1) {
                                    $rate_value = $ratePlan->child_age2_rate;
                                }
                                if ($i == 2) {
                                    $rate_value = $ratePlan->child_age3_rate;
                                }
                                ?>
                                <div class="col-sm-3 mt-3">
                                    <label>{{ __('user.childagerange') }} {!! ($i+1) !!} {{ __('user.rate') }} :</label>
                                     
                                        <input type="text" class="form-control text_float" name="child_age{!! ($i+1) !!}_rate" value="{!! $rate_value !!}"
                                               onkeypress="return isNumber(event)">
                                </div>
                            @endfor
                         

                        </div>

                        <br>
                        <h4>Valori in % per occupanti extra </h4>
                        Se vuoi che il valore venga percentuale come % della tariffa base della camera
                        <div style="border:1px solid #000000;padding:20px;">
                        <div class="row">

                             
                                    <div class="col-sm-3 sm-3">
                                        <label>1st {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                     
                                   <!-- <div class="col-sm-4">
                                        <input type="text" class="form-control" name="ext_adult1_rate_plus" placeholder="+/-" value="{!! $ratePlan->ext_adult1_rate_plus !!}" >
                                    </div>-->
                                     
                                        <input type="text" class="form-control" name="ext_adult1_rate_percentage" placeholder="%" value="{!! $ratePlan->ext_adult1_rate_percentage !!}" >
                                   
                            </div>

                             <div class="col-sm-3 sm-3">
                                        <label>2nd {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                     
                                   <!--  <div class="col-sm-4">
                                        <input type="text" class="form-control" name="ext_adult2_rate_plus" placeholder="+/-" value="{!! $ratePlan->ext_adult2_rate_plus !!}">
                                    </div>-->
                                   
                                        <input type="text" class="form-control" name="ext_adult2_rate_percentage" placeholder="%" value="{!! $ratePlan->ext_adult2_rate_percentage !!}">
                                    
                            </div>

                            <div class="col-sm-3 sm-3">
                                        <label>3rd {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                    
                                   <!--  <div class="col-sm-4">
                                        <input type="text" class="form-control" name="ext_adult3_rate_plus" placeholder="+/-" value="{!! $ratePlan->ext_adult3_rate_plus !!}">
                                    </div>-->
                                     
                                        <input type="text" class="form-control" name="ext_adult3_rate_percentage" placeholder="%" value="{!! $ratePlan->ext_adult3_rate_percentage !!}">
                                     
                            </div>

                            <div class="col-sm-3 sm-3">
                                        <label>4th {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                   
                                  <!--   <div class="col-sm-4">
                                        <input type="text" class="form-control" name="ext_adult4_rate_plus" placeholder="+/-" value="{!! $ratePlan->ext_adult4_rate_plus !!}">
                                    </div>-->
                                     
                                        <input type="text" class="form-control" name="ext_adult4_rate_percentage" placeholder="%" value="{!! $ratePlan->ext_adult4_rate_percentage !!}">
                                    
                            </div>
                            </div>
                            <div class="row">

                           
                                @for($i=0; $i<3; $i++)
                                    <?php
                                    $add_value = "";
                                    $perc_value = "";
                                    if ($i == 0) {
                                        $add_value = $ratePlan->child_age1_rate_plus;
                                        $perc_value = $ratePlan->child_age1_rate_percentage;
                                    }
                                    if ($i == 1) {
                                        $add_value = $ratePlan->child_age2_rate_plus;
                                        $perc_value = $ratePlan->child_age2_rate_percentage;
                                    }
                                    if ($i == 2) {
                                        $add_value = $ratePlan->child_age3_rate_plus;
                                        $perc_value = $ratePlan->child_age3_rate_percentage;
                                    }
                                    ?>
                                    <div class="col-sm-3 sm-3">
                                        <label>{{ __('user.childagerange') }} {!! ($i+1) !!} {{ __('user.rate') }} {{ __('label.config') }}:</label>
                                       <!-- <div class="col-sm-4">
                                            <input type="text" class="form-control" name="child_age{!! ($i+1) !!}_rate_plus"
                                                   placeholder="+/-" value="{!! $add_value !!}">
                                        </div>-->
                                         
                                            <input type="text" class="form-control" name="child_age{!! ($i+1) !!}_rate_percentage"
                                                   placeholder="%" value="{!! $perc_value !!}">
                                        
                                    </div>
                                @endfor
                             
                        </div>
                        </div>

                        <div class="row">
                        <div class="col-sm-3 mt-3 ">
                            <label>{{ __('user.minnights') }} ({{ __('user.minstay') }}) :</label>
                            <input type="text" class="form-control text_int" name="min_nights" value="{!! old('min_nights', $ratePlan->min_nights) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label>{{ __('user.maxnights') }} ({{ __('user.maxstay') }}) :</label>
                            <input type="text" class="form-control text_int" name="max_nights" value="{!! old('max_nights', $ratePlan->max_nights) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="single_stay" id="single_stay" @if($ratePlan->single_stay == "on") checked @endif> {{ __('user.cansinglestay') }}
                            </label>
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cc_required" id="cc_required" @if($ratePlan->cc_required == "on") checked @endif> {{ __('user.ccrequired') }}?
                            </label>
                        </div>

                        <div class="col-sm-3 mt-2 div_single_price">
                            <label>{{ __('user.singlerate') }} :</label>
                            <input type="text" class="form-control text_float" name="single_price" value="{!! old('single_price', $ratePlan->single_price) !!}"
                                   onkeypress="return isNumber(event)">
                        </div>
                        <input type="hidden" name="is_master" value="{!! $ratePlan->is_master !!}">

                        @if( $ratePlan->is_master == 0 )
                        <div class="col-sm-3 mt-2">
                            <label>{{ __('label.derivedpercentage') }} :</label>
                            <input type="text" class="form-control" name="derived_percentage" value="{!! $ratePlan->derived_percentage !!}" >
                        </div>
                        @endif

                    
                    </div>
                   
                     
                    
<!--
                    <div class="row mt-5">
                        <h4>{{ __('user.bookingcondition') }}</h4>
                        <div class="col-sm-12 mt-3">
                            <ul class="nav nav-tabs" id="booking_condition_tab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="booking_condition_tab1" data-toggle="tab" href="#booking_condition" role="tab" aria-controls="booking_condition" aria-selected="true"><label for="Policy">English</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="booking_condition_tab2" data-toggle="tab" href="#booking_condition_it" role="tab" aria-controls="booking_condition_it" aria-selected="false"><label for="Policy">Italian</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="booking_condition_tab3" data-toggle="tab" href="#booking_condition_fr" role="tab" aria-controls="booking_condition_fr" aria-selected="false"><label for="Policy">French</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="booking_condition_tab4" data-toggle="tab" href="#booking_condition_es" role="tab" aria-controls="booking_condition_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="booking_condition_tab5" data-toggle="tab" href="#booking_condition_de" role="tab" aria-controls="booking_condition_de" aria-selected="false"><label for="Policy">German</label></a>
                              </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                              <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="booking_condition" id="booking_condition" role="tabpanel" aria-labelledby="booking_condition_tab1">{!! $ratePlan->booking_condition !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_it" id="booking_condition_it" role="tabpanel" aria-labelledby="booking_condition_tab1">{!! $ratePlan->booking_condition_it !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_fr" id="booking_condition_fr" role="tabpanel" aria-labelledby="booking_condition_tab3">{!! $ratePlan->booking_condition_fr !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_es" id="booking_condition_es" role="tabpanel" aria-labelledby="booking_condition_tab4">{!! $ratePlan->booking_condition_es !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_de" id="booking_condition_de" role="tabpanel" aria-labelledby="booking_condition_tab5">{!! $ratePlan->booking_condition_de !!}</textarea>
                            </div>
                        </div>
                    </div>
                            -->
                
         
        <div class="col-sm-12 mt-3">
            <div class="property-wrapper container modal-footer text-left d-block">
                <button type="submit" class="btn btn-default btn-save pull-right">{{ __('user.save') }}</button>
            </div>
        </div>

    </form>
    <br><br><br>

    <div class="toast-message">
        <span class="close"></span>
        <div class="message">
            This is an Alert! But these are some junks to see how alert looks in long messages.
        </div>
    </div>
@endsection

@section('validations')

@endsection

@section('footer_content')
    <script type="text/javascript">
        $(function () {

            $('.div_single_price').hide();

            function manageSinglePrice() {
                $('.div_single_price').hide();

                if ($('#single_stay').prop("checked") == true) {

                    $('.div_single_price').show();
                }
            }

            manageSinglePrice();

            $('#single_stay').change(function () {
                manageSinglePrice();
            });
        });
    </script>
@endsection
