<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Urban Sneakers</title>
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f4f7f6; /* Abu-abu super muda untuk kontras */
            color: #1a1a1a; 
            overflow-x: hidden;
        }
        
        /* 1. SIDEBAR (KIRI) */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 260px;
            background-color: #000000;
            color: #ffffff;
            padding-top: 30px;
            z-index: 1000;
            transition: all 0.3s;
        }
        .sidebar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -1px;
            text-align: center;
            margin-bottom: 40px;
            display: block;
            color: #fff;
            text-decoration: none;
        }
        .nav-link-custom {
            color: #888888;
            font-weight: 600;
            padding: 12px 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            transition: all 0.2s;
            border-left: 4px solid transparent;
        }
        .nav-link-custom:hover, .nav-link-custom.active {
            color: #ffffff;
            background-color: #1a1a1a;
            border-left: 4px solid #ffffff;
        }
        .nav-link-custom i { font-size: 1.2rem; }

        /* 2. MAIN CONTENT (KANAN) */
        .main-content {
            margin-left: 260px;
            padding: 30px 40px;
            min-height: 100vh;
        }
        
        /* 3. KARTU STATISTIK */
        .stat-card {
            background: #ffffff;
            border: 1px solid #eaeaea;
            border-radius: 20px;
            padding: 25px;
            display: flex;
            align-items: center;
            gap: 20px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.02);
            transition: transform 0.3s;
        }
        .stat-card:hover { transform: translateY(-5px); }
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            background: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
        }
        .stat-value { font-weight: 800; font-size: 1.8rem; line-height: 1.1; margin: 0; }
        .stat-label { color: #777; font-weight: 600; font-size: 0.9rem; margin: 0; }

        /* Top Navbar Admin */
        .admin-topbar {
            background: #ffffff;
            border-radius: 16px;
            padding: 15px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 12px rgba(0,0,0,0.02);
            border: 1px solid #eaeaea;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>

    <!-- SIDEBAR NAVIGATION -->
    <div class="sidebar shadow-lg">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">URBAN ADMIN.</a>
        
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom active">
                <i class="bi bi-grid-1x2-fill"></i> Dashboard Utama
            </a>
            <a href="{{ route('admin.products.index') }}" class="nav-link-custom">
                <i class="bi bi-box-seam-fill"></i> Manajemen Produk
            </a>
            <a href="{{ route('admin.transactions.index') }}" class="nav-link-custom">
                <i class="bi bi-receipt"></i> Data Pesanan
            </a>
            
            <hr class="border-secondary my-3 mx-4">
            
            <a href="{{ route('home') }}" target="_blank" class="nav-link-custom">
                <i class="bi bi-shop"></i> Lihat Web Toko
            </a>
            
            <!-- Tombol Keluar Aman -->
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
                <h5 class="fw-bold m-0">Selamat Datang, Komandan!</h5>
                <small class="text-muted fw-bold">Berikut adalah ringkasan performa toko hari ini.</small>
            </div>
            <div class="d-flex align-items-center gap-3">
                <span class="badge bg-dark px-3 py-2 rounded-pill fw-bold"><i class="bi bi-shield-lock-fill me-1"></i> Admin Privileges</span>
            </div>
        </div>

        <!-- STATISTIK KOTAK (DINAMIS DARI DATABASE) -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon text-primary"><i class="bi bi-box-seam"></i></div>
                    <div>
                        <p class="stat-label">Total Produk</p>
                        <!-- Mengambil data dinamis total produk -->
                        <h3 class="stat-value">{{ number_format($totalProducts, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon text-success"><i class="bi bi-bag-check"></i></div>
                    <div>
                        <p class="stat-label">Pesanan Berhasil</p>
                        <!-- Mengambil data dinamis pesanan berhasil -->
                        <h3 class="stat-value">{{ number_format($successfulOrders, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stat-card">
                    <div class="stat-icon text-danger"><i class="bi bi-wallet2"></i></div>
                    <div>
                        <p class="stat-label">Total Pendapatan</p>
                        <!-- Mengambil data dinamis pendapatan dan format ke Rupiah -->
                        <h3 class="stat-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <!-- AREA KONTEN TAMBAHAN / GRAFIK -->
        <div class="bg-white p-5 border rounded-4 text-center">
            <i class="bi bi-bar-chart-line text-muted" style="font-size: 4rem;"></i>
            <h4 class="fw-bold mt-3">Area Grafik Penjualan</h4>
            <p class="text-muted">Siap diintegrasikan dengan fitur laporan penjualan lanjutan.</p>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>