<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index(Request $request)
    {
        $query = Image::query();

        // Filter by visibility
        if ($request->has('visibility')) {
            $query->where('visibility', $request->visibility);
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        // Search by filename
        if ($request->has('search')) {
            $query->where('file_name', 'like', '%' . $request->search . '%');
        }

        // Sort
        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        $query->orderBy($sort, $direction);

        $images = $query->paginate(20)->withQueryString();

        return view('admin.images.index', compact('images'));
    }

    public function create()
    {
        return view('admin.images.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048', // Max 2MB per image
            'visibility' => 'required|in:public,private',
        ]);

        $uploadedImages = [];
        dd($request->file('images'));
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $imageFile) {
                $fileName = Str::uuid() . '.' . $imageFile->getClientOriginalExtension();
                $filePath = $imageFile->storeAs('images', $fileName, 'public');

                $image = Image::create([
                    'file_name' => $imageFile->getClientOriginalName(),
                    'file_path' => $filePath,
                    'mime_type' => $imageFile->getMimeType(),
                    'file_size' => $imageFile->getSize(),
                    'visibility' => $request->visibility,
                    'is_active' => true,
                    'order' => Image::max('order') + 1
                ]);

                $uploadedImages[] = $image;
            }
        }

        return redirect()->route(app()->getLocale() . '.admin.images.index')
            ->with('success', 'Đã tải lên ' . count($uploadedImages) . ' hình ảnh thành công');
    }

    public function show(Image $image)
    {
        return view('admin.images.show', compact('image'));
    }

    public function edit(Image $image)
    {
        return view('admin.images.edit', compact('image'));
    }

    public function update(Request $request, Image $image)
    {
        $request->validate([
            'visibility' => 'required|in:public,private',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $image->update($request->only(['visibility', 'is_active', 'order']));

        return redirect()->route(app()->getLocale() . '.admin.images.index')
            ->with('success', 'Đã cập nhật hình ảnh thành công');
    }

    public function destroy(Image $image)
    {
        // Delete the physical file
        Storage::disk('public')->delete($image->file_path);
        
        // Delete the database record
        $image->delete();

        return redirect()->route(app()->getLocale() . '.admin.images.index')
            ->with('success', 'Đã xóa hình ảnh thành công');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders.*.id' => 'required|exists:images,id',
            'orders.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->orders as $item) {
            Image::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Đã cập nhật thứ tự thành công']);
    }

    public function toggleStatus(Image $image)
    {
        $image->update(['is_active' => !$image->is_active]);

        return redirect()->back()
            ->with('success', 'Đã ' . ($image->is_active ? 'kích hoạt' : 'vô hiệu hóa') . ' hình ảnh thành công');
    }
} 