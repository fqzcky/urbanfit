<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UrbanFit - Katalog Streetwear</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-img-top { height: 250px; object-fit: cover; background-color: #f8f9fa; }
        /* Fitur 4: Efek Hover - Bikin card sedikit terangkat saat disentuh mouse */
        .card-hover { transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; cursor: pointer; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">URBANFIT.</a>
        </div>
    </nav>

    <div class="container mt-5 mb-4 text-center">
        <h1 class="fw-bold display-5">Koleksi Terbaru</h1>
        <p class="text-muted">Jelajahi rilisan terbaru boxy tees, baggy denim, dan sneakers andalan kami.</p>
    </div>

    <div class="container mb-4">
        <div class="row justify-content-between align-items-center">
            <div class="col-md-8 mb-3 mb-md-0">
                <a href="{{ route('home') }}" class="btn {{ !request('kategori') ? 'btn-dark' : 'btn-outline-dark' }} me-2 mb-2 px-4 rounded-pill">Semua</a>
                @foreach($categories as $category)
                    <a href="{{ route('home', ['kategori' => $category->slug]) }}" 
                       class="btn {{ request('kategori') == $category->slug ? 'btn-dark' : 'btn-outline-dark' }} me-2 mb-2 px-4 rounded-pill">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>

            <div class="col-md-4">
                <form action="{{ route('home') }}" method="GET" class="d-flex">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <input type="text" name="search" class="form-control rounded-start-pill" placeholder="Cari nama produk..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-dark rounded-end-pill px-4">Cari</button>
                </form>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @forelse ($products as $product)
            <div class="col">
                <div class="card h-100 shadow-sm border-0 rounded-4 card-hover">
                    <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top rounded-top-4" alt="{{ $product->name }}">
                    <div class="card-body text-center">
                        <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
                        <h6 class="card-title fw-bold text-truncate" title="{{ $product->name }}">{{ $product->name }}</h6>
                        <p class="card-text text-danger fw-bold fs-5">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            
            @empty
            <div class="col-12 text-center py-5">
                <h3 class="text-muted mb-3">😕 Oops!</h3>
                <h5 class="text-secondary">Tidak ada produk yang ditemukan.</h5>
                <p class="text-muted">Coba gunakan kata kunci lain atau pilih kategori yang berbeda.</p>
                <a href="{{ route('home') }}" class="btn btn-outline-dark mt-3 px-4 rounded-pill">Reset Filter</a>
            </div>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $products->links() }}
        </div>
    </div>

</body>
</html>