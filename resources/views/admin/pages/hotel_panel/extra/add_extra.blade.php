@extends('admin.layout.default')
@section('title', 'Add Extra')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.extra')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.addextra') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.extra.store')}}" enctype='multipart/form-data'>
            @csrf
            <div class="modal-body">

                <div class="row mt-5">
                    <h4>{{ __('user.name') }}</h4>
                    <div class="col-sm-12 mt-3">
                        <ul class="nav nav-tabs" id="name_tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="name_tab1" data-toggle="tab" href="#name" role="tab" aria-controls="name" aria-selected="true"><label for="Policy">English</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="name_tab2" data-toggle="tab" href="#name_it" role="tab" aria-controls="name_it" aria-selected="false"><label for="Policy">Italian</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="name_tab3" data-toggle="tab" href="#name_fr" role="tab" aria-controls="name_fr" aria-selected="false"><label for="Policy">French</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="name_tab4" data-toggle="tab" href="#name_es" role="tab" aria-controls="name_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="name_tab5" data-toggle="tab" href="#name_de" role="tab" aria-controls="name_de" aria-selected="false"><label for="Policy">German</label></a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <input type="text" class="tab-pane fade show active form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name') !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it') !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr') !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es') !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de') !!}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="col-sm-6 mt-3 ">
                        <label>Name (En):</label>
                        <input type="text" class="form-control" name="name" value="{!! old('name') !!}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (It):</label>
                        <input type="text" class="form-control" name="name_it" value="{!! old('name_it') !!}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (Fr):</label>
                        <input type="text" class="form-control" name="name_fr" value="{!! old('name_fr') !!}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (Es):</label>
                        <input type="text" class="form-control" name="name_es" value="{!! old('name_es') !!}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (De):</label>
                        <input type="text" class="form-control" name="name_de" value="{!! old('name_de') !!}">
                    </div> -->

                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.image') }}</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.price') }} :</label>
                        <input type="text" class="form-control text_float" name="price" value="{!! old('price') !!}" onkeypress="return isNumber(event)">
                    </div>

                   
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.unit') }} :</label>
                        <select name="unit" class="form-control">
                            <option selected="selected" disabled="disabled">-- {{ __('user.selectunit') }} --</option>
                            <option>{{ __('user.perperson') }}</option>
                            <option>{{ __('user.perroom') }}</option>
                            <option>{{ __('user.perstay') }}</option>
                            <option>{{ __('user.perpersonpernight') }}</option>
                            <option>{{ __('user.perpersonperroom') }}</option>
                            <option>{{ __('user.perroompernight') }}</option>
                        </select>
                    </div>

                     <div class="col-sm-6 mt-3">
                        @for($i=0; $i<3; $i++)
                            <?php
                            $rate_value = "";
                            ?>
                            <div class="row mt-3">
                                <label class="col-sm-7">{{ __('user.childagerange') }} {!! ($i+1) !!} {{ __('user.rate') }} :</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control text_float" name="child_age{!! ($i+1) !!}_rate"
                                           value="0" onkeypress="return isNumber(event)">
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="Description">Description (En):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description" id="Description"></textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (It):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_it" id="Description_it"></textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (Fr):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_fr" id="Description_fr"></textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (Es):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_es" id="Description_es"></textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (De):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_de" id="Description_de"></textarea>
                    </div>
                </div> -->

                <div class="row mt-5">
                    <h4>{{ __('user.description') }}</h4>
                    <div class="col-sm-12 mt-3">
                        <ul class="nav nav-tabs" id="description_tab" role="tablist">
                          <li class="nav-item">
                            <a class="nav-link active" id="description_tab1" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true"><label for="Policy">English</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="description_tab2" data-toggle="tab" href="#description_it" role="tab" aria-controls="description_it" aria-selected="false"><label for="Policy">Italian</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="description_tab3" data-toggle="tab" href="#description_fr" role="tab" aria-controls="description_fr" aria-selected="false"><label for="Policy">French</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="description_tab4" data-toggle="tab" href="#description_es" role="tab" aria-controls="description_es" aria-selected="false"><label for="Policy">Spanish</label></a>
                          </li>
                          <li class="nav-item">
                            <a class="nav-link" id="description_tab5" data-toggle="tab" href="#description_de" role="tab" aria-controls="description_de" aria-selected="false"><label for="Policy">German</label></a>
                          </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                          <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="description" id="description" role="tabpanel" aria-labelledby="description_tab1">{!! old('description') !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_it" id="description_it" role="tabpanel" aria-labelledby="description_tab1">{!! old('description_it') !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_fr" id="description_fr" role="tabpanel" aria-labelledby="description_tab3">{!! old('description_fr') !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_es" id="description_es" role="tabpanel" aria-labelledby="description_tab4">{!! old('description_es') !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_de" id="description_de" role="tabpanel" aria-labelledby="description_tab5">{!! old('description_de') !!}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="is_mandatory">{{ __('user.ismandatory') }} :</label>
                        <input type="checkbox" class="" name="is_mandatory" id="is_mandatory" value="1">
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
        $(function () {

            $('#is_mandatory').change(function () {
                $(this).val(0);
                if ($(this).prop("checked") == true) {
                    $(this).val(1);
                }
            });
        });
    </script>
@endsection
 