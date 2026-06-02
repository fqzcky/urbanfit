<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Urban Sneakers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .thumbnail-img { height: 100px; object-fit: cover; cursor: pointer; transition: 0.3s; opacity: 0.6; }
        .thumbnail-img:hover, .thumbnail-active { opacity: 1; border: 2px solid #212529; }
        .related-img { height: 200px; object-fit: cover; }
        .card-hover:hover { transform: translateY(-5px); box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important; transition: 0.3s; }
    </style>
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark py-3 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">URBAN SNEAKERS.</a>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none text-muted">Katalog</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home', ['kategori' => $product->category->slug]) }}" class="text-decoration-none text-muted">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active fw-bold" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row bg-white p-4 p-md-5 rounded-4 shadow-sm border-0">
            <!-- Sisi Kiri: Galeri Foto -->
            <div class="col-md-6 mb-4 mb-md-0">
                <!-- Gambar Utama -->
                <div class="mb-3 rounded-4 overflow-hidden border">
                    <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100" style="object-fit: cover; height: 500px;" alt="{{ $product->name }}">
                </div>
                
                <!-- Layout Thumbnail Dinamis -->
                <div class="row g-2">
                    <!-- Thumbnail 1: Foto Utama (Bawaan) -->
                    <div class="col-3">
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100 h-100 rounded-3 thumbnail-img thumbnail-active" onclick="changeImage(this, '{{ asset('storage/' . $product->image) }}')" alt="Angle 1">
                    </div>
                    
                    <!-- Thumbnail 2, 3, dst: Dari Tabel Galleries -->
                    @foreach($product->galleries as $gallery)
                    <div class="col-3">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="img-fluid w-100 h-100 rounded-3 thumbnail-img" onclick="changeImage(this, '{{ asset('storage/' . $gallery->image) }}')" alt="Angle Tambahan">
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="col-md-6 d-flex flex-column justify-content-center px-md-5">
                <span class="badge bg-dark w-auto mb-3 px-3 py-2" style="width: fit-content; letter-spacing: 1px;">{{ strtoupper($product->category->name) }}</span>
                <h1 class="fw-bold mb-3 display-6">{{ $product->name }}</h1>
                <h2 class="text-danger fw-bold mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</h2>
                
                <hr class="text-muted">
                
                <h6 class="fw-bold mt-2">Deskripsi Produk</h6>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    {{ $product->description ?? 'Koleksi esensial dengan material premium dan potongan yang dirancang untuk kenyamanan maksimal sepanjang hari.' }}
                </p>
                
                <div class="mb-4 bg-light p-3 rounded-3 border">
                    <span class="text-muted">Ketersediaan:</span> 
                    @if($product->stock > 10)
                        <span class="text-success fw-bold ms-2"><i class="bi bi-check-circle-fill"></i> In Stock ({{ $product->stock }})</span>
                    @elseif($product->stock > 0)
                        <span class="text-warning fw-bold ms-2">Hampir Habis! Sisa {{ $product->stock }}</span>
                    @else
                        <span class="text-danger fw-bold ms-2">Sold Out</span>
                    @endif
                </div>

                <div class="d-grid gap-2 d-md-flex mt-2">
                    @if($product->stock > 0)
                        <button class="btn btn-dark btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm w-100">
                            Masukkan Keranjang
                        </button>
                    @else
                        <button class="btn btn-secondary btn-lg px-5 py-3 fw-bold rounded-pill w-100" disabled>
                            Stok Habis
                        </button>
                    @endif
                </div>
            </div>
        </div>

        @if($relatedProducts->count() > 0)
        <div class="mt-5 pt-5 border-top">
            <h4 class="fw-bold mb-4">Mungkin Kamu Juga Suka</h4>
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach($relatedProducts as $related)
                <div class="col">
                    <a href="{{ route('product.show', $related->id) }}" class="text-decoration-none text-dark">
                        <div class="card h-100 shadow-sm border-0 rounded-4 card-hover">
                            <img src="{{ asset('storage/' . $related->image) }}" class="card-img-top related-img rounded-top-4" alt="{{ $related->name }}">
                            <div class="card-body text-center p-3">
                                <h6 class="card-title fw-bold text-truncate m-0" style="font-size: 0.9rem;">{{ $related->name }}</h6>
                                <p class="card-text text-danger fw-bold mt-1 mb-0" style="font-size: 0.9rem;">Rp {{ number_format($related->price, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
<script>
        function changeImage(element, newSrc) {
            // 1. Ubah gambar utama ke gambar yang diklik
            document.getElementById('mainImage').src = newSrc;
            
            // 2. Hapus border hitam dari semua thumbnail
            let thumbnails = document.getElementsByClassName('thumbnail-img');
            for(let i = 0; i < thumbnails.length; i++) {
                thumbnails[i].classList.remove('thumbnail-active');
            }
            
            // 3. Tambahkan border hitam ke thumbnail yang sedang diklik
            element.classList.add('thumbnail-active');
        }
    </script>
</body>
</html>
</body>
</html>