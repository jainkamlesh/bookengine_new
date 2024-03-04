@extends('admin.layout.default')
@section('title', 'Add Room Facility')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.whatsapp-template')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('label.addwhatsapptemplate') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.whatsapp-template.store')}}" enctype='multipart/form-data'>
            @csrf

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('label.name') }} :</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('label.message') }} :</label>
                         <br>
                         <div class="mb-3">
                             <span class="btn btn-default btn-save" onclick="addtext('{id}')">{id}</span>
                             <span class="btn btn-default btn-save" onclick="addtext('{check-in}')">{check-in}</span>
                             <span class="btn btn-default btn-save" onclick="addtext('{check-out}')">{check-out}</span>
                             <span class="btn btn-default btn-save" onclick="addtext('{referer}')">{referer}</span>
                             <span class="btn btn-default btn-save" onclick="addtext('{deposit}')">{deposit}</span>
                             <span class="btn btn-default btn-save" onclick="addtext('{quotation-link}')">{quotation-link}</span>
                         </div>
                        <textarea name="message" id="message" class="form-control" id="" cols="30" rows="10" style="height: 300px"></textarea>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-save">{{ __('label.save') }}</button>
            </div>
        </form>
    </div>

    <div class="toast-message">
        <span class="close"></span>
        <div class="message">
            This is an Alert! But these are some junks to see how alert looks in long messages.
        </div>
    </div>

    <script>
        function addtext(text){
            var maintext=$('#message').val();
            $('#message').val(maintext+" "+text);
        }
    </script>
@endsection
@section('footer_content')
@endsection
