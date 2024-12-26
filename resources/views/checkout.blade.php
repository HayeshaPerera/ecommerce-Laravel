@extends('layouts.default')
@section('title', 'Checkout')
@section('content')
<main class="container" style="max-width: 900px">
    <section>
        <h2 class="mb-4">Checkout</h2>

        @if(session()->has("success"))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session()->get("success") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session("error"))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session("error") }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <form action="{{ route('checkout.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" required pattern="[0-9]{10}" title="Enter a valid 10-digit phone number">
            </div>

            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" placeholder="Enter your delivery address" required>
            </div>

            <div class="mb-3">
                <label for="pincode" class="form-label">Pin Code</label>
                <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Enter your area pincode" required pattern="[0-9]{6}" title="Enter a valid 6-digit pincode">
            </div>

            <!-- Payment Method Selection -->
            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select class="form-control" name="payment_method" id="payment_method" required>
                    <option value="cod">Cash on Delivery</option>
                    <option value="online">Online Payment</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Place Order
            </button>
        </form>
    </section>
</main>
@endsection
