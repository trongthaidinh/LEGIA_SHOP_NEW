<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
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