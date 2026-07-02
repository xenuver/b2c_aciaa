<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesanan Dikirim</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background-color: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%); padding: 28px 20px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 24px; }
        .header p { color: rgba(255,255,255,0.9); margin: 8px 0 0; font-size: 14px; }
        .content { padding: 28px 24px; color: #333; }
        .box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin: 16px 0; }
        .resi { font-size: 22px; font-weight: bold; letter-spacing: 1px; color: #1d4ed8; }
        .btn { display: inline-block; background: #16a34a; color: #fff !important; text-decoration: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; margin-top: 12px; }
        .footer { padding: 16px 24px; text-align: center; font-size: 12px; color: #94a3b8; border-top: 1px solid #e2e8f0; }
    </style>
</head>
<body>
    <div style="padding: 24px 12px;">
        <div class="container">
            <div class="header">
                <h1>Pesanan Anda Telah Dikirim</h1>
                <p>ACIAA Store</p>
            </div>
            <div class="content">
                <p>Halo <strong>{{ $transaction->user->name ?? $transaction->recipient_name }}</strong>,</p>
                <p>Pesanan Anda dengan invoice <strong>{{ $transaction->invoice_number }}</strong> sudah diserahkan ke kurir dan sedang dalam perjalanan.</p>

                <div class="box">
                    <p style="margin: 0 0 8px; color: #64748b; font-size: 13px;">Nomor Resi / AWB</p>
                    <p class="resi" style="margin: 0;">{{ $transaction->tracking_number }}</p>
                    <p style="margin: 12px 0 0; font-size: 14px;">
                        <strong>Kurir:</strong> {{ strtoupper($transaction->shipping_courier ?? '-') }}<br>
                        <strong>Layanan:</strong> {{ $transaction->shipping_service ?? '-' }}<br>
                        <strong>Estimasi:</strong> {{ $transaction->shipping_etd ?? '-' }}
                    </p>
                </div>

                @if($transaction->tracking_url)
                    <p style="text-align: center;">
                        <a href="{{ $transaction->tracking_url }}" class="btn" target="_blank" rel="noopener">Lacak Paket</a>
                    </p>
                @endif

                <p style="font-size: 14px; color: #64748b; margin-top: 20px;">
                    Anda juga dapat melihat nomor resi di halaman <strong>Riwayat Transaksi</strong> pada akun Anda.
                </p>
            </div>
            <div class="footer">
                Email ini dikirim ke {{ $transaction->user->email ?? 'alamat terdaftar Anda' }}.<br>
                &copy; {{ date('Y') }} ACIAA Store
            </div>
        </div>
    </div>
</body>
</html>
