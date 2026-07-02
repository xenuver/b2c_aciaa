<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    /**
     * Display all ratings with filters.
     */
    public function index(Request $request)
    {
        $query = Rating::with(['user', 'product', 'transaction']);

        // Filter by star rating
        if ($request->filled('rating')) {
            $query->where('rating', $request->rating);
        }

        // Filter by approval status
        if ($request->filled('status')) {
            $query->where('is_approved', $request->status === 'approved');
        }

        // Filter by reply status
        if ($request->filled('reply')) {
            if ($request->reply === 'replied') {
                $query->whereNotNull('admin_reply');
            } else {
                $query->whereNull('admin_reply');
            }
        }

        // Search by user name or review text
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('review', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('product', function ($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $ratings = $query->orderBy('created_at', 'desc')->paginate(15);

        // Stats for dashboard
        $totalRatings = Rating::count();
        $avgRating = Rating::avg('rating') ?? 0;
        $pendingReply = Rating::whereNull('admin_reply')->count();
        $hiddenCount = Rating::where('is_approved', false)->count();

        return view('admin.ratings.index', compact(
            'ratings', 'totalRatings', 'avgRating', 'pendingReply', 'hiddenCount'
        ));
    }

    /**
     * Store or update admin reply for a rating.
     */
    public function reply(Request $request, $id)
    {
        $request->validate([
            'admin_reply' => 'required|string|min:5|max:1000',
        ]);

        $rating = Rating::findOrFail($id);
        $rating->update([
            'admin_reply' => $request->admin_reply,
        ]);

        \App\Models\Notification::create([
            'user_id' => $rating->user_id,
            'title' => 'Ulasan Anda Dibalas 💬',
            'message' => "Admin toko membalas ulasan Anda untuk produk {$rating->product->name}.",
            'type' => 'info',
            'link' => route('ratings.index'),
            'is_read' => false,
        ]);

        return back()->with('success', 'Balasan berhasil disimpan.');
    }

    /**
     * Toggle approve/hide a rating.
     */
    public function toggleApprove($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->update([
            'is_approved' => !$rating->is_approved,
        ]);

        $status = $rating->is_approved ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Ulasan berhasil {$status}.");
    }

    /**
     * Delete a rating permanently.
     */
    public function destroy($id)
    {
        $rating = Rating::findOrFail($id);
        $rating->delete();

        return back()->with('success', 'Ulasan berhasil dihapus.');
    }
}
