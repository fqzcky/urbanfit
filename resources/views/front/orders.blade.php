<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8f9fa; 
            color: #1a1a1a;
        }
        
        /* Navbar Style */
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }
        
        /* Order Card Premium */
        .order-card { 
            background: #ffffff; 
            border: 1px solid #eaeaea; 
            border-radius: 24px; 
            transition: all 0.3s ease; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.02);
            overflow: hidden;
        }
        .order-card:hover { 
            border-color: #d0d0d0; 
            box-shadow: 0 15px 30px rgba(0,0,0,0.06); 
            transform: translateY(-3px);
        }
        
        .order-header { 
            border-bottom: 1px dashed #eaeaea; 
            padding-bottom: 15px; 
            margin-bottom: 20px; 
        }
        
        .product-img { 
            width: 80px; 
            height: 80px; 
            object-fit: cover; 
            border-radius: 14px; 
            background: #f4f4f4; 
            border: 1px solid #f0f0f0; 
        }

        /* Typography Bebas Neue untuk Angka/Harga */
        .trx-number { font-family: 'Bebas Neue', sans-serif; font-size: 1.6rem; letter-spacing: 1px; color: #1a1a1a; line-height: 1;}
        .total-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.8rem; letter-spacing: 0.5px; color: #e63329; line-height: 1;}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 mb-5 shadow-sm sticky-top">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-4 text-white d-flex align-items-center gap-2" href="{{ url('/') }}">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <span class="text-white fw-bold d-flex align-items-center px-3 py-2 rounded-pill bg-dark border border-secondary">
                <i class="bi bi-person-circle me-2 text-warning"></i> {{ auth()->user()->name }}
            </span>
        </div>
    </nav>

    <div class="container mb-5 pb-5">
        <h2 class="fw-extrabold mb-4 display-6" style="letter-spacing: -1px;">Riwayat Pesanan.</h2>
        
        @if(session('success'))
            <div class="alert alert-dark fw-bold rounded-4 shadow-sm border border-secondary text-white mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill text-warning fs-5 me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger fw-bold rounded-4 shadow-sm border-0 mb-4 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-9">
                @forelse($transactions as $trx)
                <div class="order-card p-4 p-md-5 mb-4">
                    <div class="order-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <span class="trx-number d-block">#TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-muted small fw-bold"><i class="bi bi-calendar-event me-1"></i> {{ $trx->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        
                        <div>
                            @if($trx->status == 'PENDING')
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-3">
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold border border-warning shadow-sm">
                                        <i class="bi bi-clock me-1"></i> Menunggu Pembayaran
                                    </span>
                                    
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('user.order.cancel', $trx->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');" class="m-0">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-outline-danger rounded-pill px-4 py-2 fw-bold bg-white transition-all">Batal</button>
                                        </form>
                                        <a href="{{ route('checkout.pay', $trx->id) }}" class="btn btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">Bayar Sekarang</a>
                                    </div>
                                </div>
                            @elseif($trx->status == 'SUCCESS')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-4 py-2 rounded-pill fw-bold fs-6 shadow-sm"><i class="bi bi-check-circle-fill me-2"></i> Pesanan Lunas</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-4 py-2 rounded-pill fw-bold fs-6"><i class="bi bi-x-circle-fill me-2"></i> Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row align-items-center mt-4">
                        <div class="col-md-8">
                            @foreach($trx->details as $detail)
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    @if($detail->product)
                                        <img src="{{ asset('storage/' . $detail->product->image) }}" class="product-img shadow-sm">
                                        <div>
                                            <h6 class="mb-1 fw-bold text-dark fs-6">{{ $detail->product->name }}</h6>
                                            <span class="badge bg-light text-dark border px-2 py-1 me-2 fw-bold">Size: {{ $detail->size }}</span>
                                            <span class="text-muted fw-bold small">Qty: {{ $detail->quantity }}</span>
                                        </div>
                                    @else
                                        <div class="product-img d-flex align-items-center justify-content-center text-muted"><i class="bi bi-box-seam fs-3"></i></div>
                                        <div><h6 class="mb-0 fw-bold text-muted">Produk Terhapus</h6></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="col-md-4 text-md-end mt-4 mt-md-0 pt-4 pt-md-0 border-top border-md-0">
                            <small class="text-muted d-block fw-bold mb-1">Total Tagihan</small>
                            <span class="total-price">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($trx->status == 'SUCCESS')
                        @if($trx->tracking_number)
                            <div class="mt-4 p-4 bg-light rounded-4 border d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3">
                                <div>
                                    <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">STATUS PENGIRIMAN:</small>
                                    <span class="fw-bold text-success fs-6"><i class="bi bi-truck me-2"></i> Paket Sedang Dikirim</span>
                                </div>
                                <div class="text-sm-end">
                                    <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">NOMOR RESI:</small>
                                    <span class="fw-bold text-dark font-monospace border bg-white px-3 py-2 rounded-3 shadow-sm d-inline-block fs-6">{{ $trx->tracking_number }}</span>
                                </div>
                            </div>
                        @else
                            <div class="mt-4 p-4 bg-light rounded-4 border text-center text-sm-start">
                                <small class="text-muted d-block fw-bold mb-2" style="font-size: 0.75rem; letter-spacing: 0.5px;">STATUS PROSES:</small>
                                <span class="fw-bold text-secondary"><i class="bi bi-box-seam-fill me-2"></i> Pesanan sedang dipersiapkan oleh tim Gudang</span>
                            </div>
                        @endif
                    @endif

                </div>
                @empty
                <div class="text-center py-5 bg-white rounded-4 border shadow-sm">
                    <i class="bi bi-bag-x text-muted mb-3 d-inline-block" style="font-size: 5rem;"></i>
                    <h3 class="fw-extrabold mt-3">Belum ada riwayat belanja.</h3>
                    <p class="text-muted fs-6 mb-4">Mulai koleksi sneakers pertamamu hari ini!</p>
                    <a href="{{ route('home') }}" class="btn btn-dark mt-2 rounded-pill px-5 py-3 fw-bold shadow-sm">
                        Belanja Sekarang <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>