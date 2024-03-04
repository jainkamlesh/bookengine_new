@extends('admin.layout.default')
@section('title', 'Add New Service')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.service')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.addnewservice') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class=" p-0" method="post" action="{{route('admin.service.store')}}" enctype='multipart/form-data'>
            @csrf
 
 
 <h4>{{ __('user.name') }}</h4>

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
    
     <hr>
                  
<h4>{{ __('user.cancellationpolicy') }}</h4>


 <div class="mb-3 row">
    <label for="1" class="col-sm-2 col-form-label">Cancellation Policy (IT)</label>
    <div class="col-sm-10">
        <textarea rows=7 onchange="$('#cancellation_policy').val($('#cancellation_policy_it').val()); $('#cancellation_policy_fr').val($('#cancellation_policy_it').val()); $('#cancellation_policy_es').val($('#cancellation_policy_it').val());$('#cancellation_policy_de').val($('#cancellation_policy_it').val());"   class=" form-textarea   form-control" name="cancellation_policy_it" id="cancellation_policy_it" role="tabpanel" aria-labelledby="name_tab2">{!! old('cancellation_policy_it') !!}</textarea>
    </div>
  </div>

 <div class="mb-3 row">
    <label for="1" class="col-sm-2 col-form-label">Cancellation Policy (EN)</label>
    <div class="col-sm-7">
        <textarea rows=7 class="form-control form-textarea" name="cancellation_policy" id="cancellation_policy" role="tabpanel" aria-labelledby="cancellation_policy_tab1">{!! old('cancellation_policy') !!}</textarea>
    </div>
    <div class="col-sm-3">
      <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#cancellation_policy_it').val(),'cancellation_policy','en');">traduci  </a>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="1" class="col-sm-2 col-form-label">Cancellation Policy (DE)</label>
    <div class="col-sm-7">
        <textarea rows=7 class="form-control form-textarea" name="cancellation_policy_de" id="cancellation_policy_de" role="tabpanel" aria-labelledby="cancellation_policy_tab1">{!! old('cancellation_policy_de') !!}</textarea>
    </div>
    <div class="col-sm-3">
      <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#cancellation_policy_it').val(),'cancellation_policy_de','de');">traduci  </a>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="1" class="col-sm-2 col-form-label">Cancellation Policy (FR)</label>
    <div class="col-sm-7">
        <textarea rows=7 class="form-control form-textarea" name="cancellation_policy_fr" id="cancellation_policy_fr" role="tabpanel" aria-labelledby="cancellation_policy_tab1">{!! old('cancellation_policy_fr') !!}</textarea>
    </div>
    <div class="col-sm-3">
      <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#cancellation_policy_it').val(),'cancellation_policy_fr','fr');">traduci  </a>
    </div>
  </div>

  <div class="mb-3 row">
    <label for="1" class="col-sm-2 col-form-label">Cancellation Policy (ES)</label>
    <div class="col-sm-7">
        <textarea rows=7 class="form-control form-textarea" name="cancellation_policy_es" id="cancellation_policy_es" role="tabpanel" aria-labelledby="cancellation_policy_tab1">{!! old('cancellation_policy_es') !!}</textarea>
    </div>
    <div class="col-sm-3">
      <a style="color:#000000" href="javascript:void(0);" onclick="traduci($('#cancellation_policy_it').val(),'cancellation_policy_es','es');">traduci  </a>
    </div>
  </div>
    
     

                <div class="row">
                    <div class="col-sm-2 mt-3 ">
                        <label>{{ __('user.maxquantity') }}:</label>
                        <input type="text" class="form-control text_int" name="max_quantity" value="{!! old('max_quantity') !!}" value="1" onkeypress="return isNumber(event)">
                    </div>
                    <div class="col-sm-2 mt-3 ">
                        <label>{{ __('user.price') }}:</label>
                        <input type="text" class="form-control " name="price" value="{!! old('price') !!}" >
                    </div>

                    <div class="col-sm-2 mt-3 ">
                        <label>{{ __('user.tax') }}:</label>
                        <input type="text" class="form-control " name="tax" value="{!! old('tax') !!}" >
                    </div>
                    <div class="col-sm-3 mt-3 ">
                        <label>{{ __('user.displayorder') }}</label>
                        <input type="text" class="form-control text_int" name="display_order" id="display_order" value="1" onkeypress="return isNumber(event)">
                    </div>
                    
                </div>

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

            $('#cancellation_policy').keypress(function (e) {

                var tval = $('#cancellation_policy').val();
                var tlength = tval.length;
                var set = 100;
                var remain = parseInt(set - tlength);

                $('.character_short').text(remain);

                if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
                    $('#cancellation_policy').val((tval).substring(0, tlength - 1))
                }
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
	$("#imggalleryj").val();
	$("#imggalleryj").val(imgtext);
}

// Bytes conversion
function deleteImageGallary(imgname,num){
	  let text = "Are you sure delete this image?";
	  let imgtext = '';
	  if (confirm(text) == true) {
		$.ajax({
			url:'{{route('admin.service.deleteimage')}}',
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
 
 
