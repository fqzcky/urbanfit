<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - UrbanFit</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="#">URBANFIT ADMIN</a>
            <div class="d-flex">
                <span class="navbar-text me-3 text-white">
                    Halo, {{ Auth::user()->name }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group shadow-sm">
                    <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action active bg-dark border-dark">
                        Dashboard Utama
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action">Kelola Produk</a>
                    <a href="{{ route('home') }}" class="list-group-item list-group-item-action text-primary" target="_blank">Lihat Website</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h4 class="fw-bold">Selamat Datang di Dapur UrbanFit!</h4>
                        <p class="text-muted">Di sini kamu bisa menambah, mengubah, dan menghapus data produk yang akan tampil di halaman depan pengunjung.</p>
                        <hr>
                        <div class="alert alert-success border-0 shadow-sm">
                            Sistem kelola produk sudah aktif! Silakan klik menu <strong>Kelola Produk</strong> di sebelah kiri untuk menambah, mengubah, atau menghapus data stok dari etalase.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>