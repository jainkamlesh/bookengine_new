var HOTELBOOKING = HOTELBOOKING || (function () {

    'use strict';
    var _args = "";

    return {
        init: function (Args) {
            _args = Args;
        },
        callHotelBooking: function () {

            if (_args != undefined && _args != "") {

                var hotel_id = _args;

                var $hotel_booking_form = jQuery('#hotel_booking_form');
                $hotel_booking_form.html("");

                jQuery.ajax({
                    url: "http://admin.booking-engine.it/hotel_booking_form",
                    type: 'GET',
                    data: {data_hotel_id: hotel_id},
                    success: function (data) {
                        $hotel_booking_form.html(data);
                        jQuery('input[name="hotel_id"]').val(hotel_id);
                    }
                });
            }
        }
    };
}());
