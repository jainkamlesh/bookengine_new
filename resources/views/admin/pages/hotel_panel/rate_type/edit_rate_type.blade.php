@extends('admin.layout.default')
@section('title', 'Edit Rate Type')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.rate-type')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.editratetype') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.rate-type.store')}}" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="id" value="{{$rateType->id}}">

            <div class="row">
                <div class='col-md-4'>
                    <h4>{{ __('user.name') }}</h4>
                            Inglese
                            <input type="text" class="      form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name', $rateType->name) !!}">
                            Italiano
                            <input type="text" class="  form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it', $rateType->name_it) !!}">
                            Francese
                            <input type="text" class="  form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr', $rateType->name_fr) !!}">
                            Spagnolo
                            <input type="text" class="  form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es', $rateType->name_es) !!}">
                            Tedesco
                            <input type="text" class="  form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de', $rateType->name_de) !!}">
                  
                </div>
                <div class='col-md-4'>
                    <h4>{{ __('user.shortdescription') }}</h4>
                     
                          Inglese
                          <textarea class=" form-control form-textarea" rows="6" name="short_description" id="short_description" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description', $rateType->short_description) !!}</textarea>
                          Italiano
                          <textarea class=" form-control form-textarea" rows="6" name="short_description_it" id="short_description_it" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description_it', $rateType->short_description_it) !!}</textarea>
                          Francese
                          <textarea class=" form-control form-textarea" rows="6" name="short_description_fr" id="short_description_fr" role="tabpanel" aria-labelledby="short_description_tab3">{!! old('short_description_fr', $rateType->short_description_fr) !!}</textarea>
                          Spagnolo
                          <textarea class=" form-control form-textarea" rows="6" name="short_description_es" id="short_description_es" role="tabpanel" aria-labelledby="short_description_tab4">{!! old('short_description_es', $rateType->short_description_es) !!}</textarea>
                          Tedesco
                          <textarea class=" form-control form-textarea" rows="6" name="short_description_de" id="short_description_de" role="tabpanel" aria-labelledby="short_description_tab5">{!! old('short_description_de', $rateType->short_description_de) !!}</textarea>
                   </div>
                  <div class='col-md-4'>
                         
                          <h4>Politiche di cancellazione</h4>
                     
                          Inglese
                          <textarea class=" form-control form-textarea" rows="6" name="cancellation_condition" id="cancellation_condition" role="tabpanel" aria-labelledby="cancellation_condition_tab1">{!! old('cancellation_condition', $rateType->cancellation_condition) !!}</textarea>
                          Italiano
                          <textarea class=" form-control form-textarea" rows="6" name="cancellation_condition_it" id="cancellation_condition_it" role="tabpanel" aria-labelledby="cancellation_condition_tab1">{!! old('cancellation_condition_it', $rateType->cancellation_condition_it) !!}</textarea>
                          Francese
                          <textarea class=" form-control form-textarea" rows="6" name="cancellation_condition_fr" id="cancellation_condition_fr" role="tabpanel" aria-labelledby="cancellation_condition_tab3">{!! old('cancellation_condition_fr', $rateType->cancellation_condition_fr) !!}</textarea>
                          Spagnolo
                          <textarea class=" form-control form-textarea" rows="6" name="cancellation_condition_es" id="cancellation_condition_es" role="tabpanel" aria-labelledby="cancellation_condition_tab4">{!! old('cancellation_condition_es', $rateType->cancellation_condition_es) !!}</textarea>
                          Tedesco
                          <textarea class=" form-control form-textarea" rows="6" name="cancellation_condition_de" id="cancellation_condition_de" role="tabpanel" aria-labelledby="cancellation_condition_tab5">{!! old('cancellation_condition_de', $rateType->cancellation_condition_de) !!}</textarea>

                
                        </div>
                 </div>
                          <br>
                
                        <label class="checkbox-inline">
                            <input type="checkbox" name="is_refundable" id="is_refundable" value="N" @if($rateType->is_refundable == "Y") checked @endif> {{ __('user.isrefundable') }} :
                        </label>

                        <br>

                 
                        <label>{{ __('user.depositpercentage') }} :</label>
                        <input type="text" class="form-control text_float" name="deposit_percentage"
                               value="{!! old('deposit_percentage', $rateType->deposit_percentage) !!}" onkeypress="return isNumber(event)">
                    

                               <br>
                        <label>{{ __('user.daysbeforefreecancellation') }} :</label>
                        <input type="text" class="form-control text_float" name="cancellation_days"
                               value="{!! old('cancellation_days', $rateType->cancellation_days) !!}" onkeypress="return isNumber(event)">
                    
                               <br>
          
                <button type="submit" class="btn btn-default btn-save btn-block">{{ __('user.save') }}</button>
                <br> <br>
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
     $(document).ready(function(){
        $('#is_refundable').click(function(){
            if($(this).prop("checked") == true){
                $(this).val('Y');
            }
            else if($(this).prop("checked") == false){
                $(this).val('N');
            }
        });
    });
</script>
@endsection
 