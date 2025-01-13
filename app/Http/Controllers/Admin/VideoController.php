<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function index(Request $request)
    {
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

        $videos = $query->paginate(20)->withQueryString();

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'youtube_url' => 'required|url',
            'is_active' => 'boolean'
        ]);

        $video = Video::create([
            'youtube_url' => $request->youtube_url,
            'is_active' => $request->is_active ?? true,
            'order' => Video::max('order') + 1
        ]);

        return redirect()->route(app()->getLocale() . '.admin.videos.index')
            ->with('success', 'Đã thêm video thành công');
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
        $request->validate([
            'youtube_url' => 'required|url',
            'is_active' => 'boolean',
            'order' => 'integer|min:0'
        ]);

        $video->update($request->only(['youtube_url', 'is_active', 'order']));

        return redirect()->route(app()->getLocale() . '.admin.videos.index')
            ->with('success', 'Đã cập nhật video thành công');
    }

    public function destroy(Video $video)
    {
        $video->delete();

        return redirect()->route(app()->getLocale() . '.admin.videos.index')
            ->with('success', 'Đã xóa video thành công');
    }

    public function updateOrder(Request $request)
    {
        $request->validate([
            'orders.*.id' => 'required|exists:videos,id',
            'orders.*.order' => 'required|integer|min:0'
        ]);

        foreach ($request->orders as $item) {
            Video::where('id', $item['id'])->update(['order' => $item['order']]);
        }

        return response()->json(['message' => 'Đã cập nhật thứ tự thành công']);
    }

    public function toggleStatus(Video $video)
    {
        $video->update(['is_active' => !$video->is_active]);

        return redirect()->back()
            ->with('success', 'Đã ' . ($video->is_active ? 'kích hoạt' : 'vô hiệu hóa') . ' video thành công');
    }
} 