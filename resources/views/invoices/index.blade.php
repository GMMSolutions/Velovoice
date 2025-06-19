@extends('invoices.layout')

@section('invoice-content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Invoices</h1>
    <a href="{{ route('invoices.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Create Invoice
    </a>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Invoice #</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Status</th>
                        <th>Due Date</th>
                        <th>Items</th>
                        <th>Total</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->code }}</td>
                            <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                            <td>{{ $invoice->client->firstname }} {{ $invoice->client->lastname }}</td>
                            <td>
                                @php
                                    $statusClasses = [
                                        'draft' => 'bg-secondary',
                                        'sent' => 'bg-info',
                                        'paid' => 'bg-success',
                                        'overdue' => 'bg-danger',
                                    ][$invoice->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClasses }}">{{ ucfirst($invoice->status) }}</span>
                            </td>
                            <td class="{{ now()->gt($invoice->due_date) && $invoice->status !== 'paid' ? 'text-danger fw-bold' : '' }}">
                                {{ $invoice->due_date->format('d/m/Y') }}
                                @if(now()->gt($invoice->due_date) && $invoice->status !== 'paid')
                                    <span class="badge bg-danger ms-1">Overdue</span>
                                @endif
                            </td>
                            <td>{{ $invoice->orders->sum('quantity') }}</td>
                            <td>{{ number_format($invoice->total, 2) }} €</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('invoices.destroy', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this invoice?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4">No invoices found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer">
        {{ $invoices->links() }}
    </div>
</div>
@endsection
