<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8f9fa; /* Background abu-abu terang sesuai keranjang & checkout */
            color: #1a1a1a; 
            margin: 0 !important; 
            padding: 0 !important;
        }
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; padding: 1rem 0; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }
        
        .pay-card { 
            background: #ffffff; 
            border: none; 
            border-radius: 24px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.08); 
            position: relative;
            overflow: hidden;
        }
        
        /* Aksen garis atas merah pada kartu biar elegan */
        .pay-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background-color: #e63329; 
        }
        
        .total-label { font-weight: 800; font-size: 1.1rem; letter-spacing: -0.5px; text-transform: uppercase;}
        
        /* Font harga total diubah jadi Bebas Neue */
        .total-amount { 
            font-family: 'Bebas Neue', sans-serif; 
            font-size: 4.5rem; 
            letter-spacing: 1.5px; 
            color: #dc3545; /* Warna merah biar pop-out */
            line-height: 1;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom shadow-sm sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            <div class="text-white fw-bold d-none d-md-flex align-items-center px-3 py-2 rounded-pill bg-dark border border-secondary">
                <i class="bi bi-shield-check text-success me-2 fs-5"></i> Pembayaran Midtrans
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5 text-center">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="mb-4">
                    <h1 class="fw-extrabold display-6" style="letter-spacing: -1px;">Selesaikan Pembayaran.</h1>
                    <p class="text-muted">Pilih metode pembayaran favoritmu dengan aman.</p>
                </div>

                <div class="pay-card p-4 p-md-5 mx-auto">
                    <div class="mb-3 text-muted"><i class="bi bi-wallet2 text-dark" style="font-size: 3rem;"></i></div>
                    <h5 class="total-label text-muted mb-3">Total Tagihan</h5>
                    
                    <div class="total-amount mb-4">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</div>
                    
                    <div class="bg-light rounded-4 p-4 mb-4 text-start border">
                        <div class="d-flex justify-content-between mb-3 border-bottom pb-2">
                            <span class="text-muted fw-bold">Nomor Pesanan</span>
                            <span class="fw-bold text-dark">#TRX-{{ $transaction->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-muted fw-bold">Nama Pelanggan</span>
                            <span class="fw-bold text-dark">{{ $transaction->name }}</span>
                        </div>
                    </div>
                    
                    <button id="pay-button" class="btn btn-dark btn-lg w-100 py-3 rounded-pill fw-bold shadow-sm" style="transition: all 0.3s; font-size: 1.15rem;">
                        <i class="bi bi-credit-card-2-front-fill me-2"></i> Bayar Sekarang
                    </button>
                    
                    <div class="mt-4 text-center">
                        <p class="small text-muted mb-2 fw-bold"><i class="bi bi-shield-lock-fill me-1"></i> Secured by Midtrans</p>
                        <div class="d-flex justify-content-center gap-2 opacity-75">
                            <span class="badge bg-light border text-dark">BCA</span>
                            <span class="badge bg-light border text-dark">Mandiri</span>
                            <span class="badge bg-light border text-dark">GoPay</span>
                            <span class="badge bg-light border text-dark">QRIS</span>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('home') }}" class="btn btn-link text-muted text-decoration-none fw-bold transition-all hover-dark">
                        &larr; Batal & Kembali Belanja
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // LOGIC MIDTRANS AMAN DAN TIDAK ADA YANG DIUBAH
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