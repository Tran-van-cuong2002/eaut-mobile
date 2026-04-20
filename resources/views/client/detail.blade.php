@extends('layouts.client')

@section('content')
<div class="container py-5">
    <div class="row bg-white p-4 rounded-4 shadow-sm">
        <div class="col-md-5">
            <img src="{{ $product->image }}" class="img-fluid rounded-3 border" alt="{{ $product->name }}">
        </div>
        <div class="col-md-7">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang chủ</a></li>
                    <li class="breadcrumb-item active">{{ $product->name }}</li>
                </ol>
            </nav>
            <h2 class="fw-bold">{{ $product->name }}</h2>
            <h3 class="text-danger fw-bold my-3">{{ number_format($product->price, 0, ',', '.') }} đ</h3>
            <p class="text-muted">{{ $product->description }}</p>
            <hr>
            <div class="d-flex align-items-center mt-4">
                <a href="{{ route('cart.add', $product->id) }}" class="btn btn-danger btn-lg px-5 py-3 fw-bold">
                    <i class="bi bi-cart-plus me-2"></i> THÊM VÀO GIỎ HÀNG
                </a>
            </div>
        </div>
    </div>
</div>
@endsection