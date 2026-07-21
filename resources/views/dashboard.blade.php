<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Link FontAwesome untuk icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-light: #e0e7ff;
            --background: #f8fafc;
            --card-bg: #ffffff;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --success: #10b981;
            --success-light: #d1fae5;
            --warning: #f59e0b;
            --warning-light: #fef3c7;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--background); color: var(--text-main); display: flex; min-height: 100vh; }
        
        /* Sidebar Sederhana */
        .sidebar { width: 260px; background: #fff; border-right: 1px solid var(--border-color); padding: 30px 20px; display: flex; flex-direction: column; gap: 20px; }
        .logo { font-size: 20px; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 15px; text-decoration: none; color: var(--text-muted); font-weight: 600; border-radius: 10px; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--primary-light); color: var(--primary); }

        /* Area Konten Utama */
        .main-content { flex: 1; padding: 40px; max-width: 1200px; margin: 0 auto; width: 100%; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { font-size: 26px; font-weight: 700; }
        
        /* Grid Kartu Statistik */
        .stats-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 30px; }
        .stat-card { background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border-color); padding: 24px; display: flex; align-items: center; gap: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .stat-icon { width: 54px; height: 54px; border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 22px; }
        .icon-blue { background: var(--primary-light); color: var(--primary); }
        .icon-green { background: var(--success-light); color: var(--success); }
        .icon-yellow { background: var(--warning-light); color: var(--warning); }
        .stat-info p { font-size: 14px; color: var(--text-muted); font-weight: 500; }
        .stat-info h3 { font-size: 22px; font-weight: 700; margin-top: 5px; }

        /* Layout Grafik & Tabel */
        .dashboard-grid { display: grid; grid-template-columns: 1.2fr 0.8fr; gap: 20px; }
        .card { background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border-color); padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        .card h2 { font-size: 18px; font-weight: 700; margin-bottom: 20px; }

        /* Tabel */
        .recent-table { width: 100%; border-collapse: collapse; }
        .recent-table th { text-align: left; padding: 12px 10px; border-bottom: 2px solid var(--border-color); color: var(--text-muted); font-size: 13px; }
        .recent-table td { padding: 14px 10px; border-bottom: 1px solid var(--border-color); font-size: 13px; }
        .badge { display: inline-block; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; background: var(--success-light); color: var(--success); }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
<!-- PASTIKAN DIV CONTAINER UTAMA SIDEBAR MENGGUNAKAN LEBAR w-64 DAN PADDING p-6 -->
<div class="w-64 bg-[#3b32a7] text-white fixed top-0 bottom-0 left-0 p-6 flex flex-col justify-between shadow-xl z-50">
    <div class="flex flex-col gap-8">
        <!-- Logo Toko -->
        <div class="flex items-center gap-3 px-2 py-2">
            <i class="fa-solid fa-shop text-xl text-white"></i>
            <span class="text-lg font-bold tracking-wider uppercase text-white">MAJU JAYA</span>
        </div>
        
        <!-- Menu Navigasi -->
        <nav class="flex flex-col gap-2">
            
            <!-- Menu Dashboard -->
            <a href="{{ route('dashboard') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm transition duration-150 
            {{ request()->routeIs('dashboard') ? 'font-bold bg-white text-[#3b32a7] rounded-l-full -mr-6 shadow-sm' : 'font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl' }}">
                <i class="fa-solid fa-chart-pie text-lg w-5 text-center"></i> Dashboard
            </a>
            
            <!-- Menu Kasir / Transaksi Utama -->
            <a href="{{ route('transaksi.index') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm transition duration-150 
            {{ request()->routeIs('transaksi.index') ? 'font-bold bg-white text-[#3b32a7] rounded-l-full -mr-6 shadow-sm' : 'font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl' }}">
                <i class="fa-solid fa-cash-register text-lg w-5 text-center"></i> Kasir / Transaksi
            </a>
            
            <!-- Menu Riwayat Transaksi -->
            <a href="{{ route('transaksi.riwayat') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm transition duration-150 
            {{ request()->routeIs('transaksi.riwayat') ? 'font-bold bg-white text-[#3b32a7] rounded-l-full -mr-6 shadow-sm' : 'font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl' }}">
                <i class="fa-solid fa-history text-lg w-5 text-center"></i> Riwayat Transaksi
            </a>

            <!-- Menu Kelola Produk -->
            <a href="{{ route('produk.index') }}" 
            class="flex items-center gap-3 px-4 py-3 text-sm transition duration-150 
            {{ request()->routeIs('produk.*') ? 'font-bold bg-white text-[#3b32a7] rounded-l-full -mr-6 shadow-sm' : 'font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl' }}">
                <i class="fa-solid fa-boxes-stacked text-lg w-5 text-center"></i> Kelola Produk
            </a>
            
        </nav>
    </div>

    <!-- Tombol Keluar -->
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
            class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-white/80 hover:bg-red-600 hover:text-white rounded-xl transition duration-150">
                <i class="fa-solid fa-right-from-bracket text-lg w-5 text-center"></i> Keluar Aplikasi
        </a>
</div>

</div>
    <!-- MAIN CONTENT (Ditambahkan ml-64 agar bergeser ke kanan mengikuti lebar sidebar Anda) -->
    <div class="ml-64 p-8 min-h-screen bg-slate-50 text-slate-800 box-border w-[calc(100%-16rem)] max-w-none">
    
    <!-- HEADER -->
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Ringkasan Penjualan</h1>
            <p class="text-sm text-slate-500 mt-1">Pantau performa harian tokomu di sini.</p>
        </div>
        <div class="flex items-center gap-2 font-semibold text-sm text-slate-500 bg-white px-4 py-2 rounded-xl shadow-sm border border-slate-100">
            <i class="fa-regular fa-calendar text-indigo-500"></i> {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}
        </div>
    </div>

    <!-- 3 KARTU STATISTIK UTAMA -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Kartu Omzet -->
        <div class="flex items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 text-xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-400">Omzet Hari Ini</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</h3>
            </div>
        </div>

        <!-- Kartu Transaksi -->
        <div class="flex items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-blue-50 text-blue-600 text-xl">
                <i class="fa-solid fa-receipt"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-400">Transaksi Hari Ini</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ $transaksiHariIni }} Transaksi</h3>
            </div>
        </div>

        <!-- Kartu Produk Terjual -->
        <div class="flex items-center gap-4 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-center w-12 h-12 rounded-xl bg-amber-50 text-amber-600 text-xl">
                <i class="fa-solid fa-box-open"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-slate-400">Produk Terjual Hari Ini</p>
                <h3 class="text-xl font-bold text-slate-800 mt-0.5">{{ $produkTerjualHariIni }} Pcs</h3>
            </div>
        </div>
    </div>

    <!-- LAYOUT GRAFIK & TABEL -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- KIRI: GRAFIK Chart.js (Mengambil 7 Kolom) -->
        <div class="lg:col-span-7 bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h2 class="text-base font-bold text-slate-800 mb-4">Tren Penjualan 7 Hari Terakhir</h2>
            <div class="relative h-[300px] w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>

        <!-- KANAN: TABEL TRANSAKSI TERBARU (Mengambil 5 Kolom) -->
        <div class="lg:col-span-5 bg-white p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col justify-between">
            <div>
                <h2 class="text-base font-bold text-slate-800 mb-4">Aktivitas Transaksi Terbaru</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-xs font-semibold uppercase tracking-wider text-slate-400">
                                <th class="pb-3">No. Nota</th>
                                <th class="pb-3">Waktu</th>
                                <th class="pb-3 text-right">Total</th>
                                <th class="pb-3 text-center">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 text-sm">
                            @forelse($transaksiTerbaru as $trx)
                                <tr class="hover:bg-slate-50/50 transition duration-150">
                                    <td class="py-3 font-semibold text-slate-700">#{{ str_pad($trx->id_transaksi, 5, '0', STR_PAD_LEFT) }}</td>
                                    <td class="py-3 text-slate-400">{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('H:i') }} WIB</td>
                                    <td class="py-3 font-bold text-indigo-600 text-right">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
                                    <td class="py-3 text-center">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                            Selesai
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-10 text-center text-sm font-medium text-slate-400">
                                        Belum ada transaksi hari ini.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- CONFIGURATION Chart.js -->
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        
        // Data dari Laravel Backend
        const labels = {!! json_encode($grafikData['labels']) !!};
        const dataPenjualan = {!! json_encode($grafikData['data']) !!};

        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: dataPenjualan,
                    borderColor: '#4f46e5',
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.3, // Membuat garis grafik melengkung lembut
                    pointBackgroundColor: '#4f46e5',
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda dataset default
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f1f5f9'
                        },
                        ticks: {
                            callback: function(value) {
                                if (value >= 1000000) {
                                    return 'Rp ' + (value / 1000000).toFixed(1) + ' Jt';
                                } else if (value >= 1000) {
                                    return 'Rp ' + (value / 1000).toFixed(0) + ' Rb';
                                }
                                return 'Rp ' + value;
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>