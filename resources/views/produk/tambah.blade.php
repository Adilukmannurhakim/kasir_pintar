<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Produk - Laravel Kasir</title>
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
        body { background-color: var(--background); display: flex; justify-content: center; align-items: center; min-height: 100vh; padding: 20px; }
        .container { width: 100%; max-width: 500px; }
        .card { background: var(--card-bg); border-radius: 16px; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.05); border: 1px solid var(--border-color); padding: 30px; }
        .card-header { text-align: center; margin-bottom: 25px; }
        .card-header .icon-box { width: 60px; height: 60px; background: #eeebff; color: var(--primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 24px; margin: 0 auto 15px auto; }
        .card-header h2 { font-size: 22px; font-weight: 700; }
        .card-header p { font-size: 14px; color: var(--text-muted); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 8px; }
        .input-wrapper { position: relative; display: flex; align-items: center; }
        .input-wrapper i { position: absolute; left: 14px; color: var(--text-muted); }
        .form-control { width: 100%; padding: 12px 12px 12px 40px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 15px; }
        .form-control:focus { outline: none; border-color: var(--primary); }
        .btn-group { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-top: 30px; }
        .btn { padding: 12px; border-radius: 10px; font-size: 15px; font-weight: 600; cursor: pointer; border: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; }
        .btn-primary { background-color: var(--primary); color: white; }
        .btn-secondary { background-color: #f1f5f9; color: var(--text-muted); border: 1px solid var(--border-color); }
        .alert { padding: 12px; border-radius: 10px; font-size: 14px; margin-bottom: 20px; }
        .alert-danger { background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; }
        .alert-success { background: #ecfdf5; color: var(--success); border: 1px solid #a7f3d0; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            
            <div class="card-header">
                <div class="icon-box">
                    <i class="fa-solid fa-box-open"></i>
                </div>
                <h2>Tambah Produk Baru (Laravel)</h2>
                <p>Masukkan rincian data produk secara akurat</p>
            </div>

            <!-- Tampilkan Alert Sukses -->
            @if (session('sukses'))
                <div class="alert alert-success">
                    <i class="fa-solid fa-circle-check"></i> {{ session('sukses') }}
                </div>
            @endif

            <!-- Tampilkan Error Validasi -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul style="list-style-type: none; padding-left: 0;">
                        @foreach ($errors->all() as $error)
                            <li><i class="fa-solid fa-circle-exclamation"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('produk.store') }}" method="POST">
                <!-- CSRF Token wajib ada di setiap form Laravel -->
                @csrf
                
                <div class="form-group">
                    <label for="nama_produk">Nama Produk / Barang</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-tag"></i>
                        <input type="text" name="nama_produk" id="nama_produk" class="form-control" placeholder="Contoh: Besi Beton 8mm" value="{{ old('nama_produk') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="harga">Harga Jual (Rp)</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-rupiah-sign"></i>
                        <input type="number" name="harga" id="harga" class="form-control" placeholder="Contoh: 45000" value="{{ old('harga') }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="stok">Jumlah Stok Awal</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-boxes-stacked"></i>
                        <input type="number" name="stok" id="stok" class="form-control" placeholder="Contoh: 150" value="{{ old('stok') }}" required>
                    </div>
                </div>

                <div class="btn-group">
                    <!-- Cari baris ini di sekitar baris ke-128 dan sesuaikan href-nya -->
                    <a href="{{ route('produk.index') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>

</body>
</html>