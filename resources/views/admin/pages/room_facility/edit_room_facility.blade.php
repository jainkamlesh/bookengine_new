@extends('admin.layout.default')
@section('title', 'Edit Room Facility')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.room-option')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('label.editroomfacility') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.room-option.store')}}" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="id" value="{{$roomFacility->id}}">

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.name') }} :</label>
                        <input type="text" class="form-control" name="name" value="{{$roomFacility->name}}">

                        <label>{{ __('label.name') }} it :</label>
                        <input type="text" class="form-control" name="name_it" value="{{$roomFacility->name_it}}">

                        <label>{{ __('label.name') }} de :</label>
                        <input type="text" class="form-control" name="name_de" value="{{$roomFacility->name_de}}">

                        <label>{{ __('label.name') }} fr :</label>
                        <input type="text" class="form-control" name="name_fr" value="{{$roomFacility->name_fr}}">

                        <label>{{ __('label.name') }} es :</label>
                        <input type="text" class="form-control" name="name_es" value="{{$roomFacility->name_es}}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.icon') }}</label>
                        <input type="file" class="form-control" name="icon">
                        @if($roomFacility->icon)
                            <img src="{{url('public/images/room_facility/')}}/{{$roomFacility->icon}}" width="100" height="100">
                        @endif
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
@endsection
@section('footer_content')
@endsection
 