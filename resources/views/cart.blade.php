@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">{{ __('Carts') }}</div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <td>SN</td>
                                <td>Image</td>
                                <td>Product Name</td>
                                <td>Quantity</td>
                                <td>Price</td>
                            </tr>
                            </thead>

                            <tbody>
                                @php($sn =1)
                                @php($total =0)
                                @foreach($carts as $value)
                                    @php($total+= $value->product->price * $value->quantity)
                                    <tr>
                                        <td>{{ $sn++ }}</td>
                                        <td><img src="{{ asset('assets/images/'.$value->product->image) }}" style="width: 50px;height: 50px;" alt=""></td>
                                        <td>{{ ucwords($value->product->name) }}</td>
                                        <td>
                                            <form method="post">
                                                @csrf
                                                <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                                                <div class="form-group">
                                                    <div class="input-group">
                                                        <div class="input-group-btn">
                                                            <button data-id="{{ $value->id }}" data-url="{{ route('carts.update',$value->id) }}" data-type="add" class="btn btn-primary add">+</button>
                                                        </div>
                                                        <input type="number" value="{{ $value->quantity }}" name="quantity" required max="{{ $value->product->quantity }}" id="quantity">
                                                        <div class="input-group-btn">
                                                            <button data-id="{{ $value->id }}" data-type="remove" data-url="{{ route('carts.destroy',$value->id) }}" class="btn btn-danger remove">-</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </td>
                                        <td>N{!! number_format($value->product->price * $value->quantity,2) !!}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="4" align="right">Total</td>
                                    <td>N{!! number_format($total,2) !!}</td>
                                </tr>
                            </tbody>
                        </table>

                        @if($total > 0)
                            <form action="{{route('order.store')}}" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="">Customer Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ auth()->user()->name }}" disabled id="">
                                </div>

                                <div class="form-group">
                                    <label for="">Email Address</label>
                                    <input type="email" class="form-control" name="email" value="{{ auth()->user()->email }}" disabled id="">
                                </div>

                                <div class="form-group">
                                    <label for="">Customer Phone Number</label>
                                    <input type="text" class="form-control" required placeholder="Customer Phone Number" name="phone_number" id="">
                                </div>

                                <input type="hidden" name="total" value="{{ $total }}" id="">

                                <div class="form-group">
                                    <label for="">Delivery Address</label>
                                    <textarea name="address" class="form-control" style="resize: none" id="" placeholder="Delivery Address"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Checkout</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
