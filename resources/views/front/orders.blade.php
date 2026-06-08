<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Pesanan - Urban Sneakers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; color: #1a1a1a; }
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }
        .order-card { background: #fff; border: 1px solid #eaeaea; border-radius: 20px; transition: 0.3s; }
        .order-card:hover { border-color: #ccc; box-shadow: 0 10px 20px rgba(0,0,0,0.03); }
        .order-header { border-bottom: 1px solid #eaeaea; padding-bottom: 15px; margin-bottom: 15px; }
        .product-img { width: 70px; height: 70px; object-fit: cover; border-radius: 12px; background: #f8f9fa; border: 1px solid #eee; }
    </style>
</head>
<body>
    <nav class="navbar navbar-dark navbar-custom py-3 mb-5 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-4 text-white" href="{{ url('/') }}">&larr; Kembali</a>
            <span class="text-white fw-bold"><i class="bi bi-person-circle me-2"></i> {{ auth()->user()->name }}</span>
        </div>
    </nav>

    <div class="container mb-5 pb-5">
        <h2 class="fw-bold mb-4" style="letter-spacing: -1px;">Riwayat Pesanan.</h2>
        
        <!-- ALERT NOTIFIKASI -->
        @if(session('success'))
            <div class="alert alert-success fw-bold rounded-pill shadow-sm border-0 mb-4 d-flex align-items-center">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger fw-bold rounded-pill shadow-sm border-0 mb-4 d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
            </div>
        @endif

        <div class="row justify-content-center">
            <div class="col-lg-9">
                @forelse($transactions as $trx)
                <div class="order-card p-4 mb-4">
                    <div class="order-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                        <div>
                            <span class="fw-bold fs-5 d-block">#TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-muted small fw-bold">{{ $trx->created_at->format('d M Y, H:i') }}</span>
                        </div>
                        
                        <!-- AREA STATUS & TOMBOL AKSI -->
                        <div>
                            @if($trx->status == 'PENDING')
                                <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2">
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold border border-warning">
                                        <i class="bi bi-clock me-1"></i> Menunggu Pembayaran
                                    </span>
                                    
                                    <div class="d-flex gap-2">
                                        <!-- TOMBOL BATAL (Baru) -->
                                        <form action="{{ route('user.order.cancel', $trx->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?');">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3 py-2 fw-bold bg-white">Batal</button>
                                        </form>
                                        <!-- TOMBOL BAYAR -->
                                        <a href="{{ route('checkout.pay', $trx->id) }}" class="btn btn-sm btn-dark rounded-pill px-4 py-2 fw-bold shadow-sm">Bayar</a>
                                    </div>
                                </div>
                            @elseif($trx->status == 'SUCCESS')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill fw-bold"><i class="bi bi-check-circle-fill me-1"></i> Lunas</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2 rounded-pill fw-bold"><i class="bi bi-x-circle-fill me-1"></i> Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="row align-items-center mt-2">
                        <div class="col-md-8">
                            @foreach($trx->details as $detail)
                                <div class="d-flex align-items-center gap-3 mb-3">
                                    @if($detail->product)
                                        <img src="{{ asset('storage/' . $detail->product->image) }}" class="product-img">
                                        <div>
                                            <h6 class="mb-1 fw-bold">{{ $detail->product->name }}</h6>
                                            <small class="text-muted fw-bold">Size: {{ $detail->size }} &bull; Qty: {{ $detail->quantity }}</small>
                                        </div>
                                    @else
                                        <div class="product-img d-flex align-items-center justify-content-center text-muted"><i class="bi bi-box"></i></div>
                                        <div><h6 class="mb-0 fw-bold text-muted">Produk Terhapus</h6></div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div class="col-md-4 text-md-end mt-3 mt-md-0 pt-3 pt-md-0 border-top border-md-0">
                            <small class="text-muted d-block fw-bold">Total Belanja</small>
                            <span class="fs-4 fw-bold text-dark">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- KONDISI INTERAKTIF: AREA RESI PENGIRIMAN BAGI PEMBELI -->
                    @if($trx->status == 'SUCCESS')
                        @if($trx->tracking_number)
                            <div class="mt-3 p-3 bg-light rounded-4 border d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                                <div>
                                    <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">STATUS EXPEDISI:</small>
                                    <span class="fw-bold text-success"><i class="bi bi-truck me-1"></i> Paket Telah Dikirim</span>
                                </div>
                                <div class="text-sm-end">
                                    <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">NOMOR RESI PENGIRIMAN:</small>
                                    <span class="fw-bold text-dark font-monospace border bg-white px-3 py-1 rounded shadow-sm d-inline-block">{{ $trx->tracking_number }}</span>
                                </div>
                            </div>
                        @else
                            <div class="mt-3 p-3 bg-light rounded-4 border">
                                <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem; letter-spacing: 0.5px;">STATUS PROSES:</small>
                                <span class="fw-bold text-secondary"><i class="bi bi-box-seam-fill me-1"></i> Pesanan Sedang Dipersiapkan oleh Gudang Admin</span>
                            </div>
                        @endif
                    @endif

                </div>
                @empty
                <div class="text-center py-5">
                    <i class="bi bi-bag-x text-muted mb-3" style="font-size: 4rem;"></i>
                    <h4 class="fw-bold mt-3">Belum ada riwayat belanja.</h4>
                    <p class="text-muted">Mulai koleksi sneakers pertamamu hari ini!</p>
                    <a href="{{ route('home') }}" class="btn btn-dark mt-3 rounded-pill px-5 py-3 fw-bold">Belanja Sekarang</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</body>
</html>