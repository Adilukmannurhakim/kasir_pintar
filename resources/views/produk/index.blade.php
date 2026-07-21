<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk - Laravel Kasir</title>
      <script src="https://cdn.tailwindcss.com"></script>
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

            <div class="flex min-h-screen bg-slate-50 font-sans antialiased">
    
    <!-- ========================================== -->
    <!-- SIDEBAR UTAMA                              -->
    <!-- ========================================== -->
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

                <!-- Menu Kelola Produk (Aktif) -->
                @if(auth()->check() && auth()->user()->role == 'admin')
                <a href="{{ route('produk.index') }}" 
                   class="flex items-center gap-3 px-4 py-3 text-sm transition duration-150 
                   {{ request()->routeIs('produk.*') ? 'font-bold bg-white text-[#3b32a7] rounded-l-full -mr-6 shadow-sm' : 'font-semibold text-white/80 hover:bg-white/10 hover:text-white rounded-xl' }}">
                    <i class="fa-solid fa-boxes-stacked text-lg w-5 text-center"></i> Kelola Produk
                </a>
                @endif
            </nav>
        </div>

        <!-- Tombol Keluar -->
        <form action="{{ route('logout') }}" method="POST" id="logout-form" class="hidden">
            @csrf
        </form>
        <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
           class="flex items-center gap-3 px-4 py-3 text-sm font-semibold text-white/80 hover:bg-red-600 hover:text-white rounded-xl transition duration-150">
            <i class="fa-solid fa-right-from-bracket text-lg w-5 text-center"></i> Keluar Aplikasi
        </a>
    </div>

    <!-- ========================================== -->
    <!-- KONTEN UTAMA                               -->
    <!-- ========================================== -->
    <div class="ml-64 flex-1 p-8 min-w-0">
        
        <!-- Header Halaman & Tombol Tambah -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Daftar Produk</h1>
                <p class="text-sm text-slate-500">Kelola stok dan harga produk kasir Anda</p>
            </div>
            
            <a href="{{ route('produk.create') }}" 
               class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-semibold text-white bg-[#3b32a7] hover:bg-[#2d2685] rounded-xl shadow-sm hover:shadow transition duration-150">
                <i class="fa-solid fa-plus"></i> Tambah Produk Baru
            </a>
        </div>

        <!-- Alert Sukses -->
        @if (session('sukses'))
            <div class="flex items-center gap-3 p-4 mb-6 text-sm text-emerald-800 rounded-xl bg-emerald-50 border border-emerald-200">
                <i class="fa-solid fa-circle-check text-base text-emerald-600"></i>
                <span>{{ session('sukses') }}</span>
            </div>
        @endif

        <!-- CARD UTAMA TABEL -->
        <div class="w-full bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="w-full overflow-x-auto">
                <table class="w-full text-left border-collapse table-fixed">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-600 uppercase tracking-wider">
                            <th class="px-6 py-4 w-20">No</th>
                            <th class="px-6 py-4">Nama Produk</th>
                            <th class="px-6 py-4 w-48">Harga Jual</th>
                            <th class="px-6 py-4 w-36 text-center">Stok</th>
                            <th class="px-6 py-4 text-center w-48">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                        @forelse ($produks as $index => $item)
                            <tr class="hover:bg-slate-50/70 transition duration-150">
                                <!-- No -->
                                <td class="px-6 py-4 font-mono font-medium text-slate-500">
                                    {{ $index + 1 }}
                                </td>
                                
                                <!-- Nama Produk -->
                                <td class="px-6 py-4 font-bold text-slate-800 truncate">
                                    {{ $item->nama_produk }}
                                </td>
                                
                                <!-- Harga Jual -->
                                <td class="px-6 py-4 font-semibold text-slate-700 whitespace-nowrap">
                                    Rp {{ number_format($item->harga, 0, ',', '.') }}
                                </td>
                                
                                <!-- Stok -->
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-slate-100 text-slate-700 border border-slate-200">
                                        {{ $item->stok }} unit
                                    </span>
                                </td>
                                
                                <!-- Tombol Aksi -->
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <div class="flex items-center justify-center gap-2">
                                        <!-- Edit -->
                                        <a href="{{ route('produk.edit', $item->id_produk) }}" 
                                           class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-amber-700 bg-amber-50 hover:bg-amber-100 border border-amber-200 rounded-lg transition duration-150">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </a>

                                        <!-- Hapus -->
                                        <form action="{{ route('produk.destroy', $item->id_produk) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-semibold text-red-700 bg-red-50 hover:bg-red-100 border border-red-200 rounded-lg transition duration-150">
                                                <i class="fa-solid fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-12 text-slate-400">
                                    <i class="fa-regular fa-folder-open text-4xl mb-3 block text-slate-300"></i>
                                    <span>Belum ada data produk.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination (jika controller menggunakan paginate) -->
            @if(method_exists($produks, 'hasPages') && $produks->hasPages())
                <div class="bg-slate-50 px-6 py-4 border-t border-slate-100">
                    {{ $produks->links('pagination::tailwind') }}
                </div>
            @endif

        </div>
    </div>
</div>

</body>
</html>