@extends('invoices.layout')

@section('invoice-content')
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h2 class="h4 mb-0">Invoice #{{ $invoice->code }}</h2>
        <div>
            <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-secondary me-2">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('invoices.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Back to Invoices
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Bill To:</h5>
                <address>
                    <strong>{{ $invoice->client->firstname }} {{ $invoice->client->lastname }}</strong><br>
                    @if($invoice->client->status === 'Société' && $invoice->client->society)
                        {{ $invoice->client->society }}<br>
                    @endif
                    {{ $invoice->client->street_number }} {{ $invoice->client->street }}<br>
                    {{ $invoice->client->CP }} {{ $invoice->client->city }}
                </address>
            </div>
            <div class="col-md-6 text-md-end">
                <h5>Invoice Details</h5>
                <p class="mb-1"><strong>Invoice #:</strong> {{ $invoice->code }}</p>
                <p class="mb-1"><strong>Date:</strong> {{ $invoice->created_at->format('F d, Y') }}</p>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-end">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($invoice->orders as $index => $order)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $order->product->name }} ({{ $order->product->code }})</td>
                            <td class="text-end">{{ number_format($order->unit_price, 2) }} €</td>
                            <td class="text-center">{{ $order->quantity }}</td>
                            <td class="text-end">{{ number_format($order->total, 2) }} €</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Subtotal</strong></td>
                        <td class="text-end">{{ number_format($invoice->total, 2) }} €</td>
                    </tr>
                    <tr>
                        <td colspan="4" class="text-end"><strong>Total</strong></td>
                        <td class="text-end"><strong>{{ number_format($invoice->total, 2) }} €</strong></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="card-footer text-end">
        <a href="{{ route('invoices.download', $invoice) }}" class="btn btn-primary">
            <i class="bi bi-download"></i> Download PDF
        </a>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('invoices.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back to Invoices
    </a>
    <div>
        <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-primary me-2">
            <i class="bi bi-pencil"></i> Edit Invoice
        </a>
        <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
                <i class="bi bi-trash"></i> Delete Invoice
            </button>
        </form>
    </div>
</div>
@endsection
