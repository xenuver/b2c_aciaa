<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fashionista Store') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=poppins:300,400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @stack('styles')

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Lucide -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="font-sans antialiased" style="font-family: 'Poppins', 'Inter', system-ui, sans-serif;">
    <div class="min-h-screen bg-gray-100">
        <!-- Navigation -->
        @include('layouts.navigation')

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    @include('components.whatsapp-button')

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
                            if (err.response && err.response.status === 401) {
                                window.location.href = '/login';
                            } else {
                                window.dispatchEvent(new CustomEvent('toast', { detail: { type: 'error', message: 'Gagal memperbarui wishlist' } }));
                            }
                        })
                        .finally(() => {
                            this.isProcessing = false;
                        });
                }
            }
        }
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