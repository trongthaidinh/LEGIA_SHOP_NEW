<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'status' => $this->input('is_published') ? 'published' : 'draft',
            'published_at' => $this->input('is_published') ? Carbon::now() : null,
            'is_featured' => $this->boolean('is_featured'),
            'excerpt' => $this->input('excerpt') ?? '',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'post_category_id' => 'required|exists:post_categories,id',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'featured_image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề bài viết không được để trống',
            'title.max' => 'Tiêu đề bài viết không được vượt quá 255 ký tự',
            'post_category_id.required' => 'Vui lòng chọn danh mục bài viết',
            'post_category_id.exists' => 'Danh mục bài viết không tồn tại',
            'content.required' => 'Nội dung bài viết không được để trống',
            'excerpt.max' => 'Tóm tắt không được vượt quá 500 ký tự',
            'featured_image.image' => 'File tải lên phải là hình ảnh',
            'featured_image.max' => 'Kích thước hình ảnh không được vượt quá 2MB',
            'status.required' => 'Vui lòng chọn trạng thái bài viết',
            'status.in' => 'Trạng thái bài viết không hợp lệ',
            'published_at.date' => 'Ngày xuất bản không hợp lệ',
        ];
    }
} 