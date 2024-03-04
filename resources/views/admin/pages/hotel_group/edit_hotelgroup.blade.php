@extends('admin.layout.default')
@section('title', 'Hotel System')
@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <section class="property-wrapper mt-4">
    	@if( isset($is_group) )
        <a href="{{route('admin.hotelgrouplist', $hotelbygroup->id) }}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        @else
        <a href="{{route('admin.hotelgroup')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        @endif
        <h2 class="list-heading">{{ __('label.edithotelgroup') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
		
        <form class="row p-0" id="hotelgroup" method="post" action="{{route('admin.hotelgroup.store')}}" enctype='multipart/form-data'>
            @csrf
			<input type="hidden" name="id" value="{{$hotelbygroup->id}}">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12">
                        <label>{{ __('label.backgroundimage') }}</label>
                        <input type="file" class="form-control" name="backgroundimage">
						@if($hotelbygroup->backgroundimage)
                            <img src="{{url('public/images/hotel_group/')}}/{{$hotelbygroup->backgroundimage}}" width="100" height="100">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <label>{{ __('user.logoimage') }}</label>
                        <input type="file" class="form-control" name="logo">
						@if($hotelbygroup->logo)
                            <img src="{{url('public/images/hotel_group_logo/')}}/{{$hotelbygroup->logo}}" width="100" height="100">
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="Address">{{ __('label.businessname') }} :</label>
                        <input type="text" class="form-control" id="businessname" name="businessname" value="{{$hotelbygroup->businessname}}">
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label>{{ __('label.phone') }} :</label>
                        <input type="text" class="form-control" name="phone" value="{{$hotelbygroup->phone}}">
                    </div>
                </div>
				<div class="row">
                    <div class="col-sm-12 mt-3">
                        <label>{{ __('label.email') }} :</label>
                        <input type="text" class="form-control" name="email" value="{{$hotelbygroup->email}}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label>{{ __('label.password') }} :</label>
                        <input type="password" class="form-control" name="password" value="{{$hotelbygroup->password}}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="customcss">{{ __('label.customcss') }} :</label>
                        <textarea class="form-control form-textarea" rows="6" name="customcss" id="customcss">{{$hotelbygroup->customcss}}</textarea>
                    </div>
                </div>
				<div class="row">
					<div class="col-sm-12 mt-3">
						<label for="customcss">{{ __('label.selecthotel') }} :</label>
						<select name="selecthotelids[]" id="selecthotelids" multiple>
						<option value="0">Select hotel group</option>
						<?php
							$gpid = unserialize($hotelbygroup->groupids);
							
						?>
						@foreach($hotelgroups as $key => $value)
							<?php
								if(in_array($value->id,$gpid)){
							?>
							<option value="{{$value->id}}" selected>{{$value->name}}</option>
							<?php
								}else{
									?>
									<option value="{{$value->id}}">{{$value->name}}</option>
									<?php
								}
								?>
						@endforeach
						</select>
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
<style>
.error {
  color: red !important;
  margin-left: 5px;
}

label.error {
  display: inline;
}
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
<script>
jQuery(document).ready(function($){
      $('#selecthotelids').select2();
	  $('#selecthotelids').on('change', function() {
		let vals = $(this).find(":selected").val();
		if(vals !== undefined && vals !=''){
			$("#selecthotelids-error").hide();
		}else{
			$("#selecthotelids-error").show();
		}
	});	
});
jQuery(document).ready(function($) {
	
	$("#hotelgroup").validate({
		rules: {
			businessname : {
				required: true,
				minlength: 3
			},
			phone : {
				required: true,
				minlength: 3,
				maxlength: 12,
			},
			email: {
				required: true,
				email: true,//add an email rule that will ensure the value entered is valid email id.
				maxlength: 255,
			},
			"selecthotelids[]":{
				required:true,
			},
		},
		messages: {
		   businessname: 'This enter business name',
		   phone: 'This enter phone number',
		   email: 'Enter a valid email',
		   customcss: 'Enter a custom css',
		   "selecthotelids[]":'Please at least one hotel should be selected',
		},
	});
});
</script>
 
</script>
 
