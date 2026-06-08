<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Produk - Admin Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f4f7f6; 
            color: #1a1a1a; 
            overflow-x: hidden;
        }
        
        /* 1. SIDEBAR (KIRI) - SAMA PERSIS DENGAN DASHBOARD */
        .sidebar {
            position: fixed; top: 0; left: 0; height: 100vh; width: 260px;
            background-color: #000000; color: #ffffff; padding-top: 30px; z-index: 1000;
        }
        .sidebar-brand {
            font-weight: 800; font-size: 1.5rem; letter-spacing: -1px; text-align: center;
            margin-bottom: 40px; display: block; color: #fff; text-decoration: none;
        }
        .nav-link-custom {
            color: #888888; font-weight: 600; padding: 12px 25px; display: flex;
            align-items: center; gap: 12px; text-decoration: none; transition: all 0.2s;
            border-left: 4px solid transparent;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            color: #ffffff; background-color: #1a1a1a; border-left: 4px solid #ffffff;
        }
        .nav-link-custom i { font-size: 1.2rem; }

        /* 2. MAIN CONTENT (KANAN) */
        .main-content { margin-left: 260px; padding: 30px 40px; min-height: 100vh; }
        
        /* Top Navbar Admin */
        .admin-topbar {
            background: #ffffff; border-radius: 16px; padding: 15px 25px; display: flex;
            justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            border: 1px solid #eaeaea; margin-bottom: 30px;
        }

        /* 3. TABLE STYLING PREMIUM */
        .table-card {
            background: #ffffff; border: 1px solid #eaeaea; border-radius: 20px;
            padding: 25px; box-shadow: 0 10px 20px rgba(0,0,0,0.02);
        }
        .table-custom { margin-bottom: 0; }
        .table-custom thead th {
            background-color: #f8f9fa; color: #666; font-weight: 700;
            text-transform: uppercase; font-size: 0.8rem; letter-spacing: 0.5px;
            border-bottom: 2px solid #eaeaea; padding: 15px;
        }
        .table-custom tbody td {
            vertical-align: middle; padding: 15px; border-bottom: 1px solid #f0f0f0;
            color: #333; font-weight: 500;
        }
        .product-thumbnail {
            width: 60px; height: 60px; object-fit: cover; border-radius: 12px;
            background-color: #f8f9fa; border: 1px solid #eaeaea;
        }
        .btn-action {
            width: 35px; height: 35px; display: inline-flex; align-items: center;
            justify-content: center; border-radius: 10px; transition: 0.2s;
        }
        .btn-action:hover { transform: translateY(-3px); }
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
            <a href="{{ route('admin.products.index') }}" class="nav-link-custom active">
                <i class="bi bi-box-seam-fill"></i> Manajemen Produk
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="nav-link-custom">
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
                <h5 class="fw-bold m-0">Katalog Produk</h5>
                <small class="text-muted fw-bold">Kelola data sepatu, harga, dan stok inventarismu di sini.</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.products.create') }}" class="btn btn-dark fw-bold rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i> Tambah Produk Baru
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success fw-bold rounded-3 shadow-sm border-0 d-flex align-items-center gap-2 mb-4">
                <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            </div>
        @endif

        <!-- AREA TABEL PRODUK -->
        <div class="table-card">
            <div class="table-responsive">
                <table class="table table-custom table-hover">
                    <thead>
                        <tr>
                            <th width="8%">Gambar</th>
                            <th width="25%">Nama Sepatu</th>
                            <th width="15%">Kategori & Gender</th>
                            <th width="15%">Harga</th>
                            <th width="12%">Stok</th>
                            <th width="15%" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                        <tr>
                            <td>
                                <img src="{{ asset('storage/' . $product->image) }}" class="product-thumbnail" alt="{{ $product->name }}">
                            </td>
                            <td>
                                <h6 class="fw-bold mb-0 text-truncate" style="max-width: 200px;" title="{{ $product->name }}">{{ $product->name }}</h6>
                                <a href="{{ route('product.show', $product->id) }}" target="_blank" class="text-muted small text-decoration-none"><i class="bi bi-box-arrow-up-right"></i> Preview</a>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1 mb-1 d-inline-block">{{ $product->category->name ?? 'Uncategorized' }}</span><br>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary px-2 py-1">
                                    @php
                                        $genderLabel = strtoupper($product->gender);
                                        if($genderLabel == 'PRIA') $genderLabel = 'MEN';
                                        if($genderLabel == 'WANITA') $genderLabel = 'WOMEN';
                                    @endphp
                                    {{ $genderLabel }}
                                </span>
                            </td>
                            <td class="fw-bold text-dark">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                            <td>
                                @if($product->stock > 10)
                                    <span class="fw-bold text-success">{{ $product->stock }} Item</span>
                                @elseif($product->stock > 0)
                                    <span class="fw-bold text-warning">{{ $product->stock }} Item (Low)</span>
                                @else
                                    <span class="badge bg-danger">Habis</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-light border btn-action text-primary shadow-sm" title="Edit Produk">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" class="d-inline-block m-0" onsubmit="return confirm('Yakin ingin menghapus produk ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-light border btn-action text-danger shadow-sm ms-1" title="Hapus Produk">
                                        <i class="bi bi-trash3-fill"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inboxes text-muted mb-3 d-block" style="font-size: 3rem;"></i>
                                <h5 class="fw-bold text-muted">Belum Ada Produk</h5>
                                <p class="text-muted small">Klik tombol "Tambah Produk Baru" di sudut kanan atas untuk mulai berjualan.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination Wrapper -->
            @if(method_exists($products, 'links'))
            <div class="mt-4 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
            @endif
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>