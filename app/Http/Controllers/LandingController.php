<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\StoreSetting;
use App\Models\HomepageSection;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\Review; // TAMBAHKAN INI AGAR TIDAK ERROR
use Illuminate\Contracts\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $settings = StoreSetting::pluck('value', 'key')->toArray();
        
        $categories = Category::where('is_active', true)->orderBy('sort_order')->take(8)->get();
        
        $featuredProducts = Product::with('category')
            ->where('is_active', true)
            ->where('is_featured', true)
            ->latest()
            ->take(4)
            ->get();
            
        $bestSellers = Product::with('category')
            ->where('is_active', true)
            ->where('is_best_seller', true)
            ->take(4)
            ->get();

        // Ambil data CMS
        $hero = HomepageSection::where('section_key', 'hero')->where('is_active', true)->first();
        
        $whyChooseUs = HomepageSection::where('section_key', 'why_choose_us')->where('is_active', true)->first();
        
        $aboutUs = HomepageSection::firstOrCreate(
            ['section_key' => 'about_us'],
            [
                'title' => 'Menyajikan Kebahagiaan di Setiap Gigitan', 
                'content' => 'Dapur Kaysan didirikan dengan satu tujuan sederhana: menghadirkan makanan rumahan yang lezat, higienis, dan berkualitas bintang lima langsung ke meja Anda.',
                'is_active' => true
            ]
        );

        $faqs = Faq::where('is_active', true)->orderBy('sort_order')->get();

        // Ambil data Galeri
        $galleries = Gallery::where('is_active', true)->orderBy('sort_order')->take(6)->get();

        // AMBIL DATA REVIEW UNTUK MARQUEE
        $reviews = Review::with(['user', 'product'])
            ->where('status', 'approved')
            ->latest()
            ->take(10)
            ->get();

        // HANYA ADA SATU RETURN DI SINI, DAN MASUKKAN 'reviews' KE DALAM COMPACT
        return view('landing.index', compact(
            'settings', 
            'categories', 
            'featuredProducts', 
            'bestSellers', 
            'hero', 
            'whyChooseUs', 
            'aboutUs', 
            'faqs', 
            'galleries',
            'reviews' // TAMBAHKAN INI
        ));
    }
}