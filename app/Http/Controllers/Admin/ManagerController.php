<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ManagerController extends Controller
{
    public function index(Request $request)
    {
        try {
            $query = Admin::query();

            // Search by name or email
            if ($request->filled('search')) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            }

            // Filter by role
            if ($request->filled('role')) {
                if ($request->role === 'super_admin') {
                    $query->where('is_super_admin', true);
                } else if ($request->role === 'admin') {
                    $query->where('is_super_admin', false);
                }
            }

            // Sort
            $sortField = $request->get('sort', 'created_at');
            $sortDirection = $request->get('direction', 'desc');
            
            if (in_array($sortField, ['name', 'email', 'created_at'])) {
                $query->orderBy($sortField, $sortDirection);
            }

            $managers = $query->paginate(10)->appends($request->query());

            return view('admin.managers.index', compact('managers'));
        } catch (\Exception $e) {
            Log::error('Error in ManagerController@index: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi khi tải danh sách quản trị viên.');
        }
    }

    public function create()
    {
        return view('admin.managers.create');
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins',
                'password' => 'required|string|min:8|confirmed',
                'is_super_admin' => 'boolean'
            ]);

            Admin::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'is_super_admin' => $validated['is_super_admin'] ?? false
            ]);

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.managers.index')
                ->with('success', 'Đã tạo quản trị viên thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ManagerController@store: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Đã xảy ra lỗi khi tạo quản trị viên: ' . $e->getMessage());
        }
    }

    public function edit(Admin $manager)
    {
        return view('admin.managers.edit', compact('manager'));
    }

    public function update(Request $request, Admin $manager)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:admins,email,' . $manager->id,
                'password' => 'nullable|string|min:8|confirmed',
                'is_super_admin' => 'boolean'
            ]);

            $data = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'is_super_admin' => $validated['is_super_admin'] ?? false
            ];

            if (!empty($validated['password'])) {
                $data['password'] = Hash::make($validated['password']);
            }

            $manager->update($data);

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.managers.index')
                ->with('success', 'Đã cập nhật quản trị viên thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ManagerController@update: ' . $e->getMessage());
            return back()->withInput()
                ->with('error', 'Đã xảy ra lỗi khi cập nhật quản trị viên: ' . $e->getMessage());
        }
    }

    public function destroy(Admin $manager)
    {
        try {
            DB::beginTransaction();

            if ($manager->is_super_admin) {
                throw new \Exception('Không thể xóa tài khoản Super Admin');
            }

            $manager->delete();

            DB::commit();
            return redirect()->route(app()->getLocale() . '.admin.managers.index')
                ->with('success', 'Đã xóa quản trị viên thành công');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in ManagerController@destroy: ' . $e->getMessage());
            return back()->with('error', 'Đã xảy ra lỗi khi xóa quản trị viên: ' . $e->getMessage());
        }
    }
} 