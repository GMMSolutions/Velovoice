@extends('products.layout')

@section('product-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Edit Product</h2>
    </div>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')
        @include('products._form', ['product' => $product, 'buttonText' => 'Update Product'])
    </form>
@endsection
