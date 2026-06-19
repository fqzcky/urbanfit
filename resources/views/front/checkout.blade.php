<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { 
            margin: 0 !important; 
            padding: 0 !important; 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #f8f9fa; /* Background abu terang biar card putih lebih pop-out */
            color: #1a1a1a; 
        }
        
        /* Navbar Sederhana (Khusus Halaman Dalam) */
        .navbar-custom { background-color: #000000; padding: 1rem 0; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }

        /* Form Styling Premium */
        .form-label { font-weight: 700; color: #1a1a1a; margin-bottom: 8px; font-size: 0.95rem; }
        .form-custom { 
            background-color: #fdfdfd; 
            border: 1.5px solid #e0e0e0; 
            border-radius: 14px; 
            padding: 14px 20px; 
            font-size: 1rem; 
            font-weight: 600; 
            color: #333;
            transition: all 0.3s ease; 
        }
        .form-custom:focus { 
            background-color: #ffffff; 
            border-color: #000000; 
            box-shadow: 0 0 0 4px rgba(0,0,0,0.05); 
            outline: none; 
        }
        .form-select.form-custom { cursor: pointer; }
        .form-select.form-custom:disabled { background-color: #f0f0f0; cursor: not-allowed; opacity: 0.7; }
        
        /* Order Summary Sticky */
        .summary-wrapper { 
            background-color: #ffffff; 
            border: none; 
            border-radius: 24px; 
            padding: 30px; 
            position: sticky; 
            top: 100px; 
            box-shadow: 0 20px 40px rgba(0,0,0,0.08); 
        }
        .summary-title { font-weight: 800; font-size: 1.3rem; margin-bottom: 25px; border-bottom: 1px solid #eaeaea; padding-bottom: 15px; }
        
        /* Mini Item List */
        .mini-item { display: flex; align-items: center; margin-bottom: 20px; gap: 15px; }
        .mini-img { width: 70px; height: 70px; border-radius: 14px; background: #f4f4f4; object-fit: cover; }
        .mini-title { font-weight: 800; font-size: 1rem; margin: 0 0 4px 0; line-height: 1.2; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .mini-meta { font-size: 0.85rem; color: #777; font-weight: 700; }
        .mini-price { font-family: 'Bebas Neue', sans-serif; font-size: 1.3rem; letter-spacing: 0.5px; color: #000; margin-left: auto; }

        /* Summary Rows */
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 15px; font-weight: 700; color: #666; font-size: 0.95rem; align-items: center; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 25px; padding-top: 25px; border-top: 2px dashed #eaeaea; align-items: center; }
        .summary-total-label { font-weight: 800; font-size: 1.1rem; color: #000; }
        .summary-total-price { font-family: 'Bebas Neue', sans-serif; font-size: 2.2rem; letter-spacing: 1px; line-height: 1; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom sticky-top shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            <div class="text-white fw-bold d-none d-md-flex align-items-center px-3 py-2 rounded-pill bg-dark border border-secondary">
                <i class="bi bi-shield-lock-fill text-success me-2"></i> Checkout Aman
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5 pb-5">
        <div class="mb-4">
            <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted fw-bold mb-3 d-inline-block transition-all hover-dark">
                <i class="bi bi-arrow-left me-1"></i> Kembali ke Keranjang
            </a>
            <h1 class="fw-extrabold display-6" style="letter-spacing: -1px;">Pengiriman & Pembayaran.</h1>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row g-5">
                
                <div class="col-lg-7">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border-0">
                        <h4 class="fw-extrabold mb-4 border-bottom pb-3">Detail Pengiriman</h4>
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control form-custom" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required placeholder="Masukkan nama penerima">
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 fw-bold px-4 rounded-start-4" style="border: 1.5px solid #e0e0e0; border-right: none;">+62</span>
                                    <input type="number" name="phone" class="form-control form-custom rounded-end-4" style="border-left: none;" value="{{ old('phone') }}" required placeholder="81234567890">
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="form-label">Provinsi</label>
                                <select name="province_id" id="province" class="form-select form-custom" required>
                                    <option value="" disabled selected>Memuat Provinsi...</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kota/Kabupaten</label>
                                <select name="city_id" id="city" class="form-select form-custom" required disabled>
                                    <option value="" disabled selected>Pilih Provinsi Dulu</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Kecamatan (Wajib)</label>
                                <select name="district_id" id="district" class="form-select form-custom" required disabled>
                                    <option value="" disabled selected>Pilih Kota Dulu</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="address" rows="3" class="form-control form-custom" placeholder="Nama jalan, RT/RW, detail rumah..." required>{{ old('address') }}</textarea>
                            </div>

                            <div class="col-md-12 mt-5">
                                <h4 class="fw-extrabold mb-3 border-bottom pb-3">Pilih Ekspedisi</h4>
                                <select name="courier" id="courier" class="form-select form-custom" required disabled>
                                    <option value="" disabled selected>Pilih Kecamatan Dulu</option>
                                    <option value="jne">JNE Express</option>
                                    <option value="jnt">J&T Express</option>
                                    <option value="sicepat">SiCepat</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                    <div class="summary-wrapper">
                        <h4 class="summary-title">Ringkasan Belanja</h4>
                        
                        <div class="mb-4">
                            @php $subtotal = 0; @endphp
                            @foreach(session('cart') as $details)
                                @php $subtotal += $details['price'] * $details['quantity']; @endphp
                                <div class="mini-item">
                                    <img src="{{ isset($details['image']) ? asset('storage/' . $details['image']) : '' }}" class="mini-img" alt="{{ $details['name'] }}">
                                    <div>
                                        <h6 class="mini-title">{{ $details['name'] }}</h6>
                                        <div class="mini-meta">Size: {{ $details['size'] }} &bull; Qty: {{ $details['quantity'] }}</div>
                                    </div>
                                    <div class="mini-price">Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}</div>
                                </div>
                            @endforeach
                        </div>

                        <div class="summary-row">
                            <span>Subtotal Barang</span>
                            <span class="fw-bold text-dark fs-6">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Biaya Pengiriman</span>
                            <span id="shipping-cost-display" class="badge bg-light text-secondary border px-3 py-2 fs-6">Pilih Kurir</span>
                        </div>
                        
                        <div class="summary-total">
                            <span class="summary-total-label">TOTAL TAGIHAN</span>
                            <span id="total-display" class="summary-total-price text-danger">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                        <input type="hidden" id="subtotal_input" value="{{ $subtotal }}">

                        <button type="submit" id="btn-pay" class="btn btn-dark btn-lg w-100 mt-4 py-3 fw-bold rounded-pill shadow-sm" disabled style="transition: all 0.3s;">
                            Menunggu Ongkir...
                        </button>
                        
                        <div class="mt-4 text-center">
                            <p class="small text-muted mb-2 fw-bold"><i class="bi bi-lock-fill me-1"></i> Pembayaran Aman Via</p>
                            <div class="d-flex justify-content-center gap-2 opacity-75">
                                <span class="badge bg-light border text-dark">BCA</span>
                                <span class="badge bg-light border text-dark">Mandiri</span>
                                <span class="badge bg-light border text-dark">GoPay</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district'); 
            const courierSelect = document.getElementById('courier');
            const shippingCostDisplay = document.getElementById('shipping-cost-display');
            const totalDisplay = document.getElementById('total-display');
            const btnPay = document.getElementById('btn-pay');
            
            const shippingCostInput = document.getElementById('shipping_cost_input');
            const subtotal = parseInt(document.getElementById('subtotal_input').value);
            const formatRp = (angka) => 'Rp ' + new Intl.NumberFormat('id-ID').format(angka);

            // 1. Ambil Data Provinsi
            fetch("{{ url('ongkir/provinces') }}")
                .then(res => res.json())
                .then(data => {
                    provinceSelect.innerHTML = '<option value="" disabled selected>Pilih Provinsi Pengiriman</option>';
                    if(data && data.length > 0) {
                        data.forEach(prov => {
                            provinceSelect.innerHTML += `<option value="${prov.id}">${prov.name}</option>`;
                        });
                    }
                });

            // 2. Ambil Data Kota saat Provinsi dipilih
            provinceSelect.addEventListener('change', function() {
                citySelect.innerHTML = '<option value="" disabled selected>Memuat Kota...</option>';
                citySelect.disabled = true;
                districtSelect.innerHTML = '<option value="" disabled selected>Pilih Kota Dulu</option>';
                districtSelect.disabled = true;
                courierSelect.selectedIndex = 0;
                courierSelect.disabled = true;
                resetOngkir();

                fetch("{{ url('ongkir/cities') }}/" + this.value)
                    .then(res => res.json())
                    .then(data => {
                        citySelect.innerHTML = '<option value="" disabled selected>Pilih Kota/Kabupaten</option>';
                        data.forEach(city => {
                            citySelect.innerHTML += `<option value="${city.id}">${city.name}</option>`;
                        });
                        citySelect.disabled = false;
                    });
            });

            // 3. Ambil Kecamatan saat Kota dipilih
            citySelect.addEventListener('change', function() {
                districtSelect.innerHTML = '<option value="" disabled selected>Memuat Kecamatan...</option>';
                districtSelect.disabled = true;
                courierSelect.selectedIndex = 0;
                courierSelect.disabled = true;
                resetOngkir();

                fetch("{{ url('ongkir/districts') }}/" + this.value)
                    .then(res => res.json())
                    .then(data => {
                        districtSelect.innerHTML = '<option value="" disabled selected>Pilih Kecamatan</option>';
                        data.forEach(dist => {
                            districtSelect.innerHTML += `<option value="${dist.id}">${dist.name}</option>`;
                        });
                        districtSelect.disabled = false;
                    });
            });

            // 4. Aktifkan Kurir saat Kecamatan dipilih
            districtSelect.addEventListener('change', function() {
                courierSelect.disabled = false;
                courierSelect.selectedIndex = 0;
                resetOngkir();
            });

            // 5. Kalkulasi Harga saat Kurir dipilih
            courierSelect.addEventListener('change', function() {
                if(!districtSelect.value) return;

                shippingCostDisplay.innerHTML = '<span class="spinner-border spinner-border-sm text-secondary" role="status"></span>';
                btnPay.disabled = true;
                btnPay.innerText = 'Menghitung Tagihan...';

                let formData = new FormData();
                formData.append('district_id', districtSelect.value);
                formData.append('courier', this.value);
                formData.append('_token', '{{ csrf_token() }}');

                fetch("{{ route('ongkir.cost') }}", {
                    method: 'POST',
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    let cost = 0;
                    if(data && data.length > 0 && data[0].cost) {
                        cost = data[0].cost;
                    }

                    if(cost > 0) {
                        shippingCostDisplay.innerText = formatRp(cost);
                        shippingCostDisplay.className = "badge bg-success text-white px-3 py-2 fs-6 shadow-sm";
                        shippingCostInput.value = cost;
                        totalDisplay.innerText = formatRp(subtotal + parseInt(cost));
                        btnPay.disabled = false;
                        btnPay.innerHTML = '<i class="bi bi-credit-card-fill me-2"></i> Lanjutkan Pembayaran';
                    } else {
                        shippingCostDisplay.innerHTML = 'Rute Tidak Didukung';
                        shippingCostDisplay.className = "badge bg-danger text-white px-3 py-2 fs-6";
                        resetOngkir(true);
                    }
                })
                .catch(err => {
                    shippingCostDisplay.innerHTML = 'Gagal Cek Ongkir';
                    shippingCostDisplay.className = "badge bg-danger text-white px-3 py-2 fs-6";
                    resetOngkir(true);
                });
            });

            function resetOngkir(keepText = false) {
                if(!keepText) {
                    shippingCostDisplay.innerText = 'Pilih Kurir';
                    shippingCostDisplay.className = "badge bg-light text-secondary border px-3 py-2 fs-6";
                }
                shippingCostInput.value = 0;
                totalDisplay.innerText = formatRp(subtotal);
                btnPay.disabled = true;
                btnPay.innerText = 'Menunggu Ongkir...';
            }
        });
    </script>
</body>
</html>