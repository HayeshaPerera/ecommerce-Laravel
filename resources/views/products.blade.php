@extends('layouts.default')

@section('title', 'Ecom - Home')

@section('content')
<main class="container py-4" style="max-width: 1200px;">
    <!-- Hero Section -->
    <section class="mb-5">
        <div class="p-5 bg-pink text-white text-center rounded shadow-lg" style="background: linear-gradient(135deg, #ff9a9e, #fad0c4);">
            <h1 class="display-5 fw-bold">Welcome to Ecom</h1>
            <p class="lead">Discover amazing products at unbeatable prices, just for you.</p>
            <a href="#products" class="btn btn-light btn-lg shadow-sm px-4 py-2 rounded-pill">Shop Now</a>
        </div>
    </section>

    <!-- Flash Messages -->
    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Product Section -->
    <section id="products">
        <h2 class="text-center fw-bold mb-4 text-pink" style="color: #ff6f91;">Our Products</h2>
        <div class="row g-4">
            @foreach ($products as $product)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card shadow-sm h-100 border-0">
                        <div class="position-relative">
                            <img src="{{ $product->image }}" class="card-img-top rounded-top" alt="{{ $product->title }}">
                            <!-- Badge for Discounts or Offers -->
                            @if($product->discount > 0)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2 rounded-pill">-{{ $product->discount }}% OFF</span>
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">
                                <a href="{{ route('products.details', $product->slug) }}" class="text-decoration-none text-pink-dark">{{ $product->title }}</a>
                            </h5>
                            <p class="card-text">
                                <strong>Price:</strong> LKR {{ number_format($product->price, 2) }}
                                @if($product->discount > 0)
                                    <br>
                                    <small class="text-muted text-decoration-line-through">
                                        LKR {{ number_format($product->original_price, 2) }}
                                    </small>
                                @endif
                            </p>
                        </div>
                        <div class="card-footer bg-light d-flex justify-content-between">
                            <a href="{{ route('products.details', $product->slug) }}" class="btn" style="background-color: #f06292; color: black; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">View Details</a>
                            <!-- Updated "Add to Cart" button with matching colors -->
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn" style="background-color: #f06292; color: black; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">Add to Cart</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="my-5">
        <div class="p-5 bg-light rounded shadow-sm">
            <h2 class="text-center fw-bold mb-4 text-pink" style="color: #ff6f91;">Why Shop with Us?</h2>
            <div class="row g-4">
                <div class="col-md-4 text-center">
                    <i class="bi bi-truck display-4 text-pink"></i>
                    <h4 class="mt-3 text-pink-dark">Fast Delivery</h4>
                    <p>Get your orders delivered quickly and hassle-free.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-shield-check display-4 text-pink"></i>
                    <h4 class="mt-3 text-pink-dark">Secure Payment</h4>
                    <p>Safe and secure payment methods for your convenience.</p>
                </div>
                <div class="col-md-4 text-center">
                    <i class="bi bi-star-fill display-4 text-pink"></i>
                    <h4 class="mt-3 text-pink-dark">Quality Products</h4>
                    <p>We offer only the best quality products to our customers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter Section -->
    <section class="mt-5">
        <div class="p-4 bg-pink text-white rounded shadow-sm text-center" style="background: linear-gradient(135deg, #ff6f91, #f9a8c9);">
            <h2 class="fw-bold">Stay Updated</h2>
            <p>Subscribe to our newsletter and never miss an update!</p>

            <!-- Subscription Form -->
            <form action="{{ route('newsletter.subscribe') }}" method="POST" class="d-flex justify-content-center">
                @csrf
                <input type="email" name="email" class="form-control w-50 me-2" placeholder="Enter your email" required>
                <button type="submit" class="btn btn-light px-4 rounded-pill shadow-sm">Subscribe</button>
            </form>

            <!-- Display success or error messages -->
            @if(session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show mt-2" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </section>

</main>
@endsection
