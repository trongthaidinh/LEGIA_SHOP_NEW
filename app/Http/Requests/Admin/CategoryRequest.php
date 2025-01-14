<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string|max:1000',
            'featured_image' => 'nullable|image|max:2048|mimes:jpeg,png,jpg,gif',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'is_active' => 'boolean'
        ];

        // Prevent selecting self as parent
        if ($this->category) {
            $rules['parent_id'] .= '|not_in:' . $this->category->id;
        }

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
            'parent_id' => __('Parent Category'),
            'description' => __('Description'),
            'featured_image' => __('Featured Image'),
            'status' => __('Status'),
            'language' => __('Language'),
            'is_featured' => __('Featured'),
            'is_active' => __('Active')
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Validation\Validator $validator
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        \Illuminate\Support\Facades\Log::error('Category validation failed', [
            'errors' => $validator->errors()->toArray(),
            'input' => $this->all()
        ]);
        
        parent::failedValidation($validator);
    }
} 