<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class TableRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'table_number' => 'required|string|unique:tables,table_number,' . $this->route('table'),
            'capacity' => 'required|integer|min:1',
            'is_available' => 'boolean',
        ];
    }
}
