<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        if (auth()->user()->role != 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }
    }

    public function index()
    {
        $data = Product::latest()->get();
        return view('backoffice.product.index', compact('data'));
    }


    public function create()
    {
        $categories = Category::where('enabled', 1)->latest()->get();
        return view('backoffice.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi input
        $attr = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric|min:0',
            'stock'            => 'required|integer|min:0',

            // khusus parfum
            'fragrance_family' => 'nullable|string|max:100',
            'volume_ml'        => 'required|integer|min:1',
            'gender_target'    => 'required|in:male,female,unisex',
            'usage_time'       => 'nullable|in:morning,night,all_day',
            'situation'        => 'nullable|in:indoor,outdoor,mixed',
            'longevity'        => 'nullable|in:long_last,light_frequent',

            // image
            'image'            => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'enabled'          => 'required|boolean',
        ]);

        // 2. Generate slug
        $attr['slug'] = Str()->slug($attr['name']);

        // 3. Upload image ke storage (folder: products)
        $attr['image'] = $request->file('image')->store('products', 'public');

        // 4. Simpan ke database
        Product::create($attr);

        // 5. Redirect dengan pesan sukses
        return redirect()->route('product.index')->with('success', 'Produk berhasil dibuat!');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('enabled', 1)->latest()->get();
        return view('backoffice.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Validasi (image opsional)
        $attr = $request->validate([
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'category_id'      => 'required|exists:categories,id',
            'price'            => 'required|numeric|min:0',
            'stock'            => 'required|integer|min:0',

            // khusus parfum
            'fragrance_family' => 'nullable|string|max:100',
            'volume_ml'        => 'required|integer|min:1',
            'gender_target'    => 'required|in:male,female,unisex',
            'usage_time'       => 'nullable|in:morning,night,all_day',
            'situation'        => 'nullable|in:indoor,outdoor,mixed',
            'longevity'        => 'nullable|in:long_last,light_frequent',

            // image
            'image'            => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'enabled'          => 'required|boolean',
        ]);

        // Slug
        $attr['slug'] = Str()->slug($attr['name']);

        // Jika ada upload baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama kalau ada
            if ($product->image && Storage::exists($product->image)) {
                Storage::delete($product->image);
            }
            // Simpan gambar baru
            $attr['image'] = $request->file('image')->store('products');
        }

        // Update data
        $product->update($attr);

        return redirect()->route('product.index')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Hapus gambar lama
        if ($product->image && Storage::exists($product->image)) {
            Storage::delete($product->image);
        }

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
    }

    public function setActive($id)
    {
        $data = Product::findOrFail($id);
        if ($data->enabled == 1) {
            $data->update(['enabled' => 0]);
            return redirect()->back()->with('success', $data->name . " has been nonactived");
        } else {
            $data->update(['enabled' => 1]);
            return redirect()->back()->with('success', $data->name . " has been actived");
        }
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('upload')) {
            $img = $request->file('upload')->store('media');
            $url = asset("/storage/" . $img);

            return response()->json(['fillname' => $request->file('upload')->getClientOriginalName(), 'uploaded' => 1, 'url' => $url]);
        }
    }
}
