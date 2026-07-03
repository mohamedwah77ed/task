<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */


 public function rules(): array
{
    $product = $this->route('product');
    $productId = is_object($product) ? $product->id : $product;

    return [
        'name' => 'required|string|max:255',

        'sku' => [
            'required',
            'string',
            Rule::unique('products', 'sku')->ignore($productId),
        ],

        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'low_stock_threshold' => 'nullable|integer|min:0',
        'status' => [
            'required',
            Rule::in(['active', 'inactive', 'discontinued']),
        ],
    ];
}
}
