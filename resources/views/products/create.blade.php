@extends('products.layout')

@section('product-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Add New Product</h2>
    </div>

    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        @include('products._form', ['product' => new App\Models\Product(), 'buttonText' => 'Create Product'])
    </form>
@endsection
