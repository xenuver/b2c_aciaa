<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'customer');
        
        // Filter berdasarkan pencarian
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }
        
        // Filter status (email verified)
        if ($request->has('verified') && $request->verified != '') {
            if ($request->verified == 'verified') {
                $query->whereNotNull('email_verified_at');
            } elseif ($request->verified == 'unverified') {
                $query->whereNull('email_verified_at');
            }
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }
    
    public function show($id)
    {
        $user = User::with(['transactions', 'addresses'])->findOrFail($id);
        
        // Statistik user
        $totalSpent = $user->transactions()->where('status', 'delivered')->sum('grand_total');
        $totalOrders = $user->transactions()->count();
        $totalOrdersCompleted = $user->transactions()->where('status', 'delivered')->count();
        
        return view('admin.users.show', compact('user', 'totalSpent', 'totalOrders', 'totalOrdersCompleted'));
    }
    
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
        ]);
        
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        
        return redirect()->route('admin.users.index')
            ->with('success', 'Data user berhasil diupdate');
    }
    
    public function updateStatus(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $request->validate([
            'is_active' => 'required|boolean'
        ]);
        
        // Di sini kita menggunakan email_verified_at sebagai status aktif
        // Atau bisa tambahkan kolom 'is_active' di migration jika perlu
        if ($request->is_active) {
            $user->email_verified_at = now();
        } else {
            $user->email_verified_at = null;
        }
        $user->save();
        
        $status = $request->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.users.index')
            ->with('success', "User berhasil {$status}");
    }
    
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Cek apakah user memiliki transaksi
        if ($user->transactions()->count() > 0) {
            return back()->with('error', 'User tidak bisa dihapus karena sudah memiliki transaksi');
        }
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus');
    }
}