<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pesanan - Admin Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; color: #1a1a1a; overflow-x: hidden; }
        
        /* SIDEBAR KONSISTEN */
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 260px; background-color: #000000; color: #ffffff; padding-top: 30px; z-index: 1000; }
        .sidebar-brand { font-weight: 800; font-size: 1.5rem; letter-spacing: -1px; text-align: center; margin-bottom: 40px; display: block; color: #fff; text-decoration: none; }
        .nav-link-custom { color: #888888; font-weight: 600; padding: 12px 25px; display: flex; align-items: center; gap: 12px; text-decoration: none; transition: all 0.2s; border-left: 4px solid transparent; }
        .nav-link-custom:hover, .nav-link-custom.active { color: #ffffff; background-color: #1a1a1a; border-left: 4px solid #ffffff; }
        .nav-link-custom i { font-size: 1.2rem; }

        .main-content { margin-left: 260px; padding: 30px 40px; min-height: 100vh; }
        
        .admin-topbar { background: #ffffff; border-radius: 16px; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.02); border: 1px solid #eaeaea; margin-bottom: 30px; }

        /* TABLE STYLING */
        .table-card { background: #ffffff; border: 1px solid #eaeaea; border-radius: 20px; padding: 25px; box-shadow: 0 10px 20px rgba(0,0,0,0.02); }
        .table-custom { margin-bottom: 0; }
        .table-custom thead th { background-color: #f8f9fa; color: #666; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px; border-bottom: 2px solid #eaeaea; padding: 15px; }
        .table-custom tbody td { vertical-align: middle; padding: 15px; border-bottom: 1px solid #f0f0f0; color: #333; font-weight: 500; }
        
        .btn-action { width: 35px; height: 35px; display: inline-flex; align-items: center; justify-content: center; border-radius: 10px; transition: 0.2s; }
        .btn-action:hover { transform: translateY(-3px); }
        
        /* Dropdown Status Pintar */
        .status-select { font-weight: 700; border-radius: 8px; cursor: pointer; border: 1.5px solid #eaeaea; font-size: 0.85rem; padding: 6px 30px 6px 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); transition: 0.2s; }
        .status-select:focus { border-color: #000; outline: none; box-shadow: 0 0 0 3px rgba(0,0,0,0.05); }
        .status-pending { color: #d97706; background-color: #fef3c7; border-color: #fde68a; }
        .status-success { color: #059669; background-color: #d1fae5; border-color: #a7f3d0; }
        .status-canceled { color: #dc2626; background-color: #fee2e2; border-color: #fecaca; }
    </style>
</head>
<body>

    <!-- SIDEBAR NAVIGATION -->
    <div class="sidebar shadow-lg">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">URBAN ADMIN.</a>
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard Utama
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link-custom">
                <i class="bi bi-box-seam-fill"></i> Manajemen Produk
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="nav-link-custom active">
                <i class="bi bi-receipt"></i> Data Pesanan
            </a>
            <hr class="border-secondary my-3 mx-4">
            <a href="{{ route('home') }}" target="_blank" class="nav-link-custom">
                <i class="bi bi-shop"></i> Lihat Web Toko
            </a>
            <form action="{{ route('logout') }}" method="POST" class="mt-auto mb-4 mx-4">
                @csrf
                <button type="submit" class="btn btn-outline-light w-100 fw-bold rounded-pill">
                    <i class="bi bi-box-arrow-left me-2"></i> Keluar
                </button>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT AREA -->
    <div class="main-content">
        
        <!-- TOPBAR -->
        <div class="admin-topbar">
            <div>
                <h5 class="fw-bold m-0">Data Transaksi Pesanan</h5>
                <small class="text-muted fw-bold">Pantau pembayaran masuk dan atur status pengiriman.</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-dark fw-bold rounded-pill px-4 shadow-sm" onclick="window.location.reload();">
                    <i class="bi bi-arrow-clockwise me-1"></i> Refresh Data
                </button>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success fw-bold rounded-3 shadow-sm border-0 d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <!-- AREA TABEL TRANSAKSI -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th width="15%">ID Pesanan</th>
                            <th width="20%">Informasi Pembeli</th>
                            <th width="15%">Total Tagihan</th>
                            <th width="20%">Waktu Transaksi</th>
                            <th width="15%">Status Pembayaran</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $trx)
                        <tr>
                            <td>
                                <span class="fw-bold text-dark">#TRX-{{ str_pad($trx->id, 5, '0', STR_PAD_LEFT) }}</span>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">{{ $trx->name }}</div>
                                <div class="text-muted small"><i class="bi bi-telephone-fill me-1"></i>{{ $trx->phone }}</div>
                            </td>
                            <td class="fw-bold text-dark fs-6">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                            <td>
                                <div class="fw-bold text-secondary">{{ $trx->created_at->format('d M Y') }}</div>
                                <div class="text-muted small"><i class="bi bi-clock me-1"></i>{{ $trx->created_at->format('H:i') }} WIB</div>
                            </td>
                            <td>
                                <!-- FORM UPDATE STATUS CEPAT -->
                                <form action="{{ route('admin.transactions.updateStatus', $trx->id) }}" method="POST" class="m-0">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select status-select 
                                        {{ $trx->status == 'SUCCESS' ? 'status-success' : ($trx->status == 'PENDING' ? 'status-pending' : 'status-canceled') }}" 
                                        onchange="this.form.submit()">
                                        <option value="PENDING" {{ $trx->status == 'PENDING' ? 'selected' : '' }}>🟡 PENDING</option>
                                        <option value="SUCCESS" {{ $trx->status == 'SUCCESS' ? 'selected' : '' }}>🟢 SUCCESS</option>
                                        <option value="CANCELED" {{ $trx->status == 'CANCELED' ? 'selected' : '' }}>🔴 CANCELED</option>
                                    </select>
                                </form>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.transactions.show', $trx->id) }}" class="btn btn-light border btn-action text-primary shadow-sm" title="Lihat Detail Pesanan">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                <a href="{{ route('admin.transactions.print', $trx->id) }}" target="_blank" class="btn btn-dark btn-action shadow-sm ms-1" title="Cetak Resi/Invoice">
                                    <i class="bi bi-printer-fill"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-receipt text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                <h5 class="fw-bold text-muted">Belum Ada Transaksi</h5>
                                <p class="text-muted small">Pesanan yang dibuat oleh pembeli akan otomatis muncul di sini.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Wrapper -->
            @if(method_exists($transactions, 'links'))
            <div class="mt-4 d-flex justify-content-center">
                {{ $transactions->links() }}
                {{ $transactions->appends(request()->query())->links() }}
            </div>
            @endif
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>