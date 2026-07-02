@push('scripts')
<script src="{{ config('midtrans.snap_url') }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
(function () {
    const checkoutForm = document.getElementById('checkoutForm');
    const payButton = document.getElementById('btnSubmitCheckout');

    if (!checkoutForm || !payButton) {
        return;
    }

    checkoutForm.addEventListener('submit', function (e) {
        e.preventDefault();

        if (payButton.disabled) {
            return;
        }

        const originalHtml = payButton.innerHTML;
        payButton.disabled = true;
        payButton.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Memproses...';

        const formData = new FormData(checkoutForm);

        fetch(checkoutForm.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
            },
            body: formData,
        })
        .then(async (res) => {
            const data = await res.json();
            if (!res.ok) {
                throw new Error(data.message || 'Gagal membuat pesanan');
            }
            return data;
        })
        .then((data) => {
            if (!data.snap_token) {
                throw new Error('Token pembayaran tidak tersedia');
            }

            window.snap.pay(data.snap_token, {
                onSuccess: function () {
                    window.location.href = data.redirect_url;
                },
                onPending: function () {
                    window.location.href = data.redirect_url;
                },
                onError: function () {
                    alert('Pembayaran gagal. Silakan coba lagi atau periksa riwayat transaksi Anda.');
                    payButton.disabled = false;
                    payButton.innerHTML = originalHtml;
                },
                onClose: function () {
                    payButton.disabled = false;
                    payButton.innerHTML = originalHtml;
                    if (confirm('Pembayaran belum selesai. Pesanan sudah dibuat — lanjutkan pembayaran nanti dari halaman transaksi?')) {
                        window.location.href = data.redirect_url;
                    }
                },
            });
        })
        .catch((err) => {
            alert(err.message || 'Terjadi kesalahan saat memproses pembayaran');
            payButton.disabled = false;
            payButton.innerHTML = originalHtml;
        });
    });
})();
</script>
@endpush
