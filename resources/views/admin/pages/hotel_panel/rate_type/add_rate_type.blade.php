@extends('admin.layout.default')
@section('title', 'Add Rate Type')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.rate-type')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="" ss="back-image"></a>
        <h2 class="list-heading">{{ __('user.addratetype') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.rate-type.store')}}" enctype='multipart/form-data'>
            @csrf

            <div class="modal-body">

          
                    <h4>{{ __('user.name') }}</h4>

<a class='btn btn-info btn-sm' style="color:#ffffff" onclick="$('#name').val('Standard');$('#name_it').val('Standard');$('#name_fr').val('Standard');$('#name_de').val('Standard');$('#name_es').val('Standard');" href="javscript:void('0');">PRECARICA TESTO "STANDARD"</a> 
<a class='btn btn-info btn-sm' style="color:#ffffff" onclick="$('#name').val('Not refundable');$('#name_it').val('Non rimborsabile');$('#name_fr').val('Non remboursable');$('#name_de').val('Nicht rückzahlbar');$('#name_es').val('No reembolsable');" href="javscript:void('0');">PRECARICA TESTO "NON RIMBORSABILE"</a>                
 
<div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Name (IT)</label>
   <div class="col-sm-10">
       <input onchange="$('#name').val($('#name_it').val()); $('#name_fr').val($('#name_it').val()); $('#name_es').val($('#name_it').val());$('#name_de').val($('#name_it').val());" type="text" class="show active form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it') !!}">
   </div>
 </div>

<div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Name (EN)</label>
   <div class="col-sm-7">
       <input type="text" class="form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name') !!}">
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#name_it').val(),'name','en');">traduci  </a>
   </div>
 </div>



 <div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Name (FR)</label>
   <div class="col-sm-7">
   <input type="text" class="form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr') !!}">
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#name_fr').val(),'name_fr','fr');">traduci  </a>
   </div>
 </div>
   
 <div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Name (ES)</label>
   <div class="col-sm-7">
   <input type="text" class="form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es') !!}">
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#name_es').val(),'name_es','es');">traduci  </a>
   </div>
 </div>

 <div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Name (DE)</label>
   <div class="col-sm-7">
   <input type="text" class="form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de') !!}">
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#name_de').val(),'name_de','de');">traduci  </a>
   </div>
 </div>

                </div>
        
                    <h4>{{ __('user.shortdescription') }}</h4>
                   
<a class='btn btn-info btn-sm' style="color:#ffffff" onclick="popola('standard')">PRECARICA TESTO "STANDARD CON CANC TUTTO IMPORTO"</a> 
<a class='btn btn-info btn-sm' style="color:#ffffff" onclick="popola('standard1notte')">PRECARICA TESTO "STANDARD CON CANC 1* NOTTE"</a> 
<a class='btn btn-info btn-sm' style="color:#ffffff" onclick="popola('nonrimborsabile')">PRECARICA TESTO "NON RIMBORSABILE"</a>                
 

<div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Short Description (IT)</label>
   <div class="col-sm-10">
       <textarea rows=7 onchange="$('#short_description').val($('#short_description_it').val()); $('#short_description_fr').val($('#short_description_it').val()); $('#short_description_es').val($('#short_description_it').val());$('#short_description_de').val($('#short_description_it').val());"   class=" form-textarea   form-control" name="short_description_it" id="short_description_it" role="tabpanel" aria-labelledby="name_tab2">{!! old('short_description_it') !!}</textarea>
   </div>
 </div>

<div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Short Description (EN)</label>
   <div class="col-sm-7">
       <textarea rows=7 class="form-control form-textarea" name="short_description" id="short_description" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description') !!}</textarea>
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#short_description_it').val(),'short_description','en'); ">traduci  </a>
   </div>
 </div>

 <div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Short Description (DE)</label>
   <div class="col-sm-7">
       <textarea rows=7 class="form-control form-textarea" name="short_description_de" id="short_description_de" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description_de') !!}</textarea>
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#short_description_it').val(),'short_description_de','de');">traduci  </a>
   </div>
 </div>

 <div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Short Description (FR)</label>
   <div class="col-sm-7">
       <textarea rows=7 class="form-control form-textarea" name="short_description_fr" id="short_description_fr" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description_fr') !!}</textarea>
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#short_description_it').val(),'short_description_fr','fr');">traduci  </a>
   </div>
 </div>

 <div class="mb-3 row">
   <label for="1" class="col-sm-2 col-form-label">Short Description (ES)</label>
   <div class="col-sm-7">
       <textarea rows=7 class="form-control form-textarea" name="short_description_es" id="short_description_es" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description_es') !!}</textarea>
   </div>
   <div class="col-sm-3">
     <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#short_description_it').val(),'short_description_es','es');">traduci  </a>
   </div>
 </div>

           
                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="is_refundable" id="is_refundable" value="N"> {{ __('user.isrefundable') }} :
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('user.depositpercentage') }} :</label>
                        <input type="text" class="form-control text_float" name="deposit_percentage"
                               value=" {!! old('deposit_percentage') !!}" onkeypress="return isNumber(event)">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('user.daysbeforefreecancellation') }} :</label>
                        <input type="text" class="form-control text_float" name="cancellation_days"
                               value=" {!! old('cancellation_days') !!}" onkeypress="return isNumber(event)">
                    </div>
                </div>
            </div>

            <div class="modal-footer">
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


    function traduci(testo,iddest,lingua){
        var url="https://app.hgst.it/traduzione-testi/traduci.php?stringa="+testo+"&tolang="+lingua;

          $.ajax({
            url:url,
            type: "GET",
            data: {},
            success:function(result){
              //alert(result);
              $("#"+iddest).val(result);
              $('#messaggio').html('tradotto in '+lingua+":"+result);
            },
            error: function(richiesta,stato,errori){
              alert(stato+" "+errori);
            }
            }
          );
      }

      function popola(cosa){

        if(cosa=="standard"){
          $('#short_description').val('You can cancel your reservation free of charge within x days of arrival. For late cancellations the full amount will be charged');
          $('#short_description_it').val('Puoi cancellare gratuitamente la prenotazione entro x giorni dall\'arrivo. Per cancellazioni tardive verrà addebitato l\'intero importo');
          $('#short_description_fr').val('Vous pouvez annuler votre réservation sans frais dans un délai de x jours avant votre arrivée. Pour les annulations tardives, le montant total sera facturé');
          $('#short_description_de').val('Sie können Ihre Reservierung innerhalb von x Tagen vor Anreise kostenfrei stornieren. Bei verspäteter Stornierung wird der volle Betrag verrechnet');
          $('#short_description_es').val('Puede cancelar su reserva sin cargo dentro de x días de su llegada. Para cancelaciones tardías se cargará el importe total');
        }else if(cosa=="standard1notte"){
          $('#short_description').val('You can cancel your reservation free of charge within x days of arrival. For late cancellations the cost of the first night will be charged');
          $('#short_description_it').val('Puoi cancellare gratuitamente la prenotazione entro x giorni dall\'arrivo. Per cancellazioni tardive verrà addebitato il costo della prima notte');
          $('#short_description_fr').val('Vous pouvez annuler votre réservation sans frais dans un délai de x jours avant votre arrivée. Pour les annulations tardives, le coût de la première nuit sera facturé');
          $('#short_description_de').val('Sie können Ihre Reservierung innerhalb von x Tagen vor Anreise kostenfrei stornieren. Bei späterer Stornierung werden die Kosten der ersten Nacht berechnet');
          $('#short_description_es').val('Puede cancelar su reserva sin cargo dentro de x días de su llegada. Para cancelaciones fuera de plazo se cobrará el costo de la primera noche');
        }else{
          $('#short_description').val('Best rate, prepayment');
          $('#short_description_it').val('Migliore tariffa, pagamento anticipatoe');
          $('#short_description_fr').val('Meilleur tarif, paiement anticipé par nuit');
          $('#short_description_de').val('Bestpreis, Vorauszahlung pro Nacht');
          $('#short_description_es').val('Mejor tarifa, pago adelantado por noche');
        }

      }

</script>
@endsection
 