<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_email' => 'nullable|email|max:255',
            'shipping_address' => 'required|string|max:255',
            'shipping_city' => 'required|string|max:255',
            'shipping_district' => 'required|string|max:255',
            'shipping_ward' => 'required|string|max:255',
            'shipping_amount' => 'required|numeric|min:0',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'language' => 'required|in:vi,zh',
            'status' => ['required', 'in:' . implode(',', array_keys(Order::getStatuses()))]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'customer_name' => __('Customer Name'),
            'customer_phone' => __('Customer Phone'),
            'customer_email' => __('Customer Email'),
            'shipping_address' => __('Shipping Address'),
            'shipping_city' => __('City'),
            'shipping_district' => __('District'),
            'shipping_ward' => __('Ward'),
            'shipping_amount' => __('Shipping Amount'),
            'notes' => __('Notes'),
            'items' => __('Order Items'),
            'items.*.product_id' => __('Product'),
            'items.*.quantity' => __('Quantity'),
            'language' => __('Language'),
            'status' => __('Status')
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'items.required' => __('Please add at least one product to the order'),
            'items.min' => __('Please add at least one product to the order'),
            'items.*.product_id.required' => __('Please select a product'),
            'items.*.product_id.exists' => __('Selected product does not exist'),
            'items.*.quantity.required' => __('Please enter quantity'),
            'items.*.quantity.min' => __('Quantity must be at least 1')
        ];
    }
} 