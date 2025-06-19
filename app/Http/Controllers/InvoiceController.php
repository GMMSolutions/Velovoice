<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\InvoiceRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class InvoiceController extends Controller
{
    public function index(): View
    {
        $invoices = Invoice::with('client')
            ->latest()
            ->paginate(10);
            
        return view('invoices.index', compact('invoices'));
    }

    public function create(): View
    {
        $clients = Client::orderBy('lastname')->get();
        $products = Product::orderBy('name')->get();
        
        return view('invoices.create', compact('clients', 'products'));
    }

    public function store(InvoiceRequest $request): RedirectResponse
    {
        // Create the invoice
        $invoice = Invoice::create([
            'code' => 'INV-' . now()->format('Ymd-His'),
            'client_id' => $request->client_id,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        // Add orders
        foreach ($request->products as $productData) {
            if (!empty($productData['product_id']) && !empty($productData['quantity'])) {
                $product = Product::find($productData['product_id']);
                
                $invoice->orders()->create([
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->unit_price,
                ]);
            }
        }

        // Handle save and new
        if ($request->action === 'save_and_new') {
            return redirect()
                ->route('invoices.create')
                ->with('success', 'Invoice created successfully.');
        }

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice created successfully.');
    }

    public function show(Invoice $invoice): View
    {
        $invoice->load(['client', 'orders.product']);
        
        return view('invoices.show', compact('invoice'));
    }

    public function edit(Invoice $invoice): View
    {
        $invoice->load(['client', 'orders.product']);
        $clients = Client::orderBy('lastname')->get();
        $products = Product::orderBy('name')->get();
        
        return view('invoices.edit', compact('invoice', 'clients', 'products'));
    }

    public function update(InvoiceRequest $request, Invoice $invoice): RedirectResponse
    {
        // Update invoice
        $invoice->update([
            'client_id' => $request->client_id,
            'status' => $request->status,
            'due_date' => $request->due_date,
            'notes' => $request->notes,
        ]);

        // Delete existing orders
        $invoice->orders()->delete();

        // Add updated orders
        foreach ($request->products as $productData) {
            if (!empty($productData['product_id']) && !empty($productData['quantity'])) {
                $product = Product::find($productData['product_id']);
                
                $invoice->orders()->create([
                    'product_id' => $product->id,
                    'quantity' => $productData['quantity'],
                    'unit_price' => $product->unit_price,
                ]);
            }
        }

        // Handle save and new
        if ($request->action === 'save_and_new') {
            return redirect()
                ->route('invoices.create')
                ->with('success', 'Invoice updated successfully.');
        }

        return redirect()
            ->route('invoices.show', $invoice)
            ->with('success', 'Invoice updated successfully.');
    }

    public function destroy(Invoice $invoice): RedirectResponse
    {
        $invoice->delete();
        
        return redirect()
            ->route('invoices.index')
            ->with('success', 'Invoice deleted successfully.');
    }

    public function getProduct(Product $product)
    {
        return response()->json($product);
    }

    public function download(Invoice $invoice)
    {
        $invoice->load(['client', 'orders.product']);
        
        $pdf = PDF::loadView('invoices.pdf', [
            'invoice' => $invoice
        ]);
        
        return $pdf->download('invoice-' . $invoice->code . '.pdf');
    }
}
