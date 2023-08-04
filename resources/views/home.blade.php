@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Products') }}</div>

                <div class="card-body">

                    <div class="row">
                        @foreach(\App\Products::all() as $value)
                            <div class="col-sm-4 mb-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ $value->name }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <img src="{{ asset('assets/images/'.$value->image) }}" style="width: 100%" alt="">
                                        <hr>
                                        <p> <small>{{ $value->description }}</small></p>
                                        <form action="{{route('carts.store')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                                            <div class="form-group">
                                                <input type="number" value="1" max="{{ $value->quantity }}" class="form-control" name="quantity" id="quantity">
                                            </div>

                                            <div class="form-group">
                                                <input type="submit" data-product-id="{{ $value->id }}"  class="btn btn-primary btn-block add-to-cart" value="Add To Cart" name="" id="add-to-cart">
                                            </div>
                                        </form>


                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
