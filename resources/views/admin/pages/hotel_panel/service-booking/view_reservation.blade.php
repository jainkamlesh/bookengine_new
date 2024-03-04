@extends('admin.layout.default')

@section('title', 'Booking List')

@section('content')
    <section class="property-wrapper mt-4">
        <a href="{{route('admin.service.booking')}}" class="back-icon" data-toggle="tooltip" title="" data-original-title="Back">
            <img src="{!! URL::asset('images/chevron.png') !!}" class="back-image">
        </a>
        <h2 class="list-heading">{{ __('user.bookingdetail') }}</h2>
    </section>

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
                            </li>
                            <li>
                                <dt>{{ __('user.bookingstatus') }} :</dt>
                                <dd id="ota_ref_id">
                                 @if( $resultData->booking_status == 1 )
                                <label class="label label-success">{{ __('user.confirm') }}</label>
                                @elseif( $resultData->booking_status == 2 )
                                <label class="label label-danger">{{ __('user.cancel') }}</label>
                                @endif
                                </dd>
                            </li>
                            <li>
                                <dt>{{ __('user.totalprice') }} :</dt>
                                <dd id="system_ref_id">&euro;{!! $resultData->grand_amount !!}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.createdate') }} :</dt>
                                <dd id="guest_zipcode">{!! $resultData->create_date !!}</dd>
                            </li>
                            <li>
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
                <?php
                $ar_name = array();
                if (isset($resultData->first_name) && !empty($resultData->first_name)) {
                    array_push($ar_name, $resultData->first_name);
                }

                if (isset($resultData->last_name) && !empty($resultData->last_name)) {
                    array_push($ar_name, $resultData->last_name);
                }
                ?>
                <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="dl-horizontal p-0">
                            <li>
                                <dt>{{ __('user.firstname') }} :</dt>
                                <dd id="guest_name">{!! $resultData->first_name !!}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.lastname') }} :</dt>
                                <dd id="guest_name">{!! $resultData->last_name !!}</dd>
                            </li>
                            <li>
                                <dt>Telefono :</dt>
                                <dd id="guest_name">{!! $resultData->phone !!}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.email') }} :</dt>
                                <dd id="guest_name">{!! $resultData->email !!}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.country') }} :</dt>
                                <dd id="guest_name">{!! $resultData->country !!}</dd>
                            </li>
                            <li>
                                <dt>Note :</dt> 
                                <dd id="guest_comment">{!! $resultData->guest_comment !!}</dd>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header" role="tab" id="headingThree">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            {{ __('user.servicedetail') }}
                        </a>
                    </h5>
                </div>

                @if(isset($selected_services) && !empty($selected_services))
                @foreach($selected_services as $key1 => $value1)
                <div id="collapseTwo" class="collapse show" role="tabpanel" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="dl-horizontal p-0">
                            <li>
                                <dt>{{ __('user.name') }} :</dt>
                                <dd id="guest_name">{!! $value1->name_it !!}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.description') }} :</dt>
                                <dd id="guest_name">{!! $value1->short_description_it !!}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.noofservice') }} :</dt>
                                <dd id="guest_name">{!! $value1->no_of_service !!}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.totalprice') }} :</dt>
                                <dd id="guest_name">&euro;{!! $value1->final_service_price !!}</dd>
                            </li>
                        </ul>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            @if(isset($resultData->category_name) && !empty($resultData->category_name))
            <div class="card mt-3">
                <div class="card-header" role="tab" id="headingFour">
                    <h5 class="mb-0">
                        <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            {{ __('user.paymentdetail') }}
                        </a>
                    </h5>
                </div>
                <div id="collapseFour" class="collapse show" role="tabpanel" aria-labelledby="headingFour" data-parent="#accordion">
                    <div class="card-body">
                        <ul class="dl-horizontal p-0">
                            <li>
                                <dt>{{ __('user.cardtype') }} :</dt>
                                <dd>{{ $resultData->category }}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.cardholdername') }} :</dt>
                                <dd>{{ $resultData->category_name }}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.cardnumber') }} :</dt>
                                <!-- <dd id="ota_ref_id">
                                    <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                                        <button class="view-icon"><i class="fa fa-eye"></i> View Card Number</button>
                                    </div>
                                </dd> -->
                                <dd>{{ $resultData->numbers }}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.cardexpirydate') }} :</dt>
                                <dd id="check_in_date">{{ $resultData->last_date }}</dd>
                            </li>
                            <li>
                                <dt>Cvv :</dt>
                                <dd id="cvv">{{ $resultData->category_code }}</dd>
                            </li>
                            <!-- <li>
                                <dt>Card Security :</dt>
                                <dd id="check_out_date">
                                    <div class="icon edit" data-toggle="modal" data-target="#promocodedata" aria-hidden="true">
                                        <button class="view-icon"><i class="fa fa-eye"></i> View Card Number</button>
                                    </div>
                                </dd>
                            </li> -->
                        </ul>
                    </div>
                </div>
            </div>
            @endif
            
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
                                <dt>{{ __('user.totalprice') }} :</dt>
                                <dd>&euro;{{ $resultData->grand_amount }}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.totaldiscount') }} :</dt>
                                <dd>&euro;{{ $resultData->total_discount }}</dd>
                            </li>
                            <li>
                                <dt>{{ __('user.grosstotal') }} :</dt>
                                <dd>&euro;{{ $resultData->after_discount_amount }}</dd>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="delete-modal-main">
            <div class="modal fade" id="promocodedata">
                <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
                    <div class="modal-content">
                        <div class="modal-body re-post">
                            <div class="coupon">
                                <h5 class="delete-warning">{{ __('user.securitykey') }}</h5>
                                <input type="text" placeholder="Enter Key" class="form-control">
                                <form action="#" class="mt-4 modal-btn">
                                    <button type="button" class="btn btn-default btn-save" data-dismiss="modal">{{ __('user.ok') }}</button>
                                    <button type="button" class="btn btn-default btn-close btn-cancel" data-dismiss="modal">{{ __('user.cancel') }}</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_content')

@endsection
