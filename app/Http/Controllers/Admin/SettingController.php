<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\HandleUploadImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    use HandleUploadImage;

    const IMAGE_FOLDER = 'settings';

    public function index()
    {
        $settings = Setting::orderBy('group')
            ->orderBy('order')
            ->get()
            ->groupBy('group');
            
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        try {
            DB::beginTransaction();

            foreach ($request->settings as $id => $value) {
                $setting = Setting::find($id);
                if ($setting) {
                    if ($setting->type == 'image' && $request->hasFile("settings.{$id}")) {
                        $value = $this->handleUploadImage(
                            $request->file("settings.{$id}"),
                            self::IMAGE_FOLDER,
                            $setting->value
                        );
                    }
                    $setting->value = $value;
                    $setting->save();
                }
            }

            DB::commit();
            Cache::forget(Setting::CACHE_KEY);
            
            return redirect()->route(app()->getLocale() . '.admin.settings.index')
                ->with('success', 'Đã cập nhật cài đặt thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in SettingController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật cài đặt: ' . $e->getMessage());
        }
    }
} 