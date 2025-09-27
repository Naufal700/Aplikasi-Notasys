<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tagihan #{{ $tagihan->lembarKerja->no_pesanan }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 13px; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; }
        .header h2 { margin: 0; font-size: 24px; }
        .header small { color: #555; }
        .info { margin-bottom: 20px; }
        .info p { margin: 3px 0; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table, th, td { border: 1px solid #333; }
        th, td { padding: 10px; text-align: left; }
        th { background-color: #f0f0f0; }
        .text-right { text-align: right; }
        .total { font-weight: bold; font-size: 14px; }
        .footer { text-align: center; margin-top: 40px; font-size: 12px; color: #555; }
        @media print {
            body { margin: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>INVOICE / TAGIHAN</h2>
        <small>Tanggal: {{ \Carbon\Carbon::parse($tagihan->tanggal)->format('d-m-Y') }}</small>
    </div>

    <div class="info">
        <p><strong>Pelanggan:</strong> {{ $tagihan->lembarKerja->klien->nama ?? '-' }}</p>
        <p><strong>No Pesanan:</strong> {{ $tagihan->lembarKerja->no_pesanan ?? '-' }}</p>
        <p><strong>Jatuh Tempo:</strong> {{ \Carbon\Carbon::parse($tagihan->jatuh_tempo)->format('d-m-Y') }}</p>
        <p><strong>Metode Pembayaran:</strong> {{ $tagihan->metode_pembayaran ?? '-' }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:5%;">No</th>
                <th>Keterangan</th>
                <th style="width:20%;" class="text-right">Jumlah</th>
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

    <div class="footer">
        <p>Terima kasih atas kepercayaan Anda.</p>
    </div>

    {{-- Auto print ketika halaman dibuka --}}
    <script>
        window.addEventListener('load', function() {
            window.print();
        });
    </script>
</body>
</html>
