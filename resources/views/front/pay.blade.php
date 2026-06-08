<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Urban Sneakers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; color: #1a1a1a; }
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }
        .pay-card { background: #fff; border: 1px solid #eaeaea; border-radius: 24px; box-shadow: 0 15px 30px rgba(0,0,0,0.04); }
        .total-amount { font-weight: 800; font-size: 3rem; letter-spacing: -1px; color: #000; }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            <div class="text-white fw-bold"><i class="bi bi-lock-fill text-success me-1"></i> Pembayaran Aman</div>
        </div>
    </nav>

    <div class="container mt-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="pay-card p-5">
                    <div class="mb-4 text-muted"><i class="bi bi-wallet2 fs-1"></i></div>
                    <h5 class="fw-bold text-muted mb-2">Total Tagihan</h5>
                    <div class="total-amount mb-4">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                    <p class="text-muted mb-4" style="line-height: 1.6;">Pesanan <strong>#TRX-{{ $transaction->id }}</strong> atas nama <strong>{{ $transaction->name }}</strong> sudah kami terima. Silakan selesaikan pembayaran.</p>
                    
                    <button id="pay-button" class="btn btn-dark btn-lg w-100 py-3 rounded-pill fw-bold" style="font-size: 1.1rem;">
                        <i class="bi bi-qr-code-scan me-2"></i> Bayar Sekarang
                    </button>
                    
                    <a href="{{ route('home') }}" class="btn btn-link text-muted mt-3 text-decoration-none fw-bold">
                        Batal & Kembali Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        document.getElementById('pay-button').addEventListener('click', function () {
            window.snap.pay('{{ $transaction->snap_token }}', {
                onSuccess: function(result){ window.location.href = "{{ route('home') }}"; },
                onPending: function(result){ alert("Menunggu pembayaran Anda!"); },
                onError: function(result){ alert("Pembayaran gagal!"); },
                onClose: function(){ alert('Anda menutup layar pembayaran sebelum menyelesaikannya.'); }
            });
        });
    </script>
</body>
</html>