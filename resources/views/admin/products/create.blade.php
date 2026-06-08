<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk Baru - Admin Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #f4f7f6; color: #1a1a1a; overflow-x: hidden; }
        
        /* SIDEBAR (Konsisten) */
        .sidebar { position: fixed; top: 0; left: 0; height: 100vh; width: 260px; background-color: #000000; color: #ffffff; padding-top: 30px; z-index: 1000; }
        .sidebar-brand { font-weight: 800; font-size: 1.5rem; letter-spacing: -1px; text-align: center; margin-bottom: 40px; display: block; color: #fff; text-decoration: none; }
        .nav-link-custom { color: #888888; font-weight: 600; padding: 12px 25px; display: flex; align-items: center; gap: 12px; text-decoration: none; transition: 0.2s; border-left: 4px solid transparent; }
        .nav-link-custom:hover, .nav-link-custom.active { color: #ffffff; background-color: #1a1a1a; border-left: 4px solid #ffffff; }
        .nav-link-custom i { font-size: 1.2rem; }
        .main-content { margin-left: 260px; padding: 30px 40px; min-height: 100vh; }
        
        /* FORM STYLING */
        .admin-topbar { background: #ffffff; border-radius: 16px; padding: 15px 25px; display: flex; justify-content: space-between; align-items: center; box-shadow: 0 4px 12px rgba(0,0,0,0.02); border: 1px solid #eaeaea; margin-bottom: 30px; }
        .form-card { background: #ffffff; border: 1px solid #eaeaea; border-radius: 20px; padding: 30px; box-shadow: 0 10px 20px rgba(0,0,0,0.02); margin-bottom: 30px; }
        .form-label { font-weight: 700; color: #333; font-size: 0.95rem; margin-bottom: 8px; }
        .form-custom { border: 1.5px solid #eaeaea; border-radius: 12px; padding: 12px 18px; font-size: 0.95rem; font-weight: 500; transition: 0.3s; background-color: #fcfcfc; }
        .form-custom:focus { background-color: #ffffff; border-color: #000; box-shadow: 0 0 0 4px rgba(0,0,0,0.05); outline: none; }
        
        /* SIZES CHECKBOX TILE */
        .size-tile input[type="checkbox"] { display: none; }
        .size-label { display: inline-block; border: 1.5px solid #eaeaea; background-color: #fff; color: #666; font-weight: 700; padding: 8px 16px; border-radius: 8px; cursor: pointer; transition: 0.2s; font-size: 0.9rem; }
        .size-label:hover { border-color: #000; color: #000; }
        .size-tile input[type="checkbox"]:checked + .size-label { background-color: #000; border-color: #000; color: #fff; }
    </style>
</head>
<body>
    <div class="sidebar shadow-lg">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">URBAN ADMIN.</a>
        <div class="d-flex flex-column gap-2">
            <a href="{{ route('admin.dashboard') }}" class="nav-link-custom"><i class="bi bi-grid-1x2-fill"></i> Dashboard Utama</a>
            <a href="{{ route('admin.products.index') }}" class="nav-link-custom active"><i class="bi bi-box-seam-fill"></i> Manajemen Produk</a>
            <a href="{{ route('admin.transactions.index') }}" class="nav-link-custom"><i class="bi bi-receipt"></i> Data Pesanan</a>
        </div>
    </div>

    <div class="main-content">
        <div class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('admin.products.index') }}" class="btn btn-light border rounded-circle shadow-sm" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;"><i class="bi bi-arrow-left"></i></a>
                <div>
                    <h5 class="fw-bold m-0">Tambah Produk Baru</h5>
                    <small class="text-muted fw-bold">Tambahkan koleksi sepatu terbaru ke etalase.</small>
                </div>
            </div>
        </div>

        @if($errors->any())
            <div class="alert alert-danger fw-bold rounded-3 border-0 shadow-sm mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error) <li>{{ $error }}</li> @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row g-4">
                <!-- KOLOM KIRI (Informasi Dasar) -->
                <div class="col-lg-8">
                    <div class="form-card">
                        <h6 class="fw-bold mb-4 border-bottom pb-2">Informasi Produk</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Nama Sepatu</label>
                            <input type="text" name="name" class="form-control form-custom" placeholder="Contoh: Nike Air Max 95 Retro" value="{{ old('name') }}" required>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Deskripsi Lengkap</label>
                            <textarea name="description" rows="5" class="form-control form-custom" placeholder="Jelaskan detail material, teknologi, dan sejarah sepatu ini..." required>{{ old('description') }}</textarea>
                        </div>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Harga (Rp)</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 fw-bold" style="border: 1.5px solid #eaeaea; border-right: none;">Rp</span>
                                    <input type="number" name="price" class="form-control form-custom" style="border-left: none;" placeholder="2500000" value="{{ old('price') }}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Stok Fisik</label>
                                <input type="number" name="stock" class="form-control form-custom" placeholder="0" value="{{ old('stock') }}" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label d-block">Ukuran Tersedia (EU)</label>
                            <div class="d-flex flex-wrap gap-2 mt-2">
                                @foreach([36, 37, 38, 39, 40, 41, 42, 43, 44, 45] as $size)
                                <div class="size-tile">
                                    <input type="checkbox" name="sizes[]" id="size_{{ $size }}" value="{{ $size }}">
                                    <label class="size-label shadow-sm" for="size_{{ $size }}">{{ $size }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KOLOM KANAN (Kategori & Media) -->
                <div class="col-lg-4">
                    <div class="form-card mb-4">
                        <h6 class="fw-bold mb-4 border-bottom pb-2">Organisasi</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Kategori Brand</label>
                            <select name="category_id" class="form-control form-custom" required>
                                <option value="" disabled selected>-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Gender (Peruntukan)</label>
                            <select name="gender" class="form-control form-custom" required>
                                <option value="Men">Men</option>
                                <option value="Women">Women</option>
                                <option value="Unisex" selected>Unisex</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-card mb-4">
                        <h6 class="fw-bold mb-4 border-bottom pb-2">Media Foto</h6>
                        
                        <div class="mb-4">
                            <label class="form-label">Foto Utama (Wajib)</label>
                            <input type="file" name="image" class="form-control form-custom" accept="image/*" required>
                            <small class="text-muted mt-2 d-block">Rasio disarankan 1:1 (Kotak).</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Galeri Tambahan (Opsional)</label>
                            <input type="file" name="galleries[]" class="form-control form-custom" accept="image/*" multiple>
                            <small class="text-muted mt-2 d-block">Bisa pilih lebih dari satu foto.</small>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark btn-lg w-100 fw-bold rounded-pill py-3 shadow-sm">
                        <i class="bi bi-save-fill me-2"></i> Simpan Produk
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>