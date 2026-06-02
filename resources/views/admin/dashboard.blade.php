<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Urban Sneakers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow-sm mb-5">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">URBAN SNEAKERS ADMIN</a>
            <div class="d-flex">
                <a href="{{ route('admin.products.index') }}" class="btn btn-outline-light me-2 fw-bold">Kelola Produk</a>
                <a href="{{ route('home') }}" target="_blank" class="btn btn-light fw-bold">Lihat Web Klien</a>
            </div>
        </div>
    </nav>

    <div class="container mb-5">
        @php
            // Menghitung total ringkasan
            $totalProducts = \App\Models\Product::count();
            $totalCategories = \App\Models\Category::count();
            $lowStock = \App\Models\Product::where('stock', '<', 10)->count();

            // Mengambil data untuk grafik (Kategori beserta jumlah produknya)
            $categories = \App\Models\Category::withCount('products')->get();
            
            // Memisahkan nama kategori dan jumlahnya ke dalam format array untuk Chart.js
            $labels = $categories->pluck('name');
            $dataCounts = $categories->pluck('products_count');
        @endphp

        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <h6 class="text-muted fw-bold text-uppercase tracking-wide">Total Sepatu</h6>
                    <h2 class="display-4 fw-bold text-dark mt-2">{{ $totalProducts }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <h6 class="text-muted fw-bold text-uppercase tracking-wide">Kategori Aktif</h6>
                    <h2 class="display-4 fw-bold text-dark mt-2">{{ $totalCategories }}</h2>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4 text-center p-4 h-100">
                    <h6 class="text-muted fw-bold text-uppercase tracking-wide">Stok Menipis (< 10)</h6>
                    <h2 class="display-4 fw-bold text-danger mt-2">{{ $lowStock }}</h2>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4 text-center">Distribusi Katalog per Kategori</h5>
                    <canvas id="categoryChart" height="150"></canvas>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Menerima data dari PHP backend ke JavaScript frontend
        const chartLabels = {!! json_encode($labels) !!};
        const chartData = {!! json_encode($dataCounts) !!};

        // Konfigurasi Chart.js
        const ctx = document.getElementById('categoryChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Kamu bisa ubah ini menjadi 'doughnut' atau 'pie' nanti
            data: {
                labels: chartLabels,
                datasets: [{
                    label: 'Jumlah Model Sepatu',
                    data: chartData,
                    backgroundColor: [
                        'rgba(33, 37, 41, 0.85)',  // Hitam/Dark (Casual)
                        'rgba(220, 53, 69, 0.85)', // Merah (Basketball)
                        'rgba(25, 135, 84, 0.85)'  // Hijau (Running)
                    ],
                    borderColor: [
                        'rgba(33, 37, 41, 1)',
                        'rgba(220, 53, 69, 1)',
                        'rgba(25, 135, 84, 1)'
                    ],
                    borderWidth: 0,
                    borderRadius: 6 // Membuat ujung grafik batangnya melengkung elegan
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda agar lebih bersih
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1 // Angka Y-axis selalu bulat (bukan 0.5)
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>