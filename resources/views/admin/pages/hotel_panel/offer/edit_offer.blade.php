@extends('admin.layout.default')

@section('title', 'Edit Offer')

@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.offer')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.editoffer') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.offer.store')}}" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="id" value="{{$offer->id}}">

            <div class="modal-body">

            <div class="row">
  
                <div class="col-sm-6">
                @if($offer->image)
                        <img src="{{url('public/images/offer/')}}/{{$offer->image}}" width="100" height="100">
                    @endif
                </div>
                <div class="col-sm-6">
                    <label>{{ __('user.image') }}</label>
                    <input type="file" class="form-control" name="image">

                </div>
            </div>

           
                <div class="row">
                  
                    <div class="col-sm-6">
                         
                    <h4>{{ __('user.name') }}</h4>

                            English
                            <input type="text" class="form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name', $offer->name) !!}">
                            Italiano
                            <input type="text" class="form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it', $offer->name_it) !!}">
                            Francese
                            <input type="text" class="form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr', $offer->name_fr) !!}">
                            Spagnolo
                            <input type="text" class="form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es', $offer->name_es) !!}">
                            Tedesco
                            <input type="text" class="form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de', $offer->name_de) !!}">
                        
                    </div>
                    <div class="col-sm-6">

 
                        <h4>{{ __('user.description') }}</h4>

                        English
                          <textarea class="form-control form-textarea" rows="6" name="description" id="description" role="tabpanel" aria-labelledby="description_tab1">{!! $offer->description !!}</textarea>
                          Italiano
                           <textarea class="form-control form-textarea" rows="6" name="description_it" id="description_it" role="tabpanel" aria-labelledby="description_tab1">{!! $offer->description_it !!}</textarea>
                           Francese
                           <textarea class="form-control form-textarea" rows="6" name="description_fr" id="description_fr" role="tabpanel" aria-labelledby="description_tab3">{!! $offer->description_fr !!}</textarea>
                           Spagnolo
                            <textarea class="form-control form-textarea" rows="6" name="description_es" id="description_es" role="tabpanel" aria-labelledby="description_tab4">{!! $offer->description_es !!}</textarea>
                            Tedesco
                             <textarea class="form-control form-textarea" rows="6" name="description_de" id="description_de" role="tabpanel" aria-labelledby="description_tab5">{!! $offer->description_de !!}</textarea>
     
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-4 mt-3 ">
                        <label>{{ __('user.validfrom') }} :</label>
                        <input type="date" class="form-control" name="valid_from" value="{{$offer->valid_from}}">
                    </div>
                    <div class="col-sm-4 mt-3 ">
                        <label>{{ __('user.validto') }} :</label>
                        <input type="date" class="form-control" name="valid_to" value="{{$offer->valid_to}}">
                    </div>
                 
                    <div class="col-sm-4 mt-3 ">
                        <label>{{ __('user.discountpercentage') }} :</label>
                        <input type="text" class="form-control text_float" name="discount_percentage" value="{{$offer->discount_percentage}}" onkeypress="return isNumber(event)">
                    </div>
                </div>

                <div class="row">
                    @php
                        $offer->exclusive_days = json_decode($offer->exclusive_days, true);
                    @endphp
                    <div class="col-sm-12 mt-3">
                        <label>{{ __('user.excludedaysoff') }} :</label>
                        @foreach($offer->exclusive_days as $exclusive_days)
                            <div class='input-form mb-2'>
                                <input type='date' placeholder='Enter Exclude days Off' id='name_1' class='txt form-control' name="exclusive_days[]" value="{{$exclusive_days['exclusive_days']}}">
                            </div>
                        @endforeach
                        <input type='date' placeholder='Enter Exclude days Off' id='name_1' class='txt form-control' name="exclusive_days[]">

                        <!--<input type='button' id='but_add' value='Add new'>-->
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('user.roomlist') }} :</label><br>
                        @php
                            $offer->room_list = json_decode($offer->room_list, true);
                            $ar_offer_room_list = $offer->room_list;

                            $ar_offer_roomID = array();
                            foreach($ar_offer_room_list as $key => $value){
                                if(isset($value['room_list'])) {
                                    array_push($ar_offer_roomID, $value['room_list']);
                                }
                            }
                        @endphp
                        @if(($rate_planCnt > 0))
                            @foreach($rate_plan as $key => $value)
                                <?php
                                $checked = "";
                                if (isset($ar_offer_roomID) && !empty($ar_offer_roomID)) {
                                    if (in_array($value->id, $ar_offer_roomID)) {
                                        $checked = "checked";
                                    }
                                }
                                ?>
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="room_list[]" value="{{$value->id}}" {!! $checked !!}> {{$value->name}}
                                </label>
                            @endforeach
                        @endif

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        @php
                            $offer->days_of_week = json_decode($offer->days_of_week, true);
                            $week_arr = array();
                            foreach($offer->days_of_week as $key => $value) {
                              $week_arr[] = $value['days_of_week'];
                            }
                        @endphp


                        <label>{{ __('user.daysofweek') }} :</label><br>
                        <label class="checkbox-inline">
                            <label>
                                <input type="checkbox" name="days_of_week[]" <?php if(in_array("Monday", $week_arr)) {?> checked="checked" <?php } ?>  value="Monday">
                                {{ __('user.monday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" <?php if(in_array("Tuesday", $week_arr)) {?> checked="checked" <?php } ?> value="Tuesday">
                                {{ __('user.tuesday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" <?php if(in_array("Wednesday", $week_arr)) {?> checked="checked" <?php } ?> value="Wednesday">
                                {{ __('user.wednesday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" <?php if(in_array("Thursday", $week_arr)) {?> checked="checked" <?php } ?> value="Thursday">
                                {{ __('user.thursday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" <?php if(in_array("Friday", $week_arr)) {?> checked="checked" <?php } ?> value="Friday">
                                {{ __('user.friday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" <?php if(in_array("Saturday", $week_arr)) {?> checked="checked" <?php } ?> value="Saturday">
                                {{ __('user.saturday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" <?php if(in_array("Sunday", $week_arr)) {?> checked="checked" <?php } ?> value="Sunday"> {{ __('user.sunday') }}
                            </label>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <!-- <h5>Condition</h5> -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">{{ __('user.condition') }}</th>
                                <th scope="col">{{ __('user.minimumvalue') }}</th>
                                <th scope="col">{{ __('user.maximumvalue') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                @if($offer->min_no_of_adults || $offer->max_no_of_adults>0)
                                    @php $is_checked = 'checked'; @endphp
                                @else
                                    @php $is_checked = ''; @endphp
                                @endif
                                <td><input type="checkbox" {{$is_checked}} name="no_of_adults">&ensp;{{ __('user.numberofadult') }}</td>
                                <td><input type="text" class="form-control" placeholder="Enter Minimum Value" name="min_no_of_adults" value="{{$offer->min_no_of_adults}}"></td>
                                <td><input type="text" class="form-control" placeholder="Enter Maximum Value" name="max_no_of_adults" value="{{$offer->max_no_of_adults}}"></td>
                            </tr>
                            <tr>
                                @if($offer->min_no_of_child)
                                    @php $is_checked = 'checked'; @endphp
                                @else
                                    @php $is_checked = ''; @endphp
                                @endif
                                <td><input type="checkbox" {{$is_checked}} name="no_of_child">&ensp;{{ __('user.numberofchild') }}</td>
                                <td><input type="text" class="form-control" placeholder="Enter Minimum Value" name="min_no_of_child" value="{{$offer->min_no_of_child}}"></td>
                                <td><input type="text" class="form-control" placeholder="Enter Maximum Value" name="max_no_of_child" value="{{$offer->max_no_of_child}}"></td>
                            </tr>
                            <tr>
                                @if($offer->min_days_in_advance)
                                    @php $is_checked = 'checked'; @endphp
                                @else
                                    @php $is_checked = ''; @endphp
                                @endif
                                <td><input type="checkbox" {{$is_checked}} name="days_in_advance">&ensp;{{ __('user.daysinadvance') }}</td>
                                <td><input type="text" class="form-control" placeholder="Enter Minimum Value" name="min_days_in_advance" value="{{$offer->min_days_in_advance}}"></td>
                                <td><input type="text" class="form-control" placeholder="Enter Maximum Value" name="max_days_in_advance" value="{{$offer->max_days_in_advance}}"></td>
                            </tr>

                            <tr>
                                @if($offer->min_no_of_night)
                                    @php $is_checked = 'checked'; @endphp
                                @else
                                    @php $is_checked = ''; @endphp
                                @endif
                                <td><input type="checkbox" {{$is_checked}} name="no_of_night">&ensp;{{ __('user.noofnight') }}</td>
                                <td><input type="text" class="form-control" placeholder="Enter Minimum Night" name="min_no_of_night" value="{{$offer->min_no_of_night}}"></td>
                                <td><input type="text" class="form-control" placeholder="Enter Maximum Night" name="max_no_of_night" value="{{$offer->max_no_of_night}}"></td>
                            </tr>

                            <tr>
                                <td>
                                    <label class="checkbox-inline">
                                        @if($offer->mobile_offer)
                                            @php $is_checked = 'checked'; @endphp
                                        @else
                                            @php $is_checked = ''; @endphp
                                        @endif
                                        <input type="checkbox" {{$is_checked}} name="mobile_offer"> {{ __('user.mobileoffer') }}
                                    </label>
                                </td>
                                <td></td>
                                <td></td>
                            </tr>

                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-save">{{ __('user.save') }}</button>
            </div>

        </form>
    </div>

    <div class="toast-message">
        <span class="close"></span>
        <div class="message">
            This is an Alert! But these are some junks to see how alert looks in long messages.
        </div>
    </div>
@endsection

@section('validations')
    $('#but_add').click(function(){
    var newel = $('.input-form:last').clone();
    $(newel).insertAfter(".input-form:last");
    });
@endsection

@section('footer_content')
@endsection
 