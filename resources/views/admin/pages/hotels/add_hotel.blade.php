@extends('admin.layout.default')
@section('title', 'Hotel System')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.hotels')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('label.addhotel') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="row p-0" method="post" action="{{route('admin.hotel.store')}}">
            @csrf

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="Hotel Name">{{ __('label.hotelname') }} :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="Name of the hotel and which is standard which will not change in future and same will not use by other"></i>
                        </label>
                        <input type="text" class="form-control" id="Hotel Name" name="name" value="{!! old('name') !!}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="Address">{{ __('label.address') }} :</label>
                        <textarea class="form-control form-textarea" rows="6" name="address" id="Address">{!! old('address') !!}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.city') }} :</label>
                        <input type="text" class="form-control" id="city" name="city" value="{!! old('city') !!}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.state') }} :</label>
                        <input type="text" class="form-control" id="state" name="state" value="{!! old('state') !!}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.country') }} :</label>
                        <input type="text" class="form-control" id="country" name="country" value="{!! old('country') !!}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.postalcode') }} :</label>
                        <input type="text" class="form-control" id="postal_code" name="postal_code" value="{!! old('postal_code') !!}">
                    </div>
                </div>

                <div class="row">
                    
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.latitude') }} :</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="{!! old('latitude') !!}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.longitude') }} :</label>
                        <input type="text" class="form-control" id="longtiude" name="longtiude" value="{!! old('longtiude') !!}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.mobile') }} :</label>
                        <input type="number" class="form-control" name="mobile" value="{!! old('mobile') !!}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.contactname') }} :</label>
                        <input type="text" class="form-control" name="contact_name" value="{!! old('contact_name') !!}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.contactemail') }} :</label>
                        <input type="text" class="form-control" name="contact_email" value="{!! old('contact_email') !!}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.username') }} :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="Each hotel is required our extranet for seen their hotel detail, reservation and all so we can provide this username & password, so
                                using this they can see their own hotel extranet"></i>
                        </label>
                        <input type="text" class="form-control" name="username" value="{!! old('username') !!}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.password') }} :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="Each hotel is required our extranet for seen their hotel detail, reservation and all so we can provide this username & password, so
                                using this they can see their own hotel extranet"></i>
                        </label>
                        <input type="Password" class="form-control" name="password">
                    </div>

                    <div class="col-sm-6 mt-3">
                        <label>Review Hotel ID :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="Please enter hotel id which is from review system so we can show review summary on booking engine"></i>
                        </label>
                        <input type="text" class="form-control" name="review_hotel_id">
                    </div>

                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.hoteltype') }} :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="This is usefull to show booking engine front page either it is hotel or apartment, by default it is hotel"></i>
                        </label>
                        <select name="booking_engine_type" class="form-control">
                            <option value="Hotel" selected>Hotel</option>
                            <option value="Apartment">Apartment</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="google" id="google" value="N"> Google :
                        </label>
                    </div>
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="adult_only" id="adult_only" value="N"> Adult Only :
                        </label>
                    </div>
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="dont_show_na_calendar" id="dont_show_na_calendar" value="N"> Don't Show NA Calendar :
                        </label>
                    </div>
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="on_request_booking" id="on_request_booking" value="N"> Google :
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="customcss">{{ __('label.customcss') }} :</label>
                        <textarea class="form-control form-textarea" rows="6" name="custom_css" id="custom_css"></textarea>
                    </div>
                </div>

                <div class="modal-footer property-wrapper">
                    <button type="submit" class="btn btn-default btn-save">{{ __('label.save') }}</button>
                </div>
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
    $("#Address").change(function(){
    var address = $("#Address").val();

    $.ajaxSetup({
    headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
    });

    $.ajax({
    url: SITE_URL + '/google_map_api',
    type: "post",
    data: { address : $("#Address").val() },
    success: function(data){
    data1 = $.parseJSON(data)


    $("#latitude").val(data1.lat);
    $("#longtiude").val(data1.long);
    $("#city").val(data1.city);
    $("#state").val(data1.state);
    $("#country").val(data1.country);
    $("#postal_code").val(data1.postal_code);


    }
    });
    });


    $(document).ready(function(){
        $('#google').click(function(){
            if($(this).prop("checked") == true){
                $(this).val('Y');
            }
            else if($(this).prop("checked") == false){
                $(this).val('N');
            }
        });

        $('#adult_only').click(function(){
            if($(this).prop("checked") == true){
                $(this).val('Y');
            }
            else if($(this).prop("checked") == false){
                $(this).val('N');
            }
        });

        $('#dont_show_na_calendar').click(function(){
            if($(this).prop("checked") == true){
                $(this).val('Y');
            }
            else if($(this).prop("checked") == false){
                $(this).val('N');
            }
        });

        $('#on_request_booking').click(function(){
            if($(this).prop("checked") == true){
                $(this).val('Y');
            }
            else if($(this).prop("checked") == false){
                $(this).val('N');
            }
        });
    });

@endsection
 