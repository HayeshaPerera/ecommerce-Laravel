@extends('layouts.default')

@section('title', $product->title)

@section('content')
    <div class="container py-5">
        <h1>{{ $product->title }}</h1>
        <img src="{{ $product->image }}" class="img-fluid" alt="{{ $product->title }}">
        <p>{{ $product->description }}</p>
        <p><strong>Price:</strong> LKR {{ number_format($product->price, 2) }}</p>

        @if($product->discount > 0)
            <p><small class="text-muted">Original Price: LKR {{ number_format($product->original_price, 2) }}</small></p>
            <p class="text-danger">Discount: {{ $product->discount }}% OFF</p>
        @endif

        <form action="{{ route('cart.add', $product->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn" style="background-color: #f06292; color: white;">Add to Cart</button>

        
        </form>
    </div>
@endsection
