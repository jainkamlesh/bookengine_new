@extends('admin.layout.default')
@section('title', 'Rate Plan List')
@section('content')
    <section class="property-wrapper mt-4">
        <h2>{{ __('user.rateplanlist') }}</h2>
        <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
            <div class="d-flex position-relative booking-wrapper align-items-center">
            </div>

            <a href="{{route('admin.add.rate-plan')}}">
                <button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>{{ __('user.addrateplan') }}</button>
            </a>
        </div>
        <div class="container-fluid">
            @include('flash-message')

            <table class="mt-4 pro-table-pg table-hover wrapper">
                <thead>
                <tr class="ft-tr">
                    <th></th>
                    <th>{{ __('user.name') }}</th>
                    <th style="max-width: 150px;">{{ __('user.roomtype') }}</th>
                    <th style="min-width: 150px;">{{ __('user.ratetype') }}</th>
                    <th>{{ __('user.roombaseprice') }}</th>
                    <!-- <th>{{ __('label.ismaster') }}</th> -->
                    <th>{{ __('label.masterplan') }}</th>
                   <!-- <th>{{ __('user.minstay') }}</th>
                    <th>{{ __('user.maxstay') }}</th> -->
                    <th>{{ __('user.action') }}</th>
                </tr>
                </thead>
                <tbody>

                @if($ratePlanCnt > 0)
                    @foreach($ratePlan as $key => $value)
                        <?php 
                        $bg_color = '';
                        if ( $value->is_master == 0 ) {
                            $bg_color = "background: lightgoldenrodyellow";
                        }
                        ?>
                        <tr style="{{ $bg_color }}">
                            <td scope="row" data-label="ID">{{++$key}}</td>
                            <td data-label="Name">{{$value->name_it}} </td>
                            <td>
                                @if(isset($roomType) && !empty($roomType))
                                    @if(isset($value->room_type_id) && !empty($value->room_type_id))
                                        @if(isset($roomType[$value->room_type_id]) && !empty($roomType[$value->room_type_id]))
                                            {!! $roomType[$value->room_type_id] !!}
                                        @endif
                                    @endif
                                @endif
                            </td>
                            <td>
                                @if(isset($rateType) && !empty($rateType))
                                    @if(isset($value->rate_type_id) && !empty($value->rate_type_id))
                                        @if(isset($rateType[$value->rate_type_id]) && !empty($rateType[$value->rate_type_id]))
                                            {!! $rateType[$value->rate_type_id] !!}
                                        @endif
                                    @endif
                                @endif
                            </td>

                            <td data-label="Room Base Price">{{$value->room_price }} </td>
                            @if( $value->is_master )
                            <td data-label="Room Base Price">{{ __('label.yes') }} </td>
                            @else
                            <td data-label="Room Base Price">{{ __('label.no') }} </td>
                            @endif
                           <!-- <td data-label="Min Night Stay">{{$value->min_nights}} </td>
                            <td data-label="Max Night Stay">{{$value->max_nights}} </td> -->

                            <td data-label="ACTION" class="action-list">
                                <div class="d-flex">
                                    <a href="{{route('admin.rate-plan.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
                                        <div class="tooltip">{{ __('user.edit') }}</div>
                                        <i class="fa fa-pencil pnsl"></i>
                                    </a>
                                    <div class="icon edit" data-toggle="modal" data-target="#promocodedata_{{$value->id}}" aria-hidden="true">
                                        <div class="tooltip">{{ __('user.delete') }}</div>
                                        <i class="fa fa-trash-o btn-danger delete-icn"></i>
                                    </div>
                                    @if( $value->is_master )
                                    <div class="icon edit" data-toggle="modal" data-target="#derived_{{$value->id}}" aria-hidden="true">
                                        <div class="tooltip">{{ __('label.makederived') }}</div>
                                        <i class="fa fa-copy pnsl"></i>
                                    </div>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <div class="delete-modal-main">
                            <div class="modal fade" id="promocodedata_{{$value->id}}">
                                <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header mt-2">
                                            <h5 class="modal-title">{{ __('user.delete') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="coupon">
                                                <h5 class="delete-warning">{{ __('user.areyousurewanttodelete') }}!</h5>
                                                <div class="mt-4 modal-btn">
                                                    <a href="{{route('admin.rate-plan.delete', ['id'=>$value->id])}}" class="btn btn-default btn-success">{{ __('user.yes') }}</a>
                                                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">{{ __('user.no') }}</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="derived-modal-main">
                            <div class="modal fade" id="derived_{{$value->id}}">
                                <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header mt-2">
                                            <h5 class="modal-title">{{ __('label.setderived') }}</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="row modal-body p-0" method="post" action="{{route('admin.rate-plan.set-derived')}}" enctype='multipart/form-data'>
                                            @csrf
                                            <input type="hidden" name="master_plan_id" value="{{$value->id}}">
                                            <div class="row mt-5">
                                                <div class="col-sm-12 mt-3">
                                                    <h4>{{ __('user.name') }}</h4>
                                                    Italiano
                                                    <input class="form-control" onchange="$('#name').val($('#name_it').val()); $('#name_fr').val($('#name_it').val()); $('#name_es').val($('#name_it').val());$('#name_de').val($('#name_it').val());" type="text" name="name_it" id="name_it" role="tabpanel" aria-labelledby="name_tab2" value="{!! old('name_it') !!}"><br>
                                                    English
                                                    <input class="form-control" type="text" name="name" id="name" role="tabpanel" aria-labelledby="name_tab1" value="{!! old('name') !!}"> <br>
                                                    
                                                    Francese
                                                    <input class="form-control" type="text"  name="name_fr" id="name_fr" role="tabpanel" aria-labelledby="name_tab3" value="{!! old('name_fr') !!}"><br>
                                                    Spagnolo
                                                    <input class="form-control" type="text"  name="name_es" id="name_es" role="tabpanel" aria-labelledby="name_tab4" value="{!! old('name_es') !!}"><br>
                                                    Tedesco
                                                    <input class="form-control" type="text"  name="name_de" id="name_de" role="tabpanel" aria-labelledby="name_tab5" value="{!! old('name_de') !!}"><br>
                                                </div>
                                            </div>
                                            <div class="row mt-5">
                                                <div class="col-sm-12 mt-3">
                                                <h4>{{ __('label.derivedpercentage') }}</h4>
                                                <input class="form-control" type="text"  name="derived_percentage" id="derived_percentage" value="{!! old('derived_percentage') !!}"><br>
                                            </div>
                                            </div>

                                            <div class="mt-4 modal-btn">
                                                <button type="submit" class="btn btn-default btn-save pull-right">{{ __('user.save') }}</button>
                                            </div>
                                            </form>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center">{{ __('user.norecordfound') }}...</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        @if($ratePlanCnt >= 10)
            <div class="pagination-btn text-right">
                <a class=" btn-add add-btn" href="{{ $ratePlan->previousPageUrl() }}">{{ __('user.previous') }}</a>
                <a class=" btn-add add-btn" href="{{ $ratePlan->nextPageUrl() }}">{{ __('user.next') }}</a>
            </div>
        @endif

    </section>
@endsection
@section('footer_content')

@endsection
 