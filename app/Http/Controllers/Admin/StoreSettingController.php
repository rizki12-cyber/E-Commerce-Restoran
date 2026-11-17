<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use App\Services\StoreSettingService;
use App\Services\ActivityLogService; // TAMBAHAN
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class StoreSettingController extends Controller
{
    public function index(): View
    {
        $settings = StoreSetting::pluck('value', 'key')->toArray();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, StoreSettingService $settingService): RedirectResponse
    {
        $request->validate([
            'app_name' => 'required|string|max:100',
            'app_tagline' => 'nullable|string|max:255',
            'primary_color' => 'required|string|max:7', // Hex color
            'contact_phone' => 'nullable|string|max:20',
            'contact_email' => 'nullable|email|max:100',
            'operating_hours_weekday' => 'nullable|string|max:100', // TAMBAHKAN INI
            'operating_hours_weekend' => 'nullable|string|max:100', // TAMBAHKAN INI
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
            'contact_address' => 'nullable|string',
            'footer_description' => 'nullable|string',
            'social_instagram' => 'nullable|url',
            'social_facebook' => 'nullable|url',
            'social_tiktok' => 'nullable|url',
            'google_maps_url' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,webp,svg|max:2048',
        ]);

        $data = $request->except(['_token', 'logo']);
        
        $files = [];
        if ($request->hasFile('logo')) {
            $files['logo'] = $request->file('logo');
        }

        $settingService->updateSettings($data, $files);

        // Catat Log
        ActivityLogService::log('Pengaturan Website', 'Memperbarui pengaturan website (Nama, Logo, atau Warna).');

        return redirect()->back()->with('success', 'Pengaturan website berhasil disimpan!');
    }
}