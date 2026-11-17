<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomepageSection;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class HomepageController extends Controller
{
    public function index(): View
    {
        $hero = HomepageSection::firstOrCreate(['section_key' => 'hero'], ['title' => 'Judul Hero', 'content' => 'Deskripsi Hero', 'is_active' => true]);
        $whyChooseUs = HomepageSection::firstOrCreate(['section_key' => 'why_choose_us'], ['title' => 'Kenapa Memilih Kami?', 'content' => 'Deskripsi...', 'is_active' => true]);
        $aboutUs = HomepageSection::firstOrCreate(['section_key' => 'about_us'], ['title' => 'Tentang Kami', 'content' => 'Deskripsi Tentang Kami...', 'is_active' => true]);

        return view('admin.cms.homepage.index', compact('hero', 'whyChooseUs', 'aboutUs'));
    }

    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_content' => 'required|string',
            'hero_image' => 'nullable|image|max:2048',
            'hero_image_2' => 'nullable|image|max:2048',
            'hero_image_3' => 'nullable|image|max:2048',
            'why_title' => 'required|string|max:255',
            'why_content' => 'required|string',
            'about_title' => 'required|string|max:255',
            'about_content' => 'required|string',
            'about_image' => 'nullable|image|max:2048',
        ]);

        // Update Hero
        $hero = HomepageSection::where('section_key', 'hero')->first();
        $heroData = ['title' => $request->hero_title, 'content' => $request->hero_content, 'is_active' => $request->has('hero_is_active')];
        
        if ($request->hasFile('hero_image')) {
            if ($hero->image) Storage::disk('public')->delete($hero->image);
            $heroData['image'] = $request->file('hero_image')->store('cms', 'public');
        }

        // Handle Gambar Collage Tambahan (Disimpan di kolom JSON settings)
        $settings = $hero->settings ?? [];
        
        if ($request->hasFile('hero_image_2')) {
            if (isset($settings['hero_image_2'])) Storage::disk('public')->delete($settings['hero_image_2']);
            $settings['hero_image_2'] = $request->file('hero_image_2')->store('cms', 'public');
        }
        if ($request->hasFile('hero_image_3')) {
            if (isset($settings['hero_image_3'])) Storage::disk('public')->delete($settings['hero_image_3']);
            $settings['hero_image_3'] = $request->file('hero_image_3')->store('cms', 'public');
        }
        $heroData['settings'] = $settings;
        
        $hero->update($heroData);

        // Update Why Choose Us
        $why = HomepageSection::where('section_key', 'why_choose_us')->first();
        $why->update(['title' => $request->why_title, 'content' => $request->why_content, 'is_active' => $request->has('why_is_active')]);

        // Update Tentang Kami
        $about = HomepageSection::where('section_key', 'about_us')->first();
        $aboutData = ['title' => $request->about_title, 'content' => $request->about_content, 'is_active' => $request->has('about_is_active')];
        if ($request->hasFile('about_image')) {
            if ($about->image) Storage::disk('public')->delete($about->image);
            $aboutData['image'] = $request->file('about_image')->store('cms', 'public');
        }
        $about->update($aboutData);

        return redirect()->back()->with('success', 'Konten beranda berhasil diperbarui.');
    }
}