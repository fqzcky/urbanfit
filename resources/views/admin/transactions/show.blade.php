<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Admin Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; color: #1a1a1a; overflow-x: hidden; }
        
        /* SIDEBAR (Konsisten) */
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 260px; background-color: #000000; color: #ffffff; padding-top: 30px; z-index: 1000; }
        .sidebar-brand { font-weight: 800; font-size: 1.5rem; letter-spacing: -1px; text-align: center; margin-bottom: 40px; display: block; color: #fff; text-decoration: none; }
        .nav-link-custom { color: #888888; font-weight: 600; padding: 12px 25px; display: flex; align-items: center; gap: 12px; text-decoration: none; transition: 0.2s; border-left: 4px solid transparent; }
        .nav-link-custom:hover, .nav-link-custom.active { color: #ffffff; background-color: #1a1a1a; border-left: 4px solid #ffffff; }
        .nav-link-custom i { font-size: 1.2rem; }
        .main-content { margin-left: 260px; padding: 30px 40px; min-height: 100vh; }
        
        /* LAYOUT & CARDS */
        .admin-topbar { background: #ffffff; border-radius: 16px; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.02); border: 1px solid #eaeaea; margin-bottom: 30px; }
        .info-card { background: #ffffff; border: 1px solid #eaeaea; border-radius: 20px; padding: 25px; box-shadow: 0 10px 20px rgba(0,0,0,0.02); height: 100%; }
        
        .info-label { font-size: 0.85rem; color: #777; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
        .info-value { font-size: 1.05rem; font-weight: 700; color: #1a1a1a; margin-bottom: 20px; }
        
        /* TABLE STYLING */
        .table-custom { margin-bottom: 0; }
        .table-custom thead th { background-color: #f8f9fa; color: #666; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; border-bottom: 2px solid #eaeaea; padding: 15px; }
        .table-custom tbody td { vertical-align: middle; padding: 15px; border-bottom: 1px solid #f0f0f0; color: #333; font-weight: 500; }
        .table-custom tfoot td { background-color: #fafafa; border-top: 2px solid #eaeaea; padding: 20px 15px; }
        
        .form-select-custom { border: 1.5px solid #eaeaea; border-radius: 10px; padding: 10px 15px; font-weight: 600; }
        .form-select-custom:focus { border-color: #000; box-shadow: none; }
    </style>
</head>
<body>

    <div class="sidebar shadow-lg">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">URBAN ADMIN.</a>
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom"><i class="bi bi-grid-1x2-fill"></i> Dashboard Utama</a>
            <a href="{{ route('admin.products.index') }}" class="nav-link-custom"><i class="bi bi-box-seam-fill"></i> Manajemen Produk</a>
            <a href="{{ route('admin.transactions.index') }}" class="nav-link-custom active"><i class="bi bi-receipt"></i> Data Pesanan</a>
        </div>
    </div>

    <div class="main-content">
        
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-light border rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-left"></i></a>
                <div>
                    <h5 class="fw-bold m-0">Detail Pesanan: #TRX-{{ str_pad($transaction->id, 5, '0', STR_PAD_LEFT) }}</h5>
                    <small class="text-muted fw-bold">{{ $transaction->created_at->format('d M Y, H:i') }} WIB</small>
                </div>
            </div>
            <div>
                <a href="{{ route('admin.transactions.print', $transaction->id) }}" target="_blank" class="btn btn-dark fw-bold rounded-pill px-4 shadow-sm">
                    <i class="bi bi-printer-fill me-1"></i> Cetak Struk
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success fw-bold rounded-3 shadow-sm border-0 d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <div class="row g-4 mb-5">
            <div class="col-lg-4">
                <div class="info-card">
                    <h6 class="fw-bold mb-4 border-bottom pb-3"><i class="bi bi-person-lines-fill me-2"></i>Informasi Pembeli</h6>
                    
                    <div class="info-label">Nama Lengkap</div>
                    <div class="info-value">{{ $transaction->name }}</div>

                    <div class="info-label">Nomor WhatsApp</div>
                    <div class="info-value">
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $transaction->phone) }}" target="_blank" class="text-decoration-none text-success">
                            <i class="bi bi-whatsapp me-1"></i> {{ $transaction->phone }}
                        </a>
                    </div>

                    <div class="info-label">Alamat Pengiriman</div>
                    <div class="info-value" style="font-size: 0.95rem; font-weight: 500; line-height: 1.5;">
                        {{ $transaction->address }}
                    </div>

                    <div class="mt-4 pt-4 border-top">
                        <h6 class="fw-bold mb-3"><i class="bi bi-arrow-repeat me-2"></i>Update Status Pesanan</h6>
                        <form action="{{ route('admin.transactions.updateStatus', $transaction->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="d-flex flex-column gap-2">
                                <select name="status" class="form-select form-select-custom">
                                    <option value="PENDING" {{ $transaction->status == 'PENDING' ? 'selected' : '' }}>🟡 PENDING (Belum Dibayar)</option>
                                    <option value="SUCCESS" {{ $transaction->status == 'SUCCESS' ? 'selected' : '' }}>🟢 SUCCESS (Sudah Lunas)</option>
                                    <option value="CANCELED" {{ $transaction->status == 'CANCELED' ? 'selected' : '' }}>🔴 CANCELED (Dibatalkan)</option>
                                </select>
                                <button type="submit" class="btn btn-dark fw-bold rounded-3 py-2 mt-2">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>

                    @if($transaction->status == 'SUCCESS')
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="fw-bold mb-3"><i class="bi bi-truck me-2"></i>Pengiriman Paket Ekspedisi</h6>
                            
                            @if($transaction->tracking_number)
                                <div class="p-3 bg-light rounded-3 border mb-3">
                                    <small class="text-muted d-block fw-bold mb-1" style="font-size: 0.75rem;">NOMOR RESI SAAT INI:</small>
                                    <span class="fs-6 fw-bold text-success font-monospace">{{ $transaction->tracking_number }}</span>
                                </div>
                            @else
                                <div class="alert alert-warning border-0 small fw-bold rounded-3 mb-3" style="font-size: 0.85rem;">
                                    <i class="bi bi-exclamation-circle-fill me-1"></i> Pembayaran lunas. Paket siap dikirimkan ke kurir.
                                </div>
                            @endif

                            <form action="{{ route('admin.transactions.updateTracking', $transaction->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="d-flex flex-column gap-2">
                                    <input type="text" name="tracking_number" class="form-control form-select-custom" placeholder="Masukkan Nomor Resi..." value="{{ $transaction->tracking_number }}" required>
                                    <button type="submit" class="btn btn-dark fw-bold rounded-3 py-2">
                                        <i class="bi bi-telegram me-1"></i> {{ $transaction->tracking_number ? 'Perbarui Resi' : 'Kirim Paket' }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    @endif
                </div>
            </div>

            <div class="col-lg-8">
                <div class="info-card p-0 overflow-hidden">
                    <div class="p-4 border-bottom bg-light">
                        <h6 class="fw-bold m-0"><i class="bi bi-bag-check-fill me-2"></i>Daftar Sepatu yang Dibeli</h6>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-custom table-hover">
                            <thead>
                                <tr>
                                    <th class="ps-4">Produk</th>
                                    <th class="text-center">Size</th>
                                    <th class="text-center">Qty</th>
                                    <th>Harga Satuan</th>
                                    <th class="pe-4 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($transaction->details as $detail)
                                <tr>
                                    <td class="ps-4 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            @if($detail->product)
                                                <img src="{{ asset('storage/' . $detail->product->image) }}" class="rounded-3 border shadow-sm" width="60" height="60" style="object-fit: cover;" alt="{{ $detail->product->name }}">
                                                <div>
                                                    <div class="fw-bold text-dark">{{ $detail->product->name }}</div>
                                                    <small class="text-muted">{{ $detail->product->category->name ?? 'Sneakers' }}</small>
                                                </div>
                                            @else
                                                <div class="rounded-3 border bg-light d-flex align-items-center justify-content-center text-muted" style="width: 60px; height: 60px;"><i class="bi bi-box"></i></div>
                                                <span class="text-danger fw-bold fst-italic">Produk telah dihapus</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center"><span class="badge bg-dark px-2 py-1 rounded-2">{{ $detail->size }}</span></td>
                                    <td class="text-center fw-bold">{{ $detail->quantity }}</td>
                                    <td class="fw-bold text-secondary">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                    <td class="pe-4 text-end fw-bold text-dark">Rp {{ number_format($detail->price * $detail->quantity, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-end fw-bold text-uppercase" style="letter-spacing: 0.5px; color: #666;">
                                        Total Pembayaran Bersih
                                    </td>
                                    <td class="pe-4 text-end fw-bold fs-4 text-dark">
                                        Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>