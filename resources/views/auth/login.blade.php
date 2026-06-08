<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Urban Sneakers</title>
    
    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #fcfcfc; 
            color: #1a1a1a; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
        }
        .auth-card { 
            background: #fff; 
            border: 1px solid #eaeaea; 
            border-radius: 24px; 
            box-shadow: 0 15px 30px rgba(0,0,0,0.04); 
        }
        .form-custom { 
            border: 1.5px solid #eaeaea; 
            border-radius: 12px; 
            padding: 14px 20px; 
            font-weight: 500; 
            transition: 0.3s; 
        }
        .form-custom:focus { 
            border-color: #000; 
            box-shadow: 0 0 0 4px rgba(0,0,0,0.05); 
            outline: none; 
        }
        .brand-logo { 
            font-weight: 800; 
            font-size: 1.8rem; 
            letter-spacing: -1px; 
            text-decoration: none; 
            color: #000; 
            display: block; 
            margin-bottom: 30px; 
            text-align: center; 
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="auth-card p-4 p-md-5">
                    <a href="{{ route('home') }}" class="brand-logo">URBAN SNEAKERS.</a>
                    
                    <h4 class="fw-bold mb-1 text-center">Selamat Datang Kembali</h4>
                    <p class="text-muted text-center mb-4 small fw-bold">Masuk untuk melanjutkan belanja Anda.</p>
                    
                    <!-- Alert Jika Login Gagal -->
                    @if($errors->any())
                        <div class="alert alert-danger p-3 rounded-3 mb-4 fw-bold shadow-sm border-0 d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                            <i class="bi bi-exclamation-triangle-fill"></i> 
                            {{ $errors->first() }}
                        </div>
                    @endif

                    <!-- Alert Jika Sukses Register -->
                    @if(session('success'))
                        <div class="alert alert-success p-3 rounded-3 mb-4 fw-bold shadow-sm border-0 d-flex align-items-center gap-2" style="font-size: 0.9rem;">
                            <i class="bi bi-check-circle-fill"></i> 
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    <!-- Form Login -->
                    <form action="{{ url('/login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Terdaftar</label>
                            <input type="email" name="email" class="form-control form-custom" placeholder="nama@email.com" value="{{ old('email') }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <label class="form-label fw-bold small m-0">Password</label>
                                <!-- Placeholder untuk fitur Lupa Password (Level Lanjut nanti) -->
                                <a href="#" class="small text-muted text-decoration-none fw-bold" title="Fitur segera hadir!">Lupa Password?</a>
                            </div>
                            <input type="password" name="password" class="form-control form-custom" placeholder="Masukkan password Anda" required>
                        </div>
                        
                        <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold rounded-pill py-3">Masuk ke Akun</button>
                    </form>
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted fw-bold">Belum punya akun? <a href="{{ route('register') }}" class="text-dark text-decoration-underline">Daftar di sini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>