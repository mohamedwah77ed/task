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
          $productId = $this->route('product');
         return [

        'name' => 'required|string|max:255',
        'sku' => 'required|string|unique:products,sku',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock_quantity' => 'required|integer|min:0',
        'low_stock_threshold' => 'nullable|integer|min:0',
        'status' => ['required', Rule::in(['active', 'inactive', 'discontinued'])],
    ];
    }
}
