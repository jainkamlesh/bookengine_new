@extends('admin.layout.default')
@section('title', 'Edit Room Type')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.room-type')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.editroomtype') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.room-type.store')}}" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="id" value="{{$roomType->id}}" id="room_type_id">

            <div class="row">

            <div class="col-md-6"> <!-- riga 1 -->

               <!-- <div style="border:1px solid #000000; background:#dedede;padding:10px">
                            @if(isset($roomType->room_image) && !empty($roomType->room_image))
                            <h4>Gallery</h4>
                                    <div class="row">
                                        <div class="col-sm-12  ">
                                            <div class="row  ">
                                                <?php
                                                $ar_images = array();
                                                $ar_images = explode(",", $roomType->room_image);
                                                ?>
                                                @if(isset($ar_images) && !empty($ar_images))
                                                    @foreach($ar_images as $key => $value)
                                                        <?php
                                                        $no_rand = rand(1111, 9999) . rand(111, 999);
                                                        ?>
                                                        <div class="col-xs-6 col-sm-3 col-md-4 mb-3" id="div_images_{!! $no_rand !!}">
                                                            <div class="position-relative d-block w-100">
                                                                <img src="{{url('public/images/room_type/')}}/{{$value}}" style="width: 100%;">
                                                                <a class="btn btn-xs btn-danger position-absolute"
                                                                style="top :0; right: 0; color: #FFFFFF;font-size: 12px;"
                                                                data-toggle="modal" data-target="#model_images_{!! $no_rand !!}" aria-hidden="true">&times;</a>
                                                                <input type="hidden" name="is_delete_image[{!! $value !!}]" id="images_{!! $no_rand !!}" value="0">
                                                            </div>
                                                        </div>

                                                        <div class="delete-modal-main">
                                                            <div class="modal fade" id="model_images_{!! $no_rand !!}">
                                                                <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header mt-2">
                                                                            <h5 class="modal-title">{{ __('user.delete') }}</h5>
                                                                            <button type="button" class="close" id="close_model_{!! $no_rand !!}" data-dismiss="modal">&times;</button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <div class="coupon">
                                                                                <h5 class="delete-warning">{{ __('user.areyousurewanttodelete') }}!</h5>
                                                                                <div class="mt-4 modal-btn">
                                                                                    <a href="javascript:void(0);" class="btn btn-default btn-success"
                                                                                    onclick="deleteImage('{!! $no_rand !!}')">{{ __('user.yes') }}</a>
                                                                                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">{{ __('user.no') }}</button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <input type="hidden" name="size_unit" value="sq_mt">
                                    <div class="col-sm-12 mt-3">
                                        <label>{{ __('user.image') }}</label>
                                        <input type="file" class="form-control" name="room_image[]" multiple accept="image/*">
                                    </div>
                                    <br>
                                <button type="submit" class="btn btn-default btn-save">{{ __('user.save') }}</button>
                    </div>-->
                    <div class="row">
					<input type="hidden" name="imggalleryj" id="imggalleryj">
                    <div class="col-sm-12 mt-3">
                        <label>Galleria di immagini</label>
                        
					<div class="container" >
						<input type="file" name="files[]" id="filejj" multiple>
						<!-- Drag and Drop container-->
						<div class="row upload-areaedit1">
							<ul id="sortable">
								@if(isset($roomType->room_image) && !empty($roomType->room_image))
									<?php
										$imgg = explode(',',$roomType->room_image);
                                    ?>
									@if(isset($imgg) && !empty($imgg))
                                          @foreach($imgg as $key=>$value)
											<?php
											  $key = $key+1;
											?>
											<li class="ui-state-default thumbnail" id="thumbnail_{{$key}}" data-value="{{$value}}"><img src="{{ URL::asset('public/images/room_type') }}/{{$value}}" name="{{$value}}" width="100%" height="78%"><div class="deleteimg" onclick="deleteImageGallary('{{$value}}',{{$key}},{{$roomType->id}})"><i class="fa fa-trash pnsl"></i></div></li>
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
                        <label>{{ __('user.baseadult') }} :</label>
                        <input type="text" class="form-control text_int" name="base_adults" value="{!! old('base_adults', $roomType->base_adults) !!}"
                               onkeypress="return isNumber(event)">
                    
                        <label>{{ __('user.maxadult') }} :</label>
                        <input type="text" class="form-control text_int" name="max_adults" value="{{ old('max_adults', $roomType->max_adults) }}"
                               onkeypress="return isNumber(event)">
                   
                        <label>room_capacity / max adulti+bambini:</label>
                        <input type="text" class="form-control text_int" name="room_capacity" value="{{ old('room_capacity', $roomType->room_capacity) }} " >
                   
                        
                        <label>{{ __('user.maxchild') }} :</label>
                        <input type="text" class="form-control text_int" name="max_child" value="{!! old('max_child', $roomType->max_child) !!}"
                               onkeypress="return isNumber(event)">
                   
                               
                        <label>{{ __('user.roomsize') }} :</label>

                        <input type="text" class="form-control text_float" name="size" value="{!! old('size', $roomType->size) !!}" onkeypress="return isNumber(event)">

                        @if( $hotel_data->booking_engine_type == 'Apartment')
                        <label>{{ __('user.noofbedroom') }} :</label>
                        <select name="no_of_bedroom" id="no_of_bedroom" class="form-control">
                            <option value="1" @if($roomType->no_of_bedroom == '1') selected @endif>1</option>
                            <option value="2" @if($roomType->no_of_bedroom == '2') selected @endif>2</option>
                            <option value="3" @if($roomType->no_of_bedroom == '3') selected @endif>3</option>
                            <option value="4" @if($roomType->no_of_bedroom == '4') selected @endif>4</option>
                            <option value="5" @if($roomType->no_of_bedroom == '5') selected @endif>5</option>
                            <option value="6" @if($roomType->no_of_bedroom == '6') selected @endif>6</option>
                            <option value="7" @if($roomType->no_of_bedroom == '7') selected @endif>7</option>
                            <option value="8" @if($roomType->no_of_bedroom == '8') selected @endif>8</option>
                            <option value="9" @if($roomType->no_of_bedroom == '9') selected @endif>9</option>
                            <option value="10" @if($roomType->no_of_bedroom == '10') selected @endif>10</option>
                        </select>

                        <label>{{ __('user.noofbathroom') }} :</label>
                        
                        <select name="no_of_bathroom" class="form-control">
                            <option value="1" @if($roomType->no_of_bathroom == '1') selected @endif>1</option>
                            <option value="2" @if($roomType->no_of_bathroom == '2') selected @endif>2</option>
                            <option value="3" @if($roomType->no_of_bathroom == '3') selected @endif>3</option>
                            <option value="4" @if($roomType->no_of_bathroom == '4') selected @endif>4</option>
                            <option value="5" @if($roomType->no_of_bathroom == '5') selected @endif>5</option>
                            <option value="6" @if($roomType->no_of_bathroom == '6') selected @endif>6</option>
                            <option value="7" @if($roomType->no_of_bathroom == '7') selected @endif>7</option>
                            <option value="8" @if($roomType->no_of_bathroom == '8') selected @endif>8</option>
                            <option value="9" @if($roomType->no_of_bathroom == '9') selected @endif>9</option>
                            <option value="10" @if($roomType->no_of_bathroom == '10') selected @endif>10</option>
                        </select>

                        <label>{{ __('user.floorno') }} :</label>
                        <input type="text" class="form-control" name="floor" value="{!! old('floor', $roomType->floor) !!}" >
                        @endif

                    
                        <label>Room Display Order :</label>

                        <input type="text" class="form-control text_float" name="room_order" value="{!! old('room_order', $roomType->room_order) !!}" onkeypress="return isNumber(event)">

                        <br>
                        <h4>{{ __('user.roomfacility') }} :</h4>
                        @if(isset($listRoomFacility) && !empty($listRoomFacility))
                            <?php
                            $ar_room_facilities = array();
                            if (isset($roomType->room_facilities) && !empty($roomType->room_facilities)) {

                                $ar_room_facilities = explode(",", $roomType->room_facilities);
                            }
                            ?>
                            
                                    @foreach($listRoomFacility as $key => $value)
                                        <?php
                                        $checked = "";
                                        if (isset($ar_room_facilities) && !empty($ar_room_facilities)) {
                                            if (in_array($key, $ar_room_facilities)) {
                                                $checked = "checked";
                                            }
                                        }
                                        ?>
                                        
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input chk_room_facilities" type="checkbox"
                                                       name="room_facilities[]" value="{!! $key !!}" id="chk_room_facilities_{!! $key !!}" {!! $checked !!}>
                                                <label class="form-check-label" for="chk_room_facilities_{!! $key !!}">
                                                    {!! $value !!}
                                                </label>
                                            </div><br>
                                         
                                    @endforeach
                               
                        @endif
         
                        <br>
                        <b>Scelta doppia/matrimoniale</b> <br>
                        <input   type="checkbox" name="twin_double" value="1" <?php if($roomType->twin_double==1) echo "checked";?> >
                        


 </div> <!-- 6 -->


 <div class="col-md-6">

            
   <h4>{{ __('user.name') }}</h4> 

           Inglese
           <input type="text" class=" form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name', $roomType->name) !!}">
           Italiano
           <input type="text" class=" form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it', $roomType->name_it) !!}">
           Francese
           <input type="text" class=" form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr', $roomType->name_fr) !!}">
           Spagnolo
           <input type="text" class=" form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es', $roomType->name_es) !!}">
           Tedesco
           <input type="text" class=" form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de', $roomType->name_de) !!}">

   <br>

   <h4>{{ __('user.shortdescription') }}</h4>

   Inglese
         <textarea class="  form-control form-textarea" rows="6" name="short_description" id="short_description" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description', $roomType->short_description) !!}</textarea>
         Italiano
         <textarea class=" form-control form-textarea" rows="6" name="short_description_it" id="short_description_it" role="tabpanel" aria-labelledby="short_description_tab1">{!! old('short_description_it', $roomType->short_description_it) !!}</textarea>
         Francese
         <textarea class=" form-control form-textarea" rows="6" name="short_description_fr" id="short_description_fr" role="tabpanel" aria-labelledby="short_description_tab3">{!! old('short_description_fr', $roomType->short_description_fr) !!}</textarea>
         Spagnolo
         <textarea class=" form-control form-textarea" rows="6" name="short_description_es" id="short_description_es" role="tabpanel" aria-labelledby="short_description_tab4">{!! old('short_description_es', $roomType->short_description_es) !!}</textarea>
         Tedesco
         <textarea class=" form-control form-textarea" rows="6" name="short_description_de" id="short_description_de" role="tabpanel" aria-labelledby="short_description_tab5">{!! old('short_description_de', $roomType->short_description_de) !!}</textarea>
 
         <br>

   <h4>{{ __('user.longdescription') }}</h4>
   Inglese
         <textarea class="   form-control form-textarea" rows="6" name="long_description" id="long_description" role="tabpanel" aria-labelledby="long_description_tab1">{!! old('long_description', $roomType->long_description) !!}</textarea>
         Italiano
         <textarea class="  form-control form-textarea" rows="6" name="long_description_it" id="long_description_it" role="tabpanel" aria-labelledby="long_description_tab1">{!! old('long_description', $roomType->long_description_it) !!}</textarea>
         Francese
         <textarea class="  form-control form-textarea" rows="6" name="long_description_fr" id="long_description_fr" role="tabpanel" aria-labelledby="long_description_tab3">{!! old('long_description', $roomType->long_description_fr) !!}</textarea>
         Spagnolo
         <textarea class="  form-control form-textarea" rows="6" name="long_description_es" id="long_description_es" role="tabpanel" aria-labelledby="long_description_tab4">{!! old('long_description', $roomType->long_description_es) !!}</textarea>
         Tedesco
         <textarea class="  form-control form-textarea" rows="6" name="long_description_de" id="long_description_de" role="tabpanel" aria-labelledby="long_description_tab5">{!! old('long_description', $roomType->long_description_de) !!}</textarea>
 
                
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
        
        var room_type_id = $('#room_type_id').val();
        fd.append("room_type_id", room_type_id);

        uploadData(fd);
    });
});

// Sending AJAX request and upload file
function uploadData(formdata){
    $.ajax({
        url:'{{route('admin.room-type.storeimage')}}',
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
		var flagsUrl = '{{ URL::asset('public/images/room_type') }}/'+name;
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
			url:'{{route('admin.room-type.deleteimage')}}',
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
 
