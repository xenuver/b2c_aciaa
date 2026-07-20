<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ACIAA — Premium Women's Fashion">

    <title>Aciaa Store - @yield('title', 'Premium Fashion')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/aciaa_logo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/aciaa_logo.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500&family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Navbar CSS -->
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    
    @stack('styles')

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        :root {
            /* Color Palette */
            --color-primary: #C2185B;
            --color-primary-light: #E91E8C;
            --color-primary-soft: #FCE4EC;
            --color-secondary: #F48FB1;
            --color-gold: #CA8A04;
            --color-gold-light: #FEF3C7;

            /* Compatibility with old vars */
            --pink: #C2185B;
            --pink-2: #E91E8C;
            --soft: #FCE4EC;
            --dark: #1A1A2E;
            --bg: #FFFFFF;

            /* Neutrals */
            --color-text: #1A1A2E;
            --color-text-secondary: #4A5568;
            --color-text-muted: #9CA3AF;
            --color-bg: #faf8f7; /* Reverted to provide contrast */
            --color-surface: #FFFFFF;
            --color-surface-alt: #FEF6F5;
            --color-border: rgba(194, 24, 91, 0.12);
            --color-border-light: rgba(0, 0, 0, 0.06);

            /* Typography */
            --font-heading: 'Cormorant', Georgia, serif;
            --font-body: 'Montserrat', system-ui, sans-serif;

            /* Spacing */
            --space-xs: 4px;
            --space-sm: 8px;
            --space-md: 16px;
            --space-lg: 24px;
            --space-xl: 32px;
            --space-2xl: 48px;
            --space-3xl: 64px;
            --space-4xl: 80px;

            /* Radius */
            --radius-sm: 8px;
            --radius-md: 12px;
            --radius-lg: 16px;
            --radius-xl: 20px;
            --radius-full: 9999px;

            /* Shadow */
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.05);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,0.1);
            --shadow-xl: 0 16px 48px rgba(0,0,0,0.12);
            --shadow-rose: 0 8px 24px rgba(194, 24, 91, 0.15);
            --shadow-gold: 0 8px 24px rgba(202, 138, 4, 0.2);

            /* Animation */
            --ease-fluid: cubic-bezier(0.25, 0.46, 0.45, 0.94);
            --ease-bounce: cubic-bezier(0.34, 1.56, 0.64, 1);
            --ease-smooth: cubic-bezier(0.4, 0, 0.2, 1);
            --duration-fast: 150ms;
            --duration-base: 250ms;
            --duration-medium: 350ms;
            --duration-slow: 500ms;
            --duration-hero: 800ms;
        }

        body {
            font-family: var(--font-body);
            color: var(--color-text);
            background-color: var(--color-bg);
            margin: 0;
            padding: 0;
            -webkit-font-smoothing: antialiased;
        }
    </style>
</head>
<body class="font-sans antialiased">
    @yield('body')

    <!-- Toast Container (Global) -->
    <x-toast />

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    
    <!-- Global Alpine Functions -->
    <script>
        function wishlistToggle(initialState = false) {
            return {
                inWishlist: initialState,
                isProcessing: false,
                toggle(productId) {
                    if (this.isProcessing) return;
                    this.isProcessing = true;
                    
                    axios.post('/wishlist/ajax', { product_id: productId })
                        .then(res => {
                            if (res.data.success) {
                                this.inWishlist = res.data.inWishlist;
                                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'success', message: res.data.message } }));
                                this.$dispatch('wishlist-toggled', { productId: productId, inWishlist: res.data.inWishlist });
                                
                                // Optional: trigger event to update wishlist badge count
                                window.dispatchEvent(new Event('update-wishlist-count'));
                            }
                        })
                        .catch(err => {
                            window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: 'Gagal memperbarui wishlist' } }));
                        })
                        .finally(() => {
                            this.isProcessing = false;
                        });
                }
            }
        }
    </script>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@0.292.0"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initial create
            if (typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            // Re-init when Alpine updates DOM
            document.addEventListener('alpine:initialized', function() {
                if (typeof lucide !== 'undefined') lucide.createIcons();
            });

            // Robust observer for dynamic elements
            const observer = new MutationObserver(function(mutations) {
                let shouldUpdate = false;
                for (const mutation of mutations) {
                    if (mutation.type === 'childList') {
                        mutation.addedNodes.forEach(node => {
                            if (node.nodeType === 1) { // Element node
                                if (node.hasAttribute('data-lucide') || node.querySelector('[data-lucide]')) {
                                    shouldUpdate = true;
                                }
                            }
                        });
                    }
                }
                
                if (shouldUpdate && typeof lucide !== 'undefined') {
                    // Debounce slightly to prevent thrashing
                    clearTimeout(window.lucideTimeout);
                    window.lucideTimeout = setTimeout(() => {
                        lucide.createIcons();
                    }, 50);
                }
            });

            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>

    @stack('scripts')

    @auth
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const redirectUrl = localStorage.getItem('redirect_after_login');
            if (redirectUrl) {
                localStorage.removeItem('redirect_after_login');
                window.location.href = redirectUrl;
            }
        });
    </script>
    @endauth

    {{-- Convert session flash messages to toast notifications --}}
    @if(session('success') || session('error') || session('warning') || session('info') || session('status'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: @json(session('success')), type: 'success' } }));
            @endif
            @if(session('error'))
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: @json(session('error')), type: 'error' } }));
            @endif
            @if(session('warning'))
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: @json(session('warning')), type: 'error' } }));
            @endif
            @if(session('info'))
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: @json(session('info')), type: 'success' } }));
            @endif
            @if(session('status') === 'profile-updated')
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Profil berhasil diperbarui.', type: 'success' } }));
            @elseif(session('status') === 'password-updated')
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: 'Password berhasil diperbarui.', type: 'success' } }));
            @elseif(session('status'))
            window.dispatchEvent(new CustomEvent('toast', { detail: { message: @json(session('status')), type: 'success' } }));
            @endif
        });
    </script>
    @endif
</body>
</html>
