<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir Modern</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        :root {
            --primary: #4f46e5;
            --primary-hover: #4338ca;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --success: #10b981;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--background); padding: 20px; color: var(--text-main); }
        .grid-container { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 20px; max-width: 1300px; margin: 0 auto; }
        .card { background: var(--card-bg); border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid var(--border-color); padding: 20px; }
        h2 { font-size: 20px; font-weight: 700; margin-bottom: 20px; display: flex; align-items: center; gap: 10px; }
        .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 15px; max-height: 550px; overflow-y: auto; padding-right: 5px; }
        .product-card { border: 1px solid var(--border-color); border-radius: 12px; padding: 15px; cursor: pointer; transition: all 0.2s; text-align: center; background: #fff; }
        .product-card:hover { border-color: var(--primary); transform: translateY(-2px); box-shadow: 0 4px 12px rgba(79, 70, 229, 0.1); }
        .product-name { font-weight: 700; font-size: 15px; margin-bottom: 5px; }
        .product-price { color: var(--primary); font-weight: 600; font-size: 14px; margin-bottom: 10px; }
        .product-stock { font-size: 12px; color: var(--text-muted); }
        
        /* Keranjang */
        .cart-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .cart-table th { text-align: left; padding: 10px; border-bottom: 2px solid var(--border-color); color: var(--text-muted); font-size: 13px; }
        .cart-table td { padding: 12px 10px; border-bottom: 1px solid var(--border-color); font-size: 14px; }
        .quantity-control { display: flex; align-items: center; gap: 5px; }
        .btn-qty { width: 24px; height: 24px; border-radius: 6px; border: 1px solid var(--border-color); background: #f1f5f9; cursor: pointer; font-weight: bold; }
        .btn-delete { color: #ef4444; border: none; background: none; cursor: pointer; }
        
        /* Pembayaran */
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .summary-total { font-size: 18px; font-weight: 700; border-top: 2px dashed var(--border-color); padding-top: 15px; margin-top: 15px; }
        .form-control { width: 100%; padding: 10px; border: 1px solid var(--border-color); border-radius: 8px; font-size: 14px; margin-top: 5px; }
        .btn-checkout { width: 100%; padding: 14px; background: var(--success); color: white; border: none; border-radius: 10px; font-weight: 700; font-size: 16px; cursor: pointer; transition: background 0.2s; margin-top: 15px; }
        .btn-checkout:hover { background: #059669; }
        .nav-btn { display: inline-flex; align-items: center; gap: 8px; text-decoration: none; color: var(--text-muted); font-weight: 600; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>

    <body>

    <!-- SIDEBAR KIRI -->
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-store"></i> MAJU JAYA
        </div>
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('transaksi.index') }}" class="nav-link active">
            <i class="fa-solid fa-cash-register"></i> Kasir / Transaksi
        </a>
        <a href="{{ route('transaksi.riwayat') }}" class="nav-link">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi
        </a>
        <a href="{{ route('produk.index') }}" class="nav-link">
            <i class="fa-solid fa-boxes-stacked"></i> Kelola Produk
        </a>
    </div>

    <!-- WRAPPER UNTUK KONTEN UTAMA (DI SEBELAH KANAN SIDEBAR) -->
    <div class="main-content-wrapper">
        
        <div class="header-action">
            <!-- KODE BARU YANG AMAN: -->
                <a href="{{ url('/') }}" class="nav-btn">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Produk
                </a>
        </div>

        <div class="grid-container">
            <!-- SEBELAH KIRI: DAFTAR PRODUK -->
            <div class="card">
                <h2><i class="fa-solid fa-boxes-stacked" style="color: var(--primary)"></i> Pilih Produk</h2>
                <div class="product-grid">
                    @foreach($produks as $produk)
                        <div class="product-card" onclick="addToCart({{ $produk->id_produk }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, {{ $produk->stok }})">
                            <div class="product-name">{{ $produk->nama_produk }}</div>
                            <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                            <div class="product-stock">Stok: <span id="stock-{{ $produk->id_produk }}">{{ $produk->stok }}</span></div>
                        </div>
                    @endforeach
                </div>
            </div>
            <style>
                /* Struktur Layout Utama */
                body {
                    display: flex;
                    background-color: #f8fafc;
                    margin: 0;
                    padding: 0;
                    min-height: 100vh;
                }

                /* Sidebar Styling */
                .sidebar {
                    width: 260px;
                    background: #fff;
                    border-right: 1px solid #e2e8f0;
                    padding: 30px 20px;
                    display: flex;
                    flex-direction: column;
                    gap: 20px;
                    position: fixed;
                    height: 100vh;
                    left: 0;
                    top: 0;
                    z-index: 100;
                }
                .logo {
                    font-size: 20px;
                    font-weight: 700;
                    color: #4f46e5;
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    margin-bottom: 20px;
                }
                .nav-link {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 12px 15px;
                    text-decoration: none;
                    color: #64748b;
                    font-weight: 600;
                    border-radius: 10px;
                    transition: all 0.2s;
                }
                .nav-link:hover, .nav-link.active {
                    background: #e0e7ff;
                    color: #4f46e5;
                }

                /* Pembungkus Konten Utama di Sebelah Kanan Sidebar */
                .main-content-wrapper {
                    flex: 1;
                    margin-left: 260px; /* Memberikan ruang agar tidak tertutup oleh sidebar yang di-fix */
                    padding: 40px;
                    box-sizing: border-box;
                }

                .header-action {
                    margin-bottom: 20px;
                }

                /* Grid Container untuk Kasir (Produk & Keranjang) */
                .grid-container {
                    display: grid;
                    grid-template-columns: 1.2fr 0.8fr; /* Membagi area produk lebih lebar dibanding keranjang */
                    gap: 30px;
                    align-items: start;
                }

                /* Penyesuaian Nav Button Kembali ke Produk */
                .nav-btn {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    text-decoration: none;
                    color: #64748b;
                    font-weight: 600;
                    font-size: 14px;
                    transition: color 0.2s;
                }
                .nav-btn:hover {
                    color: #4f46e5;
                }
            </style>

            <!-- SEBELAH KANAN: KERANJANG (Lanjutkan sisa kode keranjang belanja Anda di bawah ini) -->
        <!-- SEBELAH KANAN: KERANJANG BELANJA & PEMBAYARAN -->
        <div class="card">
            <h2><i class="fa-solid fa-cart-shopping" style="color: var(--success)"></i> Keranjang</h2>
            
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Barang</th>
                        <th>Qty</th>
                        <th>Subtotal</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-items">
                    <!-- Dinonaktifkan sementara/diisi via JS -->
                </tbody>
            </table>

            <div class="summary-section">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span id="subtotal-val">Rp 0</span>
                </div>
                <div class="summary-row">
                    <span>Diskon (%)</span>
                    <input type="number" id="input-discount" class="form-control" style="width: 80px; text-align: right;" value="0" min="0" max="100" oninput="calculateTotal()">
                </div>
                <div class="summary-row summary-total">
                    <span>Grand Total</span>
                    <span id="grand-total-val" style="color: var(--primary);">Rp 0</span>
                </div>
                <!-- ... bagian subtotal dan diskon ... -->
                    <div class="row-info" style="display: flex; justify-content: space-between; margin-bottom: 10px;">
                        <span>Subtotal</span>
                        <span id="subtotal-display">Rp 0</span>
                    </div>
                    <!-- TAMBAHKAN BARIS PAJAK BARU DI SINI -->
                    <div class="row-info" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                        <span>Pajak (PPN 11%)</span>
                        <span id="pajak-display" style="font-weight: 500; color: #64748b;">Rp 0</span>
                    </div>
                    <!-- --------------------------------- -->

                    <hr style="border: 0; border-top: 1px dashed #e2e8f0; margin: 15px 0;">

                    <div class="row-info" style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <span style="font-weight: bold; font-size: 18px;">Grand Total</span>
                        <span id="grand-total-display" style="font-weight: bold; font-size: 18px; color: #4f46e5;">Rp 0</span>
                    </div>

                <div class="summary-row" style="margin-top: 20px;">
                    <span>Uang Diterima (Rp)</span>
                    <input type="number" id="input-cash" class="form-control" style="width: 150px; text-align: right; font-weight: bold;" value="0" oninput="calculateChange()">
                </div>
                <div class="summary-row" style="font-weight: 600; margin-top: 10px;">
                    <span>Uang Kembalian</span>
                    <span id="change-val">Rp 0</span>
                </div>

                <button class="btn-checkout" onclick="submitTransaction()">
                    <i class="fa-solid fa-receipt"></i> Proses Transaksi
                </button>
            </div>
        </div>
    </div>

    <!-- JavaScript Kasir Interaktif -->
    <script>
        let cart = [];

        function addToCart(id, name, price, stock) {
            let item = cart.find(p => p.id_produk === id);
            
            if (item) {
                if (item.jumlah < stock) {
                    item.jumlah++;
                    item.subtotal = item.jumlah * price;
                } else {
                    alert('Stok produk tidak mencukupi!');
                }
            } else {
                cart.push({
                    id_produk: id,
                    nama_produk: name,
                    harga: price,
                    jumlah: 1,
                    subtotal: price,
                    stok_max: stock
                });
            }
            renderCart();
        }

        function changeQty(id, delta) {
            let item = cart.find(p => p.id_produk === id);
            if (item) {
                item.jumlah += delta;
                if (item.jumlah <= 0) {
                    cart = cart.filter(p => p.id_produk !== id);
                } else if (item.jumlah > item.stok_max) {
                    alert('Stok tidak mencukupi!');
                    item.jumlah = item.stok_max;
                }
                item.subtotal = item.jumlah * item.harga;
            }
            renderCart();
        }

        function deleteItem(id) {
            cart = cart.filter(p => p.id_produk !== id);
            renderCart();
        }

        function renderCart() {
            const tbody = document.getElementById('cart-items');
            tbody.innerHTML = '';

            if (cart.length === 0) {
                tbody.innerHTML = `<tr><td colspan="4" style="text-align:center; color:var(--text-muted); padding: 20px;">Keranjang kosong</td></tr>`;
                calculateTotal();
                return;
            }

            cart.forEach(item => {
                tbody.innerHTML += `
                    <tr>
                        <td style="font-weight: 600;">${item.nama_produk}</td>
                        <td>
                            <div class="quantity-control">
                                <button class="btn-qty" onclick="changeQty(${item.id_produk}, -1)">-</button>
                                <span>${item.jumlah}</span>
                                <button class="btn-qty" onclick="changeQty(${item.id_produk}, 1)">+</button>
                            </div>
                        </td>
                        <td>Rp ${item.subtotal.toLocaleString('id-ID')}</td>
                        <td style="text-align: right;">
                            <button class="btn-delete" onclick="deleteItem(${item.id_produk})"><i class="fa-solid fa-trash-can"></i></button>
                        </td>
                    </tr>
                `;
            });

            calculateTotal();
        }

        let currentGrandTotal = 0;

let currentPajakValue = 0; // Tambahan variabel global untuk menyimpan nilai nominal pajak

function calculateTotal() {
    // 1. Hitung Subtotal dari seluruh item di keranjang
    let subtotal = cart.reduce((sum, item) => sum + item.subtotal, 0);
    
    // 2. Hitung Diskon
    let discountPercent = parseFloat(document.getElementById('input-discount').value) || 0;
    let discountValue = (discountPercent / 100) * subtotal;
    
    // 3. Hitung Pajak (PPN 11%) setelah dikurangi diskon
    let dpp = subtotal - discountValue; // Dasar Pengenaan Pajak
    let taxValue = dpp * 0.11; // Nominal PPN 11%
    
    // 4. Hitung Grand Total (Subtotal - Diskon + Pajak)
    let grandTotal = dpp + taxValue;

    // Simpan ke variabel global agar bisa dibaca oleh fungsi lain & dikirim ke database
    currentGrandTotal = grandTotal;
    currentPajakValue = taxValue; 

    // 5. Tampilkan hasil perhitungan ke elemen HTML masing-masing
    document.getElementById('subtotal-val').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    
    // Pastikan Anda sudah membuat elemen dengan id="tax-val" di HTML untuk menampilkan nominal pajak
    if (document.getElementById('tax-val')) {
        document.getElementById('tax-val').innerText = 'Rp ' + Math.round(taxValue).toLocaleString('id-ID');
    }
    
    document.getElementById('grand-total-val').innerText = 'Rp ' + Math.round(grandTotal).toLocaleString('id-ID');

    // Hubungkan ulang ke kalkulator uang kembalian
    calculateChange();
}

function calculateChange() {
    let cash = parseFloat(document.getElementById('input-cash').value) || 0;
    let change = cash - currentGrandTotal;

    // Bulatkan nilai kembalian agar tidak ada desimal pecahan di struk
    let roundedChange = Math.round(change);

    if (change < 0) {
        document.getElementById('change-val').innerText = 'Uang Kurang';
        document.getElementById('change-val').style.color = '#ef4444';
    } else {
        document.getElementById('change-val').innerText = 'Rp ' + roundedChange.toLocaleString('id-ID');
        document.getElementById('change-val').style.color = 'var(--success)';
    }
}
        function submitTransaction() {
            if (cart.length === 0) {
                alert('Silakan pilih produk terlebih dahulu!');
                return;
            }

            let cash = parseFloat(document.getElementById('input-cash').value) || 0;
            if (cash < currentGrandTotal) {
                alert('Uang pembayaran kurang!');
                return;
            }

            let discount = parseFloat(document.getElementById('input-discount').value) || 0;

            // Kirim data ke backend Laravel menggunakan Fetch API
            fetch("{{ route('transaksi.store') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    cart: cart,
                    total_bayar: cash,
                    diskon: discount,
                    grand_total: currentGrandTotal
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Transaksi berhasil disimpan! Nota akan otomatis dicetak.');
                    
                    // MEMBUKA TAB BARU UNTUK AUTO-PRINT NOTA
                    let notaUrl = "{{ url('/transaksi/cetak') }}/" + data.id_transaksi;
                    window.open(notaUrl, '_blank'); 

                    // Memuat ulang halaman kasir agar keranjang kembali bersih
                    location.reload();
                } else {
                    alert('Terjadi kesalahan pada server.');
                }
            })
            .catch(err => {
                console.error(err);
                alert('Terjadi masalah koneksi.');
            });
        }
    </script>

</body>
</html>