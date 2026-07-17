<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Transaksi #{{ $transaksi->id_transaksi }}</title>
    <style>
        @page {
            size: 58mm auto; /* Format kertas kasir standard */
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace; /* Font kasir klasik */
            font-size: 11px;
            line-height: 1.3;
            width: 58mm;
            padding: 5mm;
            margin: 0 auto;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .divider {
            border-top: 1px dashed #000;
            margin: 5px 0;
        }
        .header {
            margin-bottom: 10px;
        }
        .header h3 {
            margin: 0;
            font-size: 14px;
            font-weight: bold;
        }
        .header p {
            margin: 2px 0;
            font-size: 10px;
        }
        .meta-info {
            font-size: 9px;
            margin-bottom: 8px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table td {
            vertical-align: top;
            padding: 2px 0;
        }
        .summary-table td {
            font-weight: bold;
        }
        .footer {
            margin-top: 15px;
            font-size: 9px;
        }
        
        /* Menyembunyikan elemen tidak penting saat tombol cetak browser aktif */
        @media print {
            body {
                width: 100%;
                padding: 0;
                margin: 0;
            }
        }
    </style>
</head>
<body>

    <div class="header text-center">
        <h3>TB. MAJU JAYA</h3>
        <p>Jl. Raya Toko Besi No. 45, Jawa Tengah</p>
        <p>Telp: 0812-3456-7890</p>
    </div>

    <div class="divider"></div>

    <div class="meta-info">
        <div>No. Nota: #{{ str_pad($transaksi->id_transaksi, 5, '0', STR_PAD_LEFT) }}</div>
        <div>Tanggal : {{ \Carbon\Carbon::parse($transaksi->tanggal_transaksi)->format('d/m/Y H:i') }}</div>
        <div>Kasir   : Admin</div>
    </div>

    <div class="divider"></div>

    <!-- DAFTAR BELANJA -->
    <table>
        @foreach($details as $detail)
            <tr>
                <td colspan="2" style="font-weight: bold;">{{ $detail->produk->nama_produk }}</td>
            </tr>
            <tr>
                <td>{{ $detail->jumlah }} x Rp{{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                <td class="text-right">Rp{{ number_format($detail->subtotal, 0, ',', '.') }}</td>
            </tr>
        @endforeach
    </table>

    <div class="divider"></div>

    <!-- RINCIAN TOTAL -->
    <table class="summary-table">
        <tr>
            <td>Subtotal:</td>
            <td class="text-right">Rp{{ number_format($transaksi->grand_total / (1 - ($transaksi->diskon / 100)), 0, ',', '.') }}</td>
        </tr>
        @if($transaksi->diskon > 0)
        <tr>
            <td>Diskon ({{ $transaksi->diskon }}%):</td>
            <td class="text-right">-Rp{{ number_format(($transaksi->grand_total / (1 - ($transaksi->diskon / 100))) * ($transaksi->diskon / 100), 0, ',', '.') }}</td>
        </tr>
        @endif
        <tr>
            <td>Grand Total:</td>
            <td class="text-right">Rp{{ number_format($transaksi->grand_total, 0, ',', '.') }}</td>
        </tr>
        <tr style="font-weight: normal;">
            <td>Bayar:</td>
            <td class="text-right">Rp{{ number_format($transaksi->total_bayar, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td>Kembalian:</td>
            <td class="text-right">Rp{{ number_format($transaksi->total_bayar - $transaksi->grand_total, 0, ',', '.') }}</td>
        </tr>
    </table>

    <div class="divider"></div>

    <div class="footer text-center">
        <p>Terima Kasih Atas Kunjungan Anda</p>
        <p>Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
    </div>

    <!-- JAVASCRIPT UNTUK AUTO-PRINT -->
    <script>
        window.onload = function() {
            window.print(); // Otomatis trigger popup printer
            // Setelah popup print ditutup (baik batal maupun cetak), tab nota otomatis menutup sendiri
            window.onafterprint = function() {
                window.close();
            };
        }
    </script>

</body>
</html>