<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Cart;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\UserAddress;
use App\Models\Province;
use App\Models\City;
use App\Models\Subdistrict;
use App\Services\MidtransService;
use App\Services\RajaOngkirService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = Cart::where('user_id', Auth::id())->first();
        
        if (!$cart || $cart->items->count() == 0) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong');
        }
        
        $cartItems = $cart->items()->with('product')->get();
        
        // Hitung subtotal
        $subtotal = $cartItems->sum(function($item) {
            return $item->quantity * $item->price;
        });

        // Hitung total qty produk
        $totalQty = $cartItems->sum('quantity');

        // Hitung total berat (gram)
        $totalWeight = $cartItems->sum(function($item) {
            return $item->quantity * config('rajaongkir.default_weight', 200);
        });

        $addresses = UserAddress::where('user_id', Auth::id())->latest()->get();
        $provinces = Province::orderBy('name')->get();
        
        $vouchers = \App\Models\UserVoucher::where('user_id', Auth::id())
            ->where('is_used', false)
            ->with(['voucher' => function($q) {
                $q->where('is_active', true)
                  ->where('expiry_date', '>=', date('Y-m-d'));
            }])
            ->get()
            ->filter(function($uv) {
                return $uv->voucher !== null && $uv->voucher->code === $uv->voucher_code;
            });

        $activeVouchers = \App\Models\Voucher::where('is_active', true)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', date('Y-m-d'));
            })
            ->get();
            
        return view('frontend.checkout.index', compact('cartItems', 'subtotal', 'totalQty', 'totalWeight', 'addresses', 'provinces', 'vouchers', 'activeVouchers'));
    }
    
    public function process(Request $request, MidtransService $midtransService)
    {
        $validated = $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'shipping_courier' => 'required|string',
            'shipping_service' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'shipping_etd' => 'required|string',
            'notes' => 'nullable|string',
            'voucher_id' => 'nullable|exists:vouchers,id',
        ]);

        $cart = Cart::where('user_id', Auth::id())->first();

        if (!$cart || $cart->items->count() == 0) {
            return $this->checkoutErrorResponse($request, 'Keranjang kosong', route('cart.index'));
        }

        $cartItems = $cart->items()->with('product')->get();
        $address = UserAddress::where('user_id', Auth::id())->findOrFail($validated['address_id']);

        $subtotal = $cartItems->sum(fn ($item) => $item->quantity * $item->price);
        $shippingCost = $validated['shipping_cost'];
        
        $totalQty = $cartItems->sum('quantity');
        
        $discountAmount = 0;
        $voucherId = null;
        $userVoucherRecord = null;
        
        if (!empty($validated['voucher_id'])) {
            $voucher = \App\Models\Voucher::where('id', $validated['voucher_id'])
                ->where('is_active', true)
                ->where('expiry_date', '>=', date('Y-m-d'))
                ->first();
                
            if ($voucher) {
                $userVoucherRecord = \App\Models\UserVoucher::where('user_id', Auth::id())
                    ->where('voucher_id', $voucher->id)
                    ->where('voucher_code', $voucher->code)
                    ->where('is_used', false)
                    ->first();
                    
                if ($userVoucherRecord) {
                    // Validasi kuota
                    if ($voucher->max_usage !== null && $voucher->used_count >= $voucher->max_usage) {
                        return $this->checkoutErrorResponse($request, 'Maaf, kuota penggunaan voucher ini sudah habis.');
                    }

                    // Validasi min_purchase
                    if ($subtotal < $voucher->min_purchase) {
                        return $this->checkoutErrorResponse($request, 'Minimal belanja untuk voucher ini adalah Rp ' . number_format($voucher->min_purchase, 0, ',', '.'));
                    }
                    
                    // Validasi min_qty
                    if ($voucher->min_qty > 0 && $totalQty < $voucher->min_qty) {
                        return $this->checkoutErrorResponse($request, 'Minimal pembelian ' . $voucher->min_qty . ' produk untuk menggunakan voucher ini.');
                    }
                    
                    $voucherId = $voucher->id;
                    
                    if ($voucher->type === 'free_shipping') {
                        $discountAmount = $shippingCost;
                        if ($voucher->max_discount !== null && $discountAmount > $voucher->max_discount) {
                            $discountAmount = $voucher->max_discount;
                        }
                    } elseif ($voucher->type === 'percentage') {
                        $discountAmount = $subtotal * ($voucher->value / 100);
                        if ($voucher->max_discount !== null && $discountAmount > $voucher->max_discount) {
                            $discountAmount = $voucher->max_discount;
                        }
                    } else {
                        $discountAmount = $voucher->value;
                    }
                    if ($discountAmount > ($subtotal + $shippingCost)) {
                        $discountAmount = $subtotal + $shippingCost;
                    }
                }
            }
        }
        
        $grandTotal = $subtotal + $shippingCost - $discountAmount;

        DB::beginTransaction();

        try {
            $transaction = $this->createTransaction(
                $address,
                $subtotal,
                $shippingCost,
                $grandTotal,
                $validated,
                $voucherId,
                $discountAmount
            );

            $this->createTransactionDetailsFromCart($transaction, $cartItems);

            if ($userVoucherRecord) {
                $userVoucherRecord->update([
                    'is_used' => true,
                    'used_at' => now()
                ]);
                
                $v = \App\Models\Voucher::find($voucherId);
                if ($v) {
                    $v->increment('used_count');
                }
                
                \App\Models\VoucherUsageLog::create([
                    'voucher_id' => $voucherId,
                    'voucher_code' => $voucher->code,
                    'user_id' => Auth::id(),
                    'transaction_id' => $transaction->id,
                    'discount_amount' => $discountAmount
                ]);
            }

            $cart->items()->delete();
            $cart->delete();

            // Kirim Notifikasi
            \App\Models\Notification::create([
                'user_id' => $transaction->user_id,
                'title' => 'Pesanan Berhasil Dibuat 🛒',
                'message' => "Pesanan Anda #{$transaction->invoice_number} telah berhasil dibuat. Silakan lakukan pembayaran.",
                'type' => 'info',
                'link' => route('transactions.show', $transaction->id),
                'is_read' => false,
            ]);

            \App\Models\Notification::sendToAdmins(
                'Pesanan Baru Masuk 🛒',
                "Pelanggan " . Auth::user()->name . " membuat pesanan baru #{$transaction->invoice_number}.",
                'info',
                route('admin.transactions.show', $transaction->id)
            );

            DB::commit();

            return $this->respondWithSnap($request, $transaction, $midtransService);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->checkoutErrorResponse($request, 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function success($id, MidtransService $midtransService)
    {
        $transaction = Transaction::with('details.product')->findOrFail($id);
        
        // Pastikan user hanya melihat transaksinya sendiri
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        
        // Sync status dengan Midtrans jika transaksi pending dan belum lunas
        if ($transaction->status === 'pending' && in_array($transaction->payment_status, ['unpaid', 'pending'])) {
            $transaction = $midtransService->syncTransactionStatus($transaction);
        }
        
        return view('frontend.checkout.success', compact('transaction'));
    }

    /**
     * AJAX: Klaim voucher langsung dari halaman checkout via kode voucher
     */
    public function claimVoucherAtCheckout(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:50',
        ]);

        $code = strtoupper(trim($request->code));

        $voucher = \App\Models\Voucher::where('code', $code)
            ->where('is_active', true)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->first();

        if (!$voucher) {
            return response()->json([
                'success' => false,
                'message' => 'Kode voucher tidak valid atau sudah kadaluarsa.',
            ], 422);
        }

        // Cek apakah user sudah pernah klaim voucher dengan kode ini
        $alreadyClaimed = \App\Models\UserVoucher::where('user_id', Auth::id())
            ->where('voucher_code', $voucher->code)
            ->exists();

        if ($alreadyClaimed) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah pernah mengklaim voucher ini.',
            ], 422);
        }

        // Cek kuota voucher
        if ($voucher->max_usage !== null && $voucher->used_count >= $voucher->max_usage) {
            return response()->json([
                'success' => false,
                'message' => 'Maaf, kuota voucher ini sudah habis.',
            ], 422);
        }

        // Cek start_date
        if ($voucher->start_date && date('Y-m-d') < $voucher->start_date) {
            return response()->json([
                'success' => false,
                'message' => 'Voucher ini belum bisa digunakan. Berlaku mulai ' . date('d M Y', strtotime($voucher->start_date)),
            ], 422);
        }

        // Klaim voucher untuk user
        \App\Models\UserVoucher::create([
            'user_id' => Auth::id(),
            'voucher_id' => $voucher->id,
            'voucher_code' => $voucher->code,
            'is_used' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Voucher berhasil diklaim!',
            'voucher' => [
                'id' => $voucher->id,
                'code' => $voucher->code,
                'name' => $voucher->name,
                'type' => $voucher->type,
                'value' => $voucher->value,
                'min_purchase' => $voucher->min_purchase,
                'min_qty' => $voucher->min_qty ?? 0,
                'max_discount' => $voucher->max_discount ?? 0,
            ],
        ]);
    }
    
    public function direct($productId)
    {
        $product = Product::findOrFail($productId);
        
        // Clear existing cart session
        session()->forget('direct_checkout_items');
        
        $item = (object) [
            'product_id' => $product->id,
            'product' => $product,
            'quantity' => 1,
            'price' => $product->discount_price ?? $product->price
        ];
        
        session(['direct_checkout_items' => [$item]]);
        session(['direct_checkout_subtotal' => $item->price]);
        session(['direct_checkout_total' => $item->price + 15000]);
        
        return redirect()->route('checkout.direct-form');
    }
    
    public function directForm()
    {
        $cartItems = session('direct_checkout_items');
        $subtotal = session('direct_checkout_subtotal');
        $total = session('direct_checkout_total');
        
        if (!$cartItems) {
            return redirect()->route('home');
        }

        // Hitung total qty
        $totalQty = collect($cartItems)->sum('quantity');

        $addresses = UserAddress::where('user_id', Auth::id())->latest()->get();
        $provinces = Province::orderBy('name')->get();
        
        $vouchers = \App\Models\UserVoucher::where('user_id', Auth::id())
            ->where('is_used', false)
            ->with(['voucher' => function($q) {
                $q->where('is_active', true)
                  ->where('expiry_date', '>=', date('Y-m-d'));
            }])
            ->get()
            ->filter(function($uv) {
                return $uv->voucher !== null && $uv->voucher->code === $uv->voucher_code;
            });

        $activeVouchers = \App\Models\Voucher::where('is_active', true)
            ->where('expiry_date', '>=', date('Y-m-d'))
            ->where(function($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', date('Y-m-d'));
            })
            ->get();
            
        return view('frontend.checkout.direct', compact('cartItems', 'subtotal', 'totalQty', 'total', 'addresses', 'provinces', 'vouchers', 'activeVouchers'));
    }
    
    public function directProcess(Request $request, MidtransService $midtransService)
    {
        $cartItems = session('direct_checkout_items');

        if (!$cartItems) {
            return $this->checkoutErrorResponse($request, 'Keranjang kosong', route('home'));
        }

        $validated = $request->validate([
            'address_id' => 'required|exists:user_addresses,id',
            'shipping_courier' => 'required|string',
            'shipping_service' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'shipping_etd' => 'required|string',
            'notes' => 'nullable|string',
            'voucher_id' => 'nullable|exists:vouchers,id',
        ]);

        $address = UserAddress::where('user_id', Auth::id())->findOrFail($validated['address_id']);

        $subtotal = session('direct_checkout_subtotal');
        $shippingCost = $validated['shipping_cost'];
        
        $totalQty = collect($cartItems)->sum(function($item) { return $item->quantity; });
        
        $discountAmount = 0;
        $voucherId = null;
        $userVoucherRecord = null;
        
        if (!empty($validated['voucher_id'])) {
            $voucher = \App\Models\Voucher::where('id', $validated['voucher_id'])
                ->where('is_active', true)
                ->where('expiry_date', '>=', date('Y-m-d'))
                ->first();
                
            if ($voucher) {
                $userVoucherRecord = \App\Models\UserVoucher::where('user_id', Auth::id())
                    ->where('voucher_id', $voucher->id)
                    ->where('voucher_code', $voucher->code)
                    ->where('is_used', false)
                    ->first();
                    
                if ($userVoucherRecord) {
                    // Validasi kuota
                    if ($voucher->max_usage !== null && $voucher->used_count >= $voucher->max_usage) {
                        return $this->checkoutErrorResponse($request, 'Maaf, kuota penggunaan voucher ini sudah habis.');
                    }

                    // Validasi min_purchase
                    if ($subtotal < $voucher->min_purchase) {
                        return $this->checkoutErrorResponse($request, 'Minimal belanja untuk voucher ini adalah Rp ' . number_format($voucher->min_purchase, 0, ',', '.'));
                    }
                    
                    // Validasi min_qty
                    if ($voucher->min_qty > 0 && $totalQty < $voucher->min_qty) {
                        return $this->checkoutErrorResponse($request, 'Minimal pembelian ' . $voucher->min_qty . ' produk untuk menggunakan voucher ini.');
                    }
                    
                    $voucherId = $voucher->id;
                    
                    if ($voucher->type === 'free_shipping') {
                        $discountAmount = $shippingCost;
                        if ($voucher->max_discount !== null && $discountAmount > $voucher->max_discount) {
                            $discountAmount = $voucher->max_discount;
                        }
                    } elseif ($voucher->type === 'percentage') {
                        $discountAmount = $subtotal * ($voucher->value / 100);
                        if ($voucher->max_discount !== null && $discountAmount > $voucher->max_discount) {
                            $discountAmount = $voucher->max_discount;
                        }
                    } else {
                        $discountAmount = $voucher->value;
                    }
                    if ($discountAmount > ($subtotal + $shippingCost)) {
                        $discountAmount = $subtotal + $shippingCost;
                    }
                }
            }
        }
        
        $grandTotal = $subtotal + $shippingCost - $discountAmount;

        DB::beginTransaction();

        try {
            $transaction = $this->createTransaction(
                $address,
                $subtotal,
                $shippingCost,
                $grandTotal,
                $validated,
                $voucherId,
                $discountAmount
            );

            $this->createTransactionDetailsFromSession($transaction, $cartItems);

            if ($userVoucherRecord) {
                $userVoucherRecord->update([
                    'is_used' => true,
                    'used_at' => now()
                ]);
                
                $v = \App\Models\Voucher::find($voucherId);
                if ($v) {
                    $v->increment('used_count');
                }
                
                \App\Models\VoucherUsageLog::create([
                    'voucher_id' => $voucherId,
                    'voucher_code' => $voucher->code,
                    'user_id' => Auth::id(),
                    'transaction_id' => $transaction->id,
                    'discount_amount' => $discountAmount
                ]);
            }

            session()->forget(['direct_checkout_items', 'direct_checkout_subtotal', 'direct_checkout_total']);

            // Kirim Notifikasi
            \App\Models\Notification::create([
                'user_id' => $transaction->user_id,
                'title' => 'Pesanan Berhasil Dibuat 🛒',
                'message' => "Pesanan Anda #{$transaction->invoice_number} telah berhasil dibuat. Silakan lakukan pembayaran.",
                'type' => 'info',
                'link' => route('transactions.show', $transaction->id),
                'is_read' => false,
            ]);

            \App\Models\Notification::sendToAdmins(
                'Pesanan Baru Masuk 🛒',
                "Pelanggan " . Auth::user()->name . " membuat pesanan baru #{$transaction->invoice_number}.",
                'info',
                route('admin.transactions.show', $transaction->id)
            );

            DB::commit();

            return $this->respondWithSnap($request, $transaction, $midtransService);
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->checkoutErrorResponse($request, 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ========== API LOKASI & ALAMAT ==========

    public function getProvinces()
    {
        $provinces = Province::orderBy('name')->get();
        return response()->json($provinces);
    }

    public function getCities($provinceId)
    {
        $cities = City::where('province_id', $provinceId)
            ->orderBy('name')
            ->orderBy('type')
            ->orderByDesc('id')
            ->get();

        $deduplicated = $cities->unique(function ($city) {
            return mb_strtolower($city->type . '|' . $city->name);
        })->values();

        return response()->json($deduplicated);
    }

    public function getSubdistricts($cityId)
    {
        $canonicalCityId = $this->resolveCanonicalCityId($cityId);
        $subdistricts = Subdistrict::where('city_id', $canonicalCityId)->orderBy('name')->get();

        if ($subdistricts->isEmpty()) {
            $synced = (new RajaOngkirService())->syncDistrictsForCity($canonicalCityId);
            if ($synced) {
                $subdistricts = Subdistrict::where('city_id', $canonicalCityId)->orderBy('name')->get();
            }
        }

        return response()->json($subdistricts);
    }

    public function getAddresses()
    {
        $addresses = UserAddress::where('user_id', Auth::id())->latest()->get();
        return response()->json($addresses);
    }

    public function deleteAddress(int $id)
    {
        $address = UserAddress::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan.',
            ], 404);
        }

        $wasDefault = (bool) $address->is_default;
        $address->delete();

        if ($wasDefault) {
            $newDefault = UserAddress::where('user_id', Auth::id())->latest()->first();
            if ($newDefault) {
                UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
                $newDefault->update(['is_default' => true]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil dihapus.',
        ]);
    }

    public function storeAddress(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'subdistrict_id' => 'nullable|exists:subdistricts,id',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'nullable|boolean'
        ]);

        $canonicalCityId = $this->resolveCanonicalCityId($request->city_id);
        $city = City::with('province')->findOrFail($canonicalCityId);

        if ((int) $request->province_id !== (int) $city->province_id) {
            return response()->json([
                'success' => false,
                'message' => 'Kota/kabupaten tidak sesuai dengan provinsi. Silakan pilih ulang provinsi dan kota.',
            ], 422);
        }

        $province = $city->province->name;
        $cityName = $city->name;
        $district = null;
        $subdistrictId = $request->subdistrict_id ?: null;

        if ($subdistrictId) {
            $subdistrict = Subdistrict::where('id', $subdistrictId)
                ->where('city_id', $canonicalCityId)
                ->first();

            if (!$subdistrict) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kecamatan tidak sesuai dengan kota yang dipilih.',
                ], 422);
            }

            $district = $subdistrict->name;
        }

        $isDefault = filter_var($request->is_default, FILTER_VALIDATE_BOOLEAN);

        $addressCount = UserAddress::where('user_id', Auth::id())->count();
        if ($isDefault || $addressCount === 0) {
            $isDefault = true;
            UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $address = UserAddress::create([
            'user_id' => Auth::id(),
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $city->province_id,
            'province' => $province,
            'city_id' => $canonicalCityId,
            'city' => $cityName,
            'subdistrict_id' => $subdistrictId,
            'district' => $district,
            'postal_code' => $request->postal_code,
            'is_default' => $isDefault
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil ditambahkan',
            'address' => $address
        ]);
    }

    public function updateAddress(Request $request, int $id)
    {
        $address = UserAddress::where('id', $id)->where('user_id', Auth::id())->first();
        if (!$address) {
            return response()->json([
                'success' => false,
                'message' => 'Alamat tidak ditemukan.',
            ], 404);
        }

        $request->validate([
            'label' => 'required|string|max:100',
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'province_id' => 'required|exists:provinces,id',
            'city_id' => 'required|exists:cities,id',
            'subdistrict_id' => 'nullable|exists:subdistricts,id',
            'postal_code' => 'nullable|string|max:10',
            'is_default' => 'nullable|boolean'
        ]);

        $canonicalCityId = $this->resolveCanonicalCityId($request->city_id);
        $city = City::with('province')->findOrFail($canonicalCityId);

        if ((int) $request->province_id !== (int) $city->province_id) {
            return response()->json([
                'success' => false,
                'message' => 'Kota/kabupaten tidak sesuai dengan provinsi. Silakan pilih ulang provinsi dan kota.',
            ], 422);
        }

        $province = $city->province->name;
        $cityName = $city->name;
        $district = null;
        $subdistrictId = $request->subdistrict_id ?: null;

        if ($subdistrictId) {
            $subdistrict = Subdistrict::where('id', $subdistrictId)
                ->where('city_id', $canonicalCityId)
                ->first();

            if (!$subdistrict) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kecamatan tidak sesuai dengan kota yang dipilih.',
                ], 422);
            }

            $district = $subdistrict->name;
        }

        $isDefault = filter_var($request->is_default, FILTER_VALIDATE_BOOLEAN);
        if ($isDefault) {
            UserAddress::where('user_id', Auth::id())->update(['is_default' => false]);
        }

        $address->update([
            'label' => $request->label,
            'recipient_name' => $request->recipient_name,
            'phone' => $request->phone,
            'address' => $request->address,
            'province_id' => $city->province_id,
            'province' => $province,
            'city_id' => $canonicalCityId,
            'city' => $cityName,
            'subdistrict_id' => $subdistrictId,
            'district' => $district,
            'postal_code' => $request->postal_code,
            'is_default' => $isDefault,
        ]);

        // Pastikan user selalu punya 1 alamat utama
        $hasDefault = UserAddress::where('user_id', Auth::id())->where('is_default', true)->exists();
        if (!$hasDefault) {
            $newDefault = UserAddress::where('user_id', Auth::id())->latest()->first();
            if ($newDefault) {
                $newDefault->update(['is_default' => true]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil diperbarui',
            'address' => $address->fresh(),
        ]);
    }

    public function getShippingCost(Request $request)
    {
        $request->validate([
            'destination_city_id' => 'required|exists:cities,id',
            'destination_subdistrict_id' => 'nullable|integer',
            'courier' => 'required|string|in:jne,pos,tiki',
            'weight' => 'nullable|numeric'
        ]);

        // Calculate weight based on config default or custom weight
        $weight = $request->weight ?? config('rajaongkir.default_weight', 200);

        $rajaOngkirService = new RajaOngkirService();
        $costs = $rajaOngkirService->getCost(
            $request->destination_city_id,
            $weight,
            $request->courier,
            $request->destination_subdistrict_id
        );

        if (empty($costs)) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghitung ongkir dari Raja Ongkir. Pastikan alamat pengiriman valid dan coba kurir lain.',
                'costs' => [],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'costs' => $costs,
        ]);
    }

    /**
     * Raja Ongkir data may contain duplicate cities (same name & type).
     * Prefer the city id that has subdistricts, otherwise the highest id.
     */
    private function resolveCanonicalCityId(int|string $cityId): int
    {
        $city = City::find($cityId);
        if (!$city) {
            return (int) $cityId;
        }

        $withSubdistricts = City::where('province_id', $city->province_id)
            ->where('name', $city->name)
            ->where('type', $city->type)
            ->whereHas('subdistricts')
            ->orderByDesc('id')
            ->first();

        if ($withSubdistricts) {
            return (int) $withSubdistricts->id;
        }

        $newest = City::where('province_id', $city->province_id)
            ->where('name', $city->name)
            ->where('type', $city->type)
            ->orderByDesc('id')
            ->first();

        return $newest ? (int) $newest->id : (int) $city->id;
    }

    private function createTransaction(
        UserAddress $address,
        float $subtotal,
        float $shippingCost,
        float $grandTotal,
        array $validated,
        ?int $voucherId = null,
        float $discountAmount = 0
    ): Transaction {
        $fullAddress = $address->address . ', Kec. ' . ($address->district ?? '') . ', '
            . $address->city . ', ' . $address->province . ' - ' . $address->postal_code;

        $invoiceNumber = Transaction::generateInvoiceNumber();

        return Transaction::create([
            'user_id' => Auth::id(),
            'voucher_id' => $voucherId,
            'invoice_number' => $invoiceNumber,
            'midtrans_order_id' => str_replace('/', '-', $invoiceNumber),
            'subtotal' => $subtotal,
            'shipping_cost' => $shippingCost,
            'discount_amount' => $discountAmount,
            'grand_total' => $grandTotal,
            'status' => 'pending',
            'payment_status' => 'unpaid',
            'shipping_courier' => strtoupper($validated['shipping_courier']),
            'shipping_service' => $validated['shipping_service'],
            'shipping_etd' => $validated['shipping_etd'],
            'shipping_address' => $fullAddress,
            'recipient_name' => $address->recipient_name,
            'recipient_phone' => $address->phone,
            'notes' => $validated['notes'] ?? null,
        ]);
    }

    private function createTransactionDetailsFromCart(Transaction $transaction, Collection $cartItems): void
    {
        foreach ($cartItems as $item) {
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->quantity * $item->price,
            ]);

            $item->product->decreaseStock($item->quantity);
        }
    }

    private function createTransactionDetailsFromSession(Transaction $transaction, array $cartItems): void
    {
        foreach ($cartItems as $item) {
            $product = Product::findOrFail($item->product_id);

            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'subtotal' => $item->quantity * $item->price,
            ]);

            $product->decreaseStock($item->quantity);
        }
    }

    private function respondWithSnap(Request $request, Transaction $transaction, MidtransService $midtransService): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        $transaction->load(['user', 'details.product']);
        
        try {
            $snapResponse = $midtransService->createSnapTransaction($transaction);
            $snapToken = $snapResponse->token;
            $snapUrl = $snapResponse->redirect_url;
            $paymentExpiredAt = now()->addHours(24);
            
            $transaction->update([
                'snap_token' => $snapToken,
                'snap_url' => $snapUrl,
                'payment_expired_at' => $paymentExpiredAt,
            ]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Error creating Midtrans transaction: ' . $e->getMessage());
            $snapToken = $transaction->snap_token;
            $snapUrl = $transaction->snap_url;
        }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'snap_token' => $snapToken,
                'snap_url' => $snapUrl,
                'transaction_id' => $transaction->id,
                'redirect_url' => route('checkout.success', $transaction->id),
            ]);
        }

        return redirect()->route('checkout.success', $transaction->id)
            ->with('snap_token', $snapToken)
            ->with('snap_url', $snapUrl);
    }

    private function checkoutErrorResponse(Request $request, string $message, ?string $redirectRoute = null): JsonResponse|\Illuminate\Http\RedirectResponse
    {
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        $redirect = $redirectRoute ? redirect($redirectRoute) : back();

        return $redirect->with('error', $message);
    }
}