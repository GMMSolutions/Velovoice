<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Invoice #{{ $invoice->code }}</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            line-height: 1.4;
        }
        .header {
            margin-bottom: 30px;
        }
        .company-info {
            margin-bottom: 30px;
        }
        .invoice-info {
            margin-bottom: 30px;
        }
        .client-info {
            margin-bottom: 30px;
            float: right;
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .text-right {
            text-align: right;
        }
        .total {
            font-weight: bold;
            font-size: 1.1em;
        }
        .notes {
            margin-top: 30px;
            padding: 10px;
            background-color: #f9f9f9;
            border: 1px solid #eee;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>INVOICE #{{ $invoice->code }}</h1>
        <div class="invoice-info">
            <p><strong>Date:</strong> {{ $invoice->created_at->format('F j, Y') }}</p>
            <p><strong>Due Date:</strong> {{ $invoice->due_date->format('F j, Y') }}</p>
            <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
        </div>
        <div class="client-info">
            <h3>Bill To:</h3>
            <p>{{ $invoice->client->firstname }} {{ $invoice->client->lastname }}</p>
            <p>{{ $invoice->client->address }}</p>
            <p>{{ $invoice->client->zip }} {{ $invoice->client->city }}</p>
            <p>{{ $invoice->client->country }}</p>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Product</th>
                <th>Description</th>
                <th>Unit Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->orders as $order)
            <tr>
                <td>{{ $order->product->name }}</td>
                <td>{{ $order->product->description }}</td>
                <td class="text-right">{{ number_format($order->unit_price, 2) }} €</td>
                <td class="text-right">{{ $order->quantity }}</td>
                <td class="text-right">{{ number_format($order->quantity * $order->unit_price, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right">{{ number_format($invoice->total, 2) }} €</td>
            </tr>
            @if($invoice->tax_rate > 0)
            <tr>
                <td colspan="4" class="text-right"><strong>Tax ({{ $invoice->tax_rate }}%):</strong></td>
                <td class="text-right">{{ number_format(($invoice->total * $invoice->tax_rate) / 100, 2) }} €</td>
            </tr>
            @endif
            <tr class="total">
                <td colspan="4" class="text-right"><strong>Total:</strong></td>
                <td class="text-right">{{ number_format($invoice->total * (1 + $invoice->tax_rate / 100), 2) }} €</td>
            </tr>
        </tfoot>
    </table>

    @if($invoice->notes)
    <div class="notes">
        <h4>Notes:</h4>
        <p>{{ $invoice->notes }}</p>
    </div>
    @endif

    <div class="footer">
        <p>Thank you for your business!</p>
    </div>
</body>
</html>
