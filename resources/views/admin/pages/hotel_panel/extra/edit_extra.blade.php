@extends('admin.layout.default')
@section('title', 'Edit Extra')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.extra')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="back-image"></a>
        <h2 class="list-heading">{{ __('user.editextra') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.extra.store')}}" enctype='multipart/form-data'>
            @csrf
            <input type="hidden" name="id" value="{{$extra->id}}">

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
                            <input type="text" class="tab-pane fade show active form-control" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name', $extra->name) !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it', $extra->name_it) !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr', $extra->name_fr) !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es', $extra->name_es) !!}">
                            <input type="text" class="tab-pane fade form-control" name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de', $extra->name_de) !!}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- <div class="col-sm-6 mt-3 ">
                        <label>Name (En):</label>
                        <input type="text" class="form-control" name="name" value="{{$extra->name}}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (It):</label>
                        <input type="text" class="form-control" name="name_it" value="{{$extra->name_it}}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (Fr):</label>
                        <input type="text" class="form-control" name="name_fr" value="{{$extra->name_fr}}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (Es):</label>
                        <input type="text" class="form-control" name="name_es" value="{{$extra->name_es}}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>Name (De):</label>
                        <input type="text" class="form-control" name="name_de" value="{{$extra->name_de}}">
                    </div> -->

                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.image') }}</label>
                        <input type="file" class="form-control" name="image">
                        @if($extra->image)
                            <img src="{{url('public/images/extra/')}}/{{$extra->image}}" width="100" height="100">
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.price') }} :</label>
                        <input type="text" class="form-control text_float" name="price" value="{{$extra->price}}" onkeypress="return isNumber(event)">
                    </div>

                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.unit') }} :</label>

                        <select name="unit" class="form-control">
                            <option selected="selected" disabled="disabled">-- {{ __('user.selectunit') }} --</option>
                            <option <?php echo ($extra->unit == 'Per Person' || $extra->unit == 'Per persona' ) ? "selected" : "" ?> >{{ __('user.perperson') }}</option>
                            <option <?php echo ($extra->unit == 'Per Room' || $extra->unit == 'Per camera' ) ? "selected" : "" ?> >{{ __('user.perroom') }}</option>
                            <option <?php echo ($extra->unit == 'Per Stay' || $extra->unit == 'Per soggiorno'  ) ? "selected" : "" ?> >{{ __('user.perstay') }}</option>
                            <option <?php echo ($extra->unit == 'Per Person Per Night' || $extra->unit == 'Per persona per notte'  ) ? "selected" : "" ?> >{{ __('user.perpersonpernight') }}</option>
                            <option <?php echo ($extra->unit == 'Per Person Per Room' || $extra->unit == 'Per persona per camera'  ) ? "selected" : "" ?> >{{ __('user.perpersonperroom') }}</option>
                            <option <?php echo ($extra->unit == 'Per Room Per Nigh' || $extra->unit == 'Per camera Per notte'  ) ? "selected" : "" ?> >{{ __('user.perroompernight') }}</option>
                        </select>
                    </div>

                    <div class="col-sm-6 mt-3">
                        @for($i=0; $i<3; $i++)
                            <?php
                            $rate_value = "";
                            if ($i == 0) {
                                $rate_value = $extra->child_age1_rate;
                            }
                            if ($i == 1) {
                                $rate_value = $extra->child_age2_rate;
                            }
                            if ($i == 2) {
                                $rate_value = $extra->child_age3_rate;
                            }
                            ?>
                            <div class="row mt-3">
                                <label class="col-sm-7">{{ __('user.childagerange') }} {!! ($i+1) !!} {{ __('user.rate') }} :</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control text_float" name="child_age{!! ($i+1) !!}_rate" value="{!! $rate_value !!}"
                                           onkeypress="return isNumber(event)">
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

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
                          <textarea class="tab-pane fade show active form-control form-textarea" rows="6" name="description" id="description" role="tabpanel" aria-labelledby="description_tab1">{!! $extra->description !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_it" id="description_it" role="tabpanel" aria-labelledby="description_tab1">{!! $extra->description_it !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_fr" id="description_fr" role="tabpanel" aria-labelledby="description_tab3">{!! $extra->description_fr !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_es" id="description_es" role="tabpanel" aria-labelledby="description_tab4">{!! $extra->description_es !!}</textarea>
                          <textarea class="tab-pane fade form-control form-textarea" rows="6" name="description_de" id="description_de" role="tabpanel" aria-labelledby="description_tab5">{!! $extra->description_de !!}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <?php
                        $checked = "";
                        if (isset($extra->is_mandatory) && !empty($extra->is_mandatory)) {
                            $checked = "checked";
                        }
                        ?>
                        <label for="is_mandatory">{{ __('user.ismandatory') }} :</label>
                        <input type="checkbox" name="is_mandatory" id="is_mandatory" value="{!! $extra->is_mandatory !!}" {!! $checked !!}>
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
 