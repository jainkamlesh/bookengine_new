@extends('admin.layout.default')
@section('title', 'Add Room Facility')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.room-option')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('label.addroomfacility') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.room-option.store')}}" enctype='multipart/form-data'>
            @csrf

            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.name') }} :</label>
                        <input type="text" class="form-control" name="name">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('label.icon') }}</label>
                        <input type="file" class="form-control" name="icon">
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
 