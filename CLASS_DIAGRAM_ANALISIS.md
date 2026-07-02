# CLASS DIAGRAM — ACIAA E-COMMERCE
## Atribut, Tipe Data, Method, dan Relasi

---

## 1. USER
```
┌─────────────────────────────────────┐
│              User                    │
├─────────────────────────────────────┤
│ - id: int                           │
│ - name: string                      │
│ - email: string [unique]            │
│ - password: string (hashed)         │
│ - phone: string                     │
│ - role: enum('admin','customer')    │
│ - provider: string (Google OAuth)   │
│ - provider_id: string               │
│ - avatar: string                    │
│ - email_verified_at: datetime|null  │
│ - remember_token: string            │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + cart(): hasOne(Cart)              │
│ + transactions(): hasMany(Transaction)│
│ + wishlists(): hasMany(Wishlist)    │
│ + addresses(): hasMany(UserAddress) │
│ + ratings(): hasMany(Rating)        │
│ + returs(): hasMany(Retur)          │
│ + userVouchers(): hasMany(UserVoucher)│
│ + notifications(): hasMany(Notification)│
│ + notificationSetting(): hasOne(...)│
│ + activityLogs(): hasMany(ActivityLog)│
└─────────────────────────────────────┘
```

## 2. CATEGORY
```
┌─────────────────────────────────────┐
│            Category                  │
├─────────────────────────────────────┤
│ - id: int                           │
│ - name: string                      │
│ - slug: string [unique]             │
│ - description: text|null            │
│ - icon: string|null                 │
│ - order: int                        │
│ - is_active: boolean                │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + products(): hasMany(Product)      │
└─────────────────────────────────────┘
```

## 3. PRODUCT
```
┌─────────────────────────────────────┐
│             Product                  │
├─────────────────────────────────────┤
│ - id: int                           │
│ - category_id: int (FK)             │
│ - name: string                      │
│ - slug: string [unique]             │
│ - description: text                 │
│ - price: decimal(12,2)              │
│ - discount_price: decimal(12,2)|null│
│ - stock: int                        │
│ - image: string|null                │
│ - gallery: json|null                │
│ - sku: string [unique]              │
│ - is_promo: boolean                 │
│ - is_active: boolean                │
│ - views_count: int                  │
│ - sold_count: int                   │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + category(): belongsTo(Category)   │
│ + cartItems(): hasMany(CartItem)    │
│ + transactionDetails(): hasMany(...)│
│ + ratings(): hasMany(Rating)        │
│ + wishlists(): hasMany(Wishlist)    │
│ + stocks(): hasMany(Stock)          │
│ + getAverageRatingAttribute(): float│
│ + getRatingCountAttribute(): int    │
│ + getFinalPriceAttribute(): decimal │
│ + isInWishlist(): bool              │
│ + decreaseStock(qty: int): void     │
│ + increaseStock(qty: int): void     │
└─────────────────────────────────────┘
```

## 4. CART
```
┌─────────────────────────────────────┐
│              Cart                    │
├─────────────────────────────────────┤
│ - id: int                           │
│ - user_id: int (FK)                 │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + user(): belongsTo(User)           │
│ + items(): hasMany(CartItem)        │
└─────────────────────────────────────┘
```

## 5. CART ITEM
```
┌─────────────────────────────────────┐
│            CartItem                  │
├─────────────────────────────────────┤
│ - id: int                           │
│ - cart_id: int (FK)                 │
│ - product_id: int (FK)              │
│ - quantity: int                     │
│ - price: decimal(12,2)              │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + cart(): belongsTo(Cart)           │
│ + product(): belongsTo(Product)     │
└─────────────────────────────────────┘
```

## 6. TRANSACTION
```
┌─────────────────────────────────────┐
│           Transaction                │
├─────────────────────────────────────┤
│ - id: int                           │
│ - user_id: int (FK)                 │
│ - voucher_id: int (FK|null)         │
│ - invoice_number: string [unique]   │
│ - subtotal: decimal(12,2)           │
│ - shipping_cost: decimal(10,2)      │
│ - discount_amount: decimal(10,2)    │
│ - grand_total: decimal(12,2)        │
│ - status: enum(pending,paid,        │
│     processing,shipped,delivered,   │
│     cancelled,refunded)             │
│ - payment_status: enum(unpaid,      │
│     pending,paid,failed,expired)    │
│ - midtrans_order_id: string|null    │
│ - midtrans_transaction_id: string|null│
│ - payment_method: string|null       │
│ - shipping_courier: string|null     │
│ - shipping_service: string|null     │
│ - shipping_etd: string|null         │
│ - tracking_number: string|null      │
│ - tracking_url: string|null         │
│ - shipping_address: text            │
│ - recipient_name: string            │
│ - recipient_phone: string           │
│ - notes: text|null                  │
│ - paid_at: timestamp|null           │
│ - shipped_at: timestamp|null        │
│ - delivered_at: timestamp|null      │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + user(): belongsTo(User)           │
│ + voucher(): belongsTo(Voucher)     │
│ + details(): hasMany(TransactionDetail)│
│ + retur(): hasOne(Retur)            │
│ + voucherUsageLog(): hasOne(...)    │
│ + getResolvedTrackingUrlAttribute() │
│ + generateInvoiceNumber(): string   │
└─────────────────────────────────────┘
```

## 7. TRANSACTION DETAIL
```
┌─────────────────────────────────────┐
│         TransactionDetail           │
├─────────────────────────────────────┤
│ - id: int                           │
│ - transaction_id: int (FK)          │
│ - product_id: int (FK)              │
│ - quantity: int                     │
│ - price: decimal(12,2)              │
│ - subtotal: decimal(12,2)           │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + transaction(): belongsTo(Transaction)│
│ + product(): belongsTo(Product)     │
│ + returItem(): hasOne(ReturItem)    │
└─────────────────────────────────────┘
```

## 8. VOUCHER
```
┌─────────────────────────────────────┐
│            Voucher                   │
├─────────────────────────────────────┤
│ - id: int                           │
│ - code: string [unique]             │
│ - name: string                      │
│ - description: text|null            │
│ - type: enum(percentage,fixed,      │
│           free_shipping)            │
│ - value: decimal(10,2)              │
│ - min_purchase: decimal(10,2)       │
│ - min_qty: int                      │
│ - max_discount: decimal(10,2)|null  │
│ - max_usage: int|null               │
│ - used_count: int                   │
│ - start_date: date|null             │
│ - expiry_date: date                 │
│ - is_active: boolean                │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + transactions(): hasMany(Transaction)│
│ + userVouchers(): hasMany(UserVoucher)│
│ + usageLogs(): hasMany(VoucherUsageLog)│
└─────────────────────────────────────┘
```

## 9. USER VOUCHER
```
┌─────────────────────────────────────┐
│          UserVoucher                │
├─────────────────────────────────────┤
│ - id: int                           │
│ - user_id: int (FK)                 │
│ - voucher_id: int (FK)              │
│ - is_used: boolean                  │
│ - used_at: timestamp|null           │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + user(): belongsTo(User)           │
│ + voucher(): belongsTo(Voucher)     │
└─────────────────────────────────────┘
```
*Unique constraint: (user_id, voucher_id)*

## 10. RATING
```
┌─────────────────────────────────────┐
│            Rating                    │
├─────────────────────────────────────┤
│ - id: int                           │
│ - user_id: int (FK)                 │
│ - product_id: int (FK)              │
│ - transaction_id: int (FK|null)     │
│ - rating: int (1-5)                 │
│ - review: text|null                 │
│ - images: json|null                 │
│ - is_approved: boolean              │
│ - admin_reply: text|null            │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + user(): belongsTo(User)           │
│ + product(): belongsTo(Product)     │
│ + transaction(): belongsTo(Transaction)│
└─────────────────────────────────────┘
```
*Unique constraint: (user_id, product_id, transaction_id)*

## 11. RETUR
```
┌─────────────────────────────────────┐
│             Retur                    │
├─────────────────────────────────────┤
│ - id: int                           │
│ - transaction_id: int (FK)          │
│ - user_id: int (FK)                 │
│ - retur_number: string [unique]     │
│ - reason: enum(defective,wrong_item,│
│     not_as_description,size_issue,  │
│     other)                          │
│ - description: text|null            │
│ - status: enum(pending,approved,    │
│     rejected,completed)             │
│ - proof_image: string|null          │
│ - admin_notes: text|null            │
│ - approved_at: timestamp|null       │
│ - completed_at: timestamp|null      │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + transaction(): belongsTo(Transaction)│
│ + user(): belongsTo(User)           │
│ + items(): hasMany(ReturItem)       │
└─────────────────────────────────────┘
```

## 12. RETUR ITEM
```
┌─────────────────────────────────────┐
│           ReturItem                 │
├─────────────────────────────────────┤
│ - id: int                           │
│ - retur_id: int (FK)                │
│ - transaction_detail_id: int (FK)   │
│ - quantity: int                     │
│ - refund_amount: decimal(12,2)|null │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + retur(): belongsTo(Retur)         │
│ + transactionDetail(): belongsTo(TransactionDetail)│
└─────────────────────────────────────┘
```

## 13. WISHLIST
```
┌─────────────────────────────────────┐
│           Wishlist                  │
├─────────────────────────────────────┤
│ - id: int                           │
│ - user_id: int (FK)                 │
│ - product_id: int (FK)              │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + user(): belongsTo(User)           │
│ + product(): belongsTo(Product)     │
└─────────────────────────────────────┘
```
*Unique constraint: (user_id, product_id)*

## 14. USER ADDRESS (Supporting)
```
┌─────────────────────────────────────┐
│          UserAddress                │
├─────────────────────────────────────┤
│ - id: int                           │
│ - user_id: int (FK)                 │
│ - label: string                     │
│ - recipient_name: string            │
│ - phone: string                     │
│ - address: text                     │
│ - province: string                  │
│ - province_id: string               │
│ - city: string                      │
│ - city_id: string                   │
│ - subdistrict_id: bigint|null (FK)  │
│ - district: string|null             │
│ - postal_code: string|null          │
│ - is_default: boolean               │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + user(): belongsTo(User)           │
└─────────────────────────────────────┘
```

## 15. BANNER
```
┌─────────────────────────────────────┐
│            Banner                   │
├─────────────────────────────────────┤
│ - id: int                           │
│ - title: string                     │
│ - image: string                     │
│ - link: string|null                 │
│ - order: int                        │
│ - is_active: boolean                │
│ - start_date: date|null             │
│ - end_date: date|null               │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
└─────────────────────────────────────┘
```

## 16. STOCK
```
┌─────────────────────────────────────┐
│            Stock                    │
├─────────────────────────────────────┤
│ - id: int                           │
│ - product_id: int (FK)              │
│ - quantity: int                     │
│ - type: enum('in','out')           │
│ - description: text|null            │
│ - created_by: int (FK|null)         │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + product(): belongsTo(Product)     │
│ + creator(): belongsTo(User)        │
└─────────────────────────────────────┘
```

## 17. NOTIFICATION (Supporting)
```
┌─────────────────────────────────────┐
│         Notification               │
├─────────────────────────────────────┤
│ - id: int                           │
│ - user_id: int (FK)                 │
│ - title: string                     │
│ - message: text                     │
│ - type: string                      │
│ - link: string|null                 │
│ - is_read: boolean                  │
│ - created_at: timestamp             │
│ - updated_at: timestamp             │
├─────────────────────────────────────┤
│ + user(): belongsTo(User)           │
└─────────────────────────────────────┘
```

---

## DIAGRAM RELASI (Garis Hubungan)

```
 ┌──────────┐        ┌──────────────┐        ┌──────────┐
 │          │ 1    N │              │ 1    N │          │
 │  USER    │────────│ TRANSACTION  │────────│TRANSACT. │
 │          │        │              │        │ DETAIL   │
 └──┬───┬───┘       └──────┬───────┘        └────┬──────┘
    │   │                  │                     │
    │   │ 1            N   │ 1               1   │
    │   └────────┐    ┌────┘               ┌────┘
    │           N│    │1                  N│
    │       ┌────┴────┴──┐          ┌──────┴────────┐
    │       │  VOUCHER   │          │   PRODUCT     │
    │       │            │          │               │
    │       └────┬───────┘          └──┬──┬──┬──┬───┘
    │            │                     │  │  │  │
    │   N     N  │1               N    │  │  │  │
    ├────────────┘        ┌────────────┘  │  │  │
    │                     │               │  │  │
    │ 1              N    │ 1          N  │  │  │
    ├───┐    ┌────────┐  │        ┌──────┘  │  │
    │   │    │ RATING │──┘        │         │  │
    │   └────│        │           │         │  │
    │        └────────┘           │         │  │
    │                            N│         │  │
    │ 1                      ┌────┘         │  │
    ├────────────────────────┤ RETUR        │  │
    │                        │              │  │
    │                        └─────────┐    │  │
    │ 1                              N │    │  │
    ├───────┐        ┌────────────┐    │    │  │
    │       └────────│WISHLIST   │    │    │  │
    │                │           │    │    │  │
    │                └───────────┘    │    │  │
    │ 1        N          N           │    │  │
    ├────────────────┐    │          N│    │  │
    │                │    │    ┌──────┘    │  │
    │ 1             N│    └────────────┐   │  │
    ├─────────┐  ┌──┴──┐        ┌─────┴───┴──┴──────┐
    │         └──│CART │        │   RETUR ITEM       │
    │            │     │        │                    │
    │            └──┬──┘        └────────────────────┘
    │               │1
    │               │
    │          N    │
    └───────────┐   │
                │   │
           ┌────┴───┴──────┐
           │  CART ITEM    │
           │               │
           └───────────────┘


LEGENDA RELASI:

   1 ————○ N   : One-to-Many (1:N)
   1 ————1     : One-to-One (1:1)

RELASI LENGKAP:

┌─────────┬──────────────────────────┬──────────┐
│ CLASS 1 │        RELASI            │ CLASS 2  │
├─────────┼──────────────────────────┼──────────┤
│ User    │ ───1 → N───             │ Cart     │
│ User    │ ───1 → N───             │ Transaction│
│ User    │ ───1 → N───             │ Wishlist │
│ User    │ ───1 → N───             │ UserAddress│
│ User    │ ───1 → N───             │ Rating   │
│ User    │ ───1 → N───             │ Retur    │
│ User    │ ───1 → N───             │ UserVoucher│
│ User    │ ───1 → N───             │ Notification│
│ User    │ ───1 → 1───             │ NotificationSetting│
│ User    │ ───1 → N───             │ ActivityLog│
│         │                          │          │
│ Category│ ───1 → N───             │ Product  │
│         │                          │          │
│ Product │ ───1 → N───             │ CartItem │
│ Product │ ───1 → N───             │ TransactionDetail│
│ Product │ ───1 → N───             │ Rating   │
│ Product │ ───1 → N───             │ Wishlist │
│ Product │ ───1 → N───             │ Stock    │
│         │                          │          │
│ Cart    │ ───1 → N───             │ CartItem │
│         │                          │          │
│ Transaction│ ───1 → N───          │ TransactionDetail│
│ Transaction│ ───1 → 1───          │ Retur    │
│ Transaction│ ───1 → 1───          │ VoucherUsageLog│
│         │                          │          │
│ TransactionDetail│ ───1 → 1───    │ ReturItem│
│         │                          │          │
│ Voucher │ ───1 → N───             │ Transaction│
│ Voucher │ ───1 → N───             │ UserVoucher│
│ Voucher │ ───1 → N───             │ VoucherUsageLog│
│         │                          │          │
│ Retur   │ ───1 → N───             │ ReturItem│
│         │                          │          │
│ Province│ ───1 → N───             │ City     │
│ City    │ ───1 → N───             │ Subdistrict│
│ (disarankan digabung jadi Location)│          │
└─────────┴──────────────────────────┴──────────┘
```

---

## CATATAN UNTUK SKRIPSI

### Method Umum di Semua Class:
- `+ __construct()` — Constructor
- `+ save()` — Simpan ke database (inherited dari Eloquent Model)
- `+ delete()` — Hapus dari database (inherited dari Eloquent Model)
- `+ static find(id)` — Cari by ID
- `+ static where(column, value)` — Filter query
- `+ static create(data)` — Buat record baru
- `+ update(data)` — Update record

### Method Khusus (Business Logic):
| Class | Method | Deskripsi |
|-------|--------|-----------|
| Product | `+ decreaseStock(qty)` | Kurangi stok + increment sold_count |
| Product | `+ increaseStock(qty)` | Tambah stok |
| Product | `+ getFinalPrice()` | Harga setelah diskon |
| Product | `+ getAverageRating()` | Rata-rata rating produk |
| Product | `+ isInWishlist()` | Cek apakah di wishlist user |
| Transaction | `+ static generateInvoiceNumber()` | Generate nomor invoice auto-increment |
| Transaction | `+ getResolvedTrackingUrl()` | Dapatkan URL tracking |

### Relasi Kunci untuk Diagram:
```
[User] 1───N [Transaction] 1───N [TransactionDetail] N───1 [Product]
                                                          │
                                                    N───1 │
[User] 1───N [Cart] 1───N [CartItem] N───1 ───────────────┘

[User] 1───N [Rating] N───1 [Product]

[User] 1───N [Retur] 1───1 [Transaction]
               1───N [ReturItem] N───1 [TransactionDetail]

[Category] 1───N [Product]

[Voucher] 1───N [UserVoucher] N───1 [User]
[Voucher] 1───N [VoucherUsageLog] N───1 [Transaction]
```
