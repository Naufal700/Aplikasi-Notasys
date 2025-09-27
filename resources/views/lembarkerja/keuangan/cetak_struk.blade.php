<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran #{{ $tagihan->lembarKerja->no_pesanan }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; }
        .header h2 { margin: 0; font-size: 20px; }
        .header small { color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 8px; text-align: left; }
        .text-right { text-align: right; }
        .total { font-weight: bold; }
        .footer { text-align: center; margin-top: 20px; font-size: 11px; color: #555; }
        @media print {
            body { margin: 0; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>STRUK PEMBAYARAN</h2>
        <small>Tanggal: {{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d-m-Y') }}</small>
    </div>

    <p><strong>Pelanggan:</strong> {{ $tagihan->lembarKerja->klien->nama ?? '-' }}</p>
    <p><strong>No Pesanan:</strong> {{ $tagihan->lembarKerja->no_pesanan ?? '-' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Keterangan</th>
                <th class="text-right">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>{{ $tagihan->keterangan ?? '-' }}</td>
                <td class="text-right">{{ number_format($tagihan->total_tagihan,0,',','.') }}</td>
            </tr>
            <tr>
                <td colspan="2" class="text-right total">TOTAL</td>
                <td class="text-right total">{{ number_format($tagihan->total_tagihan,0,',','.') }}</td>
            </tr>
        </tbody>
    </table>

    <p><strong>Metode Pembayaran:</strong> {{ $tagihan->metode_pembayaran ?? '-' }}</p>

    <div class="footer">
        <p>Terima kasih, pembayaran Anda telah kami terima.</p>
    </div>

    <script>
        // Auto print saat halaman load
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
