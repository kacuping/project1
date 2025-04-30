<!DOCTYPE html>
<html>

<head>
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
        }

        .receipt {
            width: 80mm;
            margin: 0 auto;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .transaction-info {
            margin-bottom: 15px;
        }

        .transaction-info p {
            margin: 5px 0;
        }

        .items {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
            padding: 10px 0;
            margin: 10px 0;
        }

        .item {
            margin-bottom: 5px;
        }

        .total {
            text-align: right;
            margin-top: 10px;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
        }

        @media print {
            body {
                width: 80mm;
                margin: 0;
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="header">
            <h2>{{ $tenant->name }}</h2>
        </div>

        <div class="transaction-info">
            <p>No. Order: {{ $transaction->nomor_order }}</p>
            <p>Tanggal: {{ $transaction->created_at->format('d/m/Y') }}</p>
            <p>Waktu: {{ $transaction->created_at->format('H:i:s') }}</p>
        </div>

        <div class="items">
            @foreach ($transaction->transaksiDetails as $detail)
                <div class="item">
                    <p>{{ $detail->produk->nama }}</p>
                    <p>{{ $detail->jumlah }} x {{ number_format($detail->harga_satuan, 0, ',', '.') }} =
                        {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>

        <div class="total">
            <p><strong>Total: Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</strong></p>
            <p>Status: {{ ucfirst($transaction->status) }}</p>
        </div>

        <div class="footer">
            <p>Terima kasih atas kunjungan Anda!</p>
        </div>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
