<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImageController extends Controller
{
    use HandleUploadImage;

    /**
     * Folder path for storing gallery images
     */
    const IMAGE_FOLDER = 'gallery';

    public function index(Request $request)
    {
        try {
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

            $images = $query->paginate(20);

            return view('admin.images.index', compact('images'));
        } catch (\Exception $e) {
            Log::error('Error in ImageController@index: ' . $e->getMessage());
            return back()->with('error', __('Error loading images.'));
        }
    }

    public function create()
    {
        return view('admin.images.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'images.*' => 'required|image|max:2048', // Max 2MB per image
                'visibility' => 'required|in:public,private',
            ]);

            $uploadedImages = [];

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $filePath = $this->handleUploadImage($imageFile, self::IMAGE_FOLDER);

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

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.images.index')
                ->with('success', 'Đã tải lên ' . count($uploadedImages) . ' hình ảnh thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ImageController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', __('Error uploading images: ') . $e->getMessage());
        }
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
        try {
            DB::beginTransaction();

            $request->validate([
                'visibility' => 'required|in:public,private',
                'is_active' => 'boolean',
                'order' => 'integer|min:0'
            ]);

            $image->update($request->only(['visibility', 'is_active', 'order']));

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.images.index')
                ->with('success', 'Đã cập nhật hình ảnh thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ImageController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', __('Error updating image: ') . $e->getMessage());
        }
    }

    public function destroy(Image $image)
    {
        try {
            DB::beginTransaction();

            // Delete the physical file
            $this->deleteImage($image->file_path);
            
            // Delete the database record
            $image->delete();

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.images.index')
                ->with('success', 'Đã xóa hình ảnh thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ImageController@destroy: ' . $e->getMessage());
            return back()->with('error', __('Error deleting image: ') . $e->getMessage());
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'orders.*.id' => 'required|exists:images,id',
                'orders.*.order' => 'required|integer|min:0'
            ]);

            foreach ($request->orders as $item) {
                Image::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            DB::commit();
            return response()->json(['message' => 'Đã cập nhật thứ tự thành công']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ImageController@updateOrder: ' . $e->getMessage());
            return response()->json(['error' => __('Error updating order: ') . $e->getMessage()], 500);
        }
    }

    public function toggleStatus(Image $image)
    {
        try {
            DB::beginTransaction();

            $image->update(['is_active' => !$image->is_active]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Đã ' . ($image->is_active ? 'kích hoạt' : 'vô hiệu hóa') . ' hình ảnh thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ImageController@toggleStatus: ' . $e->getMessage());
            return back()->with('error', __('Error toggling status: ') . $e->getMessage());
        }
    }
} 