<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Kasir Modern</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: #f8fafc; color: #0f172a; }
        /* Mengamankan scrollbar pada grid produk agar tetap rapi */
        .product-scroll::-webkit-scrollbar { width: 6px; }
        .product-scroll::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 8px; }
        .product-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 8px; }
        .product-scroll::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>

<body>

    <!-- PASTIKAN DIV CONTAINER UTAMA SIDEBAR JUGA MENGGUNAKAN LEBAR w-64 DAN PADDING p-6 -->
    <div class="w-64 bg-[#3b32a7] text-white fixed top-0 bottom-0 left-0 p-6 flex flex-col justify-between shadow-xl z-50">
        <div class="flex flex-col gap-8">
            <!-- Logo Toko -->
            <div class="flex items-center gap-3 px-2 py-2">
                <i class="fa-solid fa-shop text-xl text-white"></i>
                <span class="text-lg font-bold tracking-wider uppercase text-white">MAJU JAYA</span>
            </div>
            
            <!-- Menu Navigasi -->
            <nav class="flex flex-col gap-2">
                <!-- Menu Dashboard (TIDAK AKTIF) -->
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl transition duration-150">
                    <i class="fa-solid fa-chart-pie text-lg w-5 text-center"></i> Dashboard
                </a>
                
                <!-- Menu Kasir / Transaksi (AKTIF) -->
                <a href="{{ url('/transaksi') }}" class="flex items-center gap-3 px-4 py-3 text-sm font-bold bg-white text-[#3b32a7] rounded-l-full -mr-6 shadow-sm transition duration-150">
                    <i class="fa-solid fa-cash-register text-lg w-5 text-center"></i> Kasir / Transaksi
                </a>
                
                <!-- Menu Riwayat Transaksi (TIDAK AKTIF) -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl transition duration-150">
                    <i class="fa-solid fa-history text-lg w-5 text-center"></i> Riwayat Transaksi
                </a>

                <!-- Menu Kelola Produk (TIDAK AKTIF) -->
                <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl transition duration-150">
                    <i class="fa-solid fa-boxes-stacked text-lg w-5 text-center"></i> Kelola Produk
                </a>
            </nav>
        </div>

        <!-- Tombol Keluar -->
        <a href="#" class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-white/80 hover:bg-red-600 hover:text-white rounded-xl transition duration-150">
            <i class="fa-solid fa-right-from-bracket text-lg w-5 text-center"></i> Keluar Aplikasi
        </a>
    </div>

    <!-- MAIN CONTENT KASIR: Margin disesuaikan ml-72 agar kontainer pas pasca pelebaran sidebar -->
    <div class="flex-1 ml-72 p-8 min-h-screen box-border text-slate-800">
        
        <!-- HEADER BAR -->
        <div class="flex flex-row justify-between items-center mb-8 bg-transparent w-full">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Kasir / Transaksi</h1>
                <p class="text-sm text-slate-400 mt-1">Kelola penjualan barang dengan cepat di sini.</p>
            </div>
            <a href="{{ url('/') }}" class="flex items-center gap-2 text-xs font-bold text-slate-600 bg-white hover:bg-slate-50 px-4 py-2.5 rounded-xl shadow-sm border border-slate-200/60 transition duration-150">
                <i class="fa-solid fa-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- GRID LAYOUT UTAMA -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start w-full">
            
            <!-- SEBELAH KIRI: PILIH PRODUK -->
            <div class="lg:col-span-7 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col h-fit">
                <h2 class="text-base font-extrabold text-slate-800 mb-5 flex items-center gap-2">
                    <i class="fa-solid fa-boxes-stacked text-[#4338ca]"></i> Pilih Produk
                </h2>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 max-h-[600px] overflow-y-auto pr-1">
                    @foreach($produks as $produk)
                        <button type="button" 
                                onclick="addToCart({{ $produk->id_produk }}, '{{ $produk->nama_produk }}', {{ $produk->harga }}, {{ $produk->stok }})"
                                class="flex flex-col text-left p-4 bg-slate-50/60 hover:bg-indigo-50/50 hover:border-indigo-200 border border-slate-100 rounded-xl transition duration-150 group w-full focus:outline-none">
                            <span class="font-bold text-slate-700 group-hover:text-[#4338ca] text-sm mb-1 truncate w-full">{{ $produk->nama_produk }}</span>
                            <span class="text-sm font-extrabold text-[#4338ca] mb-3">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            <span class="text-[11px] text-slate-400 font-medium">
                                Stok: <span id="stock-{{ $produk->id_produk }}" class="font-bold text-slate-500">{{ $produk->stok }}</span>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- SEBELAH KANAN: KERANJANG & PEMBAYARAN -->
            <div class="lg:col-span-5 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col gap-5 h-fit">
                <h2 class="text-base font-extrabold text-slate-800 flex items-center gap-2 border-b border-slate-100 pb-3">
                    <i class="fa-solid fa-cart-shopping text-emerald-600"></i> Keranjang
                </h2>
                
                <div class="overflow-x-auto min-h-[150px] max-h-[240px] overflow-y-auto pr-1">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[11px] font-bold uppercase tracking-wider text-slate-400">
                                <th class="pb-2">Barang</th>
                                <th class="pb-2 text-center w-24">Qty</th>
                                <th class="pb-2 text-right">Subtotal</th>
                                <th class="pb-2 w-8"></th>
                            </tr>
                        </thead>
                        <tbody id="cart-items" class="divide-y divide-slate-50 text-sm text-slate-700 font-medium">
                            <!-- JS Output Anda -->
                        </tbody>
                    </table>
                </div>

                <!-- FORM KALKULASI -->
                <div class="flex flex-col gap-3 bg-slate-50 p-4 rounded-xl text-sm font-semibold text-slate-600">
                    <div class="flex justify-between">
                        <span>Subtotal</span>
                        <span id="subtotal-display" data-value="0" class="text-slate-800 font-bold">Rp 0</span>
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span>Diskon (%)</span>
                        <input type="number" id="input-discount" 
                               class="w-20 px-2 py-1 bg-white border border-slate-200 rounded-lg text-right text-slate-800 font-bold shadow-sm focus:outline-none focus:border-indigo-500" 
                               value="0" min="0" max="100" oninput="calculateTotal()">
                    </div>
                    
                    <div class="flex justify-between items-center">
                        <span>Pajak (PPN 11%)</span>
                        <span id="pajak-display" data-value="0" class="font-bold text-slate-500">Rp 0</span>
                    </div>
                    
                    <hr class="border-slate-200/80 border-dashed my-1">
                    
                    <div class="flex justify-between items-center text-base font-extrabold text-slate-900">
                        <span>Grand Total</span>
                        <span id="grand-total-display" data-value="0" class="text-[#4338ca] text-lg font-black">Rp 0</span>
                    </div>
                    
                    <hr class="border-slate-200/80 border-dashed my-1">

                    <div class="flex justify-between items-center mt-1">
                        <span>Uang Diterima (Rp)</span>
                        <input type="number" id="input-cash" 
                               class="w-40 px-3 py-1.5 bg-white border border-slate-200 rounded-lg text-right text-slate-900 font-black text-base shadow-sm focus:outline-none focus:border-indigo-500" 
                               value="0" oninput="calculateChange()">
                    </div>
                    
                    <div class="flex justify-between items-center mt-1 text-emerald-600 font-extrabold text-base">
                        <span>Uang Kembalian</span>
                        <span id="change-val" class="font-black text-lg">Rp 0</span>
                    </div>
                </div>

                <button type="button" onclick="submitTransaction()"
                        class="w-full bg-emerald-500 hover:bg-emerald-600 text-white font-extrabold py-3 px-4 rounded-xl shadow-md transition duration-150 flex items-center justify-center gap-2 text-sm uppercase tracking-wider">
                    <i class="fa-solid fa-receipt text-base"></i> Proses Transaksi
                </button>
            </div>

        </div>
    </div>
</div>

</body>
    <!-- JavaScript Kasir Interaktif -->
    <script>
        let cart = [];

function addToCart(id, name, price, stock) {
    let existingItem = cart.find(item => item.id === id);
    if (existingItem) {
        if (existingItem.qty < stock) {
            existingItem.qty++;
        } else {
            alert('Stok tidak mencukupi!');
            return;
        }
    } else {
        cart.push({ id, name, price, qty: 1 });
    }
    renderCart();
}

function updateQty(id, change) {
    let item = cart.find(item => item.id === id);
    if (item) {
        item.qty += change;
        if (item.qty <= 0) {
            cart = cart.filter(i => i.id !== id);
        }
        renderCart();
    }
}

function deleteItem(id) {
    cart = cart.filter(item => item.id !== id);
    renderCart();
}

function renderCart() {
    const tbody = document.getElementById('cart-items');
    tbody.innerHTML = '';
    
    let subtotal = 0;

    cart.forEach(item => {
        let itemSubtotal = item.price * item.qty;
        subtotal += itemSubtotal;

        tbody.innerHTML += `
            <tr class="border-b border-slate-50">
                <td class="py-3 font-bold text-slate-800">${item.name}</td>
                <td class="py-3 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button type="button" onclick="updateQty(${item.id}, -1)" class="w-6 h-6 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs">-</button>
                        <span class="w-6 font-bold">${item.qty}</span>
                        <button type="button" onclick="updateQty(${item.id}, 1)" class="w-6 h-6 rounded-md bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold text-xs">+</button>
                    </div>
                </td>
                <td class="py-3 text-right font-bold text-slate-700">Rp ${itemSubtotal.toLocaleString('id-ID')}</td>
                <td class="py-3 text-right">
                    <button type="button" onclick="deleteItem(${item.id})" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash-can"></i></button>
                </td>
            </tr>
        `;
    });

    // Simpan nilai bersih ke attribute elemen data-value
    document.getElementById('subtotal-display').setAttribute('data-value', subtotal);
    document.getElementById('subtotal-display').innerText = 'Rp ' + subtotal.toLocaleString('id-ID');
    
    calculateTotal();
}

function calculateTotal() {
    let subtotal = parseFloat(document.getElementById('subtotal-display').getAttribute('data-value')) || 0;
    let discountPercent = parseFloat(document.getElementById('input-discount').value) || 0;
    
    let discountAmount = subtotal * (discountPercent / 100);
    let setelahDiskon = subtotal - discountAmount;
    
    let pajak = setelahDiskon * 0.11; // PPN 11%
    let grandTotal = setelahDiskon + pajak;

    document.getElementById('pajak-display').innerText = 'Rp ' + Math.round(pajak).toLocaleString('id-ID');
    
    const grandTotalDisplay = document.getElementById('grand-total-display');
    grandTotalDisplay.setAttribute('data-value', Math.round(grandTotal));
    grandTotalDisplay.innerText = 'Rp ' + Math.round(grandTotal).toLocaleString('id-ID');
    
    calculateChange();
}

function calculateChange() {
    let grandTotal = parseFloat(document.getElementById('grand-total-display').getAttribute('data-value')) || 0;
    let cash = parseFloat(document.getElementById('input-cash').value) || 0;
    let change = cash - grandTotal;

    const changeVal = document.getElementById('change-val');
    if (change < 0) {
        changeVal.innerText = 'Rp 0';
        changeVal.classList.replace('text-emerald-600', 'text-rose-500');
    } else {
        changeVal.innerText = 'Rp ' + change.toLocaleString('id-ID');
        changeVal.classList.replace('text-rose-500', 'text-emerald-600');
    }
}

function submitTransaction() {
    // 1. Validasi apakah keranjang belanja kosong
    if (cart.length === 0) {
        alert('Keranjang masih kosong! Silakan pilih produk terlebih dahulu.');
        return;
    }

    // 2. Ambil nilai angka mentah dari attribute data-value
    let grandTotal = parseFloat(document.getElementById('grand-total-display').getAttribute('data-value')) || 0;
    let cash = parseFloat(document.getElementById('input-cash').value) || 0;

    // 3. Validasi apakah uang yang dibayarkan cukup
    if (cash < grandTotal) {
        alert('Uang yang diterima kurang dari Grand Total!');
        return;
    }

    // 4. Siapkan data transaksi yang akan dikirim ke Backend/Controller Laravel
    let transactionData = {
        _token: '{{ csrf_token() }}',
        grand_total: grandTotal,
        total_bayar: cash,
        kembalian: cash - grandTotal,
        cart: cart
    };

    // 5. Kirim data ke server menggunakan Fetch API
    fetch("{{ url('/transaksi/simpan') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify(transactionData)
    })
    // Intersepsi response sebelum dipaksa menjadi JSON
    .then(async response => {
        const isJson = response.headers.get('content-type')?.includes('application/json');
        const data = isJson ? await response.json() : null;

        if (!response.ok) {
            // Jika server crash / route error (mengirim halaman HTML error)
            const errorText = !isJson ? await response.text() : null;
            if (errorText) {
                console.error("Server Error HTML:", errorText);
            }
            throw new Error(data?.message || `Server merespon dengan status ${response.status}`);
        }
        return data;
    })
    .then(data => {
        if (data && data.success) {
            alert('Transaksi berhasil diproses!');
            
            // Kosongkan keranjang setelah sukses
            cart = [];
            renderCart();
            document.getElementById('input-cash').value = 0;
            document.getElementById('change-val').innerText = 'Rp 0';
            
            // RESET INPUT DISKON (Jika ada elemen input-discount di halaman Anda)
            if (document.getElementById('input-discount')) {
                document.getElementById('input-discount').value = 0;
            }
            
            // ACUAN UTAMA: Mengarahkan halaman ke rute /transaksi/cetak/{id} sesuai web.php
            window.location.href = "{{ url('/transaksi/cetak') }}/" + data.id_transaksi;
        } else {
            alert('Gagal memproses transaksi: ' + (data?.message || 'Terjadi kesalahan internal.'));
        }
    })
    .catch(error => {
        console.error('Detail Error:', error);
        alert('Terjadi kesalahan: ' + error.message + '. Silakan buka Inspect Element (F12) -> tab Console untuk melihat error Laravel.');
    });
}
    </script>

</body>
</html>