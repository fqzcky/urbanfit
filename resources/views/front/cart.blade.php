<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Urban Sneakers</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa; /* Background abu-abu terang agar kartu putih lebih menonjol */
            color: #1a1a1a;
        }

        /* Navbar Sederhana (Khusus Halaman Dalam) */
        .navbar-custom { background-color: #000000; padding: 1rem 0; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }

        /* Styling Item Keranjang */
        .cart-item-card {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid #eaeaea;
            transition: all 0.3s ease;
        }
        .cart-item-card:hover { border-color: #000; box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
        .cart-img-box {
            background-color: #f4f4f4;
            border-radius: 12px;
            overflow: hidden;
            width: 100px; height: 100px;
        }
        .cart-img-box img { width: 100%; height: 100%; object-fit: cover; }
        .cart-title { font-weight: 800; font-size: 1.1rem; line-height: 1.3; }
        .cart-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.5rem; letter-spacing: 0.5px; }

        /* Tombol Hapus */
        .btn-delete {
            width: 40px; height: 40px; border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            background-color: #ffe5e5; color: #dc3545; border: none; transition: 0.2s;
        }
        .btn-delete:hover { background-color: #dc3545; color: #fff; transform: scale(1.1); }

        /* Order Summary Sticky */
        .summary-card {
            background: #ffffff;
            border-radius: 24px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            position: sticky;
            top: 100px; /* Jarak melayang dari atas saat di-scroll */
        }
        .summary-title { font-weight: 800; font-size: 1.3rem; letter-spacing: -0.5px; }
        .summary-total { font-family: 'Bebas Neue', sans-serif; font-size: 2.2rem; letter-spacing: 1px; }
        
        /* Empty State */
        .empty-cart-icon { font-size: 6rem; color: #e0e0e0; margin-bottom: 20px; display: inline-block;}
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            <a href="{{ route('home') }}" class="btn btn-outline-light rounded-pill px-4 fw-bold shadow-sm">Lanjut Belanja</a>
        </div>
    </nav>

    <div class="container mt-5 mb-5 pb-5">
        <div class="mb-4">
            <h2 class="fw-extrabold" style="letter-spacing: -1px;">KERANJANG BELANJA</h2>
            <p class="text-muted">Pastikan barang dan ukuran sudah sesuai sebelum checkout.</p>
        </div>

        @if(session('success'))
            <div style="position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 1050; width: 100%; max-width: 600px; padding: 0 15px; animation: slideDown 0.4s ease forwards;">
                <div class="alert alert-dark alert-dismissible fade show fw-bold rounded-4 shadow-lg border border-secondary d-flex align-items-center gap-2 m-0 text-white" role="alert">
                    <i class="bi bi-check-circle-fill text-warning fs-5"></i> 
                    {{ session('success') }}
                    <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            </div>
            <style>
                @keyframes slideDown {
                    from { opacity: 0; transform: translate(-50%, -20px); }
                    to { opacity: 1; transform: translate(-50%, 0); }
                }
            </style>
        @endif

        <div class="row g-4">
            
            @if(session('cart') && count(session('cart')) > 0)
                <div class="col-lg-8">
                    @php $totalPrice = 0; @endphp
                    
                    @foreach(session('cart') as $key => $details)
                        @php $totalPrice += $details['price'] * $details['quantity']; @endphp
                        
                        <div class="cart-item-card p-3 mb-3 d-flex align-items-center gap-3">
                            <div class="cart-img-box flex-shrink-0">
                                @if(isset($details['image']))
                                    <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                        <i class="bi bi-box-seam fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-grow-1">
                                <a href="{{ route('product.show', $details['product_id'] ?? 1) }}" class="text-decoration-none text-dark">
                                    <h5 class="cart-title mb-1">{{ $details['name'] }}</h5>
                                </a>
                                <p class="text-muted small mb-2 fw-bold">Size: {{ $details['size'] }}</p>
                                <div class="cart-price">Rp {{ number_format($details['price'], 0, ',', '.') }}</div>
                            </div>

                            <div class="d-flex align-items-center gap-4 pe-2">
                                <div class="fw-bold fs-5 text-muted">x{{ $details['quantity'] }}</div>
                                
                                <form action="{{ route('cart.remove', $key) }}" method="POST" class="m-0">
                                    @csrf
                                    <button type="submit" class="btn-delete shadow-sm" title="Hapus Item"><i class="bi bi-trash-fill"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="summary-card p-4">
                        <h5 class="summary-title mb-4 border-bottom pb-3">Ringkasan Pesanan</h5>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-bold">Subtotal ({{ count(session('cart')) }} item)</span>
                            <span class="fw-bold fs-5">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span> 
                        </div>
                        
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-bold">Estimasi Pajak</span>
                            <span class="fw-bold">Termasuk</span> 
                        </div>

                        <div class="d-flex justify-content-between mb-4">
                            <span class="text-muted fw-bold">Biaya Pengiriman</span>
                            <span class="text-secondary fw-bold fst-italic" style="font-size: 0.9rem;">Dihitung di Checkout</span>
                        </div>

                        <div class="border-top pt-3 mb-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-extrabold text-dark" style="font-size: 1.1rem;">TOTAL ESTIMASI</span>
                                <span class="summary-total text-danger">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <a href="{{ route('checkout.index') }}" class="btn btn-dark w-100 py-3 rounded-pill fw-bold fs-5 shadow" style="transition: all 0.3s;">
                            Lanjut ke Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        
                        <div class="mt-4 text-center">
                            <p class="small text-muted mb-2 fw-bold">Metode Pembayaran</p>
                            <div class="d-flex justify-content-center gap-2 opacity-75">
                                <span class="badge bg-light border text-dark">BCA</span>
                                <span class="badge bg-light border text-dark">Mandiri</span>
                                <span class="badge bg-light border text-dark">GoPay</span>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="text-center p-5 bg-white rounded-4 border shadow-sm">
                        <i class="bi bi-cart-x empty-cart-icon"></i>
                        <h3 class="fw-bold mt-3">Keranjangmu Masih Kosong</h3>
                        <p class="text-muted fs-6 mb-4">Sepertinya kamu belum memilih sneakers andalanmu. Yuk, cari sepatu incaranmu sekarang!</p>
                        <a href="{{ route('home') }}" class="btn btn-dark rounded-pill px-5 py-3 fw-bold mt-2 fs-5">
                            Mulai Belanja
                        </a>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>