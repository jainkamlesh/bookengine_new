@extends('admin.layout.default')
@section('title', 'Hotel List')
@section('content')
<section class="property-wrapper mt-4">
      <h2>{{ __('label.hotellist') }}</h2>
      <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
        <div class="d-flex position-relative booking-wrapper align-items-center">
          <!-- <form autocomplete="off" action="/action_page.php">
            <div class="autocomplete" >
              <input id="myInput" type="text"  placeholder="Search Hotel" class="prop-inp">
            </div>
          </form> -->
          <!-- <i class="fa fa-search srch-icn-vg" aria-hidden="true"></i>
          <div class="form-group calendar-nav">
            <button id="search" ><i class="fa fa-search" aria-hidden="true"></i></button>
     
          </div> -->
        </div>

        <a href="{{route('admin.editHotelGroupProfile')}}"><button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>{{ __('label.addhotel') }}</button></a>
      </div>
      <div class="container-fluid">
        @include('flash-message')
        <table class="mt-4 pro-table-pg table-hover wrapper">
          <thead>
            <tr class="ft-tr">
              <th>ID</th>
              <th>{{ __('label.hotelname') }}</th>
              <!-- <th>Address</th> -->
              <th>{{ __('label.city') }}</th>
              <!-- <th>State</th> -->
              <th>{{ __('label.contactname') }}</th>
              <th>{{ __('label.contactemail') }}</th>
              <th>{{ __('label.action') }}</th>
            </tr>
          </thead>
          <tbody>

            @if($hotelCnt > 0)
            @foreach($hotels as $key => $value)
            <tr>
              <td scope="row" data-label="ID"> {{$value->id}}</td>
              <td data-label="Hotel Name">{{$value->name}} </td>
              <!-- <td data-label="Address">{{$value->address}}</td> -->
              <td data-label="City">{{$value->city}}</td>
              <!-- <td data-label="State">{{$value->state}}</td> -->
              <td data-label="Contact Name">{{$value->contact_name}}</td>
              <td data-label="Contact Email">{{$value->contact_email}}</td>
              <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                  <!-- <a href="{{route('admin.hotel.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
                    <div class="tooltip">{{ __('label.edit') }}</div>
                    <i class="fa fa-pencil pnsl"></i>
                  </a> -->
                  <div class="icon edit">
                    <div class="tooltip">{{ __('label.login') }}</div>
                    <a class="btn btn-info" href="{{route('admin.byPassHotelLogin', ['id'=>$value->id])}}" target="_blank">{{ __('label.login') }}</a>
                  </div>
                  <div class="icon edit">
                    <a class="btn btn-info" href="{{ env('APP_URL') }}/Scripts/index.pl?hotel_id={{$value->id}}" target="_blank">View</a>
                  </div>
                  @if( $value->hotel_status == 'Y' )
                  <div class="icon edit">
                    <a class="btn btn-success" href="{{route('admin.hotel.status', ['id'=>$value->id,'status'=>'N'])}}" >Inactive</a>
                  </div>
                  @else
                  <div class="icon edit">
                    <a class="btn btn-danger" href="{{route('admin.hotel.status', ['id'=>$value->id,'status'=>'Y'])}}" >Active</a>
                  </div>
                  @endif
                  
                  <!--<div class="icon edit" data-toggle="modal" data-target="#promocodedata_{{$value->id}}" aria-hidden="true">
                    <div class="tooltip">{{ __('label.delete') }}</div>
                    <i class="fa fa-trash-o btn-danger delete-icn"></i>
                  </div>-->
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
                    <a href="{{route('admin.hotel.delete', ['id'=>$value->id])}}" class="btn btn-default btn-success" >{{ __('label.yes') }}</a>
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
      @if($hotelCnt >= 10)
      <div class="pagination-btn text-right">
        <a class=" btn-add add-btn" href="{{ $hotels->previousPageUrl() }}">{{ __('label.previous') }}</a>
        <a class=" btn-add add-btn" href="{{ $hotels->nextPageUrl() }}">{{ __('label.next') }}</a>
      </div>
      @endif

    </section>
@endsection
@section('footer_content')
@endsection
 