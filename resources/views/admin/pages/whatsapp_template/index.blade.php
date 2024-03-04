@extends('admin.layout.default')
@section('title', 'Whatsapp Template List')
@section('content')
<section class="property-wrapper mt-4">
      <h2>{{ __('label.whatsapptemplate') }}</h2>
      <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
        <div class="d-flex position-relative booking-wrapper align-items-center">

        </div>

        <a href="{{route('admin.add.whatsapp-template')}}"><button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>{{ __('label.addwhatsapptemplate') }}</button></a>
      </div>
      <div class="container-fluid">
        @include('flash-message')

        <table class="mt-4 pro-table-pg table-hover wrapper">
          <thead>
            <tr class="ft-tr">
              <th></th>
              <th>{{ __('label.name') }}</th>
              <th>{{ __('label.message') }}</th>
              <th>{{ __('label.action') }}</th>
            </tr>
          </thead>
          <tbody>

            @if($whatsappTemplateCnt > 0)
            @foreach($whatsappTemplate as $key => $value)
            <tr>
              <td scope="row" data-label="ID">{{++$key}}</td>
              <td data-label="Name">{{$value->name}} </td>
              <td data-label="message">{!!$value->message!!} </td>
              <td data-label="ACTION" class="action-list">
                <div class="d-flex">
                  <a href="{{route('admin.whatsapp-template.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
                    <div class="tooltip">{{ __('label.edit') }}</div>
                    <i class="fa fa-pencil pnsl"></i>
                  </a>
                  <div class="icon edit" data-toggle="modal" data-target="#promocodedata_{{$value->id}}" aria-hidden="true">
                    <div class="tooltip">{{ __('label.delete') }}</div>
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
                        <h5 class="modal-title">{{ __('label.delete') }}</h5>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="coupon">
                        <h5 class="delete-warning">{{ __('label.areyousurewanttodelete') }}!</h5>
                        <div class="mt-4 modal-btn">
                            <a href="{{route('admin.whatsapp-template.delete', ['id'=>$value->id])}}" class="btn btn-default btn-success" >{{ __('label.yes') }}</a>
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
              <td colspan="4" class="text-center" >{{ __('label.norecordfound') }}...</td>
            </tr>
            @endif

          </tbody>
        </table>
      </div>
      @if($whatsappTemplateCnt >= 10)
      <div class="pagination-btn text-right">
        <a class=" btn-add add-btn" href="{{ $whatsappTemplate->previousPageUrl() }}">{{ __('label.previous') }}</a>
        <a class=" btn-add add-btn" href="{{ $whatsappTemplate->nextPageUrl() }}">{{ __('label.next') }}</a>
      </div>
      @endif

    </section>
@endsection
@section('footer_content')

@endsection
