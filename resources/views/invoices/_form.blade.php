<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Invoice Information</h5>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="status" class="form-label">Status *</label>
                    <select class="form-select @error('status') is-invalid @enderror" 
                            id="status" name="status" required>
                        <option value="draft" {{ old('status', $invoice->status ?? 'draft') == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="sent" {{ old('status', $invoice->status ?? '') == 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="paid" {{ old('status', $invoice->status ?? '') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="cancelled" {{ old('status', $invoice->status ?? '') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="due_date" class="form-label">Due Date</label>
                    <input type="date" class="form-control @error('due_date') is-invalid @enderror" 
                           id="due_date" name="due_date" 
                           value="{{ old('due_date', isset($invoice->due_date) ? $invoice->due_date->format('Y-m-d') : '') }}">
                    @error('due_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Client Information</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="client_id" class="form-label">Client *</label>
            <select class="form-select @error('client_id') is-invalid @enderror" 
                    id="client_id" name="client_id" required>
                <option value="" disabled selected>Select a client</option>
                @foreach($clients as $client)
                    <option value="{{ $client->id }}" {{ old('client_id', $invoice->client_id ?? '') == $client->id ? 'selected' : '' }}>
                        {{ $client->firstname }} {{ $client->lastname }}
                    </option>
                @endforeach
            </select>
            @error('client_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">Products</h5>
        <button type="button" class="btn btn-sm btn-primary" id="add-product">
            <i class="bi bi-plus"></i> Add Product
        </button>
    </div>
    <div class="card-body">
        <div id="products-container">
            @if(isset($invoice) && $invoice->orders->count() > 0)
                @foreach($invoice->orders as $index => $order)
                    <div class="product-row mb-3 border-bottom pb-3">
                        <div class="row g-3">
                            <div class="col-md-5">
                                <select class="form-select product-select" name="products[{{ $index }}][product_id]" required>
                                    <option value="" disabled>Select a product</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}" 
                                            data-price="{{ $product->unit_price }}"
                                            {{ $order->product_id == $product->id ? 'selected' : '' }}>
                                            {{ $product->name }} ({{ $product->code }}) - {{ number_format($product->unit_price, 2) }} €
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" min="1" value="{{ $order->quantity }}" class="form-control quantity" 
                                       name="products[{{ $index }}][quantity]" required>
                            </div>
                            <div class="col-md-3">
                                <input type="text" class="form-control price" value="{{ number_format($order->quantity * $order->product->unit_price, 2) }} €" readonly>
                            </div>
                            <div class="col-md-2 d-flex align-items-center">
                                <button type="button" class="btn btn-sm btn-danger remove-product">
                                    <i class="bi bi-trash"></i> Remove
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<template id="product-template">
    <div class="product-row mb-3 border-bottom pb-3">
        <div class="row g-3">
            <div class="col-md-5">
                <select class="form-select product-select" name="products[__index__][product_id]" required>
                    <option value="" selected disabled>Select a product</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" data-price="{{ $product->unit_price }}">
                            {{ $product->name }} ({{ $product->code }}) - {{ number_format($product->unit_price, 2) }} €
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <input type="number" min="1" value="1" class="form-control quantity" 
                       name="products[__index__][quantity]" required>
            </div>
            <div class="col-md-3">
                <input type="text" class="form-control price" readonly>
            </div>
            <div class="col-md-2 d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-danger remove-product">
                    <i class="bi bi-trash"></i> Remove
                </button>
            </div>
        </div>
    </div>
</template>

<div class="card mb-4">
    <div class="card-header">
        <h5 class="mb-0">Notes</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <textarea class="form-control @error('notes') is-invalid @enderror" 
                      id="notes" name="notes" 
                      rows="3">{{ old('notes', $invoice->notes ?? '') }}</textarea>
            @error('notes')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>

<div class="d-flex justify-content-between">
    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Back to Invoices
    </a>
    <div>
        <button type="submit" name="action" value="save_and_new" class="btn btn-outline-primary me-2">
            <i class="bi bi-save"></i> Save & New
        </button>
        <button type="submit" name="action" value="save" class="btn btn-primary">
            <i class="bi bi-save"></i> {{ $buttonText ?? 'Save Invoice' }}
        </button>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('products-container');
    const template = document.getElementById('product-template').innerHTML;
    const addButton = document.getElementById('add-product');
    let productIndex = 0;

    // Add product row
    function addProductRow(data = {}) {
        const index = productIndex++;
        let html = template.replace(/__index__/g, index);
        
        const row = document.createElement('div');
        row.innerHTML = html;
        
        // Set values if provided
        if (data.product_id) {
            const select = row.querySelector('.product-select');
            select.value = data.product_id;
            updatePrice(row);
        }
        
        if (data.quantity) {
            row.querySelector('.quantity').value = data.quantity;
        }
        
        container.appendChild(row.firstElementChild);
        
        // Add event listeners to the new row
        addRowEventListeners(row.firstElementChild);
    }
    
    // Update price when product or quantity changes
    function updatePrice(row) {
        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity');
        const priceInput = row.querySelector('.price');
        
        if (select.value) {
            const option = select.options[select.selectedIndex];
            const price = parseFloat(option.dataset.price);
            const quantity = parseInt(quantityInput.value) || 0;
            const total = price * quantity;
            
            priceInput.value = total.toFixed(2) + ' €';
        } else {
            priceInput.value = '';
        }
    }
    
    // Add event listeners to a row
    function addRowEventListeners(row) {
        const select = row.querySelector('.product-select');
        const quantityInput = row.querySelector('.quantity');
        const removeButton = row.querySelector('.remove-product');
        
        if (select) {
            select.addEventListener('change', () => updatePrice(row));
        }
        
        if (quantityInput) {
            quantityInput.addEventListener('input', () => updatePrice(row));
        }
        
        if (removeButton) {
            removeButton.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation(); // Prevent event bubbling
                if (confirm('Are you sure you want to remove this product?')) {
                    row.remove();
                    // Rename all form fields to maintain proper array indexing
                    updateProductRowIndexes();
                }
            });
        }
    }
    
    // Update product row indexes to maintain proper array indexing
    function updateProductRowIndexes() {
        document.querySelectorAll('.product-row').forEach((row, index) => {
            // Update product ID field
            const productSelect = row.querySelector('.product-select');
            if (productSelect) {
                productSelect.name = `products[${index}][product_id]`;
            }
            
            // Update quantity field
            const quantityInput = row.querySelector('.quantity');
            if (quantityInput) {
                quantityInput.name = `products[${index}][quantity]`;
            }
        });
    }
    }
    
    // Add product button click handler
    addButton.addEventListener('click', () => {
        addProductRow();
    });
    
    // Add initial product row if empty and not editing
    @if(!isset($invoice) || $invoice->orders->count() === 0)
        if (container.children.length === 0) {
            addProductRow();
        }
    @endif
    
    // Initialize event listeners for existing rows
    document.querySelectorAll('.product-row').forEach(row => {
        addRowEventListeners(row);
    });
});
</script>
@endpush
