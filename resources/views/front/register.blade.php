<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Urban Sneakers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8f9fa; /* Disamakan dengan background global */
            color: #1a1a1a; 
            min-height: 100vh; 
            display: flex; 
            align-items: center; 
        }
        .auth-card { 
            background: #ffffff; 
            border: 1px solid #eaeaea; 
            border-radius: 24px; 
            box-shadow: 0 15px 30px rgba(0,0,0,0.04); 
        }
        .form-custom { 
            border: 1.5px solid #eaeaea; 
            border-radius: 12px; 
            padding: 14px 20px; 
            font-weight: 600; 
            transition: 0.3s; 
            background-color: #fdfdfd;
        }
        .form-custom:focus { 
            border-color: #000; 
            box-shadow: 0 0 0 4px rgba(0,0,0,0.05); 
            outline: none; 
            background-color: #ffffff;
        }
        .brand-logo { 
            font-weight: 800; 
            font-size: 2rem; 
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
                    
                    <h4 class="fw-extrabold mb-1 text-center" style="letter-spacing: -0.5px;">Buat Akun Baru</h4>
                    <p class="text-muted text-center mb-4 small fw-bold">Bergabunglah untuk pengalaman belanja lebih cepat.</p>
                    
                    <form action="{{ route('register.process') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control form-custom" placeholder="Nama sesuai KTP" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Email Aktif</label>
                            <input type="email" name="email" class="form-control form-custom" placeholder="nama@email.com" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold small">Password</label>
                            <input type="password" name="password" class="form-control form-custom" placeholder="Minimal 6 karakter" required>
                        </div>
                        <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold rounded-pill py-3 shadow-sm transition-all" style="font-size: 1.1rem;">Daftar Sekarang</button>
                    </form>
                    
                    <div class="text-center mt-4 pt-3 border-top">
                        <small class="text-muted fw-bold">Sudah punya akun? <a href="{{ route('login') }}" class="text-dark text-decoration-underline">Masuk di sini</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>