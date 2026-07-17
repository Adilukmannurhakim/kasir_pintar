<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kasir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
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
    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-store"></i> MAJU JAYA
        </div>
        <a href="{{ route('dashboard') }}" class="nav-link active">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('transaksi.index') }}" class="nav-link">
            <i class="fa-solid fa-cash-register"></i> Kasir / Transaksi
        </a>
        <!-- TAMBAHKAN BARIS INI -->
        <a href="{{ route('transaksi.riwayat') }}" class="nav-link">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi
        </a>
        <a href="{{ route('produk.index') }}" class="nav-link">
            <i class="fa-solid fa-boxes-stacked"></i> Kelola Produk
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <div class="header">
            <div>
                <h1>Ringkasan Penjualan</h1>
                <p style="color: var(--text-muted); margin-top: 5px;">Pantau performa harian tokomu di sini.</p>
            </div>
            <div style="font-weight: 600; color: var(--text-muted);">
                <i class="fa-regular fa-calendar"></i> {{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}
            </div>
        </div>

        <!-- 3 KARTU STATISTIK UTAMA -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon icon-green">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <p>Omzet Hari Ini</p>
                    <h3>Rp {{ number_format($omzetHariIni, 0, ',', '.') }}</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-blue">
                    <i class="fa-solid fa-receipt"></i>
                </div>
                <div class="stat-info">
                    <p>Transaksi Hari Ini</p>
                    <h3>{{ $transaksiHariIni }} Transaksi</h3>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon icon-yellow">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <div class="stat-info">
                    <p>Produk Terjual Hari Ini</p>
                    <h3>{{ $produkTerjualHariIni }} Pcs</h3>
                </div>
            </div>
        </div>

        <!-- LAYOUT GRAFIK & TABEL -->
        <div class="dashboard-grid">
            <!-- KIRI: GRAFIK Chart.js -->
            <div class="card">
                <h2>Tren Penjualan 7 Hari Terakhir</h2>
                <div style="position: relative; height:300px; width:100%;">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- KANAN: TABEL TRANSAKSI TERBARU -->
            <div class="card">
                <h2>Aktivitas Transaksi Terbaru</h2>
                <table class="recent-table">
                    <thead>
                        <tr>
                            <th>No. Nota</th>
                            <th>Waktu</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiTerbaru as $trx)
                            <tr>
                                <td style="font-weight: 600;">#{{ str_pad($trx->id_transaksi, 5, '0', STR_PAD_LEFT) }}</td>
                                <td style="color: var(--text-muted);">{{ \Carbon\Carbon::parse($trx->tanggal_transaksi)->format('H:i') }} WIB</td>
                                <td style="font-weight: 700; color: var(--primary);">Rp {{ number_format($trx->grand_total, 0, ',', '.') }}</td>
                                <td><span class="badge">Selesai</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 30px;">Belum ada transaksi hari ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
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