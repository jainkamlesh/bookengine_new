@extends('admin.layout.default')
@section('title', 'Add Coupon')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.coupon')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="" ss="back-image"></a>
        <h2 class="list-heading">{{ __('user.addcoupon') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.coupon.store')}}" enctype='multipart/form-data'>
            @csrf

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.couponcode') }} :</label>
                        <input type="text" class="form-control" name="code" value="{!! old('code') !!}">
                    </div>
                    <div class="col-sm-3 mt-3 ">
                        <label>{{ __('user.discountpercentage') }} :</label>
                        <input type="text" class="form-control text_float" name="discount_percentage" value="{!! old('discount_percentage') !!}"
                               onkeypress="return isNumber(event)">
                    </div>
                    <div class="col-sm-3 mt-3 ">
                        <label>{{ __('user.fixeddiscount') }} :</label>
                        <input type="text" class="form-control text_float" name="fixed_discount" value="{!! old('fixed_discount') !!}"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.validfrom') }} :</label>
                        <input type="date" class="form-control" name="valid_from" value="{!! old('valid_from') !!}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.validto') }} :</label>
                        <input type="date" class="form-control" name="valid_to" value="{!! old('valid_to') !!}">
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
@section('footer_content')
<script type="text/javascript">
    jQuery('input[name="valid_from"]').daterangepicker({
        singleDatePicker: true,
        locale: {
            cancelLabel: 'Clear'
        },
        minDate: moment(),
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    jQuery('input[name="valid_from"]').on('apply.daterangepicker', function(ev, picker) {
        jQuery('#valid_from').val(picker.startDate.format('YYYY-MM-DD'));
    });

    jQuery('input[name="valid_to"]').daterangepicker({
        singleDatePicker: true,
        locale: {
            cancelLabel: 'Clear'
        },
        minDate: moment(),
        locale: {
            format: 'YYYY-MM-DD'
        }
    });

    jQuery('input[name="valid_to"]').on('apply.daterangepicker', function(ev, picker) {
        jQuery('#valid_to').val(picker.startDate.format('YYYY-MM-DD'));
    });
</script>
@endsection
 