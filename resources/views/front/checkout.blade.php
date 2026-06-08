<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Urban Sneakers</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        html, body { margin: 0 !important; padding: 0 !important; font-family: 'Plus Jakarta Sans', sans-serif; background-color: #fcfcfc; color: #1a1a1a; }
        .navbar-custom { background-color: #000000; border-bottom: 1px solid #222; }
        .navbar-brand-custom { font-weight: 800; letter-spacing: -1px; }

        .form-label { font-weight: 700; color: #333; margin-bottom: 8px; font-size: 0.95rem; }
        .form-custom { background-color: #f9f9f9; border: 1.5px solid #eaeaea; border-radius: 12px; padding: 14px 20px; font-size: 1rem; font-weight: 500; transition: all 0.3s ease; }
        .form-custom:focus { background-color: #ffffff; border-color: #000000; box-shadow: 0 0 0 4px rgba(0,0,0,0.05); outline: none; }
        
        .summary-wrapper { background-color: #ffffff; border: 1px solid #f0f0f0; border-radius: 24px; padding: 30px; position: sticky; top: 100px; box-shadow: 0 15px 30px rgba(0,0,0,0.03); }
        .summary-title { font-weight: 800; font-size: 1.3rem; margin-bottom: 25px; border-bottom: 2px dashed #eee; padding-bottom: 15px; }
        .mini-item { display: flex; align-items: center; margin-bottom: 15px; gap: 15px; }
        .mini-img { width: 65px; height: 65px; border-radius: 12px; background: #f8f9fa; object-fit: cover; border: 1px solid #eee; }
        .mini-title { font-weight: 700; font-size: 0.95rem; margin: 0; line-height: 1.2; display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
        .mini-meta { font-size: 0.8rem; color: #777; font-weight: 600; margin-top: 4px; }
        .mini-price { font-weight: 800; font-size: 0.95rem; color: #000; margin-left: auto; }

        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-weight: 600; color: #555; font-size: 0.95rem; align-items: center; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 2px solid #000; font-weight: 800; font-size: 1.5rem; color: #000; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark navbar-custom py-3 shadow-sm">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand navbar-brand-custom fs-3 text-white" href="{{ route('home') }}">URBAN SNEAKERS.</a>
            <div class="text-white fw-bold d-none d-md-block">
                <i class="bi bi-shield-lock-fill text-success me-1"></i> Checkout Aman
            </div>
        </div>
    </nav>

    <div class="container mt-5 mb-5 pb-5">
        <div class="mb-4">
            <a href="{{ route('cart.index') }}" class="text-decoration-none text-muted fw-bold mb-2 d-inline-block">&larr; Kembali ke Keranjang</a>
            <h1 class="fw-bold display-6" style="letter-spacing: -1px;">Pengiriman & Pembayaran.</h1>
        </div>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <div class="row g-5">
                <div class="col-lg-7">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border" style="border-color: #f0f0f0 !important;">
                        <h4 class="fw-bold mb-4">Detail Pengiriman</h4>
                        
                        <div class="row g-4">
                            <div class="col-md-12">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control form-custom" value="{{ auth()->check() ? auth()->user()->name : old('name') }}" required>
                            </div>
                            
                            <div class="col-md-12">
                                <label class="form-label">Nomor WhatsApp</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0 fw-bold px-3" style="border: 1.5px solid #eaeaea; border-right: none;">+62</span>
                                    <input type="number" name="phone" class="form-control form-custom" style="border-left: none;" value="{{ old('phone') }}" required>
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

                            <div class="col-md-12">
                                <label class="form-label">Pilih Kurir Ekspedisi</label>
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
                            <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="summary-row">
                            <span>Biaya Pengiriman</span>
                            <span id="shipping-cost-display" class="text-secondary fw-bold bg-light px-2 py-1 rounded">Pilih Kurir</span>
                        </div>
                        
                        <div class="summary-total">
                            <span>Total Tagihan</span>
                            <span id="total-display" class="text-danger">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        
                        <input type="hidden" name="shipping_cost" id="shipping_cost_input" value="0">
                        <input type="hidden" id="subtotal_input" value="{{ $subtotal }}">

                        <button type="submit" id="btn-pay" class="btn btn-dark btn-lg w-100 mt-4 py-3 fw-bold rounded-pill" disabled style="font-size: 1.15rem;">
                            Menunggu Ongkir...
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinceSelect = document.getElementById('province');
            const citySelect = document.getElementById('city');
            const districtSelect = document.getElementById('district'); // Tambahan Kecamatan
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

                shippingCostDisplay.innerHTML = '<span class="spinner-border spinner-border-sm text-secondary"></span>';
                btnPay.disabled = true;
                btnPay.innerText = 'Menghitung Tagihan...';

                let formData = new FormData();
                formData.append('district_id', districtSelect.value); // DIKOMERCE HARUS KECAMATAN
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
                        shippingCostDisplay.className = "text-success fw-bold";
                        shippingCostInput.value = cost;
                        totalDisplay.innerText = formatRp(subtotal + parseInt(cost));
                        btnPay.disabled = false;
                        btnPay.innerHTML = '<i class="bi bi-credit-card-fill me-2"></i> Lanjutkan Pembayaran';
                    } else {
                        shippingCostDisplay.innerHTML = '<span class="text-danger small">Kurir tidak mendukung rute ini</span>';
                        resetOngkir(true);
                    }
                })
                .catch(err => {
                    shippingCostDisplay.innerHTML = '<span class="text-danger small">Gagal mengecek ongkir</span>';
                    resetOngkir(true);
                });
            });

            function resetOngkir(keepText = false) {
                if(!keepText) {
                    shippingCostDisplay.innerText = 'Pilih Kurir';
                    shippingCostDisplay.className = "text-secondary fw-bold bg-light px-2 py-1 rounded";
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