{{-- ========== PREMIUM FOOTER COMPONENT ========== --}}
<footer class="site-footer">
    <div class="footer-top">
        <div class="container">
            <div class="row g-4">
                {{-- Brand Column --}}
                <div class="col-lg-4 col-md-6">
                    <div class="footer-brand">
                        <a href="{{ route('landing') }}" class="footer-logo-link">
                            <div class="footer-logo-icon"><img src="{{ asset('images/aciaa_logo.png') }}" alt="Aciaa" style="width: 100%; height: 100%; object-fit: contain;"></div>
                            <span class="footer-logo-text">ACIAA</span>
                        </a>
                        <p class="footer-brand-desc">
                           Ayooo belanja di Aciaa, Jangan sampai ketinggalan model terbaru!!
                        </p>
                        <div class="footer-socials">
                            <a href="https://www.instagram.com/aciaa.id?igsh=MWhxaG15dzVwNmNzZg==" class="footer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                            <a href="https://www.tiktok.com/@aciaa.id?_r=1&_t=ZS-96qGAWcEAlN" class="footer-social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="col-lg-2 col-md-6 col-6">
                    <div class="footer-col">
                        <h5 class="footer-col-title">Navigasi</h5>
                        <ul class="footer-links">
                            <li><a href="{{ route('landing') }}">Landing Page</a></li>
                            <li><a href="{{ route('home') }}">Beranda</a></li>
                            <li><a href="{{ route('products.index') }}">Semua Produk</a></li>
                            @auth
                            <li><a href="{{ route('wishlist.index') }}">Wishlist</a></li>
                            @endauth
                        </ul>
                    </div>
                </div>

                {{-- Customer Service --}}
                <div class="col-lg-3 col-md-6 col-6">
                    <div class="footer-col">
                        <h5 class="footer-col-title">Layanan</h5>
                        <ul class="footer-links">
                            @auth
                            <li><a href="{{ route('transactions.index') }}">Riwayat Pesanan</a></li>
                            <li><a href="{{ route('returs.index') }}">Pengembalian</a></li>
                            <li><a href="{{ route('profile.edit') }}">Akun Saya</a></li>
                            @else
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Daftar</a></li>
                            @endauth
                            <li><a href="#">FAQ</a></li>
                        </ul>
                    </div>
                </div>

                {{-- Contact --}}
                <div class="col-lg-3 col-md-6">
                    <div class="footer-col">
                        <h5 class="footer-col-title">Hubungi Kami</h5>
                        <ul class="footer-contact-list">
                            <li>
                                <i class="fas fa-map-marker-alt"></i>
                                <span>Jl. H. Rais A. Rachman No. 2005, Sungai Jawi, Kecamatan Pontianak Kota, Kota Pontianak, Kalimantan Barat 78244.</span>
                            </li>
                            <li>
                                <i class="fas fa-phone"></i>
                                <span>+62 821 5631 1243</span>
                            </li>
                            <li>
                                <i class="fas fa-envelope"></i>
                                <span>aciaa917@gmail.com</span>
                            </li>
                            <li>
                                <i class="fas fa-clock"></i>
                                <span>Senin — Minggu, 10:30 — 20:00 WIB</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
        <div class="container">
            <div class="footer-bottom-inner">
                <p class="footer-copyright">&copy; {{ date('Y') }} <strong>ACIAA</strong>. All rights reserved.</p>
                <div class="footer-payment-icons">
                    <span class="payment-label">Metode Pembayaran:</span>
                    <i class="fab fa-cc-visa"></i>
                    <i class="fab fa-cc-mastercard"></i>
                    <i class="fas fa-wallet"></i>
                    <i class="fas fa-building-columns"></i>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
/* ========== FOOTER STYLES ========== */
.site-footer {
    background: #1a1a1a;
    color: #ccc;
    font-family: 'Poppins', 'Inter', sans-serif;
}

.footer-top {
    padding: 70px 0 50px;
}

/* Brand */
.footer-logo-link {
    display: inline-flex;
    align-items: center;
    gap: 10px;
    text-decoration: none;
    margin-bottom: 1.25rem;
}

.footer-logo-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    background: linear-gradient(135deg, #d4a5a5 0%, #b5838d 100%);
    font-weight: 700;
    font-size: 1.1rem;
    flex-shrink: 0;
}

.footer-logo-text {
    font-size: 1.3rem;
    font-weight: 700;
    color: #fff;
    letter-spacing: 1px;
}

.footer-brand-desc {
    font-size: 0.88rem;
    color: #999;
    line-height: 1.7;
    margin-bottom: 1.5rem;
    max-width: 320px;
}

.footer-socials {
    display: flex;
    gap: 10px;
}

.footer-social-link {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    border: 1px solid rgba(255,255,255,0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ccc;
    text-decoration: none;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.footer-social-link:hover {
    background: #d4a5a5;
    border-color: #d4a5a5;
    color: #fff;
    transform: translateY(-3px);
}

/* Footer Columns */
.footer-col-title {
    font-size: 1rem;
    font-weight: 600;
    color: #fff;
    margin-bottom: 1.25rem;
    position: relative;
    padding-bottom: 10px;
}

.footer-col-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 30px;
    height: 2px;
    background: #d4a5a5;
}

.footer-links {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-links li {
    margin-bottom: 10px;
}

.footer-links a {
    color: #999;
    text-decoration: none;
    font-size: 0.88rem;
    transition: all 0.2s ease;
    display: inline-block;
}

.footer-links a:hover {
    color: #d4a5a5;
    padding-left: 5px;
}

/* Contact List */
.footer-contact-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-contact-list li {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    margin-bottom: 14px;
    font-size: 0.88rem;
    color: #999;
}

.footer-contact-list li i {
    color: #d4a5a5;
    margin-top: 3px;
    width: 16px;
    text-align: center;
    flex-shrink: 0;
}

/* Footer Bottom */
.footer-bottom {
    border-top: 1px solid rgba(255,255,255,0.08);
    padding: 20px 0;
}

.footer-bottom-inner {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.footer-copyright {
    margin: 0;
    font-size: 0.8rem;
    color: #777;
}

.footer-copyright strong {
    color: #d4a5a5;
}

.footer-payment-icons {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #666;
    font-size: 1.3rem;
}

.payment-label {
    font-size: 0.75rem;
    color: #666;
    margin-right: 4px;
}

/* Responsive */
@media (max-width: 768px) {
    .footer-top {
        padding: 50px 0 30px;
    }
    
    .footer-bottom-inner {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-brand-desc {
        max-width: 100%;
    }
}
</style>
