<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RecruitmentSetting;

class RecruitmentSettingController extends Controller
{
    public function index()
    {
        $settings = RecruitmentSetting::all()->groupBy('group');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->except('_token');

        foreach ($data as $key => $value) {
            RecruitmentSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    public function clearCache()
    {
        if (!auth()->user()->hasRole(['super_admin', 'hr_admin'])) {
            abort(403);
        }

        try {
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            \Illuminate\Support\Facades\Artisan::call('view:clear');
            \Illuminate\Support\Facades\Artisan::call('config:clear');
            \Illuminate\Support\Facades\Artisan::call('route:clear');

            $opcacheReset = false;
            if (function_exists('opcache_reset')) {
                $opcacheReset = @opcache_reset();
            }

            $message = 'System caches cleared successfully!';
            if ($opcacheReset) {
                $message .= ' (PHP OPCache has been reset)';
            }

            return redirect()->back()->with('success', $message);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to clear cache: ' . $e->getMessage());
        }
    }
}
