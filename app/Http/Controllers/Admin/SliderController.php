<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    public function index()
    {
        $sliders = Slider::orderBy('order')
            ->byLanguage()
            ->paginate(10);
        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'required|image|max:2048',
                'button_text' => 'nullable|string|max:255',
                'button_url' => 'nullable|string|max:255',
                'order' => 'integer|min:0',
                'is_active' => 'boolean',
                'starts_at' => 'nullable|date',
                'ends_at' => 'nullable|date|after:starts_at',
                'status' => 'required|in:draft,published'
            ]);

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('public/sliders');
                $validated['image'] = str_replace('public/', '', $path);
            }

            $validated['language'] = app()->getLocale();
            Slider::create($validated);

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.sliders.index')
                ->with('success', 'Đã thêm slider thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SliderController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Đã xảy ra lỗi khi thêm slider: ' . $e->getMessage());
        }
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.edit', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
                'button_text' => 'nullable|string|max:255',
                'button_url' => 'nullable|string|max:255',
                'order' => 'integer|min:0',
                'is_active' => 'boolean',
                'starts_at' => 'nullable|date',
                'ends_at' => 'nullable|date|after:starts_at',
                'status' => 'required|in:draft,published'
            ]);

            if ($request->hasFile('image')) {
                // Delete old image
                if ($slider->image) {
                    Storage::delete('public/' . $slider->image);
                }
                $path = $request->file('image')->store('public/sliders');
                $validated['image'] = str_replace('public/', '', $path);
            }

            $slider->update($validated);

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.sliders.index')
                ->with('success', 'Đã cập nhật slider thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SliderController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật slider: ' . $e->getMessage());
        }
    }

    public function destroy(Slider $slider)
    {
        try {
            DB::beginTransaction();

            if ($slider->image) {
                Storage::delete('public/' . $slider->image);
            }
            $slider->delete();

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.sliders.index')
                ->with('success', 'Đã xóa slider thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SliderController@destroy: ' . $e->getMessage());
            return back()
                ->with('error', 'Đã xảy ra lỗi khi xóa slider: ' . $e->getMessage());
        }
    }

    public function updateOrder(Request $request)
    {
        try {
            DB::beginTransaction();
            
            $request->validate([
                'orders' => 'required|array',
                'orders.*' => 'integer|exists:sliders,id'
            ]);

            foreach ($request->orders as $index => $id) {
                Slider::where('id', $id)->update(['order' => $index]);
            }

            DB::commit();
            return response()->json(['message' => 'Đã cập nhật thứ tự thành công']);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SliderController@updateOrder: ' . $e->getMessage());
            return response()->json(['error' => 'Đã xảy ra lỗi khi cập nhật thứ tự'], 500);
        }
    }

    public function toggleStatus(Slider $slider)
    {
        try {
            DB::beginTransaction();
            $slider->update(['is_active' => !$slider->is_active]);

            DB::commit();
            Log::info('Slider status updated successfully');
            return redirect()->route(app()->getLocale() . '.admin.sliders.index')
                ->with('success', 'Đã cập nhật trạng thái slider thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SliderController@toggleStatus: ' . $e->getMessage());
            return back()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật trạng thái slider: ' . $e->getMessage());
        }
    }
} 