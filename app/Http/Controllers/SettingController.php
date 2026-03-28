<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\SystemSetting;

class SettingController extends Controller
{
    public function index()
    {
        // Only Admin can access
        if (!auth()->user()->hasRole('Admin')) {
            abort(403);
        }

        $settings = SystemSetting::all()->pluck('value', 'key');
        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        // Only Admin can access
        if (!auth()->user()->hasRole('Admin')) {
            abort(403);
        }

        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            SystemSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Đã cập nhật cài đặt hệ thống thành công!');
    }
}
