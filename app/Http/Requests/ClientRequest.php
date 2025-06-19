<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'code' => 'required|string|max:50|unique:clients,code' . ($this->client ? ",{$this->client->id}" : ''),
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'status' => 'required|in:Indépendant,Société',
            'society' => 'nullable|string|max:255',
            'street' => 'required|string|max:255',
            'CP' => 'required|string|max:20',
            'street_number' => 'required|string|max:20',
        ];
    }
}
