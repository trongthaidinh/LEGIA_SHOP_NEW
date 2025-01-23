<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    use HandleUploadImage;

    const IMAGE_FOLDER = 'testimonials';

    public function index(Request $request)
    {
        $language = $request->get('language', app()->getLocale());
        
        $testimonials = Testimonial::byLanguage($language)
            ->ordered()
            ->paginate(10);
            
        return view('admin.testimonials.index', compact('testimonials', 'language'));
    }

    public function create()
    {
        return view('admin.testimonials.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'language' => 'required|string|in:vi,zh',
            'customer_avatar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('customer_avatar')) {
            $validated['customer_avatar'] = $this->handleUploadImage(
                $request->file('customer_avatar'),
                self::IMAGE_FOLDER
            );
        }

        Testimonial::create($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.testimonials.index')
            ->with('success', __('Testimonial created successfully'));
    }

    public function edit(Testimonial $testimonial)
    {
        return view('admin.testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_position' => 'nullable|string|max:255',
            'content' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'company' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'status' => 'required|in:draft,published',
            'language' => 'required|string|in:vi,zh',
            'customer_avatar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('customer_avatar')) {
            $validated['customer_avatar'] = $this->handleUploadImage(
                $request->file('customer_avatar'),
                self::IMAGE_FOLDER,
                $testimonial->customer_avatar
            );
        }

        $testimonial->update($validated);

        return redirect()
            ->route(app()->getLocale() . '.admin.testimonials.index')
            ->with('success', __('Testimonial updated successfully'));
    }

    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->customer_avatar) {
            $this->deleteImage($testimonial->customer_avatar);
        }
        
        $testimonial->delete();

        return redirect()
            ->route(app()->getLocale() . '.admin.testimonials.index')
            ->with('success', __('Testimonial deleted successfully'));
    }
} 