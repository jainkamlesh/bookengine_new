@extends('admin.layout.default')
@section('title', 'Rate Type List')
@section('content')
    <section class="property-wrapper mt-4">
        <h2>{{ __('user.ratetypelist') }}</h2>
        <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
            <div class="d-flex position-relative booking-wrapper align-items-center">

            </div>

            <a href="{{route('admin.add.rate-type')}}">
                <button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>{{ __('user.addratetype') }}</button>
            </a>
        </div>
        <div class="container-fluid">
            @include('flash-message')

            <table class="mt-4 pro-table-pg table-hover wrapper">
                <thead>
                <tr class="ft-tr">
                    <th></th>
                    <th>{{ __('user.name') }}</th>
                    <th>{{ __('user.shortdescription') }}</th>
                    <th>{{ __('user.isrefundable') }}</th>
                    <th>{{ __('user.depositpercentage') }}</th>
                    <th>{{ __('user.action') }}</th>
                </tr>
                </thead>
                <tbody>

                @if($rateTypeCnt > 0)
                    @foreach($rateType as $key => $value)
                        <tr>
                            <td scope="row" data-label="ID">{{++$key}}</td>
                            <td data-label="Name">{{$value->name_it}} </td>
                            <td data-label="Short Description">{{$value->short_description_it}} </td>
                            <td data-label="Room Size">
                                @if(isset($value->is_refundable) && !empty($value->is_refundable))
                                    {{ $value->is_refundable }}
                                @else
                                    Off
                                @endif
                            </td>
                            <td data-label="Room Size">
                                @if(isset($value->deposit_percentage) && !empty($value->deposit_percentage))
                                    {{ $value->deposit_percentage }} %
                                @else
                                    0%
                                @endif
                            </td>
                            <td data-label="ACTION" class="action-list">
                                <div class="d-flex">
                                    <a href="{{route('admin.rate-type.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
                                        <div class="tooltip">{{ __('user.edit') }}</div>
                                        <i class="fa fa-pencil pnsl"></i>
                                    </a>
                                    <div class="icon edit" data-toggle="modal" data-target="#promocodedata_{{$value->id}}" aria-hidden="true">
                                        <div class="tooltip">{{ __('user.delete') }}</div>
                                        <i class="fa fa-trash-o btn-danger delete-icn"></i>
                                    </div>
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
                                                    <a href="{{route('admin.rate-type.delete', ['id'=>$value->id])}}" class="btn btn-default btn-success">{{ __('user.yes') }}</a>
                                                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">{{ __('user.no') }}</button>
                                                </div>
                                            </div>
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
        @if($rateTypeCnt >= 10)
            <div class="pagination-btn text-right">
                <a class=" btn-add add-btn" href="{{ $rateType->previousPageUrl() }}">{{ __('user.previous') }}</a>
                <a class=" btn-add add-btn" href="{{ $rateType->nextPageUrl() }}">{{ __('user.next') }}</a>
            </div>
        @endif

    </section>
@endsection
@section('footer_content')

@endsection
 