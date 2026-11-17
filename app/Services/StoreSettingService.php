<?php

namespace App\Services;

use App\Models\StoreSetting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class StoreSettingService
{
    public function getAllSettings(): array
    {
        return Cache::rememberForever('store_settings', function () {
            return StoreSetting::pluck('value', 'key')->toArray();
        });
    }

    public function updateSettings(array $data, array $files = []): void
    {
        foreach ($data as $key => $value) {
            StoreSetting::updateOrCreate(
                ['key' => $key],
                [
                    'value' => $value,
                    'group' => 'general' // Tambahkan ini agar tidak error
                ]
            );
        }

        // Handle file uploads (Logo, Favicon)
        foreach ($files as $key => $file) {
            if ($file) {
                $oldSetting = StoreSetting::where('key', $key)->first();
                if ($oldSetting && $oldSetting->value && Storage::disk('public')->exists($oldSetting->value)) {
                    Storage::disk('public')->delete($oldSetting->value);
                }

                $path = $file->store('settings', 'public');
                StoreSetting::updateOrCreate(
                    ['key' => $key],
                    [
                        'value' => $path, 
                        'type' => 'image',
                        'group' => 'branding' // Tambahkan ini
                    ]
                );
            }
        }

        // Bersihkan cache agar website langsung memuat data baru
        Cache::forget('store_settings');
    }
}