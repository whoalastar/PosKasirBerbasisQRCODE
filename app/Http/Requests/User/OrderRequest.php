<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'table_id' => 'required|exists:tables,id',
            'customer_name' => 'required|string|max:255',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.menu_id' => 'required|exists:menus,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.notes' => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom error messages for validation rules.
     */
    public function messages(): array
    {
        return [
            'table_id.required' => 'Table selection is required.',
            'table_id.exists' => 'Selected table does not exist.',
            'customer_name.required' => 'Customer name is required.',
            'customer_name.max' => 'Customer name cannot exceed 255 characters.',
            'payment_method_id.required' => 'Payment method selection is required.',
            'payment_method_id.exists' => 'Selected payment method does not exist.',
            'items.required' => 'At least one menu item must be selected.',
            'items.min' => 'At least one menu item must be selected.',
            'items.*.menu_id.required' => 'Menu item selection is required.',
            'items.*.menu_id.exists' => 'Selected menu item does not exist.',
            'items.*.quantity.required' => 'Quantity is required for each item.',
            'items.*.quantity.integer' => 'Quantity must be a valid number.',
            'items.*.quantity.min' => 'Quantity must be at least 1.',
            'items.*.notes.max' => 'Item notes cannot exceed 500 characters.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Additional validation: Check if all menu items are available and have sufficient stock
            if ($this->has('items')) {
                foreach ($this->items as $index => $item) {
                    $menu = \App\Models\Menu::find($item['menu_id']);
                    
                    if ($menu) {
                        // Check if menu is available
                        if (!$menu->is_available) {
                            $validator->errors()->add(
                                "items.{$index}.menu_id", 
                                "The menu item '{$menu->name}' is currently not available."
                            );
                        }
                        
                        // Check stock
                        if ($menu->stock < $item['quantity']) {
                            $validator->errors()->add(
                                "items.{$index}.quantity", 
                                "Insufficient stock for '{$menu->name}'. Available: {$menu->stock}"
                            );
                        }
                    }
                }
            }

            // Check if table is available
            if ($this->has('table_id')) {
                $table = \App\Models\Table::find($this->table_id);
                if ($table && !$table->is_available) {
                    $validator->errors()->add('table_id', 'Selected table is currently not available.');
                }
            }
        });
    }
}