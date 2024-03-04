@extends('admin.layout.default')
@section('title', 'Edit Profile')
@section('content')
<section class="property-wrapper mt-4">
        <!-- <a href="{{route('admin.room-option')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a> -->
        <h2 class="list-heading">{{ __('user.editprofile') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="row modal-body p-0" method="post" action="{{route('admin.hotel.edit_profile')}}" enctype='multipart/form-data' >
            @csrf

          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.name') }} :</label>
            <input type="text" class="form-control" name="Name" value="{{$admin->name}}">
          </div>
          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.username') }} :</label>
            <input type="text" class="form-control" name="UserName" value="{{$admin->username}}">
          </div>
          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.email') }} :</label>
            <input type="text" class="form-control" name="Email" value="{{$admin->email}}">
          </div>

        </div>
         <div class="modal-footer property-wrapper">
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
@endsection
 