<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use App\Models\UserVoucher;
use Illuminate\Http\Request;

class VoucherController extends Controller
{
    public function index(Request $request)
    {
        $query = Voucher::query();
        
        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            if ($request->status == 'active') {
                $query->where('is_active', 1)
                      ->where('expiry_date', '>=', date('Y-m-d'));
            } elseif ($request->status == 'expired') {
                $query->where('expiry_date', '<', date('Y-m-d'));
            } elseif ($request->status == 'inactive') {
                $query->where('is_active', 0);
            }
        }
        
        $vouchers = $query->orderBy('created_at', 'desc')->paginate(10);
        return view('admin.vouchers.index', compact('vouchers'));
    }
    
    public function create()
    {
        return view('admin.vouchers.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed,free_shipping',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'min_qty' => 'nullable|integer|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'max_usage' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'expiry_date' => 'required|date',
            'is_active' => 'boolean',
            'user_type' => 'required|in:general,active_user',
            'min_completed_orders' => 'nullable|integer|min:0',
        ]);
        
        Voucher::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->type === 'free_shipping' ? 0 : $request->value,
            'min_purchase' => $request->min_purchase ?? 0,
            'min_qty' => $request->min_qty ?? 0,
            'max_discount' => $request->max_discount,
            'max_usage' => $request->max_usage,
            'start_date' => $request->start_date,
            'expiry_date' => $request->expiry_date,
            'is_active' => $request->is_active ?? 1,
            'user_type' => $request->user_type,
            'min_completed_orders' => $request->user_type === 'active_user' ? ($request->min_completed_orders ?? 0) : 0,
        ]);
        
        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil ditambahkan');
    }
    
    public function edit($id)
    {
        $voucher = Voucher::findOrFail($id);
        return view('admin.vouchers.edit', compact('voucher'));
    }
    
    public function update(Request $request, $id)
    {
        $voucher = Voucher::findOrFail($id);
        
        $request->validate([
            'code' => 'required|string|max:50|unique:vouchers,code,' . $id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:percentage,fixed,free_shipping',
            'value' => 'required|numeric|min:0',
            'min_purchase' => 'nullable|numeric|min:0',
            'min_qty' => 'nullable|integer|min:0',
            'max_discount' => 'nullable|numeric|min:0',
            'max_usage' => 'nullable|integer|min:1',
            'start_date' => 'nullable|date',
            'expiry_date' => 'required|date',
            'is_active' => 'boolean',
            'user_type' => 'required|in:general,active_user',
            'min_completed_orders' => 'nullable|integer|min:0',
        ]);
        
        $voucher->update([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'value' => $request->type === 'free_shipping' ? 0 : $request->value,
            'min_purchase' => $request->min_purchase ?? 0,
            'min_qty' => $request->min_qty ?? 0,
            'max_discount' => $request->max_discount,
            'max_usage' => $request->max_usage,
            'start_date' => $request->start_date,
            'expiry_date' => $request->expiry_date,
            'is_active' => $request->is_active ?? 1,
            'user_type' => $request->user_type,
            'min_completed_orders' => $request->user_type === 'active_user' ? ($request->min_completed_orders ?? 0) : 0,
        ]);
        
        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil diupdate');
    }
    
    public function destroy($id)
    {
        $voucher = Voucher::findOrFail($id);
        
        // Cek apakah voucher sudah pernah digunakan
        if ($voucher->used_count > 0) {
            return back()->with('error', 'Voucher tidak bisa dihapus karena sudah pernah digunakan');
        }
        
        $voucher->delete();
        
        return redirect()->route('admin.vouchers.index')
            ->with('success', 'Voucher berhasil dihapus');
    }
    
    public function usage($id)
    {
        $voucher = Voucher::findOrFail($id);
        $usages = \App\Models\VoucherUsageLog::where('voucher_id', $id)
            ->with(['user', 'transaction'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.vouchers.usage', compact('voucher', 'usages'));
    }
}