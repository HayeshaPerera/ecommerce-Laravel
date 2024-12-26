@extends('layouts.default')

@section('title', 'Your Cart')

@section('content')
    <main class="container" style="max-width: 900px">
        <section>
            <h2>Your Cart</h2>

            @if(session()->has('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session()->has('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif


            @if ($cartItems->isEmpty())
                <p>Your cart is empty!</p>
            @else
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cartItems as $item)
                            <tr>
                                <td>{{ $item->title }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $item->product_id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" class="form-control" style="width: 60px;">
                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                    </form>
                                </td>
                                <td>LKR {{ number_format($item->price, 2) }}</td>
                                <td>LKR {{ number_format($item->price * $item->quantity, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $item->product_id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            <div>
                <a class="btn btn-success" href="{{ route('checkout.show') }}">Checkout</a>
            </div>
        </section>
    </main>
@endsection
