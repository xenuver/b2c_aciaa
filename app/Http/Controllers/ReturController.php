<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Retur;
use App\Models\ReturItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReturController extends Controller
{
    // HAPUS __construct() ini
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function index()
    {
        $returs = Retur::where('user_id', Auth::id())
            ->with('transaction')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        return view('frontend.returs.index', compact('returs'));
    }

    public function create($transactionId = null)
    {
        $transactions = Transaction::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->whereDoesntHave('retur')
            ->orderBy('created_at', 'desc')
            ->get();
        
        $selectedTransaction = null;
        $items = [];
        
        if ($transactionId) {
            $selectedTransaction = Transaction::where('user_id', Auth::id())
                ->where('status', 'delivered')
                ->findOrFail($transactionId);
            
            $items = $selectedTransaction->details;
        }
        
        return view('frontend.returs.create', compact('transactions', 'selectedTransaction', 'items'));
    }

    public function getTransactionItems($id)
    {
        $transaction = Transaction::where('user_id', Auth::id())
            ->where('status', 'delivered')
            ->findOrFail($id);
        
        return response()->json([
            'items' => $transaction->details->map(function($item) {
                return [
                    'id' => $item->id,
                    'product_name' => $item->product->name,
                    'quantity' => $item->quantity,
                    'price' => $item->price
                ];
            })
        ]);
    }

    public function store(Request $request)
{
    $request->validate([
        'transaction_id' => 'required|exists:transactions,id',
        'reason' => 'required|in:defective,wrong_item,not_as_description,size_issue,other',
        'description' => 'nullable|string|max:1000',
        'selected_products' => 'required|array|min:1',
        'selected_products.*' => 'exists:transaction_details,id',
        'proof_image' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
    ]);
    
    $transaction = Transaction::where('user_id', Auth::id())
        ->where('status', 'delivered')
        ->findOrFail($request->transaction_id);
    
    if (Retur::where('transaction_id', $transaction->id)->exists()) {
        return back()->with('error', 'Transaksi ini sudah mengajukan retur');
    }
    
    DB::beginTransaction();
    
    try {
        $proofImage = null;
        if ($request->hasFile('proof_image')) {
            $proofImage = $request->file('proof_image')->store('returs', 'public');
        }
        
        $retur = Retur::create([
            'transaction_id' => $transaction->id,
            'user_id' => Auth::id(),
            'retur_number' => 'RET/' . date('Ymd') . '/' . str_pad(Retur::count() + 1, 4, '0', STR_PAD_LEFT),
            'reason' => $request->reason,
            'description' => $request->description,
            'proof_image' => $proofImage,
            'status' => 'pending'
        ]);
        
        // Proses produk yang diretur
        foreach ($request->selected_products as $detailId) {
            $detail = $transaction->details()->find($detailId);
            if ($detail) {
                $quantity = $request->quantities[$detailId] ?? 1;
                $refundAmount = $detail->price * $quantity;
                
                ReturItem::create([
                    'retur_id' => $retur->id,
                    'transaction_detail_id' => $detail->id,
                    'quantity' => $quantity,
                    'refund_amount' => $refundAmount
                ]);
            }
        }

        \App\Models\Notification::sendToAdmins(
            'Pengajuan Retur Baru ↩️',
            "Pelanggan " . Auth::user()->name . " mengajukan retur untuk pesanan #{$transaction->invoice_number}.",
            'info',
            route('admin.returs.show', $retur->id)
        );
        
        DB::commit();
        
        return redirect()->route('returs.index')
            ->with('success', 'Pengajuan retur berhasil dikirim. Admin akan memproses dalam 1x24 jam.');
        
    } catch (\Exception $e) {
        DB::rollBack();
        return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
    }
}

    public function show($id)
    {
        $retur = Retur::where('user_id', Auth::id())
            ->with(['transaction', 'items.transactionDetail.product'])
            ->findOrFail($id);
        
        return view('frontend.returs.show', compact('retur'));
    }

    public function cancel($id)
    {
        $retur = Retur::where('user_id', Auth::id())
            ->where('status', 'pending')
            ->findOrFail($id);
        
        $retur->update(['status' => 'rejected']);
        
        return redirect()->route('returs.index')
            ->with('success', 'Pengajuan retur dibatalkan');
    }
}