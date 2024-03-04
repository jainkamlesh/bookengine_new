@extends('admin.layout.default')
@section('title', 'Edit Hotel')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.hotels')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('label.edithotel') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.hotel.store')}}">
            @csrf
            <input type="hidden" name="id" value="{{$hotel->id}}">

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label for="Hotel Name">{{ __('label.hotelname') }} :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="Name of the hotel and which is standard which will not change in future and same will not use by other"></i>
                        </label>
                        <input type="text" class="form-control" id="Hotel Name" name="name" value="{{$hotel->name}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="Address">{{ __('label.address') }} :</label>
                        <textarea class="form-control form-textarea" rows="6" name="address" id="Address">{{$hotel->address}}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.city') }} :</label>
                        <input type="text" class="form-control" name="city" value="{{$hotel->city}}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.state') }} :</label>
                        <input type="text" class="form-control" name="state" value="{{$hotel->state}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.country') }} :</label>
                        <input type="text" class="form-control" id="country" value="{{$hotel->country}}" name="country">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.postalcode') }} :</label>
                        <input type="text" class="form-control" name="postal_code" value="{{$hotel->postal_code}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.latitude') }} :</label>
                        <input type="text" class="form-control" id="latitude" value="{{$hotel->latitude}}" name="latitude">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.longitude') }} :</label>
                        <input type="text" class="form-control" value="{{$hotel->longtiude}}" id="longtiude" name="longtiude">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.mobile') }} :</label>
                        <input type="number" class="form-control" name="mobile" value="{{$hotel->mobile}}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.contactname') }} :</label>
                        <input type="text" class="form-control" name="contact_name" value="{{$hotel->contact_name}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.contactemail') }} :</label>
                        <input type="text" class="form-control" name="contact_email" value="{{$hotel->contact_email}}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.username') }} : <i class="fa fa-info-circle" data-toggle="tooltip" title="Each hotel is required our extranet for seen their hotel detail,
                         reservation and all so we can provide this username & password, so using this they can see their own hotel extranet"></i>
                        </label>
                        <input type="text" class="form-control" name="username" value="{{$hotel->username}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.password') }} : <i class="fa fa-info-circle" data-toggle="tooltip" title="Each hotel is required our extranet for seen their hotel detail,
                         reservation and all so we can provide this username & password, so using this they can see their own hotel extranet"></i>
                        </label>
                        <input type="text" class="form-control" name="password" value="{{$hotel->password}}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>Review Hotel ID :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="Please enter hotel id which is from review system so we can show review summary on booking engine"></i>
                        </label>
                        <input type="text" class="form-control" name="review_hotel_id" value="{{$hotel->review_hotel_id}}">
                    </div>
                    <div class="col-sm-6 mt-3">
                        <label>{{ __('label.hoteltype') }} :
                            <i class="fa fa-info-circle" data-toggle="tooltip"
                               title="This is usefull to show booking engine front page either it is hotel or apartment, by default it is hotel"></i>
                        </label>
                        <select name="booking_engine_type" class="form-control">
                            <option value="Hotel" @if($hotel->booking_engine_type == 'Hotel') selected @endif>Hotel</option>
                            <option value="Apartment" @if($hotel->booking_engine_type == 'Apartment') selected @endif>Apartment</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="google" id="google" @if($hotel->google == "Y") checked value="Y" @else value="N" @endif> Google :
                        </label>
                    </div>
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="adult_only" id="adult_only" @if($hotel->adult_only == "Y") checked value="Y" @else value="N" @endif> Adult Only :
                        </label>
                    </div>
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="dont_show_na_calendar" id="dont_show_na_calendar" @if($hotel->dont_show_na_calendar == "Y") checked value="Y" @else value="N" @endif> Don't Show NA Calendar :
                        </label>
                    </div>
                    <div class="col-sm-4 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="on_request_booking" id="on_request_booking" @if($hotel->on_request_booking == "Y") checked value="Y" @else value="N" @endif> On Request Booking :
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="customcss">{{ __('label.customcss') }} :</label>
                        <textarea class="form-control form-textarea" rows="6" name="custom_css" id="custom_css">{{$hotel->custom_css}}</textarea>
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
@section('footer_content')
<script type="text/javascript">
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
</script>
@endsection
 