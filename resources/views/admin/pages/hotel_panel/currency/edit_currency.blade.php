@extends('admin.layout.default')
@section('title', 'Edit Currency')
@section('content')
<section class="property-wrapper mt-4">
        <a href="{{route('admin.currency')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.editcurrency') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="row modal-body p-0" method="post" action="{{route('admin.currency.store')}}" >
            @csrf
            <input type="hidden" name="id" value="{{$currency->id}}">

          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.currencyname') }} :</label>
            <input type="text" class="form-control" name="name" value="{{$currency->name}}">
          </div>
          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.currencycode') }} :</label>
            <input type="text" class="form-control" name="code" value="{{$currency->code}}">
          </div>
          <div class="col-sm-6 mt-3 ">
            <label>{{ __('user.currencysymbol') }} :</label>
            <input type="text" class="form-control" name="symbol" value="{{$currency->symbol}}">
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
 