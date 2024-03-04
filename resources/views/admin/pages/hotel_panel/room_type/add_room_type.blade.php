@extends('admin.layout.default')
@section('title', 'Add Room Type')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.room-type')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">Add New Room Type / Aggiungi nuova tipologia</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class=" p-0" method="post" action="{{route('admin.room-type.store')}}" enctype='multipart/form-data'>
            @csrf
 
 
 <h4>Name / Nome</h4>

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

  
  <div id="messaggio"></div>
                   
                        <hr>
                  
                        <h4>Short Description</h4>


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
      <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#short_description_it').val(),'short_description','en');">traduci  </a>
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
    
     
   <!--       
                <div class="row mt-5">
                    <h4>Long Description / Descrizione estesa</h4>
                    <div class="col-sm-12 mt-3">
                        <ul class="nav nav-tabs" id="long_description_tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link " id="long_description_tab1" data-toggle="tab" href="#long_description" role="tab" aria-controls="long_description" aria-selected="true"><label for="Policy">English</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link active" id="long_description_tab2" data-toggle="tab" href="#long_description_it" role="tab" aria-controls="long_description_it" aria-selected="false"><label for="Policy">Italian</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="long_description_tab3" data-toggle="tab" href="#long_description_fr" role="tab" aria-controls="long_description_fr" aria-selected="false"><label for="Policy">French</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="long_description_tab4" data-toggle="tab" href="#long_description_es" role="tab" aria-controls="long_description_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="long_description_tab5" data-toggle="tab" href="#long_description_de" role="tab" aria-controls="long_description_de" aria-selected="false"><label for="Policy">German</label></a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <textarea class="tab-pane fade  form-control form-textarea" rows="6" name="long_description" id="long_description" role="tabpanel" aria-labelledby="long_description_tab1">{!! old('long_description') !!}</textarea>
                          <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="long_description_it" id="long_description_it" role="tabpanel" aria-labelledby="long_description_tab1">{!! old('long_description_it') !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="long_description_fr" id="long_description_fr" role="tabpanel" aria-labelledby="long_description_tab3">{!! old('long_description_fr') !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="long_description_es" id="long_description_es" role="tabpanel" aria-labelledby="long_description_tab4">{!! old('long_description_es') !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="long_description_de" id="long_description_de" role="tabpanel" aria-labelledby="long_description_tab5">{!! old('long_description_de') !!}</textarea>
                        </div>
                    </div>
                </div>
-->

<h4>Persone</h4>
                <div class="row">
                    <div class="col-sm-2 mt-3 ">
                        <label>Base Adults / Base adulti:</label>
                        <input type="text" class="form-control text_int" name="base_adults" value="{!! old('base_adults') !!}" onkeypress="return isNumber(event)">
                    </div>
                    <div class="col-sm-2 mt-3 ">
                        <label>Max Adults / Max adulti:</label>
                        <input type="text" class="form-control text_int" name="max_adults" value="{!! old('max_adults') !!}" onkeypress="return isNumber(event)">
                    </div>

                    <div class="col-sm-2 mt-3 ">
                        <label>Max Childs / Max bambini accettati:</label>
                        <input type="text" class="form-control text_int" name="max_child" value="{!! old('max_child') !!}" onkeypress="return isNumber(event)">
                    </div>


                    <div class="col-sm-2 mt-3 ">
                        <label>room_capacity / max adulti+bambini:</label>
                        <input type="text" class="form-control text_int" name="room_capacity" value="{{ old('room_capacity') }}" >
                    </div>

                    <div class="col-sm-3 mt-3 ">
                        <label>Room Size / Mq:</label>
                        <input type="text" class="form-control text_float" name="size" value="{!! old('size') !!}" onkeypress="return isNumber(event)">
                    </div>
                </div>

               <!-- <div class="row">
 
                    <div class="col-sm-12 mt-3">
                        <label>Image</label>
                        <input type="file" class="form-control" name="room_image[]" multiple accept="image/*">
                    </div>
                </div>-->
				<div class="row">
					<input type="hidden" name="imggalleryj" id="imggalleryj">
                    <div class="col-sm-12 mt-3">
                        <label>Room Gallery</label>
					<div class="container" >
						<input type="file" name="files[]" id="filejj" multiple accept="image/*">
						<!-- Drag and Drop container-->
						<div class="row upload-area1">
							<ul id="sortable"></ul>
						</div> 
						<div class="upload-area"  id="uploadfile">
							<h4>Clicca qui per scegliere le immagini</h4>
						</div>
                        <br>
                        Dimensioni massime: 500kb - formato .jpg o .jpeg
					</div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>Room Facilities:</label>
                        @if(isset($listRoomFacility) && !empty($listRoomFacility))
                            <div class="col-sm-12">
                                <div class="row">
                                    @foreach($listRoomFacility as $key => $value)
                                        
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input chk_room_facilities" type="checkbox"  
                                                       name="room_facilities[]" value="{!! $key !!}" id="chk_room_facilities_{!! $key !!}">
                                                      <label class="form-check-label" for="chk_room_facilities_{!! $key !!}">
                                                      {!! $value !!} 
                                                </label>
                                            </div>
                                        
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>Scelta doppia/matrimoniale</label>
                        <input type="checkbox" name="twin_double" id="twin_double" value="0" >
                    </div>
                </div>

                @if( $hotel_data->booking_engine_type == 'Apartment')
                    <label>{{ __('user.noofbedroom') }} :</label>
                    <select name="no_of_bedroom" id="no_of_bedroom" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>

                    <label>{{ __('user.noofbathroom') }} :</label>
                    
                    <select name="no_of_bathroom" class="form-control">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>

                    <label>{{ __('user.floorno') }} :</label>
                    <input type="text" class="form-control" name="floor" value="{!! old('floor') !!}" >
                    @endif

                <div class="row">
                    <div class="col-sm-3 mt-3 ">
                        <label>Room Display Order</label>
                        <input type="text" class="form-control" name="room_order" id="room_order" value="0" >
                    </div>
                </div>
      
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-default btn-save">Save</button>
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
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <script type="text/javascript">

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

        $(function () {

            $('#short_description').keypress(function (e) {

                var tval = $('#short_description').val();
                var tlength = tval.length;
                var set = 100;
                var remain = parseInt(set - tlength);

                $('.character_short').text(remain);

                if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                    $('#short_description').val((tval).substring(0, tlength - 1))
                }
            });

            $('.chk_room_facilities').each(function () {
                if($(this).val()==10) $(this).prop("checked", true);
                if($(this).val()==11) $(this).prop("checked", true);
                if($(this).val()==12) $(this).prop("checked", true);
                if($(this).val()==14) $(this).prop("checked", true);
                if($(this).val()==15) $(this).prop("checked", true);
                if($(this).val()==16) $(this).prop("checked", true);
                if($(this).val()==17) $(this).prop("checked", true);

                if($(this).val()==22) $(this).prop("checked", true);
                if($(this).val()==27) $(this).prop("checked", true);
            });
        });
		// Drag enter
		$(function() {
    $('.upload-area').on('dragenter', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drag over
    $('.upload-area').on('dragover', function (e) {
        e.stopPropagation();
        e.preventDefault();
        $("h1").text("Drop");
    });

    // Drop
    $('.upload-area').on('drop', function (e) {
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
	$("#imggalleryj").val();
	$("#imggalleryj").val(imgtext);
}

// Bytes conversion
function deleteImageGallary(imgname,num){
	  let text = "Are you sure delete this image?";
	  let imgtext = '';
	  if (confirm(text) == true) {
		$.ajax({
			url:'{{route('admin.room-type.deleteimage')}}',
			type: 'post',
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
			data: {"imgname":imgname},
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
function convertSize(size) {
    var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    if (size == 0) return '0 Byte';
    var i = parseInt(Math.floor(Math.log(size) / Math.log(1024)));
    return Math.round(size / Math.pow(1024, i), 2) + ' ' + sizes[i];
}

    </script>
	<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
	<script>
	$( function() {
    $( "#sortable" ).sortable(
	{
		
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
	}
	);
    $( "#sortable" ).disableSelection();
  } );

    $('#twin_double').on('change', function(){
       $('#twin_double').val(this.checked ? 1 : 0);
    });
    </script>
@endsection
 
 
