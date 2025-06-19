@extends('products.layout')

@section('product-content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Product Details</h2>
        <div class="btn-group">
            <a href="{{ route('products.edit', $product) }}" class="btn btn-outline-secondary">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-arrow-left"></i> Back to Products
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <h6 class="card-subtitle mb-2 text-muted">{{ $product->code }}</h6>
                </div>
                <div class="col-md-6 text-md-end">
                    <h3 class="text-primary">${{ number_format($product->unit_price, 2) }}</h3>
                    <small class="text-muted">Unit Price</small>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <dl class="row">
                        <dt class="col-sm-4">Created At</dt>
                        <dd class="col-sm-8">{{ $product->created_at->format('M d, Y h:i A') }}</dd>
                        
                        <dt class="col-sm-4">Updated At</dt>
                        <dd class="col-sm-8">{{ $product->updated_at->format('M d, Y h:i A') }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="card-footer bg-transparent">
            <form action="{{ route('products.destroy', $product) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger" 
                        onclick="return confirm('Are you sure you want to delete this product?')">
                    <i class="bi bi-trash"></i> Delete Product
                </button>
            </form>
        </div>
    </div>
@endsection
