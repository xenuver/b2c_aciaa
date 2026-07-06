<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Stock; // Tambahkan ini jika model Stock ada
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; // Tambahkan ini untuk DB transaction

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->orderBy('created_at', 'desc');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter status
        if ($request->filled('status')) {
            if ($request->status === 'aktif') {
                $query->where('is_active', 1);
            } elseif ($request->status === 'nonaktif') {
                $query->where('is_active', 0);
            } elseif ($request->status === 'promo') {
                $query->where('is_promo', 1);
            }
        }

        $products   = $query->paginate(10)->withQueryString();
        $categories = Category::where('is_active', 1)->orderBy('name')->get();

        // Statistik dihitung dari seluruh tabel (bukan hanya halaman ini)
        $totalProducts  = Product::count();
        $activeProducts = Product::where('is_active', 1)->count();
        $promoProducts  = Product::where('is_promo', 1)->count();
        $lowStockCount  = Product::where('stock', '<', 10)->count();

        return view('admin.products.index', compact(
            'products', 'categories',
            'totalProducts', 'activeProducts', 'promoProducts', 'lowStockCount'
        ));
    }

    public function create()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'is_promo' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $slug = Str::slug($request->name);
        
        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'sku' => 'SKU-' . strtoupper(Str::random(8)),
            'is_promo' => $request->is_promo ?? 0,
            'is_active' => $request->is_active ?? 1
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_active', 1)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required',
            'price' => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:10240',
            'is_promo' => 'boolean',
            'is_active' => 'boolean'
        ]);

        $slug = Str::slug($request->name);
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'price' => $request->price,
            'discount_price' => $request->discount_price,
            'stock' => $request->stock,
            'is_promo' => $request->is_promo ?? 0,
            'is_active' => $request->is_active ?? 1
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            
            // Gunakan database transaction
            DB::transaction(function () use ($product) {
                // Hapus data terkait di tabel stocks
                // Sesuaikan dengan nama model dan relationship yang Anda miliki
                
                // Opsi 1: Jika menggunakan model Stock
                if (class_exists(\App\Models\Stock::class)) {
                    \App\Models\Stock::where('product_id', $product->id)->delete();
                }
                
                // Opsi 2: Jika menggunakan DB Query Builder langsung
                // DB::table('stocks')->where('product_id', $product->id)->delete();
                
                // Hapus file image jika ada
                if ($product->image && \Storage::disk('public')->exists($product->image)) {
                    \Storage::disk('public')->delete($product->image);
                }
                
                // Hapus product
                $product->delete();
            });
            
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus');
            
        } catch (\Illuminate\Database\QueryException $e) {
            // Tangani error foreign key constraint
            if ($e->getCode() == 23000) {
                return redirect()->route('admin.products.index')->with('error', 'Tidak dapat menghapus produk karena masih memiliki data stok terkait. Hapus data stok terlebih dahulu.');
            }
            
            return redirect()->route('admin.products.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}