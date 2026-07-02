<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('sku', 'like', '%' . $request->search . '%');
        }
        
        // Filter berdasarkan kategori
        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }
        
        // Filter stok menipis (kurang dari 10)
        if ($request->has('low_stock') && $request->low_stock) {
            $query->where('stock', '<', 10);
        }
        
        // Filter stok habis
        if ($request->has('out_of_stock') && $request->out_of_stock) {
            $query->where('stock', 0);
        }
        
        $products = $query->orderBy('stock', 'asc')->paginate(15);
        $categories = \App\Models\Category::where('is_active', 1)->get();
        
        return view('admin.stocks.index', compact('products', 'categories'));
    }
    
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.stocks.edit', compact('product'));
    }
    
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $request->validate([
            'stock' => 'required|integer|min:0',
            'note' => 'nullable|string'
        ]);
        
        $oldStock = $product->stock;
        $newStock = $request->stock;
        $difference = $newStock - $oldStock;
        
        // Update stok produk
        $product->stock = $newStock;
        $product->save();
        
        // Catat riwayat mutasi stok
        Stock::create([
            'product_id' => $product->id,
            'quantity' => abs($difference),
            'type' => $difference > 0 ? 'in' : 'out',
            'description' => $request->note ?: ($difference > 0 ? 'Penambahan stok manual' : 'Pengurangan stok manual'),
            'created_by' => Auth::id()
        ]);
        
        return redirect()->route('admin.stocks.index')
            ->with('success', "Stok produk {$product->name} berhasil diupdate dari {$oldStock} menjadi {$newStock}");
    }
    
    public function history($id)
    {
        $product = Product::findOrFail($id);
        $histories = Stock::where('product_id', $id)
            ->with('creator')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.stocks.history', compact('product', 'histories'));
    }
    
    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.stock' => 'required|integer|min:0'
        ]);
        
        $updated = 0;
        foreach ($request->products as $item) {
            $product = Product::find($item['id']);
            if ($product && $product->stock != $item['stock']) {
                $oldStock = $product->stock;
                $product->stock = $item['stock'];
                $product->save();
                
                // Catat riwayat
                Stock::create([
                    'product_id' => $product->id,
                    'quantity' => abs($item['stock'] - $oldStock),
                    'type' => $item['stock'] > $oldStock ? 'in' : 'out',
                    'description' => 'Bulk update stok',
                    'created_by' => Auth::id()
                ]);
                $updated++;
            }
        }
        
        return redirect()->route('admin.stocks.index')
            ->with('success', "Berhasil mengupdate stok untuk {$updated} produk");
    }
}