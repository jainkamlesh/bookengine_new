@extends('admin.layout.default')

@section('title', 'Download Widget')

@section('pageCSS')
    <link rel="stylesheet" href="{{url('/')}}/css/codemirror.css">
@endsection

@section('overWriteCSS')
    <style>
        .CodeMirror {
            height: auto;
            border: 1px solid #ddd;
        }
    </style>
@endsection

@section('content')
    {{--<section class="property-wrapper mt-4">
        <h2 class="list-heading">{{ __('user.downloadwidget') }}</h2>
    </section>--}}

    <main role="main" class="container">
        <h1 class="mt-5">{{ __('user.howtoaddwidgetinyoursite') }}</h1>
        <!-- <p class="lead">Download below CSS and JS.</p>
        <p><a href="{!! URL::to('hotel_booking_widget.css') !!}" download=""><i class="fa fa-download mr-2"></i>Hotel Booking widget - CSS</a></p>
        <p><a href="{!! URL::to('hotel_booking_widget.js') !!}" download=""><i class="fa fa-download mr-2"></i>Hotel Booking widget - JS</a></p> -->

<!--         <script src="http://admin.booking-engine.it/js/jquery-3.3.1.min.js"></script>
            <link rel="stylesheet" href="http://admin.booking-engine.it/css/hotel_booking_widget.css">
            <script src="http://admin.booking-engine.it/js/hotel_booking_widget.js"></script>
            <div id="hotel_booking_form"></div>
          
            <script type="text/javascript">
                HOTELBOOKING.init("{!! $hotel_id !!}");
                HOTELBOOKING.callHotelBooking();
            </script>
 -->
        <p>{{ __('user.copypastebelowcodeinyoursite') }}</p>
        <textarea class="w-100" id="text_download_info" rows="10">
            <style type="text/css">
                .bookingpersefone_____maschera {
                    left: 0px;
                    margin: 0 auto;
                    z-index: 999;
                    bottom: 0px;
                    position: fixed;
                    width: 100%;
                    background: rgba(80, 77, 77, 0.3);
                    z-index: 99999999999999999999999 !important;
                }
                
                .bookingpersefone_____bottom {
                    padding: 5px 0px;
                    max-width: 890px;
                    margin: 0 auto;
                }
                 .fancybox-overlay {
                    z-index: 99999999999999999999999999 !important;
                }
                </style>

            <div class="bookingpersefone_____maschera">
                <div class="bookingpersefone_____bottom">
                    <script type="text/javascript" src="https://widget.booking-engine.it/maschera.php?hotel_id={!! $hotel_id !!}&jquery=1&bootstrap=0&modal=1&sfondo=ffffff&testo=000000&pulsante=d7993e&testopulsante=FFFFFF&lingua=it"></script> 
                </div>
            </div>
        </textarea>
    </main>
@endsection

@section('footer_content')
    <script src="{{url('/')}}/js/codemirror.js"></script>

    <script>
        var editor = CodeMirror.fromTextArea(document.getElementById("text_download_info"), {
            lineNumbers: true,
            mode: "text/html",
            matchBrackets: true,
            theme: "night",
        });
    </script>
@endsection