<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Urban Sneakers - Katalog Sepatu Premium</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfc;
            color: #1a1a1a;
            overflow-x: hidden;
            width: 100%;
        }

        /* Navbar Style */
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }

        /* ======================================================== */
        /* HERO BANNER (DIPERSIAPKAN UNTUK GAMBAR/VIDEO LOKAL)      */
        /* ======================================================== */
        .hero-banner {
            background: linear-gradient(135deg, #111111 0%, #222222 100%); /* Warna fallback */
            border-radius: 24px;
            overflow: hidden;
            position: relative;
            color: #ffffff;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            min-height: 400px; /* Tinggi minimum area hero */
        }
        
        /* UNTUK MEMASANG GAMBAR/VIDEO BACKGROUND LOKAL:
           Hapus display: none; pada class di bawah ini jika kamu sudah menaruh file di folder public/images/
        */
        .hero-bg-media {
            display: none; /* <--- HAPUS BARIS INI JIKA MAU PAKAI FOTO/VIDEO SENDIRI */
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            z-index: 0;
            opacity: 0.6; /* Membuat gambar sedikit gelap agar teks terbaca */
        }

        .hero-content {
            position: relative;
            z-index: 2; /* Memastikan teks selalu berada di atas gambar/video */
        }
        
        .hero-title { font-weight: 800; font-size: 3.5rem; line-height: 1.1; letter-spacing: -2px; }

        /* CSS ANIMASI FADE-UP HALUS HEADER */
        .hero-animate { opacity: 0; transform: translateY(30px); animation: smoothFadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .delay-1 { animation-delay: 0.2s; } .delay-2 { animation-delay: 0.4s; } .delay-3 { animation-delay: 0.6s; }
        @keyframes smoothFadeUp { to { opacity: 1; transform: translateY(0); } }

        /* ======================================================== */
        /* ADOPSI CLAUDE 1: TICKER MERAH MEMANJANG                  */
        /* ======================================================== */
        .scrolling-ticker {
            background-color: #e63329; /* Merah aksen Claude */
            overflow: hidden;
            white-space: nowrap;
            padding: 12px 0;
            margin: 1.5rem 0 3rem 0;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(230, 51, 41, 0.2);
        }
        .ticker-content {
            display: inline-block;
            font-family: 'Bebas Neue', sans-serif; /* Font tegas */
            font-size: 1.1rem;
            letter-spacing: 3px;
            color: #ffffff;
            animation: marquee 30s linear infinite;
        }
        @keyframes marquee { 0% { transform: translateX(100vw); } 100% { transform: translateX(-100%); } }

        /* Category Filter & Search Input */
        .btn-filter { font-weight: 600; font-size: 0.9rem; transition: all 0.25s ease; border: 1px solid #e0e0e0; background-color: #fff; color: #1a1a1a; }
        .btn-filter:hover, .btn-filter.active { background-color: #000000; border-color: #000000; color: #ffffff; }
        .search-custom { border: 1px solid #e0e0e0; padding-left: 1.5rem; font-weight: 500; }
        .search-custom:focus { border-color: #000; box-shadow: none; }

        /* ======================================================== */
        /* PRODUCT CARD & ADOPSI CLAUDE 2: TOMBOL PANAH             */
        /* ======================================================== */
        .product-card-wrapper { transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
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
        
        /* Area Bawah Kartu (Harga & Tombol Panah) */
        .card-footer-custom { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
        .product-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.4rem; letter-spacing: 0.5px; color: #000000; line-height: 1; margin: 0; }
        
        /* Tombol Bulat Panah Kanan Claude */
        .arrow-btn {
            width: 38px; height: 38px; border-radius: 50%;
            background-color: #000000; color: #ffffff;
            display: flex; justify-content: center; align-items: center;
            font-size: 1.1rem; transition: background-color 0.3s, transform 0.3s;
        }
        .product-card-wrapper:hover .arrow-btn { background-color: #e63329; transform: rotate(-45deg); } /* Efek hover panah menukik merah */

        /* Pagination Style */
        .pagination-container nav > div.d-flex.justify-content-between.flex-fill.d-sm-none { display: none !important; }
        .pagination-container nav > div.d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between { display: flex !important; flex-direction: column-reverse !important; justify-content: center !important; align-items: center !important; gap: 15px; width: 100%; }
        .pagination-container nav p.small.text-muted { font-size: 0.85rem !important; color: #777777 !important; font-weight: 600; margin-bottom: 0 !important; text-align: center; }
        .pagination { gap: 6px; margin: 0 !important; padding: 0; }
        .pagination .page-item .page-link { border: 1px solid #e0e0e0; background-color: #ffffff; color: #1a1a1a; padding: 10px 18px; font-weight: 700; font-size: 0.9rem; border-radius: 12px !important; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .pagination .page-item .page-link:hover, .pagination .page-item.active .page-link { background-color: #000; border-color: #000; color: #fff; }
        .pagination .page-item.disabled .page-link { background-color: #f5f5f5; border-color: #e0e0e0; color: #999; }

        /* ======================================================== */
        /* FOOTER JD SPORTS (Versi Terang / Clean Style)            */
        /* ======================================================== */
        .footer-urban {
            background-color: #ffffff; /* Footer putih/terang */
            color: #444;
            font-size: 0.9rem;
            margin-top: 5rem;
            border-top: 1px solid #eaeaea;
        }
        .footer-title { color: #000000; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 1.5rem; font-size: 1.1rem; text-transform: uppercase; }
        .footer-list { list-style: none; padding: 0; margin: 0; }
        .footer-list li { margin-bottom: 10px; }
        .footer-list a { color: #666; text-decoration: none; transition: all 0.3s ease; font-weight: 500; }
        .footer-list a:hover { color: #e63329; padding-left: 5px; } /* Hover warna merah aksen */
        .social-circle {
            display: inline-flex; justify-content: center; align-items: center; width: 40px; height: 40px; border-radius: 50%;
            background-color: #f0f0f0; color: #000; transition: 0.3s; text-decoration: none; border: 1px solid #eaeaea;
        }
        .social-circle:hover { background-color: #000; color: #fff; transform: translateY(-3px); }
        .payment-icon { height: 25px; margin-right: 8px; opacity: 0.8; transition: 0.3s; }
        .payment-icon:hover { opacity: 1; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 sticky-top shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative rounded-pill px-4 fw-600">
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

    @if(session('success'))
        <div class="container mt-4">
            <div class="alert alert-success alert-dismissible fade show fw-bold rounded-4 shadow-sm border-0 bg-dark text-white d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-stars text-warning fs-5"></i> 
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    @endif

    <div class="container mt-4">
        
        <!-- ======================================================== -->
        <!-- HERO BANNER DENGAN BACKGROUND VIDEO LOKAL                -->
        <!-- ======================================================== -->
        <div class="hero-banner p-5 mb-4 text-md-start text-center d-flex align-items-center">
            
            <!-- LAYER 1: VIDEO BACKGROUND -->
            <video autoplay loop muted playsinline class="hero-bg-media" style="display: block;">
                <source src="{{ asset('videos/15461246_3840_2160_30fps.mp4') }}" type="video/mp4">
            </video>

            <!-- LAYER 2: EFEK KACA FILM GELAP (Agar Teks Terbaca) -->
            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.5); z-index: 1;"></div>

            <!-- LAYER 3: TEKS HEADER (Z-Index: 2 membuatnya berada di atas video) -->
            <div class="row align-items-center py-4 hero-content w-100 m-0" style="z-index: 2; position: relative;">
                <div class="col-lg-7 ps-0">
                    <span class="badge bg-danger text-uppercase fw-bold px-3 py-2 rounded-3 mb-3 hero-animate delay-1">Skena Retro & Streetwear</span>
                    <h1 class="hero-title mb-3 hero-animate delay-2">STEP INTO THE<br>STREETS STYLE.</h1>
                    <p class="text-light fs-5 mb-0 hero-animate delay-3 opacity-75">Jelajahi rilisan terbaru sepatu running, basketball, dan casual sneakers pilihan terbaik untuk kultur urban modern.</p>
                </div>
            </div>
            
        </div>
        
        <div class="scrolling-ticker">
            <div class="ticker-content">
                PREMIUM STREETWEAR CULTURE &nbsp;&nbsp;／&nbsp;&nbsp; LIMITED STOCK AVAILABLE &nbsp;&nbsp;／&nbsp;&nbsp; FAST DELIVERY &nbsp;&nbsp;／&nbsp;&nbsp; FREE SHIPPING PULAU JAWA &nbsp;&nbsp;／&nbsp;&nbsp; 100% ORIGINAL GUARANTEED &nbsp;&nbsp;／&nbsp;&nbsp; PREMIUM STREETWEAR CULTURE &nbsp;&nbsp;／&nbsp;&nbsp; LIMITED STOCK AVAILABLE &nbsp;&nbsp;／&nbsp;&nbsp; FAST DELIVERY &nbsp;&nbsp;／&nbsp;&nbsp; FREE SHIPPING PULAU JAWA &nbsp;&nbsp;／&nbsp;&nbsp;
            </div>
        </div>

        <div class="row justify-content-between align-items-center mb-5 g-3">
            <div class="col-md-8">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('home') }}" class="btn btn-filter rounded-pill px-4 py-2 {{ !request('kategori') ? 'active' : '' }}">
                        Semua Koleksi
                    </a>
                    @foreach($categories as $category)
                        <a href="{{ route('home', ['kategori' => $category->slug]) }}" 
                           class="btn btn-filter rounded-pill px-4 py-2 {{ request('kategori') == $category->slug ? 'active' : '' }}">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="col-md-4">
                <form action="{{ route('home') }}" method="GET" class="input-group">
                    @if(request('kategori'))
                        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
                    @endif
                    <input type="text" name="search" class="form-control search-custom rounded-start-pill py-2" placeholder="Cari model sneakers..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-dark rounded-end-pill px-4"><i class="bi bi-search"></i></button>
                </form>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-5">
            @forelse ($products as $index => $product)
            <div class="col product-card-wrapper" data-aos="fade-up" data-aos-delay="{{ ($index % 4) * 100 }}">
                <a href="{{ route('product.show', $product->id) }}" class="text-decoration-none">
                    <div class="card-box">
                        <div class="img-container">
                            <div class="badge-overlay">
                                <span class="badge-custom bg-dark text-white shadow-sm">{{ $product->category->name }}</span>
                                <span class="badge-custom bg-white text-dark border border-light shadow-sm">
                                @php
                                $genderLabel = strtoupper($product->gender);
                                if($genderLabel == 'PRIA') $genderLabel = 'MEN';
                                if($genderLabel == 'WANITA') $genderLabel = 'WOMEN';
                                @endphp
                                {{ $genderLabel }}
                                </span>
                            </div>
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        </div>
                        
                        <div class="card-info">
                            <h6 class="product-title" title="{{ $product->name }}">{{ $product->name }}</h6>
                            
                            <div class="card-footer-custom border-top pt-3">
                                <div class="product-price">Rp {{ number_format($product->price, 0, ',', '.') }}</div>
                                <div class="arrow-btn"><i class="bi bi-arrow-right-short"></i></div>
                            </div>
                            
                        </div>
                    </div>
                </a>
            </div>
            
            @empty
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <div class="text-muted mb-3 fs-1"><i class="bi bi-emoji-frown"></i></div>
                <h5 class="fw-bold text-secondary">Sneakers Tidak Ditemukan</h5>
                <p class="text-muted small">Coba gunakan kata kunci lain atau bersihkan filter pencarian kamu.</p>
                <a href="{{ route('home') }}" class="btn btn-dark mt-2 rounded-pill px-4 fw-bold">Reset Filter</a>
            </div>
            @endforelse
        </div>

        <div class="pagination-container mt-5 mb-5" data-aos="fade-up" data-aos-offset="0">
            {{ $products->links('pagination::bootstrap-5') }}
        </div>
    </div>

    <footer class="footer-urban pb-4">
        <div class="container pt-5">
            <div class="row g-5 mb-5">
                
                <div class="col-lg-4 col-md-6">
                    <h5 class="footer-title">Hubungi Kami</h5>
                    <p class="mb-1 fw-bold text-dark">Jam Operasional</p>
                    <p class="mb-4 text-muted small">Senin - Minggu : Jam 09:00 - 18:00 WIB<br>(termasuk hari libur nasional)</p>
                    
                    <p class="mb-1 fw-bold text-dark">Layanan Pengaduan Konsumen</p>
                    <p class="mb-1 text-muted small">PT Urban Sneakers Indonesia</p>
                    <ul class="footer-list small mb-4">
                        <li><i class="bi bi-telephone me-2"></i> Call Center : 1500888</li>
                        <li><i class="bi bi-whatsapp me-2"></i> WhatsApp : 0812 3456 7890</li>
                        <li><i class="bi bi-envelope me-2"></i> Email : cs@urbansneakers.id</li>
                    </ul>

                    <p class="mb-1 fw-bold text-dark">Direktorat Perlindungan Konsumen</p>
                    <p class="mb-1 text-muted small">Kementerian Perdagangan RI</p>
                    <p class="text-muted small"><i class="bi bi-whatsapp me-2"></i> WhatsApp : +62853 1111 1010</p>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Shopping With Urban</h5>
                    <ul class="footer-list">
                        <li><a href="#">Size Guide</a></li>
                        <li><a href="#">Find a Store</a></li>
                        <li><a href="#">Customer Care</a></li>
                        <li><a href="#">Delivery & Returns</a></li>
                        <li><a href="#">Payment Information</a></li>
                        <li><a href="#">Track My Order</a></li>
                        <li><a href="#">FAQ & Help</a></li>
                        <li><a href="#">Beware of Scams</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h5 class="footer-title">Information</h5>
                    <ul class="footer-list mb-4">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Career at Urban</a></li>
                        <li><a href="#">Store Location</a></li>
                        <li><a href="#">Sneaker Releases</a></li>
                    </ul>

                    <h5 class="footer-title">Legal</h5>
                    <ul class="footer-list">
                        <li><a href="#">Terms & Conditions</a></li>
                        <li><a href="#">Privacy & Cookies Policy</a></li>
                    </ul>
                </div>

                <div class="col-lg-2 col-md-6 text-lg-end">
                    <h5 class="footer-title">Follow Us</h5>
                    <div class="d-flex flex-lg-column gap-3 justify-content-lg-end align-items-lg-end">
                        <a href="#" class="social-circle"><i class="bi bi-instagram fs-5"></i></a>
                        <a href="#" class="social-circle"><i class="bi bi-tiktok fs-5"></i></a>
                        <a href="https://github.com/fqzcky" target="_blank" class="social-circle"><i class="bi bi-github fs-5"></i></a>
                    </div>
                </div>

            </div>

            <div class="border-top border-light-subtle pt-4 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                <small class="text-muted fw-bold">
                    Copyright &copy; 2026 Urban Sneakers by Faiq Zacky.
                </small>
                
                <div class="d-flex flex-wrap gap-3 align-items-center justify-content-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/8/86/Midtrans_Logo.png" alt="Midtrans" class="payment-icon bg-light p-1 border rounded" style="height: 25px;">
                    <span class="badge bg-light text-dark border">BCA</span>
                    <span class="badge bg-light text-dark border">Mandiri</span>
                    <span class="badge bg-light text-dark border">GoPay</span>
                    <span class="badge bg-light text-dark border">ShopeePay</span>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        window.addEventListener('load', function() {
            AOS.init({
                duration: 800,
                once: true,
                offset: 20,
                easing: 'ease-out-cubic',
                disable: 'mobile'
            });
        });
    </script>
</body>
</html>