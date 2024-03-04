@extends('admin.layout.default')
@section('title', 'Change Password')
@section('content')
<section class="property-wrapper mt-4">
        <!-- <a href="{{route('admin.room-option')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a> -->
        <h2 class="list-heading">{{ __('user.changepassword') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="row modal-body p-0" method="post" action="{{route('admin.hotel.changePassword')}}" enctype='multipart/form-data' >
            @csrf

          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.currentpassword') }} :</label>
            <input type="password" class="form-control" name="CurrentPassword" placeholder="current password">
          </div>
          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.newpassword') }} :</label>
            <input type="password" class="form-control" name="NewPassword" placeholder="new password">
          </div>
          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.confirmpassword') }}</label>
            <input type="password" class="form-control" name="NewConfirmPassword" placeholder="confirm password">
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
 