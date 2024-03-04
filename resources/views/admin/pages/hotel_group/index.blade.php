@extends('admin.layout.default')
@section('title', 'Hotel Group List')
@section('content')
<section class="property-wrapper mt-4">
      <h2>{{ __('label.hotelgroup') }}</h2>
	  <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
        <div class="d-flex position-relative booking-wrapper align-items-center">
        </div>
        <a href="{{route('admin.add.hotelgroup')}}"><button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>{{ __('label.addhotelgroup') }}</button></a>
      </div>
	  <div class="container-fluid">
        @include('flash-message')
        <table class="mt-4 pro-table-pg table-hover wrapper">
          <thead>
            <tr class="ft-tr">
              <th>ID</th>
              <th>{{ __('label.backgroundimage') }}</th>
              <!-- <th>Address</th> -->
              <th>{{ __('label.businessname') }}</th>
              <!-- <th>State</th> -->
              <th>{{ __('label.phone') }}</th>
              <th>{{ __('label.email') }}</th>
             <!-- <th>{{ __('label.selecthotel') }}</th>-->
              <th>{{ __('label.action') }}</th>
            </tr>
          </thead>
          <tbody>

            @if($hotelgpCnt > 0)
            @foreach($hotelgroups as $key => $value)
			<?php
				$gpid = unserialize($value->groupids);
				$gpm  = implode(',',$gpid);
			?>
            <tr>
              <td scope="row" data-label="ID"> {{$value->id}}</td>
              <td data-label="backgroundimage">
				<img src="{{url('public/images/hotel_group/')}}/{{$value->backgroundimage}}" width="100" height="100">
			  </td>
              <td data-label="businessname">{{$value->businessname}}</td>
              <td data-label="phone">{{$value->phone}}</td>
              <td data-label="email">{{$value->email}}</td>
              <!--<td data-label="selecthotel">{{$gpm}}</td>-->
              <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                  <a href="{{route('admin.hotelgroup.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
                    <div class="tooltip">{{ __('label.edit') }}</div>
                    <i class="fa fa-pencil pnsl"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata_{{$value->id}}" aria-hidden="true">
                    <div class="tooltip">{{ __('label.delete') }}</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>
                  <div class="icon edit">
                    <a class="btn btn-info" href="{{ env('APP_URL') }}/Scripts/group.pl?group_id={{$value->id}}" target="_blank">View</a>
                  </div>
                </div>
              </td>
            </tr>
            <div class="delete-modal-main">
        <div class="modal fade" id="promocodedata_{{$value->id}}">
          <div class="modal-dialog modal-dialog-centered promocode_main" role="document">
            <div class="modal-content">
              <div class="modal-header mt-2">
                <h5 class="modal-title">{{ __('label.delete') }}</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              <div class="modal-body">
                <div class="coupon">
                  <h5 class="delete-warning">{{ __('label.areyousurewanttodelete') }}!</h5>
                  <div class="mt-4 modal-btn">
                    <a href="{{route('admin.hotelgroup.delete', ['id'=>$value->id])}}" class="btn btn-default btn-success" >{{ __('label.yes') }}</a>
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
              <td colspan="7" class="text-center" >{{ __('label.norecordfound') }}...</td>
            </tr>
            @endif

          </tbody>
        </table>
      </div>
      @if($hotelgpCnt >= 10)
      <div class="pagination-btn text-right">
        <a class=" btn-add add-btn" href="{{ $hotelgroups->previousPageUrl() }}">{{ __('label.previous') }}</a>
        <a class=" btn-add add-btn" href="{{ $hotelgroups->nextPageUrl() }}">{{ __('label.next') }}</a>
      </div>
      @endif
</section>
@endsection
@section('footer_content')
@endsection
 