@extends('admin.layout.default')

@section('title', 'Booking List')

@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.hotel.booking')}}" class="back-icon" data-toggle="tooltip" title="" data-original-title="Back">
            <img src="{!! URL::asset('images/chevron.png') !!}" class="back-image">
        </a>
        <h2 class="list-heading">{{ __('label.bookingdetail') }}</h2>
    </section>
    @include('flash-message')
    <form  action="{{ route('admin.hotel.update.booking.data') }}" method="POST" enctype="multipart/form-data">
        @csrf
    <div class="property-wrapper channel-wrapper dashboard-wrapper container my-5">
        <div id="accordion" role="tablist">
            <div class="card">
                <div class="card-header" role="tab" id="headingOne">
                    <h5 class="mb-0">
                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ __('user.basicdetail') }}
                        </a>
                    </h5>
                </div>
                <div id="collapseOne" class="collapse show" role="tabpanel" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="dl-horizontal p-0">
                            <li>
                                <dt>{{ __('user.reservationid') }} :</dt>
                                <dd id="system_ref_id">{!! $resultData->id !!}</dd>
                                <input type="hidden" name="id" class="form-control" id="id" value="{{$resultData->id}}">
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.bookingstatus') }} :</dt>
                                <select name="booking_status" class="form-control" id="booking_status">
                                    <option value="1" @if($resultData->booking_status == 1) selected @endif>{{ __('user.confirm') }}</option>
                                    <option value="2" @if($resultData->booking_status == 2) selected @endif>{{ __('user.cancel') }}</option>
                                </select>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.checkindate') }} :</dt>
                                <input type="date" name="check_in_date" class="form-control" id="check_in_date" value="{{$resultData->check_in_date}}">
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('check_in_date')}}</span>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.checkoutdate') }} :</dt>
                                <input type="date" name="check_out_date" class="form-control" id="check_out_date" value="{{$resultData->check_out_date}}">
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('check_out_date')}}</span>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.noofadult') }} :</dt>
                                <input type="number" name="no_of_adult" class="form-control" id="no_of_adult" value="{{$resultData->no_of_adult}}">
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('no_of_adult')}}</span>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.noofchild') }} :</dt>
                                <input type="number" name="no_of_child" class="form-control" id="no_of_child" value="{{$resultData->no_of_child}}">
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.childages') }} :</dt>
                                <input type="text" name="child_ages" class="form-control" id="child_ages" value="{{$resultData->child_ages}}">
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.createdate') }} :</dt>
                                <dd id="guest_zipcode">{!! $resultData->create_date !!}</dd>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.modifydate') }} :</dt>
                                <dd id="guest_zipcode">{!! $resultData->modify_date !!}</dd>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header" role="tab" id="headingTwo">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            {{ __('user.masterguestinformation') }}
                        </a>
                    </h5>
                </div>
                <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="dl-horizontal p-0">
                            <li>
                                <dt>{{ __('user.firstname') }} :</dt>
                                <input type="text" name="first_name" class="form-control" id="first_name" value="{{$resultData->first_name}}">
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('first_name')}}</span>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.lastname') }} :</dt>
                                <input type="text" name="last_name" class="form-control" id="last_name" value="{{$resultData->last_name}}">
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('last_name')}}</span>
                            </li>
                            <li class="mt-2">
                                <dt>Telefono :</dt>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{$resultData->phone}}">
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('phone')}}</span>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.email') }} :</dt>
                                <input type="email" name="email" class="form-control" id="email" value="{{$resultData->email}}">
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('email')}}</span>
                            </li>
                            <li class="mt-2">
                                <dt>{{ __('user.country') }} :</dt>
                                <input type="text" name="country" class="form-control" id="country" value="{{$resultData->country}}">
                            </li>
                            <li class="mt-2">
                                <dt>Note :</dt>
                                <textarea name="guest_comment" id="guest_comment" class="form-control" cols="30" rows="10">{!! $resultData->guest_comment !!}</textarea>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" role="tab" id="headingFive">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            {{ __('user.additionalinformation') }}
                        </a>
                    </h5>
                </div>
                <div id="collapseFive" class="collapse show" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="dl-horizontal p-0">
                            <li>
                                <dt>{{ __('user.totalbaseamount') }} :</dt>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{!! $hotelDetail->currency_symbol !!}</span>
                                    </div>
                                    <input type="text" name="total_base_amount" step=".01" class="form-control" id="total_base_amount" value="{{$resultData->total_base_amount}}">
                                  </div>
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('total_base_amount')}}</span>
                            </li>
                            <li>
                                <dt>{{ __('user.extraguestcharge') }} :</dt>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{!! $hotelDetail->currency_symbol !!}</span>
                                    </div>
                                    <input type="number" name="total_extra_person_amount" step=".01" class="form-control" id="total_extra_person_amount" value="{{$resultData->total_extra_person_amount}}">
                                  </div>
                            </li>
                            <li>
                                <dt>{{ __('user.extracharge') }} :</dt>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{!! $hotelDetail->currency_symbol !!}</span>
                                    </div>
                                    <input type="number" name="extra_amount" step=".01" class="form-control" id="extra_amount" value="{{$resultData->extra_amount}}">
                                  </div>
                            </li>
                            <li>
                                <dt>{{ __('user.discount') }} :</dt>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{!! $hotelDetail->currency_symbol !!}</span>
                                    </div>
                                    <input type="number" name="total_discount" step=".01" class="form-control" id="total_discount" value="{{$resultData->total_discount}}">
                                  </div>
                            </li>
                            <li>
                                <dt>{{ __('user.grosstotal') }} :</dt>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                      <span class="input-group-text">{!! $hotelDetail->currency_symbol !!}</span>
                                    </div>
                                    <input type="number" name="gross_amount" step=".01" class="form-control" id="gross_amount" value="{{$resultData->gross_amount}}">
                                  </div>
                            </li>
                            <li>
                                <dt></dt>
                                <span class="text-danger">{{$errors->first('gross_amount')}}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header" role="tab" id="headingFive">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                            {{ __('user.additionalinformation') }}
                        </a>
                    </h5>
                </div>
                <div id="collapseFive" class="collapse show" role="tabpanel" aria-labelledby="headingFive" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="dl-horizontal p-0">
                            <li>
                                <dt></dt>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="not_has_whatsapp" name="not_has_whatsapp" @if ($resultData->not_has_whatsapp == 1) checked @endif style="width: 18px;height: 18px;" value="1">
                                    <label class="form-check-label">Not has whatsapp</label>
                                </div>
                            </li>
                            <li>
                                <dt></dt>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="email_not_valid" name="email_not_valid" @if ($resultData->email_not_valid == 1) checked @endif style="width: 18px;height: 18px;" value="1">
                                    <label class="form-check-label">Email not valid </label>
                                </div>
                            </li>
                            <li>
                                <dt></dt>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="promo_sent" name="promo_sent" @if ($resultData->promo_sent == 1) checked @endif style="width: 18px;height: 18px;" value="1">
                                    <label class="form-check-label">Promo sent</label>
                                </div>
                            </li>
                            <li>
                                <dt></dt>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="paid" name="paid" style="width: 18px;height: 18px;" @if ($resultData->paid == 1) checked @endif value="1">
                                    <label class="form-check-label">Paid</label>
                                </div>
                            </li>
                            <li>
                                <dt></dt>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="promotion" name="promotion" style="width: 18px;height: 18px;" @if ($resultData->promotion == 1) checked @endif value="1">
                                    <label class="form-check-label">Promotion</label>
                                </div>
                            </li>
                            <li>
                                <dt></dt>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="deposit_request" name="deposit_request" style="width: 18px;height: 18px;" @if ($resultData->deposit_request == 1) checked @endif value="1">
                                    <label class="form-check-label">Deposit request</label>
                                </div>
                            </li>
                            <li class="mt-2">
                                <dt>Internal Note :</dt>
                                <textarea name="internal_note" id="internal_note" class="form-control" cols="30" rows="50" style="height: 200px">{!! $resultData->internal_note !!}</textarea>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-default btn-save mt-3">Submit</button>
        </div>
    </div>
    </form>
@endsection

@section('footer_content')

@endsection
