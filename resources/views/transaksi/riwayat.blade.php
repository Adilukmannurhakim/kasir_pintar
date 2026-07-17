<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Maju Jaya</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

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
        }
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body { background-color: var(--background); color: var(--text-main); display: flex; min-height: 100vh; }
        
        /* Sidebar */
        .sidebar { width: 260px; background: #fff; border-right: 1px solid var(--border-color); padding: 30px 20px; display: flex; flex-direction: column; gap: 20px; }
        .logo { font-size: 20px; font-weight: 700; color: var(--primary); display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .nav-link { display: flex; align-items: center; gap: 12px; padding: 12px 15px; text-decoration: none; color: var(--text-muted); font-weight: 600; border-radius: 10px; transition: all 0.2s; }
        .nav-link:hover, .nav-link.active { background: var(--primary-light); color: var(--primary); }

        /* Main Content */
        .main-content { flex: 1; padding: 40px; max-width: 1200px; margin: 0 auto; width: 100%; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header h1 { font-size: 26px; font-weight: 700; }

        /* Card container */
        .card { background: var(--card-bg); border-radius: 16px; border: 1px solid var(--border-color); padding: 24px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); }
        
        /* Form Filter */
        .filter-form { display: flex; gap: 15px; margin-bottom: 25px; align-items: flex-end; }
        .form-group { display: flex; flex-direction: column; gap: 8px; }
        .form-group label { font-size: 13px; font-weight: 600; color: var(--text-muted); }
        .form-control { padding: 10px 15px; border-radius: 8px; border: 1px solid var(--border-color); outline: none; font-size: 14px; min-width: 200px; }
        .btn-primary { background: var(--primary); color: white; border: none; padding: 11px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: 0.2s; }
        .btn-primary:hover { background: #4338ca; }
        .btn-secondary { background: var(--border-color); color: var(--text-main); border: none; padding: 11px 20px; border-radius: 8px; font-weight: 600; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; }

        /* Table */
        .table-responsive { width: 100%; overflow-x: auto; margin-top: 15px; }
        .table { width: 100%; border-collapse: collapse; text-align: left; }
        .table th { padding: 16px; border-bottom: 2px solid var(--border-color); color: var(--text-muted); font-size: 14px; font-weight: 600; }
        .table td { padding: 16px; border-bottom: 1px solid var(--border-color); font-size: 14px; }
        .badge { display: inline-block; padding: 4px 10px; border-radius: 6px; font-size: 11px; font-weight: 700; background: var(--success-light); color: var(--success); }

        /* Action Button */
        .btn-reprint { background: var(--primary-light); color: var(--primary); border: none; padding: 8px 12px; border-radius: 6px; font-weight: 600; font-size: 12px; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; gap: 6px; transition: 0.2s; }
        .btn-reprint:hover { background: var(--primary); color: white; }

        /* Pagination Style */
        .pagination-container { margin-top: 25px; display: flex; justify-content: center; }
    </style>
</head>
<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-store"></i> MAJU JAYA
        </div>
        <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="fa-solid fa-chart-pie"></i> Dashboard
        </a>
        <a href="{{ route('transaksi.index') }}" class="nav-link">
            <i class="fa-solid fa-cash-register"></i> Kasir / Transaksi
        </a>
        <a href="{{ route('transaksi.riwayat') }}" class="nav-link active">
            <i class="fa-solid fa-clock-rotate-left"></i> Riwayat Transaksi
        </a>
        <a href="{{ route('produk.index') }}" class="nav-link">
            <i class="fa-solid fa-boxes-stacked"></i> Kelola Produk
        </a>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-container">
    
    <!-- HEADER UTAMA -->
    <div class="header-container">
        <div>
            <h1 class="main-title">Riwayat Transaksi</h1>
            <p class="sub-title">Pantau seluruh catatan transaksi penjualan kasir Anda</p>
        </div>
        
        <div class="button-group">
            <a href="{{ url('/') }}" class="btn-back-dashboard">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <!-- CARD TABEL RIWAYAT -->
    <div class="table-card">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 120px;">No. Nota</th>
                    <th>Tanggal & Waktu</th>
                    <th style="text-align: center;">Diskon (%)</th>
                    <th style="text-align: right;">Potongan</th>
                    <th style="text-align: right;">Total Bayar</th>
                    <th style="text-align: center; width: 120px;">Status</th>
                    <th style="text-align: center; width: 140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Silakan sesuaikan nama variabel $transaksis / $riwayats sesuai controller Anda -->
                @foreach($transaksis as $t)
                    <tr>
                        <td class="nota-cell">#{{ str_pad($t->id_transaksi ?? $t->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="date-cell">
                            {{ \Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y, H:i') }} WIB
                        </td>
                        <td style="text-align: center;">
                            <span class="discount-badge">{{ $t->diskon ?? 0 }}%</span>
                        </td>
                        <td style="text-align: right; font-weight: 500; color: #ef4444;">
                            Rp {{ number_format($t->nominal_diskon ?? 0, 0, ',', '.') }}
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #1e293b;" class="total-cell">
                            Rp {{ number_format($t->total_harga ?? $t->total ?? $t->grand_total, 0, ',', '.') }}
                        </td>
                        <td style="text-align: center;">
                            <span class="status-badge {{ strtolower($t->status ?? 'selesai') == 'selesai' ? 'status-success' : 'status-pending' }}">
                                {{ $t->status ?? 'Selesai' }}
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="{{ url('/transaksi/cetak/'.$t->id_transaksi) }}" class="btn-print" target="_blank">
                                <i class="fa-solid fa-print"></i> Cetak Ulang
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- PAGINATION SECTION (MEMBATASI UKURAN PANAH RAKSASA) -->
        <div class="pagination-wrapper">
            {{ $transaksis->links() }}
        </div>
    </div>
</div>
<style>
    /* Container Utama & Header */
.main-container {
    max-width: 1200px;
    margin: 40px auto;
    padding: 0 20px;
    width: 100%;
    box-sizing: border-box;
}

.header-container {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
}

.main-title {
    font-size: 28px;
    font-weight: 700;
    color: #0f172a;
    margin: 0;
}

.sub-title {
    font-size: 14px;
    color: #64748b;
    margin: 5px 0 0 0;
}

/* Tombol Kembali */
.btn-back-dashboard {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background-color: #f1f5f9;
    color: #475569;
    padding: 11px 18px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    text-decoration: none;
    border: 1px solid #e2e8f0;
    transition: all 0.2s ease;
}

.btn-back-dashboard:hover {
    background-color: #e2e8f0;
    color: #0f172a;
}

/* Card Tabel */
.table-card {
    background: #ffffff;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    padding: 24px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
    width: 100%;
}

/* Tabel Desain Modern */
.table {
    width: 100%;
    border-collapse: collapse;
    text-align: left;
    margin-bottom: 20px;
}

.table th {
    padding: 16px;
    color: #64748b;
    font-weight: 600;
    font-size: 13px;
    text-transform: uppercase;
    border-bottom: 2px solid #f1f5f9;
    background-color: #f8fafc;
}

.table td {
    padding: 16px;
    border-bottom: 1px solid #f1f5f9;
    font-size: 14px;
    color: #334155;
    vertical-align: middle;
}

.table tbody tr:hover {
    background-color: #f8fafc;
}

/* Cell khusus */
.nota-cell {
    font-weight: 700;
    color: #4f46e5;
}

.date-cell {
    color: #475569;
    font-size: 13px;
}

.total-cell {
    font-size: 15px;
}

/* Badges */
.discount-badge {
    background-color: #fef3c7;
    color: #d97706;
    padding: 3px 8px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 12px;
}

.status-badge {
    display: inline-block;
    padding: 5px 12px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 12px;
    text-transform: capitalize;
}

.status-success {
    background-color: #ecfdf5;
    color: #10b981;
}

.status-pending {
    background-color: #fffbeb;
    color: #f59e0b;
}

/* Tombol Cetak */
.btn-print {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background-color: #e0e7ff;
    color: #4f46e5;
    padding: 8px 14px;
    border-radius: 6px;
    font-weight: 600;
    font-size: 13px;
    text-decoration: none;
    transition: all 0.2s ease;
}

.btn-print:hover {
    background-color: #4f46e5;
    color: white;
}

/* FIX PAGINATION: Membatasi SVG panah raksasa bawaan Laravel */
.pagination-wrapper {
    margin-top: 25px;
    display: flex;
    justify-content: center;
}

.pagination-wrapper svg {
    width: 16px !important;
    height: 16px !important;
    display: inline-block;
}

.pagination-wrapper nav div {
    display: flex;
    align-items: center;
    gap: 4px;
}

.pagination-wrapper span, 
.pagination-wrapper a {
    padding: 8px 14px;
    border-radius: 6px;
    border: 1px solid #e2e8f0;
    font-size: 14px;
    text-decoration: none;
    color: #475569;
}

.pagination-wrapper .active span {
    background-color: #4f46e5;
    color: white;
    border-color: #4f46e5;
}
</style>
</body>
</html>