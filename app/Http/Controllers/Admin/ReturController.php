<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Retur;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReturController extends Controller
{
    public function index(Request $request)
    {
        $query = Retur::with(['user', 'transaction']);
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }
        
        $returs = $query->orderBy('created_at', 'desc')->paginate(15);
        $statuses = ['pending', 'approved', 'rejected', 'completed', 'cancelled'];
        
        return view('admin.returs.index', compact('returs', 'statuses'));
    }

    public function show($id)
    {
        $retur = Retur::with(['user', 'transaction', 'items.transactionDetail.product'])->findOrFail($id);
        return view('admin.returs.show', compact('retur'));
    }

    public function approve($id)
    {
        $retur = Retur::findOrFail($id);
        
        if ($retur->status != 'pending') {
            return back()->with('error', 'Retur sudah diproses sebelumnya');
        }
        
        DB::beginTransaction();
        
        try {
            $retur->update([
                'status' => 'approved',
                'admin_notes' => request('admin_notes'),
                'approved_at' => now()
            ]);
            
            // Update status transaksi menjadi refunded
            $retur->transaction->update([
                'status' => 'refunded'
            ]);

            \App\Models\Notification::create([
                'user_id' => $retur->user_id,
                'title' => 'Pengajuan Retur Disetujui ✅',
                'message' => "Pengajuan retur Anda dengan nomor #{$retur->retur_number} telah disetujui oleh admin.",
                'type' => 'info',
                'link' => route('returs.show', $retur->id),
                'is_read' => false,
            ]);
            
            DB::commit();
            
            return redirect()->route('admin.returs.index')
                ->with('success', 'Retur berhasil disetujui');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $retur = Retur::findOrFail($id);
        
        if ($retur->status != 'pending') {
            return back()->with('error', 'Retur sudah diproses sebelumnya');
        }
        
        $request->validate([
            'admin_notes' => 'required|string|min:10'
        ]);
        
        $retur->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes
        ]);

        \App\Models\Notification::create([
            'user_id' => $retur->user_id,
            'title' => 'Pengajuan Retur Ditolak ❌',
            'message' => "Pengajuan retur Anda dengan nomor #{$retur->retur_number} ditolak. Alasan: " . $request->admin_notes,
            'type' => 'info',
            'link' => route('returs.show', $retur->id),
            'is_read' => false,
        ]);
        
        return redirect()->route('admin.returs.index')
            ->with('success', 'Retur ditolak');
    }

    public function complete($id)
    {
        $retur = Retur::findOrFail($id);
        
        if ($retur->status != 'approved') {
            return back()->with('error', 'Retur harus disetujui terlebih dahulu');
        }
        
        $retur->update([
            'status' => 'completed',
            'completed_at' => now()
        ]);

        \App\Models\Notification::create([
            'user_id' => $retur->user_id,
            'title' => 'Proses Retur Selesai ↩️',
            'message' => "Proses pengembalian untuk retur #{$retur->retur_number} telah selesai diproses.",
            'type' => 'info',
            'link' => route('returs.show', $retur->id),
            'is_read' => false,
        ]);
        
        return redirect()->route('admin.returs.index')
            ->with('success', 'Proses retur selesai');
    }
}