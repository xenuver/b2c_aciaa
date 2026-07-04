<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Aciaa') }} - @yield('title', 'Auth')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body style="font-family: var(--font-body);">
    <style>
        :root{
            --pink:#C2185B;
            --pink-2:#E91E8C;
            --soft:#FCE4EC;
            --dark:#1A1A2E;
            --bg:#FDF2F8;
            --font-heading: 'Cormorant', Georgia, serif;
            --font-body: 'Montserrat', system-ui, sans-serif;
        }

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        .auth-shell{
            min-height: 100vh;
            display:flex;
            align-items:center;
            justify-content:center;
            padding: 40px 16px;
            background: var(--bg);
            position: relative;
            overflow: hidden;
        }

        /* Subtle decorative circles */
        .auth-shell::before{
            content:'';
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(194, 24, 91, 0.12);
            top: -120px;
            right: -80px;
            pointer-events: none;
        }
        .auth-shell::after{
            content:'';
            position: absolute;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(233, 30, 140, 0.08);
            bottom: -60px;
            left: -60px;
            pointer-events: none;
        }

        .auth-card{
            width: min(960px, 100%);
            border: 0;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 40px rgba(0,0,0,0.08);
            background: #fff;
            position: relative;
            z-index: 1;
        }

        .auth-left{
            background: linear-gradient(160deg, var(--color-surface-alt) 0%, #f8eceb 100%);
            border-right: 1px solid rgba(0,0,0,0.04);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem !important;
        }

        .brand-badge{
            display:inline-flex;
            align-items:center;
            gap: 12px;
            text-decoration:none;
        }
        .brand-badge:hover{
            text-decoration: none;
        }

        .brand-logo{
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display:flex;
            align-items:center;
            justify-content:center;
            color:#fff;
            background: linear-gradient(135deg, var(--pink) 0%, var(--pink-2) 100%);
            font-weight: 700;
            font-size: 1.15rem;
            letter-spacing: .5px;
            flex-shrink: 0;
        }

        .brand-name{
            font-weight: 700;
            font-size: 1.15rem;
            color: var(--dark);
            letter-spacing: .3px;
        }
        .brand-tagline{
            color: #9b8e8e;
            font-size: .78rem;
            margin: 0;
        }

        .auth-welcome{
            margin-top: 2.5rem;
        }
        .auth-welcome h2{
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--dark);
            margin-bottom: 8px;
        }
        .auth-welcome p{
            color:#888;
            font-size: .88rem;
            line-height: 1.6;
            margin: 0;
        }

        .auth-features{
            margin-top: 2rem;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }
        .auth-feature-item{
            display: flex;
            align-items: center;
            gap: 12px;
            color: #666;
            font-size: .84rem;
        }
        .auth-feature-item i{
            color: var(--pink-2);
            font-size: .9rem;
            width: 18px;
            text-align: center;
        }

        .auth-footer-text{
            color:#bbb;
            font-size: .75rem;
            margin-top: 2rem;
        }

        .auth-right{
            padding: 2.5rem;
        }

        /* Form styling overrides */
        .auth-right label,
        .auth-right .block{
            font-weight: 500;
            color: #444;
            font-size: .88rem;
        }
        .auth-right input[type="email"],
        .auth-right input[type="password"],
        .auth-right input[type="text"]{
            border: 1.5px solid #e8e0de;
            border-radius: 10px;
            padding: 10px 14px;
            font-size: .9rem;
            transition: border-color .2s ease, box-shadow .2s ease;
            background: #fcfafa;
        }
        .auth-right input[type="email"]:focus,
        .auth-right input[type="password"]:focus,
        .auth-right input[type="text"]:focus{
            border-color: var(--pink);
            box-shadow: 0 0 0 3px rgba(194, 24, 91, 0.15);
            outline: none;
            background: #fff;
        }

        .auth-right a{
            color: var(--pink-2);
            font-size: .85rem;
        }
        .auth-right a:hover{
            color: var(--pink);
        }
        .auth-right .underline{ text-decoration: none !important; }
        .auth-right .underline:hover{ text-decoration: underline !important; }

        /* Checkbox styling */
        .auth-right input[type="checkbox"]{
            accent-color: var(--pink-2);
        }

        /* Primary button override */
        .auth-right button[type="submit"],
        .auth-right .ms-3,
        .auth-right .ms-4{
            background: linear-gradient(135deg, var(--pink) 0%, var(--pink-2) 100%) !important;
            border: none !important;
            border-radius: 10px !important;
            padding: 10px 28px !important;
            font-weight: 600 !important;
            font-size: .88rem !important;
            color: #fff !important;
            transition: transform .15s ease, box-shadow .15s ease !important;
            text-transform: none !important;
            letter-spacing: 0 !important;
        }
        .auth-right button[type="submit"]:hover,
        .auth-right .ms-3:hover,
        .auth-right .ms-4:hover{
            transform: translateY(-1px) !important;
            box-shadow: 0 6px 20px rgba(194, 24, 91, 0.3) !important;
        }

        @media (max-width: 991px){
            .auth-left{
                padding: 1.5rem !important;
            }
            .auth-welcome{
                margin-top: 1.5rem;
            }
            .auth-features{
                display: none;
            }
        }
    </style>

    <div class="auth-shell">
        <div class="auth-card">
            <div class="row g-0">
                <div class="col-lg-5 auth-left">
                    <div>
                        <a href="{{ route('home') }}" class="brand-badge">
                            <div class="brand-logo">
                                <img src="{{ asset('images/aciaa_logo.png') }}" alt="ACIAA Logo" style="width: 100%; height: 100%; object-fit: contain;">
                            </div>
                            <div>
                                <div class="brand-name">ACIAA</div>
                                <div class="brand-tagline">Fashion & Beauty Store</div>
                            </div>
                        </a>

                        <div class="auth-welcome">
                            <h2>Selamat Datang 👋</h2>
                            <p>Masuk ke akun kamu untuk menikmati pengalaman belanja terbaik di ACIAA.</p>
                        </div>

                        <div class="auth-features">
                            <div class="auth-feature-item">
                                <i class="fas fa-truck"></i>
                                <span>Pengiriman cepat ke seluruh Indonesia</span>
                            </div>
                            <div class="auth-feature-item">
                                <i class="fas fa-shield-alt"></i>
                                <span>Transaksi aman & terpercaya</span>
                            </div>
                            <div class="auth-feature-item">
                                <i class="fas fa-tags"></i>
                                <span>Promo & voucher eksklusif member</span>
                            </div>
                        </div>
                    </div>

                    <div class="auth-footer-text d-none d-lg-block">
                        &copy; {{ date('Y') }} {{ config('app.name', 'ACIAA') }}. All rights reserved.
                    </div>
                </div>

                <div class="col-lg-7 auth-right">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
