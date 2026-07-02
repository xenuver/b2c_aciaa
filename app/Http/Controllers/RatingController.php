<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function create($productId, Request $request)
    {
        $product = Product::findOrFail($productId);

        // Check if a specific transaction_id is provided (from transaction detail page)
        $transactionId = $request->query('transaction_id');

        if ($transactionId) {
            // Validate this transaction belongs to user, is delivered, and contains this product
            $transaction = Transaction::where('id', $transactionId)
                ->where('user_id', Auth::id())
                ->where('status', 'delivered')
                ->whereHas('details', function ($q) use ($productId) {
                    $q->where('product_id', $productId);
                })
                ->first();

            if (!$transaction) {
                return redirect()->back()->with('error', 'Transaksi tidak valid atau produk tidak ditemukan dalam transaksi ini.');
            }

            // Check if already reviewed for this specific transaction
            $existingRating = Rating::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->where('transaction_id', $transactionId)
                ->first();

            if ($existingRating) {
                return redirect()->back()->with('info', 'Anda sudah memberikan ulasan untuk pembelian ini.');
            }
        } else {
            // No transaction_id provided: find an unreviewed delivered transaction
            $deliveredTransactions = Transaction::where('user_id', Auth::id())
                ->where('status', 'delivered')
                ->whereHas('details', function ($q) use ($productId) {
                    $q->where('product_id', $productId);
                })
                ->pluck('id');

            if ($deliveredTransactions->isEmpty()) {
                return redirect()->back()->with('error', 'Anda hanya bisa memberi ulasan untuk produk yang sudah dibeli dan diterima.');
            }

            // Find a transaction that hasn't been reviewed yet
            $reviewedTransactions = Rating::where('user_id', Auth::id())
                ->where('product_id', $productId)
                ->whereIn('transaction_id', $deliveredTransactions)
                ->pluck('transaction_id');

            $unreviewedTransactions = $deliveredTransactions->diff($reviewedTransactions);

            if ($unreviewedTransactions->isEmpty()) {
                return redirect()->back()->with('info', 'Anda sudah memberikan ulasan untuk semua pembelian produk ini.');
            }

            // Pick the first unreviewed transaction
            $transactionId = $unreviewedTransactions->first();
        }

        return view('frontend.ratings.create', compact('product', 'transactionId'));
    }

    public function store(Request $request)
    {
        // Honeypot anti-bot check: if the hidden field is filled, reject silently
        if ($request->filled('website_url')) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'transaction_id' => 'required|exists:transactions,id',
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $productId = $request->product_id;
        $transactionId = $request->transaction_id;

        // Verify transaction belongs to user, is delivered, and contains this product
        $transaction = Transaction::where('id', $transactionId)
            ->where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereHas('details', function ($q) use ($productId) {
                $q->where('product_id', $productId);
            })
            ->first();

        if (!$transaction) {
            return back()->with('error', 'Transaksi tidak valid.');
        }

        // Check if already reviewed for this specific transaction + product combo
        $existingRating = Rating::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->where('transaction_id', $transactionId)
            ->exists();

        if ($existingRating) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk pembelian ini.');
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('ratings', 'public');
                $imagePaths[] = $path;
            }
        }

        // Anti-spam keyword check
        $isApproved = true;
        if ($this->containsSpam($request->review)) {
            $isApproved = false;
        }

        $newRating = Rating::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
            'transaction_id' => $transactionId,
            'rating' => $request->rating,
            'review' => $request->review,
            'images' => $imagePaths,
            'is_approved' => $isApproved
        ]);

        \App\Models\Notification::sendToAdmins(
            'Ulasan Produk Baru ⭐',
            "Pelanggan " . Auth::user()->name . " memberikan ulasan bintang {$request->rating} untuk produk {$newRating->product->name}.",
            'info',
            route('admin.ratings.index')
        );

        if (!$isApproved) {
            return redirect()->route('products.show', $request->product_slug)
                ->with('success', 'Ulasan Anda berhasil disimpan dan sedang dalam moderasi admin karena mendeteksi kata sensitif/tautan.');
        }

        return redirect()->route('products.show', $request->product_slug)
            ->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function myRatings()
    {
        $ratings = Rating::where('user_id', Auth::id())
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.ratings.index', compact('ratings'));
    }

    public function edit($id)
    {
        $rating = Rating::where('user_id', Auth::id())->findOrFail($id);
        $product = $rating->product;

        return view('frontend.ratings.edit', compact('rating', 'product'));
    }

    public function update(Request $request, $id)
    {
        $rating = Rating::where('user_id', Auth::id())->findOrFail($id);

        // Honeypot check on edit
        if ($request->filled('website_url')) {
            return redirect()->route('home')->with('error', 'Terjadi kesalahan.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $imagePaths = $rating->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('ratings', 'public');
                $imagePaths[] = $path;
            }
        }

        // Anti-spam keyword check
        $isApproved = true;
        if ($this->containsSpam($request->review)) {
            $isApproved = false;
        }

        $rating->update([
            'rating' => $request->rating,
            'review' => $request->review,
            'images' => $imagePaths,
            'is_approved' => $isApproved
        ]);

        \App\Models\Notification::sendToAdmins(
            'Ulasan Produk Diperbarui ⭐',
            "Pelanggan " . Auth::user()->name . " memperbarui ulasan bintang {$request->rating} untuk produk {$rating->product->name}.",
            'info',
            route('admin.ratings.index')
        );

        if (!$isApproved) {
            return redirect()->route('ratings.index')->with('success', 'Ulasan berhasil diperbarui dan sedang dalam moderasi admin karena mendeteksi kata sensitif/tautan.');
        }

        return redirect()->route('ratings.index')->with('success', 'Ulasan berhasil diperbarui');
    }

    public function destroy($id)
    {
        $rating = Rating::where('user_id', Auth::id())->findOrFail($id);
        $rating->delete();

        return redirect()->route('ratings.index')->with('success', 'Ulasan berhasil dihapus');
    }

    /**
     * Check if the review contains spam keywords.
     */
    private function containsSpam($text)
    {
        $spamKeywords = [
            'judi', 'slot', 'gacor', 'casino', 'poker', 'togel', 'betting', 'baccarat',
            'promo', 'klik disini', 'whatsapp', 'wa.me', 'hubungi kami', 'dapatkan bonus',
            'http://', 'https://', 'www.', '.com/', '.net/', '.org/', '.id/'
        ];

        $lowercaseText = strtolower($text);

        foreach ($spamKeywords as $keyword) {
            if (str_contains($lowercaseText, $keyword)) {
                return true;
            }
        }

        return false;
    }
}