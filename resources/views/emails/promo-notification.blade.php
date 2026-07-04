<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promo Spesial</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%);
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            color: white;
            margin: 0;
            font-size: 28px;
        }
        .header p {
            color: rgba(255,255,255,0.9);
            margin: 10px 0 0;
        }
        .content {
            padding: 30px 20px;
        }
        .greeting {
            font-size: 18px;
            color: #333;
            margin-bottom: 20px;
        }
        .promo-grid {
            display: flex;
            flex-direction: column;
            gap: 16px;
            margin: 25px 0;
        }
        .promo-card {
            display: flex;
            gap: 15px;
            padding: 15px;
            border: 1px solid #eee;
            border-radius: 12px;
            transition: all 0.3s;
        }
        .promo-card:hover {
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .promo-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
        }
        .promo-info {
            flex: 1;
        }
        .promo-name {
            font-size: 16px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }
        .promo-price {
            margin-top: 8px;
        }
        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 13px;
        }
        .new-price {
            color: #e74c3c;
            font-weight: 700;
            font-size: 18px;
            margin-left: 8px;
        }
        .btn-shop {
            display: inline-block;
            background: #d4a5a5;
            color: white;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 50px;
            margin-top: 20px;
            font-weight: 600;
            transition: background 0.3s;
        }
        .btn-shop:hover {
            background: #b5838d;
        }
        .footer {
            background-color: #f8f8f8;
            padding: 20px;
            text-align: center;
            color: #999;
            font-size: 12px;
        }
        @media (max-width: 480px) {
            .promo-card {
                flex-direction: column;
                text-align: center;
            }
            .promo-image {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔥 PROMO SPESIAL! 🔥</h1>
            <p>Jangan lewatkan diskon menarik untuk Anda</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                Halo, <strong>{{ $userName }}</strong>! 👋
            </div>
            
            <p>Kami punya kabar baik! Produk-produk favorit berikut sedang <strong>diskon besar-besaran</strong>:</p>
            
            <div class="promo-grid">
                @foreach($promoProducts as $product)
                <div class="promo-card">
                    <img src="{{ url('render-image?path=' . ($product->image ?? 'default.jpg')) }}" class="promo-image" alt="{{ $product->name }}">
                    <div class="promo-info">
                        <div class="promo-name">{{ $product->name }}</div>
                        <div class="promo-price">
                            @if($product->discount_price)
                                <span class="old-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                <span class="new-price">Rp {{ number_format($product->discount_price, 0, ',', '.') }}</span>
                            @else
                                <span class="new-price">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            @endif
                        </div>
                        <div style="margin-top: 10px;">
                            <span style="background: #ff4444; color: white; padding: 2px 8px; border-radius: 20px; font-size: 12px;">PROMO</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div style="text-align: center;">
                <a href="{{ route('products.index', ['promo' => 1]) }}" class="btn-shop">
                    🛍️ Belanja Sekarang
                </a>
            </div>
            
            <p style="margin-top: 25px; color: #666; font-size: 13px;">
                * Promo berlaku terbatas. Jangan sampai kehabisan!
            </p>
        </div>
        
        <div class="footer">
            <p>&copy; {{ date('Y') }} Fashionista Store. All rights reserved.</p>
            <p>Jl. Fashion No. 123, Jakarta Selatan</p>
            <p>
                <a href="{{ route('home') }}" style="color: #d4a5a5;">Website</a> | 
                <a href="#" style="color: #d4a5a5;">Unsubscribe</a>
            </p>
        </div>
    </div>
</body>
</html>