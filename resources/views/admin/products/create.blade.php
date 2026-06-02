<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - UrbanFit Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold" href="{{ route('admin.products.index') }}">&larr; Kembali ke Daftar Produk</a>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 fw-bold">Tambah Produk Baru</h5>
                    </div>
                    <div class="card-body">
                        
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Nama Produk</label>
                                    <input type="text" name="name" class="form-control" required placeholder="Contoh: Nike Air Max 95">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kategori</label>
                                    <select name="category_id" class="form-select" required>
                                        <option value="">-- Pilih Kategori --</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">Harga (Rp)</label>
                                    <input type="number" name="price" class="form-control" required placeholder="Contoh: 150000">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Stok</label>
                                    <input type="number" name="stock" class="form-control" required value="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Produk</label>
                                <textarea name="description" class="form-control" rows="3"></textarea>
                            </div>

                            <div class="mb-4">
                                <label class="form-label">Foto Produk (JPG/PNG)</label>
                                <input type="file" name="image" class="form-control" accept="image/*" required>
                            </div>

                            <button type="submit" class="btn btn-dark w-100 fw-bold">Simpan Produk & Upload</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>