<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'status' => 'required|in:draft,sent,paid,cancelled',
            'due_date' => 'nullable|date|after_or_equal:today',
            'notes' => 'nullable|string|max:1000',
            'products' => 'required|array|min:1',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'client_id.required' => 'Please select a client.',
            'products.required' => 'Please add at least one product.',
            'products.*.product_id.required' => 'Please select a product.',
            'products.*.quantity.required' => 'Please enter a quantity.',
            'products.*.quantity.min' => 'Quantity must be at least 1.',
        ];
    }
}
