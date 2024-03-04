@extends('admin.layout.default')
@section('title', 'Edit Service')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.service')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.editservice') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.service.store')}}" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="id" value="{{$service->id}}" id="service_id">

            <div class="row">

            <div class="col-md-6"> <!-- riga 1 -->

                    <div class="row">
					<input type="hidden" name="imggalleryj" id="imggalleryj">
                    <div class="col-sm-12 mt-3">
                        <label>Galleria di immagini</label>
                        
					<div class="container" >
						<input type="file" name="files[]" id="filejj" multiple>
						<!-- Drag and Drop container-->
						<div class="row upload-areaedit1">
							<ul id="sortable">
								@if(isset($service->images) && !empty($service->images))
									<?php
										$imgg = explode(',',$service->images);
                                    ?>
									@if(isset($imgg) && !empty($imgg))
                                          @foreach($imgg as $key=>$value)
											<?php
											  $key = $key+1;
											?>
											<li class="ui-state-default thumbnail" id="thumbnail_{{$key}}" data-value="{{$value}}"><img src="{{ URL::asset('public/images/service') }}/{{$value}}" name="{{$value}}" width="100%" height="78%"><div class="deleteimg" onclick="deleteImageGallary('{{$value}}',{{$key}},{{$service->id}})"><i class="fa fa-trash pnsl"></i></div></li>
										  @endforeach
									@endif			
								@endif
							</ul>
						</div>
						<div class="upload-areaedit"  id="uploadfile">
							<h4>Clicca qui per scegliere le immagini</h4>
						</div>
                        <br>
                        Dimensioni massime: 500kb - formato .jpg o .jpeg
						
					</div>
                    </div>
                </div>        

               <br>
                        <label>{{ __('user.maxquantity') }} :</label>
                        <input type="text" class="form-control text_int" name="max_quantity" value="{!! old('max_quantity', $service->max_quantity) !!}"
                               onkeypress="return isNumber(event)">
                    
                        <label>{{ __('user.price') }} :</label>
                        <input type="text" class="form-control" name="price" value="{{ old('price', $service->price) }}">
                   
                        <label>{{ __('user.tax') }}:</label>
                        <input type="text" class="form-control" name="tax" value="{{ old('tax', $service->tax) }} " >
                                       
                        <label>{{ __('user.displayorder') }} :</label>
                        <input type="text" class="form-control text_float" name="display_order" value="{!! old('display_order', $service->display_order) !!}" onkeypress="return isNumber(event)">

 </div> <!-- 6 -->


 <div class="col-md-6">

            
   <h4>{{ __('user.name') }}</h4> 

           Inglese
           <input type="text" class=" form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name', $service->name) !!}">
           Italiano
           <input type="text" class=" form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it', $service->name_it) !!}">
           Francese
           <input type="text" class=" form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr', $service->name_fr) !!}">
           Spagnolo
           <input type="text" class=" form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es', $service->name_es) !!}">
           Tedesco
           <input type="text" class=" form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de', $service->name_de) !!}">

   <br>

   <h4>{{ __('user.shortdescription') }}</h4>

   Inglese
         <textarea class="  form-control form-textarea" rows="6" name="short_description" id="short_description" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description', $service->short_description) !!}</textarea>
         Italiano
         <textarea class=" form-control form-textarea" rows="6" name="short_description_it" id="short_description_it" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description_it', $service->short_description_it) !!}</textarea>
         Francese
         <textarea class=" form-control form-textarea" rows="6" name="short_description_fr" id="short_description_fr" role="tabpanel" aria-labelledby="short_description_tab3">{!! old('short_description_fr', $service->short_description_fr) !!}</textarea>
         Spagnolo
         <textarea class=" form-control form-textarea" rows="6" name="short_description_es" id="short_description_es" role="tabpanel" aria-labelledby="short_description_tab4">{!! old('short_description_es', $service->short_description_es) !!}</textarea>
         Tedesco
         <textarea class=" form-control form-textarea" rows="6" name="short_description_de" id="short_description_de" role="tabpanel" aria-labelledby="short_description_tab5">{!! old('short_description_de', $service->short_description_de) !!}</textarea>
 
         <br>
    
    <h4>{{ __('user.cancellationpolicy') }}</h4>

   Inglese
         <textarea class="  form-control form-textarea" rows="6" name="cancellation_policy" id="cancellation_policy" role="tabpanel" aria-labelledby="cancellation_policy_tab1">{!! old('cancellation_policy', $service->cancellation_policy) !!}</textarea>
         Italiano
         <textarea class=" form-control form-textarea" rows="6" name="cancellation_policy_it" id="cancellation_policy_it" role="tabpanel" aria-labelledby="cancellation_policy_tab1">{!! old('cancellation_policy_it', $service->cancellation_policy_it) !!}</textarea>
         Francese
         <textarea class=" form-control form-textarea" rows="6" name="cancellation_policy_fr" id="cancellation_policy_fr" role="tabpanel" aria-labelledby="cancellation_policy_tab3">{!! old('cancellation_policy_fr', $service->cancellation_policy_fr) !!}</textarea>
         Spagnolo
         <textarea class=" form-control form-textarea" rows="6" name="cancellation_policy_es" id="cancellation_policy_es" role="tabpanel" aria-labelledby="cancellation_policy_tab4">{!! old('cancellation_policy_es', $service->cancellation_policy_es) !!}</textarea>
         Tedesco
         <textarea class=" form-control form-textarea" rows="6" name="cancellation_policy_de" id="cancellation_policy_de" role="tabpanel" aria-labelledby="cancellation_policy_tab5">{!! old('cancellation_policy_de', $service->cancellation_policy_de) !!}</textarea>
 
         <br>

 </div>
</div>
<br>
                <button type="submit" class="btn btn-default btn-save btn-block">{{ __('user.save') }}</button>
   
        </form>
   <br><br>

    <div class="toast-message">
        <span class="close"></span>
        <div class="message">
            This is an Alert! But these are some junks to see how alert looks in long messages.
        </div>
    </div>
@endsection
@section('footer_content')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">
        new_deleteImage = null;
        $(function () {

            function deleteImage($no_images) {

                $('#div_images_' + $no_images).hide(1);
                $('#images_' + $no_images).val(1);
                $('#close_model_' + $no_images).trigger("click");
            }

            new_deleteImage = deleteImage;
        });

        function deleteImage($no_images) {
            new_deleteImage($no_images);
        }
    </script>

    <script type="text/javascript">
        $(function () {

           /* $('#short_description').keypress(function (e) {

                var tval = $('#short_description').val();
                var tlength = tval.length;
                var set = 100;
                var remain = parseInt(set - tlength);

                $('.character_short').text(remain);

                if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                    $('#short_description').val((tval).substring(0, tlength - 1))
                }
            });*/
        });
		// Drag enter
		$(function() {
    $('.upload-areaedit').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drag over
    $('.upload-areaedit').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drop
    $('.upload-areaedit').on('drop', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $("h1").text("Upload");

        var file = e.originalEvent.dataTransfer.files;
        var fd = new FormData();

        fd.append('file', file[0]);

        uploadData(fd);
    });

    // Open file selector on div click
    $("#uploadfile").click(function(){
        $("#filejj").click();
    });

    // file selected
    $("#filejj").change(function(){
        var fd = new FormData();
		var totalfiles = document.getElementById('filejj').files.length;
		   for (var index = 0; index < totalfiles; index++) {
			  fd.append("files[]", document.getElementById('filejj').files[index]);
		   }
        
        var service_id = $('#service_id').val();
        fd.append("service_id", service_id);

        uploadData(fd);
    });
});

// Sending AJAX request and upload file
function uploadData(formdata){
    $.ajax({
        url:'{{route('admin.service.storeimage')}}',
        type: 'post',
		headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        data: formdata,
        contentType: false,
        processData: false,
        dataType: 'json',
        success: function(response){
            addThumbnail(response);
        }
    });
}

// Added thumbnail
function addThumbnail(data){
    var len = $("#sortable li.thumbnail").length;
    var num = Number(len);
    num = num + 1;
	let imgarr = [];
	data.forEach(function(ind,val){
		var name = data[val].name;
		var src = data[val].src;
		num = num+1;
		imgarr.push(name);
		var flagsUrl = '{{ URL::asset('public/images/service') }}/'+name;
    // Creating an thumbnail
		$("#sortable").append('<li class="ui-state-default thumbnail" id="thumbnail_'+num+'" data-value="'+name+'"></li>');
		$("#thumbnail_"+num).append('<img src="'+flagsUrl+'" name="'+name+'" width="100%" height="78%"><div class="deleteimg" onClick="deleteImageGallary('+"'"+name+"'"+','+num+')"><i class="fa fa-trash pnsl"></i></div>');
	});
	let imgtext = '';
	let lenf = $("#sortable li.thumbnail").length;
	$("#sortable li.thumbnail").each(function(inf,val){
		let egmname = val.id;
		let egnm = $("#"+egmname).attr("data-value");
		imgtext += egnm+',';
	});
	$("#imggalleryj").val(imgtext);
}

// Bytes conversion
function deleteImageGallary(imgname,num,id){
	  let text = "Are you sure delete this image?";
	  let imgtext = '';
	  if (confirm(text) == true) {
		$.ajax({
			url:'{{route('admin.service.deleteimage')}}',
			type: 'post',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {"imgname":imgname,"id":id},
			dataType: 'json',
			success: function(response){
				$("#thumbnail_"+num).remove();
				let lenf = $("#sortable li.thumbnail").length;
				if(lenf > 0){
					$("#sortable li.thumbnail").each(function(inf,val){
					let egmname = val.id;
					let egnm = $("#"+egmname).attr("data-value");
					imgtext += egnm+',';
					});	
					$("#imggalleryj").val('');
					$("#imggalleryj").val(imgtext);
				}
			}
		});
	  } 
}
    </script>
	<script>
	$( function() {
    $( "#sortable" ).sortable({
		beforeStop: function(e, ui) {
		   let lenfele = $("#sortable li.thumbnail");
		   let lenf = $("#sortable li.thumbnail").length;
		   let imgtext = '';
				if(lenf > 0){
					$("#sortable li.thumbnail").each(function(inf,val){
						let egmname = val.id;
						let egnm = val.getAttribute("data-value");
						if(egnm != null && egnm!=''){
							imgtext += egnm+',';
						}
					});	
					$("#imggalleryj").val(imgtext);
				}
		}
	});
    $( "#sortable" ).disableSelection();
  } );
    </script>	
@endsection
 
