@extends('admin.layout.default')

@section('title', 'Add Rate Plan')

@section('content')

    <section class="property-wrapper mt-4">
        <a href="{{route('admin.rate-plan')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="" ss="back-image"></a>
        <h2 class="list-heading">{{ __('user.addrateplan') }}</h2>
    </section>

    <form class="row modal-body p-0" method="post" action="{{route('admin.rate-plan.store')}}" enctype='multipart/form-data'>
        @csrf
        <div class="col-sm-12">
            <div class="property-wrapper container mt-5">

                @include('flash-message')

                <input type="hidden" name="is_master" value="1">
                <input type="hidden" name="master_plan_id" value="0">

                <div class="row">
  
                        <div class="col-sm-4 mt-3 ">
                            <label>{{ __('user.roomtype') }} :</label>
                            <select id="room_type_id" name="room_type_id" class="form-control">
                                <option selected="selected" disabled="disabled">-- {{ __('user.selectroomtype') }} --</option>
                                @if($roomTypeCnt > 0)
                                    @foreach($roomType as $key => $value)
                                        <?php
                                        $selected = "";
                                        if (old('room_type_id') == $value->id) {
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option data-fr="{!! $value->name_fr !!}" data-de="{!! $value->name_de !!}" data-es="{!! $value->name_es !!}" data-it="{!! $value->name_it !!}" data-en="{!! $value->name !!}" value="{!! $value->id !!}" {!! $selected !!}>{!! $value->name !!}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-4 mt-3 ">
                            <label>{{ __('user.ratetype') }} :</label>
                            <select onchange="$('#booking_condition_fr').val($('#rate_type_id option:selected').data('condfr')); $('#booking_condition_es').val($('#rate_type_id option:selected').data('condes')); $('#booking_condition_de').val($('#rate_type_id option:selected').data('condde')); $('#booking_condition').val($('#rate_type_id option:selected').data('conden')); $('#booking_condition_it').val($('#rate_type_id option:selected').data('condit')); $('#name_it').val($('#room_type_id option:selected').data('it')+' - tariffa '+$('#rate_type_id option:selected').data('it'));  $('#name').val($('#room_type_id option:selected').data('en')+ ' - '+$('#rate_type_id option:selected').data('en')+'  rate');   $('#name_fr').val($('#room_type_id option:selected').data('fr')+' - tarif '+$('#rate_type_id option:selected').data('fr'));  $('#name_de').val($('#room_type_id option:selected').data('de')+' - tarif '+$('#rate_type_id option:selected').data('de'));  $('#name_es').val($('#room_type_id option:selected').data('es')+' - tarif '+$('#rate_type_id option:selected').data('es'));" id="rate_type_id" name="rate_type_id" class="form-control">
                                <option selected="selected" disabled="disabled">-- {{ __('user.selectratetype') }} --</option>
                                @if($rateTypeCnt > 0)
                                    @foreach($rateType as $key => $value)
                                        <?php
                                        $selected = "";
                                        if (old('rate_type_id') == $value->id) {
                                            $selected = "selected";
                                        }
                                        ?>
                                        <option data-fr="{!! $value->name_fr !!}" data-de="{!! $value->name_de !!}" data-es="{!! $value->name_es !!}" data-it="{!! $value->name_it !!}" data-en="{!! $value->name !!}" value="{!! $value->id !!}" {!! $selected !!}>{!! $value->name_it !!}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-sm-4 mt-3 ">
                        <button type="submit" class="btn btn-default btn-save pull-right">{{ __('user.save') }}</button>
                        </div>
                    </div>

                <div class="modal-body">
                    <div class="row mt-5">
                        <h4>{{ __('user.name') }}</h4>
                        <div class="col-sm-12 mt-3">
                          <!--  <ul class="nav nav-tabs" id="name_tab" role="tablist">
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
                            <div class="tab-content" id="myTabContent"> -->
                                English
                                <input class="form-control" type="text" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name') !!}"> <br>
                                <!--<input type="text" class="tab-pane fade form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it') !!}">-->
                                Italiano
                                <input class="form-control" onchange="$('#name').val($('#name_it').val()); $('#name_fr').val($('#name_it').val()); $('#name_es').val($('#name_it').val());$('#name_de').val($('#name_it').val());" type="text" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it') !!}"><br>
                                Francese
                                <input class="form-control" type="text"  name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr') !!}"><br>
                                Spagnolo
                                <input class="form-control" type="text"  name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es') !!}"><br>
                                Tedesco
                                <input class="form-control" type="text"  name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de') !!}"><br>
                          <!--  </div>
                        </div>-->
                    </div>

                    <div class="row">
                          <div class="col-sm-12 mt-6 ">
                            <label>{{ __('user.roombaseprice') }} :</label>
                            <input type="text" class="form-control text_float" name="room_price" value="999" onkeypress="return isNumber(event)">
                        </div>
                   </div>
                   
                   <!--
                    <div class="row">

                        <div class="col-sm-3 mt-3 ">
                            <label>1st {{ __('user.extraadultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult1_rate" value="0" onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label>2nd {{ __('user.extraadultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult2_rate" value="0" onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label>3rd {{ __('user.extraadultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult3_rate" value="0" onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-3 mt-3 ">
                            <label>4rd {{ __('user.extraadultrate') }} :</label>
                            <input type="text" class="form-control text_float" name="ext_adult4_rate" value="0" onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-12 mt-3">
                            @for($i=0; $i<3; $i++)
                                <?php
                                $rate_value = "";
                                ?>
                                <div class="row mt-3">
                                    <label class="col-sm-3">{{ __('user.childagerange') }} {!! ($i+1) !!} {{ __('user.rate') }} :</label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control text_float" name="child_age{!! ($i+1) !!}_rate"
                                               value="0" onkeypress="return isNumber(event)">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-sm-12 mt-3">
                            <div class="row mt-3">
                                <div class="col sm-3">
                                    <label>1st {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult1_rate_plus" placeholder="+/-" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult1_rate_percentage" placeholder="%" >
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="row mt-3">
                                <div class="col sm-3">
                                    <label>2nd {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult2_rate_plus" placeholder="+/-" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult2_rate_percentage" placeholder="%" >
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="row mt-3">
                                <div class="col sm-3">
                                    <label>3rd {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult3_rate_plus" placeholder="+/-" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult3_rate_percentage" placeholder="%" >
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            <div class="row mt-3">
                                <div class="col sm-3">
                                    <label>4th {{ __('user.extraadultrate') }} {{ __('label.config') }}:</label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult4_rate_plus" placeholder="+/-" >
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control text_float" name="ext_adult4_rate_percentage" placeholder="%" >
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12 mt-3">
                            @for($i=0; $i<3; $i++)
                                <?php
                                $rate_value = "";
                                ?>
                                <div class="row mt-4">
                                    <label class="col-sm-3">{{ __('user.childagerange') }} {!! ($i+1) !!} {{ __('user.rate') }} {{ __('label.config') }}:</label>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text_float" name="child_age{!! ($i+1) !!}_rate_plus"
                                               placeholder="+/-">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control text_float" name="child_age{!! ($i+1) !!}_rate_percentage"
                                               placeholder="%">
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                                    -->

                        <div style="display:none">

                            <div class="col-sm-6 mt-3 ">
                                <label>{{ __('user.minnights') }} ({{ __('user.minstay') }}) :</label>
                                <input type="text" class="form-control text_int" name="min_nights" value="1" onkeypress="return isNumber(event)">
                            </div>

                            <div class="col-sm-6 mt-3 ">
                                <label>{{ __('user.maxnights') }} ({{ __('user.maxstay') }}) :</label>
                                <input type="text" class="form-control text_int" name="max_nights" value="30" onkeypress="return isNumber(event)">
                            </div>

                        </div>


                        <div class="col-sm-6 mt-3 ">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="single_stay" id="single_stay"> {{ __('user.cansinglestay') }}
                            </label>
                        </div>

                        <div class="col-sm-6 mt-3 ">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="cc_required" id="cc_required" checked> {{ __('user.ccrequired') }}?
                            </label>
                        </div>

                        <div class="col-sm-6 mt-2 div_single_price">
                            <label>{{ __('user.singlerate') }} :</label>
                            <input type="text" class="form-control text_float" name="single_price" value="{!! old('single_price') !!}" onkeypress="return isNumber(event)">
                        </div>
                    </div>
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
                              <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="booking_condition" id="booking_condition" role="tabpanel" aria-labelledby="booking_condition_tab1">{!! old('booking_condition') !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_it" id="booking_condition_it" role="tabpanel" aria-labelledby="booking_condition_tab1">{!! old('booking_condition_it') !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_fr" id="booking_condition_fr" role="tabpanel" aria-labelledby="booking_condition_tab3">{!! old('booking_condition_fr') !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_es" id="booking_condition_es" role="tabpanel" aria-labelledby="booking_condition_tab4">{!! old('booking_condition_es') !!}</textarea>
                              <textarea class="tab-pane fade form-control form-textarea" rows="6" name="booking_condition_de" id="booking_condition_de" role="tabpanel" aria-labelledby="booking_condition_tab5">{!! old('booking_condition_de') !!}</textarea>
                            </div>
                        </div>
                    </div>
                                    -->
                </div>
            </div>
        </div>

        <div class="col-sm-12 mt-3">
            <div class="property-wrapper container modal-footer text-left d-block">
                <button type="submit" class="btn btn-default btn-save pull-right">{{ __('user.save') }}</button>
            </div>
        </div>

    </form>

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

            $('#single_stay').prop("checked", false);
            $('.div_single_price').hide();

            function manageSinglePrice() {
                $('.div_single_price').hide();

                if ($('#single_stay').prop("checked") == true) {

                    $('.div_single_price').show();
                }
            }

            $('#single_stay').change(function () {
                manageSinglePrice();
            });
        });
    </script>
@endsection
 