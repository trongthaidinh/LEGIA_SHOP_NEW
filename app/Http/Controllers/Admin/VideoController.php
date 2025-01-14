<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    use HandleUploadImage;

    /**
     * Folder path for storing video thumbnails
     */
    const IMAGE_FOLDER = 'video-thumbnails';

    public function index(Request $request)
    {
        try {
            $query = Video::query();

            // Filter by status
            if ($request->has('status')) {
                $query->where('is_active', $request->status === 'active');
            }

            // Search by URL
            if ($request->has('search')) {
                $query->where('youtube_url', 'like', '%' . $request->search . '%');
            }

            // Sort
            $sort = $request->sort ?? 'created_at';
            $direction = $request->direction ?? 'desc';
            $query->orderBy($sort, $direction);

            $videos = $query->paginate(20);

            return view('admin.videos.index', compact('videos'));
        } catch (\Exception $e) {
            Log::error('Error in VideoController@index: ' . $e->getMessage());
            return back()->with('error', __('Error loading videos.'));
        }
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'youtube_url' => 'required|url',
                'thumbnail' => 'nullable|image|max:2048',
                'is_active' => 'boolean'
            ]);

            $data = [
                'youtube_url' => $request->youtube_url,
                'is_active' => $request->is_active ?? true,
                'order' => Video::max('order') + 1
            ];

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $this->handleUploadImage(
                    $request->file('thumbnail'),
                    self::IMAGE_FOLDER
                );
            }

            Video::create($data);

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.videos.index')
                ->with('success', 'Đã thêm video thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VideoController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', __('Error creating video: ') . $e->getMessage());
        }
    }

    public function show(Video $video)
    {
        return view('admin.videos.show', compact('video'));
    }

    public function edit(Video $video)
    {
        return view('admin.videos.edit', compact('video'));
    }

    public function update(Request $request, Video $video)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'youtube_url' => 'required|url',
                'thumbnail' => 'nullable|image|max:2048',
                'is_active' => 'boolean',
                'order' => 'integer|min:0'
            ]);

            $data = $request->only(['youtube_url', 'is_active', 'order']);

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $data['thumbnail'] = $this->handleUploadImage(
                    $request->file('thumbnail'),
                    self::IMAGE_FOLDER,
                    $video->thumbnail
                );
            }

            $video->update($data);

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.videos.index')
                ->with('success', 'Đã cập nhật video thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VideoController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', __('Error updating video: ') . $e->getMessage());
        }
    }

    public function destroy(Video $video)
    {
        try {
            DB::beginTransaction();

            // Delete thumbnail if exists
            if ($video->thumbnail) {
                $this->deleteImage($video->thumbnail);
            }

            $video->delete();

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.videos.index')
                ->with('success', 'Đã xóa video thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VideoController@destroy: ' . $e->getMessage());
            return back()->with('error', __('Error deleting video: ') . $e->getMessage());
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            DB::beginTransaction();

            $request->validate([
                'orders.*.id' => 'required|exists:videos,id',
                'orders.*.order' => 'required|integer|min:0'
            ]);

            foreach ($request->orders as $item) {
                Video::where('id', $item['id'])->update(['order' => $item['order']]);
            }

            DB::commit();
            return response()->json(['message' => 'Đã cập nhật thứ tự thành công']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VideoController@updateOrder: ' . $e->getMessage());
            return response()->json(['error' => __('Error updating order: ') . $e->getMessage()], 500);
        }
    }

    public function toggleStatus(Video $video)
    {
        try {
            DB::beginTransaction();

            $video->update(['is_active' => !$video->is_active]);

            DB::commit();
            return redirect()->back()
                ->with('success', 'Đã ' . ($video->is_active ? 'kích hoạt' : 'vô hiệu hóa') . ' video thành công');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in VideoController@toggleStatus: ' . $e->getMessage());
            return back()->with('error', __('Error toggling status: ') . $e->getMessage());
        }
    }
} 