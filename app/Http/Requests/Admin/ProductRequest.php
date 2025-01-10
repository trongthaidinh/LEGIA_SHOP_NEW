<?php

namespace App\Http\Requests\Admin;

use App\Models\Product;
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
        $rules = [
            'name' => 'required|max:255',
            'type' => 'required|in:' . implode(',', array_keys(Product::getTypes())),
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'content' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => [
                'nullable',
                'numeric',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value && $value >= $this->input('price')) {
                        $fail('The sale price must be less than the regular price.');
                    }
                },
            ],
            'stock' => 'required|integer|min:0',
            'sku' => [
                'required',
                'string',
                'max:50',
                Rule::unique('products')->ignore($this->product),
            ],
            'featured_image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:draft,published',
            'language' => 'required|in:vi,zh',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ];

        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => __('Name'),
            'type' => __('Type'),
            'category_id' => __('Category'),
            'description' => __('Description'),
            'content' => __('Content'),
            'price' => __('Price'),
            'sale_price' => __('Sale Price'),
            'stock' => __('Stock'),
            'sku' => __('SKU'),
            'featured_image' => __('Featured Image'),
            'status' => __('Status'),
            'language' => __('Language'),
            'is_featured' => __('Featured'),
            'is_active' => __('Active')
        ];
    }
} 