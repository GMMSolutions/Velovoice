@extends('invoices.layout')

@section('invoice-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Edit Invoice #{{ $invoice->code }}</h1>
</div>

<form action="{{ route('invoices.update', $invoice) }}" method="POST">
    @csrf
    @method('PUT')
    @include('invoices._form')
</form>

<div class="mt-4">
    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
            <i class="bi bi-trash"></i> Delete Invoice
        </button>
    </form>
</div>
@endsection
