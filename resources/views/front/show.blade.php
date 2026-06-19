<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        html, body {
            margin: 0 !important;
            padding: 0 !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfc;
            color: #1a1a1a;
        }

        /* Navbar Style (Sama dengan Index) */
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }

        /* Breadcrumb Premium */
        .breadcrumb { font-weight: 600; font-size: 0.9rem; }
        .breadcrumb-item a { color: #888; transition: color 0.2s; }
        .breadcrumb-item a:hover { color: #000; }

        /* Gallery Styling */
        .gallery-main {
            background-color: #f4f4f4;
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            padding-bottom: 100%; /* 1:1 Aspect Ratio */
        }
        .gallery-main img {
            position: absolute;
            top: 0; left: 0;
            width: 100%; height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }
        .gallery-main:hover img {
            transform: scale(1.05); /* Efek Zoom saat dihover */
        }
        
        .thumbnail-img {
            background-color: #f4f4f4;
            border-radius: 16px;
            height: 100px;
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            opacity: 0.6;
        }
        .thumbnail-img:hover { opacity: 1; }
        .thumbnail-active {
            opacity: 1;
            border: 2px solid #000000;
        }

        /* Product Info Styling */
        .product-title {
            font-weight: 800;
            font-size: 2.5rem;
            line-height: 1.2;
            letter-spacing: -1px;
            margin-bottom: 15px;
        }
        .product-price {
            font-weight: 800;
            font-size: 1.8rem;
            color: #000000;
        }
        .desc-text {
            color: #666;
            line-height: 1.8;
            font-size: 1.05rem;
        }

        /* Premium Size Selector (Tile Style) */
        .size-selector input[type="radio"] { display: none; }
        .size-label {
            display: inline-block;
            border: 1.5px solid #e0e0e0;
            background-color: #fff;
            color: #1a1a1a;
            font-weight: 700;
            font-size: 1rem;
            padding: 12px 0;
            width: 70px;
            text-align: center;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .size-label:hover { border-color: #000; }
        .size-selector input[type="radio"]:checked + .size-label {
            background-color: #000000;
            border-color: #000000;
            color: #ffffff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        }

        /* Related Products (Sama dengan Index) */
        .product-card-wrapper { transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .product-card-wrapper:hover { transform: translateY(-8px); }
        .card-box {
            border: 1px solid #f0f0f0;
            background: #ffffff;
            border-radius: 20px;
            overflow: hidden;
            height: 100%; display: flex; flex-direction: column;
            transition: box-shadow 0.4s ease;
        }
        .product-card-wrapper:hover .card-box { box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
        .img-container { position: relative; background-color: #f8f9fa; padding-bottom: 100%; overflow: hidden; }
        .img-container img {
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover; transition: transform 0.6s ease;
        }
        .product-card-wrapper:hover .img-container img { transform: scale(1.06); }
        .card-info { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; }

        /* STYLE KHUSUS KARTU PRODUK SERUPA (Sama dengan Halaman Utama) */
        .product-card-wrapper { transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); text-decoration: none !important; }
        .product-card-wrapper:hover { transform: translateY(-8px); }
        .card-box { border: 1px solid #f0f0f0; background: #ffffff; border-radius: 20px; overflow: hidden; height: 100%; display: flex; flex-direction: column; transition: box-shadow 0.4s ease; }
        .product-card-wrapper:hover .card-box { box-shadow: 0 15px 30px rgba(0,0,0,0.08); }
        .img-container { position: relative; background-color: #f8f9fa; padding-bottom: 100%; overflow: hidden; }
        .img-container img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .product-card-wrapper:hover .img-container img { transform: scale(1.06); }
        .badge-overlay { position: absolute; top: 15px; left: 15px; z-index: 2; display: flex; flex-direction: column; gap: 5px; }
        .badge-custom { font-size: 0.75rem; font-weight: 700; padding: 6px 12px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.5px; }
        .card-info { padding: 20px; display: flex; flex-direction: column; flex-grow: 1; text-align: left; }
        .product-title { font-size: 1rem; font-weight: 700; color: #1a1a1a; margin-bottom: 12px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.8rem; }
        .card-footer-custom { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
        .product-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.5px; color: #000000; line-height: 1; margin: 0; }
        .arrow-btn { width: 38px; height: 38px; border-radius: 50%; background-color: #000000; color: #ffffff; display: flex; justify-content: center; align-items: center; font-size: 1.1rem; transition: background-color 0.3s, transform 0.3s; }
        .product-card-wrapper:hover .arrow-btn { background-color: #e63329; transform: rotate(-45deg); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 sticky-top shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative rounded-pill px-4 fw-bold">
                    <i class="bi bi-bag-heart-fill me-1"></i> Keranjang
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-dark">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
                
                @auth
                    <a href="{{ route('user.orders') }}" class="btn btn-warning fw-bold rounded-pill px-3">Riwayat Pesanan</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger fw-bold rounded-pill px-3">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link text-white text-decoration-none fw-bold px-3">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-light fw-bold rounded-pill px-4">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Katalog</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home', ['kategori' => $product->category->slug]) }}" class="text-decoration-none">{{ $product->category->name }}</a></li>
                <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="row g-5">
            <div class="col-lg-6">
                <div class="gallery-main mb-3">
                    <img id="mainImage" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                </div>
                
                <div class="row g-2">
                    <div class="col-3">
                        <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid w-100 thumbnail-img thumbnail-active" onclick="changeImage(this, '{{ asset('storage/' . $product->image) }}')" alt="Angle 1">
                    </div>
                    @foreach($product->galleries as $gallery)
                    <div class="col-3">
                        <img src="{{ asset('storage/' . $gallery->image) }}" class="img-fluid w-100 thumbnail-img" onclick="changeImage(this, '{{ asset('storage/' . $gallery->image) }}')" alt="Angle Tambahan">
                    </div>
                    @endforeach
                </div>
            </div>
            
            <div class="col-lg-6 d-flex flex-column pt-3">
                <div class="d-flex gap-2 mb-3">
                    <span class="badge bg-dark px-3 py-2 rounded-pill shadow-sm" style="letter-spacing: 1px;">{{ strtoupper($product->category->name) }}</span>
                    <span class="badge bg-white border border-dark text-dark px-3 py-2 rounded-pill shadow-sm" style="letter-spacing: 1px;">{{ strtoupper($product->gender) }}</span>
                </div>
                
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-price mb-4">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                
                <p class="desc-text mb-4">
                    {{ $product->description ?? 'Koleksi esensial dengan material premium dan siluet modern yang dirancang untuk kenyamanan maksimal dan ketahanan di lingkungan urban.' }}
                </p>
                
                <div class="d-flex align-items-center mb-5">
                    <span class="fw-bold me-2">Status:</span>
                    @if($product->stock > 10)
                        <span class="badge bg-success bg-opacity-10 text-success border border-success px-3 py-2 rounded-pill"><i class="bi bi-check-circle-fill me-1"></i> Tersedia ({{ $product->stock }})</span>
                    @elseif($product->stock > 0)
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning px-3 py-2 rounded-pill"><i class="bi bi-exclamation-circle-fill me-1"></i> Sisa {{ $product->stock }} Pasang</span>
                    @else
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger px-3 py-2 rounded-pill"><i class="bi bi-x-circle-fill me-1"></i> Sold Out</span>
                    @endif
                </div>

                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="mt-auto">
                    @csrf
                    
                    <div class="d-flex justify-content-between align-items-end mb-3">
                        <h6 class="fw-bold m-0">Pilih Ukuran (EU)</h6>
                        <a href="#" class="text-muted small text-decoration-none text-decoration-underline" data-bs-toggle="modal" data-bs-target="#sizeGuideModal">Lihat Panduan Ukuran</a>
                    </div>
                    
                    <div class="size-selector d-flex gap-2 flex-wrap mb-4">
                        @if(is_array($product->sizes) && count($product->sizes) > 0)
                            @foreach($product->sizes as $size)
                                <div>
                                    <input type="radio" name="size" id="size_{{ $size }}" value="{{ $size }}" required>
                                    <label class="size-label shadow-sm" for="size_{{ $size }}">{{ $size }}</label>
                                </div>
                            @endforeach
                        @else
                            <div class="w-100 p-3 bg-light rounded-3 text-muted text-center fw-bold border">
                                Ukuran belum dikonfigurasi admin.
                            </div>
                        @endif
                    </div>

                    <div class="mt-2">
                        @if($product->stock > 0)
                            @if(is_array($product->sizes) && count($product->sizes) > 0)
                                <button type="submit" class="btn btn-dark btn-lg w-100 py-3 fw-bold rounded-pill shadow-sm" style="font-size: 1.1rem; transition: all 0.3s;">
                                    <i class="bi bi-cart-plus-fill me-2"></i> Tambahkan ke Keranjang
                                </button>
                            @else
                                <button type="button" class="btn btn-secondary btn-lg w-100 py-3 fw-bold rounded-pill" disabled>
                                    Ukuran Tidak Tersedia
                                </button>
                            @endif
                        @else
                            <button type="button" class="btn btn-outline-danger btn-lg w-100 py-3 fw-bold rounded-pill" disabled>
                                Produk Habis Terjual
                            </button>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div> 
    
    <div class="modal fade" id="sizeGuideModal" tabindex="-1" aria-labelledby="sizeGuideModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow-lg">
                <div class="modal-header border-bottom-0 pb-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold" id="sizeGuideModalLabel">Panduan Ukuran Sepatu</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <table class="table table-bordered text-center align-middle mb-0">
                        <thead class="table-light fw-bold">
                            <tr>
                                <th>EU</th>
                                <th>US (Men)</th>
                                <th>UK</th>
                                <th>CM (Panjang)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>39</td><td>6.5</td><td>6</td><td>24.5</td></tr>
                            <tr><td>40</td><td>7</td><td>6.5</td><td>25.0</td></tr>
                            <tr><td>41</td><td>8</td><td>7.5</td><td>26.0</td></tr>
                            <tr><td>42</td><td>8.5</td><td>8</td><td>26.5</td></tr>
                            <tr><td>43</td><td>9.5</td><td>9</td><td>27.5</td></tr>
                            <tr><td>44</td><td>10</td><td>9.5</td><td>28.0</td></tr>
                            <tr><td>45</td><td>11</td><td>10.5</td><td>29.0</td></tr>
                        </tbody>
                    </table>
                    <p class="text-muted small mt-3 mb-0">* Ini adalah panduan ukuran standar universal. Untuk model tertentu (seperti Nike Air Max atau seri ASICS Gel), disarankan untuk naik setengah ukuran (upsize).</p>
                </div>
            </div>
        </div>
    </div>

    <!-- ======================================================== -->
    <!-- SECTION PRODUK SERUPA (RELATED PRODUCTS)                 -->
    <!-- ======================================================== -->
    <div class="container my-5 pt-5 border-top">
        <div class="mb-4 text-start">
            <p class="text-uppercase text-muted small fw-bold mb-1" style="letter-spacing: 2px;">Mungkin Anda Suka</p>
            <h3 class="fw-extrabold text-dark" style="font-family: 'Plus Jakarta Sans'; font-weight: 800; letter-spacing: -1px;">PRODUK SERUPA</h3>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            @forelse ($relatedProducts as $index => $related)
            <div class="col product-card-wrapper" data-aos="fade-up" data-aos-delay="{{ $index * 100 }}">
                <a href="{{ route('product.show', $related->id) }}" class="text-decoration-none">
                    <div class="card-box">
                        <div class="img-container">
                            <div class="badge-overlay">
                                <span class="badge-custom bg-dark text-white shadow-sm">{{ $related->category->name }}</span>
                                <span class="badge-custom bg-white text-dark border border-light shadow-sm">
                                @php
                                $genderLabel = strtoupper($related->gender);
                                if($genderLabel == 'PRIA') $genderLabel = 'MEN';
                                if($genderLabel == 'WANITA') $genderLabel = 'WOMEN';
                                @endphp
                                {{ $genderLabel }}
                                </span>
                            </div>
                            <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}">
                        </div>
                        
                        <div class="card-info">
                            <h6 class="product-title" title="{{ $related->name }}">{{ $related->name }}</h6>
                            
                            <div class="card-footer-custom border-top pt-3">
                                <div class="product-price">Rp {{ number_format($related->price, 0, ',', '.') }}</div>
                                <div class="arrow-btn"><i class="bi bi-arrow-right-short"></i></div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            
            @empty
            <!-- State kalau tidak ada produk lain di kategori yang sama -->
            <div class="col-12 py-4">
                <p class="text-muted small italic">Belum ada koleksi produk serupa lainnya untuk kategori ini.</p>
            </div>
            @endforelse
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function changeImage(element, newSrc) {
            document.getElementById('mainImage').src = newSrc;
            
            let thumbnails = document.getElementsByClassName('thumbnail-img');
            for(let i = 0; i < thumbnails.length; i++) {
                thumbnails[i].classList.remove('thumbnail-active');
            }
            element.classList.add('thumbnail-active');
        }
    </script>

    <a href="https://wa.me/6288229978003?text=Halo%20Admin%20Urban%20Sneakers,%20saya%20mau%20tanya%20tentang%20sepatu..." target="_blank" class="wa-floating-btn" data-aos="zoom-in" data-aos-offset="0">
        <i class="bi bi-whatsapp"></i>
    </a>

    <style>
        .wa-floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366; /* Hijau Khas WhatsApp */
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            box-shadow: 0 10px 20px rgba(37, 211, 102, 0.4);
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        }
        .wa-floating-btn:hover {
            transform: translateY(-5px) scale(1.05);
            color: white;
            box-shadow: 0 15px 25px rgba(37, 211, 102, 0.5);
        }
    </style>
</body>
</html>