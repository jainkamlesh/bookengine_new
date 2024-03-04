@extends('admin.layout.default')
@section('title', 'Service List')
@section('content')
    <section class="property-wrapper mt-4">
        <h2>{{ __('user.servicelist') }}</h2>
        <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
            <div class="d-flex position-relative booking-wrapper align-items-center">

            </div>

            <a href="{{route('admin.add.service')}}">
                <button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>{{ __('user.addservice') }}</button>
            </a>
        </div>
        <div class="container-fluid">
            @include('flash-message')

            <table class="mt-4 pro-table-pg table-hover wrapper">
                <thead>
                <tr class="ft-tr">
                    <th></th>
                    <th>{{ __('user.name') }}</th>
                    <th>{{ __('user.image') }}</th>
                    <th>{{ __('user.maxquantity') }}</th>
                    <th>{{ __('user.price') }}</th>
                    <th>{{ __('user.tax') }}</th>
                    <th>{{ __('user.action') }}</th>
                </tr>
                </thead>
                <tbody>

                @if($serviceCnt > 0)
                    @foreach($service as $key => $value)
                        <tr>
                            <td scope="row" data-label="ID">{{++$key}}</td>
                            <td data-label="Name">{{$value->name_it}} </td>
                            <td data-label="images">
                            <?php
                             $ar_images = array();
                             $ar_images = explode(",", $value->images);
                             
 
                                foreach($ar_images as $key => $value2){
                                    ?>
                                      <img src="{{url('public/images/service/')}}/{{$value2}}" style="width:  50px;"> 
                                    <?php
                                }
                            
 
                             ?>
          
                             </td>
                            <td data-label="Max Quantity">{{$value->max_quantity}} </td>
                            <td data-label="Price">{{$value->price}} </td>
                            <td data-label="Tax">{{$value->tax}} </td>

                            <td data-label="ACTION" class="action-list">
                                <div class="d-flex">
                                    <a href="{{route('admin.service.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
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
                                                    <a href="{{route('admin.service.delete', ['id'=>$value->id])}}" class="btn btn-default btn-success">{{ __('label.yes') }}</a>
                                                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">{{ __('label.no') }}</button>
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
                        <td colspan="4" class="text-center">{{ __('user.norecordfound') }}...</td>
                    </tr>
                @endif

                </tbody>
            </table>
        </div>
    </section>
@endsection
@section('footer_content')

@endsection
 