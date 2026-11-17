<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('sort_order')->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'sort_order' => Category::max('sort_order') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui.');
    }

   public function destroy(Category $category)
{
    // 1. Produk aktif → tolak hapus kategori
    $activeCount = $category->products()->count();
    if ($activeCount > 0) {
        return redirect()
            ->route('admin.categories.index')
            ->with('error', "Kategori \"{$category->name}\" tidak bisa dihapus karena masih memiliki {$activeCount} produk aktif. Pindahkan atau hapus produknya terlebih dahulu.");
    }

    try {
        // 2. Hapus permanen produk yang sudah di-soft-delete
        $category->products()->onlyTrashed()->forceDelete();

        // 3. Baru hapus kategorinya
        $category->delete();

        return redirect()
            ->route('admin.categories.index')
            ->with('success', "Kategori \"{$category->name}\" berhasil dihapus.");
    } catch (\Illuminate\Database\QueryException $e) {
        return redirect()
            ->route('admin.categories.index')
            ->with('error', 'Kategori gagal dihapus karena masih terkait dengan data lain.');
    }
}
}