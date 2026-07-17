<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Laravel Kasir</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
        body { background-color: var(--background); padding: 40px 20px; color: var(--text-main); }
        .container { width: 100%; max-width: 1000px; margin: 0 auto; }
        .header-section { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .header-section h2 { font-size: 24px; font-weight: 700; }
        .btn { padding: 10px 18px; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer; border: none; display: inline-flex; align-items: center; gap: 8px; text-decoration: none; transition: all 0.2s; }
        .btn-primary { background-color: var(--primary); color: white; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .card { background: var(--card-bg); border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid var(--border-color); overflow: hidden; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { background-color: #f1f5f9; padding: 16px; font-size: 14px; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border-color); }
        td { padding: 16px; font-size: 15px; border-bottom: 1px solid var(--border-color); }
        tr:last-child td { border-bottom: none; }
        .alert { padding: 15px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; background: #ecfdf5; color: var(--success); border: 1px solid #a7f3d0; }
    </style>
</head>
<body>

            <div class="main-container">
            
            <!-- HEADER UTAMA (HANYA SATU INI SAJA) -->
            <div class="header-container">
        <div>
            <h1 class="main-title">Daftar Produk</h1>
            <p class="sub-title">Kelola stok dan harga produk kasir Anda</p>
        </div>
        
        <div class="button-group">
            <!-- TOMBOL KEMBALI KE DASHBOARD -->
            <a href="{{ url('/') }}" class="btn-back-dashboard">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Dashboard
            </a>

            <!-- TOMBOL TAMBAH PRODUK BARU -->
            <a href="{{ url('/produk/create') }}" class="btn-add-product">
                <i class="fa-solid fa-plus"></i> Tambah Produk Baru
            </a>
        </div>
    </div>
    <style>
        /* Pembungkus Utama Halaman Produk */
            .main-container {
                max-width: 1200px;
                margin: 40px auto; /* Membuat halaman berada tepat di tengah-tengah layar */
                padding: 0 20px;
                width: 100%;
                box-sizing: border-box;
            }

            /* Card untuk Tabel agar Rapih dan Bersih */
            .table-card {
                background: #ffffff;
                border-radius: 16px;
                border: 1px solid #e2e8f0;
                padding: 24px;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
                width: 100%;
                overflow-x: auto; /* Mencegah tabel pecah di layar HP/Kecil */
            }
                </style>
                    <style>
                    /* Container Header agar Judul di Kiri dan Tombol di Kanan */
                .header-container {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    margin-bottom: 30px;
                    width: 100%;
                }

                .main-title {
                    font-size: 28px;
                    font-weight: 700;
                    color: #0f172a;
                }

                .sub-title {
                    font-size: 14px;
                    color: #64748b;
                    margin-top: 5px;
                }

                /* Grouping Tombol agar Sejajar */
                .button-group {
                    display: flex;
                    gap: 12px;
                    align-items: center;
                }

                /* Style Tombol Kembali (Abu-Abu) */
                .btn-back-dashboard {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    background-color: #f1f5f9;
                    color: #475569;
                    padding: 12px 20px;
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

                /* Style Tombol Tambah Produk (Biru/Ungu) */
                .btn-add-product {
                    display: inline-flex;
                    align-items: center;
                    gap: 8px;
                    background-color: #4f46e5; /* Sesuaikan warna ungu/biru utama Anda */
                    color: white;
                    padding: 12px 20px;
                    border-radius: 8px;
                    font-weight: 600;
                    font-size: 14px;
                    text-decoration: none;
                    border: none;
                    transition: all 0.2s ease;
                    box-shadow: 0 4px 6px -1px rgba(79, 70, 229, 0.2);
                }

                .btn-add-product:hover {
                    background-color: #4338ca;
                    box-shadow: 0 4px 12px -1px rgba(79, 70, 229, 0.3);
                }
                </style>
                </div>
                
        <!-- Tampilkan Alert Sukses jika ada -->
        @if (session('sukses'))
            <div class="alert">
                <i class="fa-solid fa-circle-check"></i> {{ session('sukses') }}
            </div>
        @endif

        <div class="card">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga Jual</th>
                        <th>Stok</th>
                        <th style="text-align: center;">Aksi</th> <!-- Tambah ini -->
                    </tr>
                </thead>
                <tbody>
                    @forelse ($produks as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td style="font-weight: 600;">{{ $item->nama_produk }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->stok }} unit</td>
                            <!-- Tambahkan kolom aksi di bawah ini -->
                            <td style="text-align: center;">
                                <a href="{{ route('produk.edit', $item->id_produk) }}" class="btn btn-warning" style="padding: 6px 12px; font-size: 13px; background-color: #f59e0b; color: white;">
                                    <i class="fa-solid fa-pen-to-square"></i> Edit
                                </a>
                                <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST" style="display: inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="padding: 6px 12px; font-size: 13px; background-color: #ef4444; color: white;">
                                        <i class="fa-solid fa-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 40px;">
                                <i class="fa-regular fa-folder-open" style="font-size: 30px; margin-bottom: 10px; display: block;"></i>
                                Belum ada data produk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>