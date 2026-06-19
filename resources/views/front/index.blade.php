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
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #fcfcfc;
            color: #1a1a1a;
            overflow-x: hidden;
            width: 100%;
        }

        /* CUSTOM SCROLLBAR PREMIUM */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0a0a0a; }
        ::-webkit-scrollbar-thumb { background: #e63329; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #ff4d4d; }

        /* DYNAMIC NAVBAR (BUNGLON) */
        .navbar-custom { 
            background-color: transparent !important; 
            border-bottom: 1px solid transparent; 
            transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
            padding-top: 1.8rem !important;
            padding-bottom: 1.8rem !important;
        }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        
        .navbar-custom.scrolled {
            background-color: rgba(5, 5, 5, 0.85) !important;
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
            padding-top: 1rem !important;
            padding-bottom: 1rem !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        /* HERO BANNER CONTAINER FULL EDGE-TO-EDGE */
        .hero-banner {
            background: #000000;
            border-radius: 0 !important; 
            overflow: hidden;
            position: relative;
            color: #ffffff;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            min-height: 90vh; 
            margin-top: -110px; 
            padding-top: 140px !important;
            display: flex;
            align-items: center;
        }
        
        .hero-bg-media {
            position: absolute;
            top: 0; left: 0; width: 100%; height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 2; 
        }
        
        /* GLASSMORPHISM HERO BOX */
        .hero-glass-box {
            background: rgba(10, 10, 10, 0.3);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            border-radius: 28px;
            padding: 3rem;
            max-width: 650px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
        }

        .hero-title { font-weight: 800; font-size: 3.5rem; line-height: 1.1; letter-spacing: -2px; }

        /* CSS ANIMASI FADE-UP */
        .hero-animate { opacity: 0; transform: translateY(30px); animation: smoothFadeUp 1s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; }
        .delay-1 { animation-delay: 0.2s; } .delay-2 { animation-delay: 0.4s; } .delay-3 { animation-delay: 0.6s; }
        @keyframes smoothFadeUp { to { opacity: 1; transform: translateY(0); } }

        /* TICKER MERAH */
        .scrolling-ticker {
            background-color: #e63329; 
            overflow: hidden;
            white-space: nowrap;
            padding: 14px 0;
            margin: 3rem 0;
            border-radius: 16px;
            box-shadow: 0 8px 25px rgba(230, 51, 41, 0.25);
        }
        .ticker-content {
            display: inline-block;
            font-family: 'Bebas Neue', sans-serif; 
            font-size: 1.2rem;
            letter-spacing: 3px;
            color: #ffffff;
            animation: marquee 35s linear infinite;
        }
        @keyframes marquee { 0% { transform: translateX(100vw); } 100% { transform: translateX(-100%); } }

        /* Category Filter & Search Input */
        .btn-filter { font-weight: 700; font-size: 0.85rem; transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1); border: 1px solid #e0e0e0; background-color: #fff; color: #1a1a1a; text-transform: uppercase; letter-spacing: 0.5px; }
        .btn-filter:hover, .btn-filter.active { background-color: #000000; border-color: #000000; color: #ffffff; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .search-custom { border: 1.5px solid #e0e0e0; padding-left: 1.5rem; font-weight: 500; transition: 0.3s; }
        .search-custom:focus { border-color: #000; box-shadow: 0 0 0 4px rgba(0,0,0,0.05); }

        /* PRODUCT CARD & TOMBOL PANAH */
        .product-card-wrapper { transition: transform 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .product-card-wrapper:hover { transform: translateY(-10px); }
        .card-box { border: 1px solid #f0f0f0; background: #ffffff; border-radius: 24px; overflow: hidden; height: 100%; display: flex; flex-direction: column; transition: box-shadow 0.4s ease; }
        .product-card-wrapper:hover .card-box { box-shadow: 0 20px 40px rgba(0,0,0,0.08); }
        
        .img-container { position: relative; background-color: #f8f9fa; padding-bottom: 100%; overflow: hidden; }
        .img-container img { position: absolute; top: 0; left: 0; width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s cubic-bezier(0.165, 0.84, 0.44, 1); }
        .product-card-wrapper:hover .img-container img { transform: scale(1.08); }
        
        .badge-overlay { position: absolute; top: 18px; left: 18px; z-index: 2; display: flex; flex-direction: column; gap: 6px; }
        .badge-custom { font-size: 0.7rem; font-weight: 800; padding: 7px 14px; border-radius: 8px; text-transform: uppercase; letter-spacing: 0.8px; backdrop-filter: blur(5px); }
        
        .card-info { padding: 24px; display: flex; flex-direction: column; flex-grow: 1; text-align: left; }
        .product-title { font-size: 1.05rem; font-weight: 800; color: #1a1a1a; margin-bottom: 15px; line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.9rem; }
        
        .card-footer-custom { display: flex; justify-content: space-between; align-items: center; margin-top: auto; }
        .product-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.6rem; letter-spacing: 0.5px; color: #000000; line-height: 1; margin: 0; }
        
        .arrow-btn { width: 42px; height: 42px; border-radius: 50%; background-color: #000000; color: #ffffff; display: flex; justify-content: center; align-items: center; font-size: 1.2rem; transition: background-color 0.3s, transform 0.3s; }
        .product-card-wrapper:hover .arrow-btn { background-color: #e63329; transform: rotate(-45deg); box-shadow: 0 5px 15px rgba(230, 51, 41, 0.3); }

        /* Pagination Style */
        .pagination-container nav > div.d-flex.justify-content-between.flex-fill.d-sm-none { display: none !important; }
        .pagination-container nav > div.d-none.flex-sm-fill.d-sm-flex.align-items-sm-center.justify-content-sm-between { display: flex !important; flex-direction: column-reverse !important; justify-content: center !important; align-items: center !important; gap: 15px; width: 100%; }
        .pagination-container nav p.small.text-muted { font-size: 0.85rem !important; color: #777777 !important; font-weight: 600; margin-bottom: 0 !important; text-align: center; }
        .pagination { gap: 6px; margin: 0 !important; padding: 0; }
        .pagination .page-item .page-link { border: 1.5px solid #e0e0e0; background-color: #ffffff; color: #1a1a1a; padding: 10px 18px; font-weight: 800; font-size: 0.9rem; border-radius: 12px !important; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
        .pagination .page-item .page-link:hover, .pagination .page-item.active .page-link { background-color: #000; border-color: #000; color: #fff; }
        .pagination .page-item.disabled .page-link { background-color: #f5f5f5; border-color: #e0e0e0; color: #999; }

        /* FOOTER STYLE */
        .footer-urban { background-color: #ffffff; color: #444; font-size: 0.9rem; margin-top: 5rem; border-top: 1px solid #eaeaea; }
        .footer-title { color: #000000; font-weight: 800; letter-spacing: -0.5px; margin-bottom: 1.5rem; font-size: 1.1rem; text-transform: uppercase; }
        .footer-list { list-style: none; padding: 0; margin: 0; }
        .footer-list li { margin-bottom: 10px; }
        .footer-list a { color: #666; text-decoration: none; transition: all 0.3s ease; font-weight: 500; }
        .footer-list a:hover { color: #e63329; padding-left: 5px; }
        .social-circle { display: inline-flex; justify-content: center; align-items: center; width: 40px; height: 40px; border-radius: 50%; background-color: #f0f0f0; color: #000; transition: 0.3s; text-decoration: none; border: 1px solid #eaeaea; }
        .social-circle:hover { background-color: #000; color: #fff; transform: translateY(-3px); }
        .payment-icon { height: 25px; margin-right: 8px; opacity: 0.8; transition: 0.3s; }
        .payment-icon:hover { opacity: 1; }

        /* FLOATING WHATSAPP */
        .wa-floating-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
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
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom fixed-top w-100">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            
            <div class="d-flex gap-2 align-items-center">
                <a href="{{ route('cart.index') }}" class="btn btn-outline-light position-relative rounded-pill px-4 fw-600 shadow-sm">
                    <i class="bi bi-bag-heart-fill me-1"></i> Keranjang
                    @if(session('cart') && count(session('cart')) > 0)
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-dark">
                            {{ count(session('cart')) }}
                        </span>
                    @endif
                </a>
                
                @auth
                    <a href="{{ route('user.orders') }}" class="btn btn-warning fw-bold rounded-pill px-3 shadow-sm">Riwayat Pesanan</a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-danger fw-bold rounded-pill px-3 shadow-sm">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-link text-white text-decoration-none fw-bold px-3">Masuk</a>
                    <a href="{{ route('register') }}" class="btn btn-light fw-bold rounded-pill px-4 shadow-sm">Daftar</a>
                @endauth
            </div>
        </div>
    </nav>

    @if(session('success'))
        <div style="position: fixed; top: 100px; left: 50%; transform: translateX(-50%); z-index: 1050; width: 100%; max-width: 600px; padding: 0 15px; animation: slideDown 0.4s ease forwards;">
            <div class="alert alert-dark alert-dismissible fade show fw-bold rounded-4 shadow-lg border border-secondary d-flex align-items-center gap-2 m-0 text-white" role="alert">
                <i class="bi bi-stars text-warning fs-5"></i> 
                {{ session('success') }}
                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
        <style>
            @keyframes slideDown {
                from { opacity: 0; transform: translate(-50%, -20px); }
                to { opacity: 1; transform: translate(-50%, 0); }
            }
        </style>
    @endif

    <div class="container-fluid p-0 m-0 overflow-hidden">
        <div class="hero-banner p-5 mb-0 text-md-start text-center">
    
            <video autoplay loop muted playsinline class="hero-bg-media">
                <source src="{{ asset('videos/15461246_3840_2160_30fps.mp4') }}" type="video/mp4">
                Browser Anda tidak mendukung tag video.
            </video>

            <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(180deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.2) 50%, rgba(0,0,0,0.8) 100%); z-index: 1;"></div>

            <div class="container hero-content m-auto">
                <div class="row py-4">
                    <div class="col-lg-8 ps-0">
                        <div class="hero-glass-box">
                            <span class="badge bg-danger text-uppercase fw-bold px-4 py-2 rounded-pill mb-4 hero-animate delay-1 shadow">Skena Retro & Streetwear</span>
                            <h1 class="hero-title mb-3 hero-animate delay-2">STEP INTO THE<br>STREETS STYLE.</h1>
                            <p class="text-light fs-5 mb-0 hero-animate delay-3 opacity-75" style="font-weight: 500;">Jelajahi rilisan terbaru sepatu running, basketball, dan casual sneakers pilihan terbaik untuk kultur urban modern.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <div class="container">
        <div class="scrolling-ticker">
            <div class="ticker-content">
                PREMIUM STREETWEAR CULTURE &nbsp;&nbsp;／&nbsp;&nbsp; LIMITED STOCK AVAILABLE &nbsp;&nbsp;／&nbsp;&nbsp; FAST DELIVERY &nbsp;&nbsp;／&nbsp;&nbsp; 100% ORIGINAL GUARANTEED &nbsp;&nbsp;／&nbsp;&nbsp; SECURE PAYMENT &nbsp;&nbsp;／&nbsp;&nbsp; PREMIUM STREETWEAR CULTURE &nbsp;&nbsp;／&nbsp;&nbsp; LIMITED STOCK AVAILABLE &nbsp;&nbsp;／&nbsp;&nbsp; FAST DELIVERY &nbsp;&nbsp;／&nbsp;&nbsp; 100% ORIGINAL GUARANTEED &nbsp;&nbsp;／&nbsp;&nbsp; SECURE PAYMENT &nbsp;&nbsp;／&nbsp;&nbsp;
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
                    <img src="https://avatars.githubusercontent.com/u/10416954?s=200&v=4" alt="Midtrans" class="payment-icon bg-light p-1 border rounded" style="height: 25px; object-fit: contain;">
                    <span class="badge bg-light text-dark border">BCA</span>
                    <span class="badge bg-light text-dark border">Mandiri</span>
                    <span class="badge bg-light text-dark border">GoPay</span>
                    <span class="badge bg-light text-dark border">ShopeePay</span>
                </div>
            </div>
        </div>
    </footer>

    <a href="https://wa.me/6281234567890?text=Halo%20Admin%20Urban%20Sneakers,%20saya%20mau%20tanya%20tentang%20sepatu..." target="_blank" class="wa-floating-btn" data-aos="zoom-in" data-aos-offset="0">
        <i class="bi bi-whatsapp"></i>
    </a>

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

        // JAVASCRIPT UNTUK NAVBAR BUNGLON DYNAMIC
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 60) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    </script>
</body>
</html>