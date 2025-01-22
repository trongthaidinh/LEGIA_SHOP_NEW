<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    use HandleUploadImage;

    /**
     * Folder path for storing certificate images
     */
    const IMAGE_FOLDER = 'certificates';

    public function index(Request $request)
    {
        $language = $request->get('language', app()->getLocale());
        
        $certificates = Certificate::byLanguage($language)
            ->ordered()
            ->paginate(10);
            
        return view('admin.certificates.index', compact('certificates', 'language'));
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => __('The certificate name is required'),
            'name.max' => __('The certificate name must not exceed 255 characters'),
            'image.required' => __('The certificate image is required'),
            'image.image' => __('The file must be an image'),
            'image.max' => __('The image size must not exceed 2MB'),
            'status.required' => __('The status is required'),
            'status.in' => __('Invalid status value'),
            'order.integer' => __('The order must be a number'),
            'language.required' => __('The language is required'),
            'language.in' => __('Invalid language selection')
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|max:2048',
            'status' => 'required|in:draft,published',
            'is_active' => 'boolean',
            'order' => 'integer',
            'language' => 'required|string|in:vi,zh'
        ], $messages);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleUploadImage(
                $request->file('image'),
                self::IMAGE_FOLDER,
            );
        }

        Certificate::create($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.certificates.index')
            ->with('success', __('Certificate created successfully'));
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $messages = [
            'name.required' => __('The certificate name is required'),
            'name.max' => __('The certificate name must not exceed 255 characters'),
            'image.image' => __('The file must be an image'),
            'image.max' => __('The image size must not exceed 2MB'),
            'status.required' => __('The status is required'),
            'status.in' => __('Invalid status value'),
            'order.integer' => __('The order must be a number'),
            'language.required' => __('The language is required'),
            'language.in' => __('Invalid language selection')
        ];

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'is_active' => 'boolean',
            'order' => 'integer',
            'language' => 'required|string|in:vi,zh'
        ], $messages);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->handleUploadImage(
                $request->file('image'),
                self::IMAGE_FOLDER,
                $certificate->image
            );
        }

        $certificate->update($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.certificates.index')
            ->with('success', __('Certificate updated successfully'));
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image) {
            Storage::disk('public')->delete($certificate->image);
        }
        
        $certificate->delete();

        return redirect()
            ->route(app()->getLocale() . '.admin.certificates.index')
            ->with('success', __('Certificate deleted successfully'));
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders' => 'required|array',
            'orders.*.id' => 'required|exists:certificates,id',
            'orders.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->orders as $item) {
            Certificate::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Order updated successfully']);
    }

    public function toggleStatus(Certificate $certificate)
    {
        $certificate->update(['is_active' => !$certificate->is_active]);
        
        return response()->json([
            'message' => __('Certificate status updated successfully'),
            'is_active' => $certificate->is_active
        ]);
    }
} 