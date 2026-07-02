<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Province;
use App\Models\Transaction;
use App\Models\UserAddress;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();

        // Admin tetap diarahkan ke tampilan admin
        if ($user && $user->role === 'admin') {
            return view('profile.edit', [
                'user' => $user,
            ]);
        }

        $addresses = UserAddress::where('user_id', $user->id)
            ->orderByDesc('is_default')
            ->latest()
            ->get();

        $totalOrders = Transaction::where('user_id', $user->id)->count();
        $completedOrders = Transaction::where('user_id', $user->id)->where('status', 'delivered')->count();
        $totalSpent = (float) Transaction::where('user_id', $user->id)->where('payment_status', 'paid')->sum('grand_total');

        $provinces = Province::orderBy('name')->get();

        return view('frontend.profile.edit', [
            'user' => $user,
            'addresses' => $addresses,
            'provinces' => $provinces,
            'stats' => [
                'total_orders' => $totalOrders,
                'completed_orders' => $completedOrders,
                'total_spent' => $totalSpent,
            ],
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
