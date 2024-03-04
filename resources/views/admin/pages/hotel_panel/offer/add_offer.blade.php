@extends('admin.layout.default')
@section('title', 'Add Offer')
@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.offer')}}" class="back-icon" data-toggle="tooltip" title="Back"><img src="{{url('/')}}/images/chevron.png" class="" ss="back-image"></a>
        <h2 class="list-heading">{{ __('user.addoffer') }}</h2>
    </section>
    <div class="property-wrapper container mt-5">
        @include('flash-message')
        <form class="p-0" method="post" action="{{route('admin.offer.store')}}" enctype='multipart/form-data'>
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
                        <input required type="file" class="form-control" name="image">
                    </div>
                </div>

                <!-- <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label for="Description">Description (En):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description" id="Description">{!! old('description') !!}</textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (It):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_it" id="Description_it">{!! old('description_it') !!}</textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (Fr):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_fr" id="description_fr">{!! old('description_fr') !!}</textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (Es):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_es" id="description_es">{!! old('description_es') !!}</textarea>
                    </div>
                    <div class="col-sm-12 mt-3">
                        <label for="Description_it">Description (De):</label>
                        <textarea class="form-control form-textarea" rows="6" name="description_de" id="description_de">{!! old('description_de') !!}</textarea>
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
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.validfrom') }} :</label>
                        <input type="date" class="form-control" name="valid_from" value="{!! old('valid_from') !!}">
                    </div>
                    <div class="col-sm-6 mt-3 ">
                        <label>{{ __('user.validto') }} :</label>
                        <input type="date" class="form-control" name="valid_to" value="{!! old('valid_to') !!}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('user.discountpercentage') }} :</label>
                        <input type="text" class="form-control text_float" name="discount_percentage" value="{!! old('discount_percentage') !!}"
                               onkeypress="return isNumber(event)">
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3">
                        <label>{{ __('user.excludedaysoff') }} :</label>
                        <div class='input-form mb-2'>
                            <input type='date' placeholder='Enter Exclude days Off' id='name_1' class='txt form-control' name="exclusive_days[]">
                        </div>
                        <input type='button' id='but_add' value='Add new'>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('user.roomlist') }} :</label><br>
                        @if($rate_planCnt > 0)
                            @foreach($rate_plan as $key => $value)
                                <label class="checkbox-inline">
                                    <input type="checkbox" name="room_list[]" value="{{$value->id}}"> {{$value->name}}
                                </label>
                            @endforeach
                        @endif

                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <label>{{ __('user.daysofweek') }} :</label><br>
                        <label class="checkbox-inline">
                            <label>
                                <input type="checkbox" name="days_of_week[]" value="Monday"> {{ __('user.monday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" value="Tuesday"> {{ __('user.tuesday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" value="Wednesday"> {{ __('user.wednesday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" value="Thursday"> {{ __('user.thursday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" value="Friday"> {{ __('user.friday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" value="Saturday"> {{ __('user.saturday') }}
                            </label>
                            <label>
                                <input type="checkbox" name="days_of_week[]" value="Sunday"> {{ __('user.sunday') }}
                            </label>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 mt-3 ">
                        <!-- <h5>Condition</h5> -->
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col">{{ __('user.condition') }}</th>
                                <th scope="col">{{ __('user.minimumvalue') }}</th>
                                <th scope="col">{{ __('user.maximumvalue') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><input type="checkbox" name="no_of_adults">&ensp;{{ __('user.numberofadult') }}</td>
                                    <td><input type="text" class="form-control" placeholder="Enter Minimum Value" name="min_no_of_adults"></td>
                                    <td><input type="text" class="form-control" placeholder="Enter Maximum Value" name="max_no_of_adults"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="no_of_child">&ensp;{{ __('user.numberofchild') }}</td>
                                    <td><input type="text" class="form-control" placeholder="Enter Minimum Value" name="min_no_of_child"></td>
                                    <td><input type="text" class="form-control" placeholder="Enter Maximum Value" name="max_no_of_child"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="days_in_advance">&ensp;{{ __('user.daysinadvance') }}</td>
                                    <td><input type="text" class="form-control" placeholder="Enter Minimum Value" name="min_days_in_advance"></td>
                                    <td><input type="text" class="form-control" placeholder="Enter Maximum Value" name="max_days_in_advance"></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" name="no_of_night">&ensp;{{ __('user.noofnight') }}</td>
                                    <td><input type="text" class="form-control" placeholder="Enter Minimum Night" name="min_no_of_night"></td>
                                    <td><input type="text" class="form-control" placeholder="Enter Maximum Night" name="max_no_of_night"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <label class="checkbox-inline">
                                            <input type="checkbox" name="mobile_offer"> {{ __('user.mobileoffer') }}
                                        </label>
                                    </td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>

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
@section('validations')
    $('#but_add').click(function(){
    var newel = $('.input-form:last').clone();
    $(newel).insertAfter(".input-form:last");
    });
@endsection
@section('footer_content')
@endsection
 