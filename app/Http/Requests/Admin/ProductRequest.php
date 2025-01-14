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
            // 'gallery' => 'nullable|array',
            // 'gallery.*' => 'nullable|string',
            'status' => 'required|in:draft,published',
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
            'gallery' => __('Gallery'),
            'gallery.*' => __('Gallery Image'),
            'status' => __('Status'),
            'language' => __('Language'),
            'is_featured' => __('Featured'),
            'is_active' => __('Active')
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            // Integer validation
            'stock.integer' => 'Số lượng trong kho phải là số nguyên',
            'category_id.integer' => 'Danh mục không hợp lệ',
            '*.integer' => 'Trường :attribute phải là số nguyên',

            // String validation
            'name.string' => 'Tên sản phẩm phải là chuỗi ký tự',
            'description.string' => 'Mô tả phải là chuỗi ký tự',
            'content.string' => 'Nội dung phải là chuỗi ký tự',
            'sku.string' => 'Mã SKU phải là chuỗi ký tự',
            '*.string' => 'Trường :attribute phải là chuỗi ký tự',

            // Unique validation
            'sku.unique' => 'Mã SKU này đã được sử dụng',
            '*.unique' => 'Trường :attribute đã tồn tại trong hệ thống',

            // Required validation
            'name.required' => 'Vui lòng nhập tên sản phẩm',
            'type.required' => 'Vui lòng chọn loại sản phẩm',
            'category_id.required' => 'Vui lòng chọn danh mục',
            'price.required' => 'Vui lòng nhập giá bán',
            'stock.required' => 'Vui lòng nhập số lượng trong kho',
            'sku.required' => 'Vui lòng nhập mã SKU',
            'status.required' => 'Vui lòng chọn trạng thái',
            '*.required' => 'Trường :attribute không được để trống',

            // Numeric validation
            'price.numeric' => 'Giá bán phải là số',
            'sale_price.numeric' => 'Giá khuyến mãi phải là số',
            '*.numeric' => 'Trường :attribute phải là số',

            // Min validation
            'price.min' => 'Giá bán không được nhỏ hơn :min',
            'sale_price.min' => 'Giá khuyến mãi không được nhỏ hơn :min',
            'stock.min' => 'Số lượng trong kho không được nhỏ hơn :min',
            '*.min' => 'Trường :attribute không được nhỏ hơn :min',

            // Max validation
            'name.max' => 'Tên sản phẩm không được vượt quá :max ký tự',
            'description.max' => 'Mô tả không được vượt quá :max ký tự',
            'sku.max' => 'Mã SKU không được vượt quá :max ký tự',
            '*.max' => 'Trường :attribute không được vượt quá :max ký tự',

            // Image validation
            'featured_image.image' => 'Ảnh đại diện phải là file hình ảnh',
            'featured_image.max' => 'Ảnh đại diện không được vượt quá :max KB',
            'featured_image.mimes' => 'Ảnh đại diện phải có định dạng: :values',
            'gallery.array' => 'Thư viện ảnh không hợp lệ',
            'gallery.*.image' => 'Các file trong thư viện ảnh phải là hình ảnh',

            // Boolean validation
            'is_featured.boolean' => 'Trường sản phẩm nổi bật không hợp lệ',
            'is_active.boolean' => 'Trường trạng thái hoạt động không hợp lệ',
            '*.boolean' => 'Trường :attribute phải là giá trị boolean',

            // In validation
            'status.in' => 'Trạng thái đã chọn không hợp lệ',
            'type.in' => 'Loại sản phẩm đã chọn không hợp lệ',
            '*.in' => 'Giá trị đã chọn trong trường :attribute không hợp lệ',

            // Exists validation
            'category_id.exists' => 'Danh mục đã chọn không tồn tại',
            '*.exists' => 'Giá trị đã chọn trong trường :attribute không tồn tại'
        ];
    }
} 