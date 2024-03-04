@extends('admin.layout.default')
@section('title', 'Offer List')
@section('content')
    <section class="property-wrapper mt-4">
        <h2>Offers / Offerte
        </h2>
        <div class="d-flex justify-content-between align-items-center container-fluid mt-4 pro-add-nnb">
            <div class="d-flex position-relative booking-wrapper align-items-center">
            </div>

            <a href="{{route('admin.add.offer')}}">
                <button class="btn-add add-btn"><i class="fa fa-plus" aria-hidden="true"></i>Add Offer / Aggiungi offerte</button>
            </a>
        </div>
        <div class="container-fluid">
            @include('flash-message')

            <table class="mt-4 pro-table-pg table-hover wrapper">
                <thead>
                <tr class="ft-tr">
                    <th></th>
                    <th>Name</th>
                    <th>Nome</th>
                    <th>Image</th>
                    <th>Valid From / Dal</th>
                    <th>Valid To / Al</th>
                    <th>Discount% / Sconto%</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @if($offerCnt > 0)
                    @foreach($offer as $key => $value)
                        <tr>
                            <td scope="row" data-label="ID">{{++$key}}</td>
                            <td data-label="Name">{{$value->name}} </td>
                            <td data-label="Name">{{$value->name_it}} </td>
                            <td data-label="Name"><img src="{{url('public/images/offer/')}}/{{$value->image}}" width="100" height="100"></td>
                            <td data-label="Short Description">{{$value->valid_from}} </td>
                            <td data-label="Room Size">{{$value->valid_to}} </td>
                            <td data-label="Room Size">{{$value->discount_percentage}} </td>

                            <td data-label="ACTION" class="action-list">
                                <div class="d-flex">
                                    <a href="{{route('admin.offer.edit', ['id'=>$value->id])}}" class="icon edit edit-icon">
                                        <div class="tooltip">Edit</div>
                                        <i class="fa fa-pencil pnsl"></i>
                                    </a>
                                    <div class="icon edit" data-toggle="modal" data-target="#promocodedata_{{$value->id}}" aria-hidden="true">
                                        <div class="tooltip">Delete</div>
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
                                            <h5 class="modal-title">Delete</h5>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="offer">
                                                <h5 class="delete-warning">Are you sure want to Delete!</h5>
                                                <div class="mt-4 modal-btn">
                                                    <a href="{{route('admin.offer.delete', ['id'=>$value->id])}}" class="btn btn-default btn-success">Yes</a>
                                                    <button type="button" class="btn btn-default btn-danger" data-dismiss="modal">No</button>
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
                        <td colspan="7" class="text-center">No records Found...</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
        @if($offerCnt >= 10)
            <div class="pagination-btn text-right">
                <a class=" btn-add add-btn" href="{{ $offer->previousPageUrl() }}">Previous</a>
                <a class=" btn-add add-btn" href="{{ $offer->nextPageUrl() }}">Next</a>
            </div>
        @endif

    </section>
@endsection
@section('footer_content')

@endsection
 