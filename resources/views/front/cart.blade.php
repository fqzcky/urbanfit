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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfc;
            color: #1a1a1a;
        }

        /* Navbar Style (Selalu Sinkron) */
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }

        /* Cart List Style */
        .cart-item {
            border: 1px solid #f0f0f0;
            border-radius: 20px;
            background-color: #ffffff;
            transition: all 0.3s ease;
        }
        .cart-item:hover {
            box-shadow: 0 10px 25px rgba(0,0,0,0.05);
            border-color: #e6e6e6;
        }
        .cart-img-box {
            background-color: #f8f9fa;
            border-radius: 16px;
            overflow: hidden;
            width: 120px;
            height: 120px;
            flex-shrink: 0;
        }
        .cart-img-box img {
            width: 100%; height: 100%; object-fit: cover;
        }
        .item-title {
            font-weight: 800;
            font-size: 1.15rem;
            color: #1a1a1a;
            margin-bottom: 5px;
            line-height: 1.3;
        }
        .item-meta {
            font-size: 0.9rem;
            color: #666;
            font-weight: 600;
        }
        
        /* Btn Hapus Estetik */
        .btn-remove {
            background: none;
            border: none;
            color: #dc3545;
            font-weight: 700;
            font-size: 0.9rem;
            padding: 0;
            transition: color 0.2s;
        }
        .btn-remove:hover { color: #a71d2a; text-decoration: underline; }

        /* Order Summary Style */
        .summary-card {
            background-color: #ffffff;
            border: 1px solid #f0f0f0;
            border-radius: 24px;
            padding: 30px;
            position: sticky;
            top: 100px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.03);
        }
        .summary-title { font-weight: 800; font-size: 1.3rem; margin-bottom: 25px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-weight: 600; color: #555; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 2px dashed #eee; font-weight: 800; font-size: 1.4rem; color: #000; }

        /* Empty Cart State */
        .empty-cart-icon { font-size: 6rem; color: #e0e0e0; margin-bottom: 20px; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 sticky-top shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            
            <div class="d-flex gap-2 align-items-center">
                @auth
                    <a href="{{ route('user.orders') }}" class="btn btn-warning fw-bold rounded-pill px-3">Riwayat Pesanan</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger fw-bold rounded-pill px-3">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link text-white text-decoration-none fw-bold px-3">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-light fw-bold rounded-pill px-4">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5 pb-5">
        <h1 class="fw-bold display-6 mb-4" style="letter-spacing: -1px;">Keranjang Belanja.</h1>

        @if(session('success'))
            <div class="alert alert-success fw-bold rounded-4 shadow-sm border-0 bg-dark text-white mb-4">
                <i class="bi bi-check-circle-fill text-warning me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('cart') && count(session('cart')) > 0)
            <div class="row g-5">
                <div class="col-lg-8">
                    @php $totalPrice = 0; @endphp
                    
                    @foreach(session('cart') as $key => $details)
                        @php $totalPrice += $details['price'] * $details['quantity']; @endphp
                        
                        <div class="cart-item d-flex flex-column flex-sm-row align-items-center p-3 p-md-4 mb-4">
                            <div class="cart-img-box me-sm-4 mb-3 mb-sm-0">
                                @if(isset($details['image']))
                                    <img src="{{ asset('storage/' . $details['image']) }}" alt="{{ $details['name'] }}">
                                @else
                                    <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted">
                                        <i class="bi bi-box-seam fs-1"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-grow-1 w-100 text-center text-sm-start">
                                <a href="{{ route('product.show', $details['product_id'] ?? 1) }}" class="text-decoration-none">
                                    <h5 class="item-title">{{ $details['name'] }}</h5>
                                </a>
                                <div class="item-meta mb-2">
                                    <span class="badge bg-light text-dark border px-2 py-1 me-2">Size: {{ $details['size'] }}</span>
                                    <span>Qty: {{ $details['quantity'] }}</span>
                                </div>
                                <div class="fw-bold fs-5 text-dark">
                                    Rp {{ number_format($details['price'], 0, ',', '.') }}
                                </div>
                            </div>
                            
                            <div class="mt-3 mt-sm-0 ms-sm-auto">
                                <form action="{{ route('cart.remove', $key) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn-remove">
                                        <i class="bi bi-trash3-fill me-1"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-lg-4">
                    <div class="summary-card">
                        <h4 class="summary-title">Ringkasan Pesanan</h4>
                        
                        <div class="summary-row">
                            <span>Subtotal ({{ count(session('cart')) }} item)</span>
                            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span>Estimasi Pajak</span>
                            <span>Termasuk</span>
                        </div>
                        <div class="summary-row">
                            <span>Biaya Pengiriman</span>
                            <span class="text-success fw-bold">Dihitung di Checkout</span>
                        </div>
                        
                        <div class="summary-total">
                            <span>Total Estimasi</span>
                            <span class="text-danger">Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                        </div>
                        
                        <a href="{{ route('checkout.index') }}" class="btn btn-dark btn-lg w-100 mt-4 py-3 fw-bold rounded-pill" style="font-size: 1.1rem;">
                            Lanjut ke Checkout <i class="bi bi-arrow-right ms-2"></i>
                        </a>
                        
                        <a href="{{ route('home') }}" class="btn btn-link w-100 mt-3 text-muted text-decoration-none fw-bold">
                            &larr; Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
            
        @else
            <div class="row justify-content-center mt-5 pt-5">
                <div class="col-md-6 text-center">
                    <i class="bi bi-cart-x empty-cart-icon"></i>
                    <h2 class="fw-bold mb-3">Keranjangmu Masih Kosong</h2>
                    <p class="text-muted mb-4 fs-5">Sepertinya kamu belum memilih sneakers andalanmu. Yuk, cari sepatu incaranmu sekarang!</p>
                    <a href="{{ route('home') }}" class="btn btn-dark btn-lg px-5 py-3 rounded-pill fw-bold">
                        Mulai Belanja
                    </a>
                </div>
            </div>
        @endif

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>