<!DOCTYPE html>
<html>

<head>
    <title>Struk Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .receipt {
            width: 300px;
            margin: 0 auto;
            border: 1px dashed #000;
            padding: 10px;
        }

        .center {
            text-align: center;
        }

        .paid {
            background-color: #d4edda;
            color: #155724;
            padding: 4px;
            text-align: center;
            font-weight: bold;
            border: 1px solid #c3e6cb;
            margin-bottom: 10px;
        }

        .items td {
            padding: 5px 0;
        }
    </style>
</head>

<body>
    <div class="receipt">
        <div class="center">
            <h3>{{ $transaksi->tenant->nama }}</h3>
            <p><strong>Order #{{ $transaksi->nomor_order }}</strong></p>
        </div>

        <div class="paid">SUDAH DIBAYAR</div>

        <table width="100%" class="items">
            @foreach ($transaksi->transactionDetails as $detail)
                <tr>
                    <td>{{ $detail->produk->nama }}</td>
                    <td>{{ $detail->jumlah }} x {{ number_format($detail->harga_satuan, 0) }}</td>
                    <td style="text-align:right">{{ number_format($detail->subtotal, 0) }}</td>
                </tr>
            @endforeach
        </table>

        <hr>
        <p><strong>Total: </strong>Rp {{ number_format($transaksi->total_harga, 0) }}</p>
        <p><em>Terima kasih!</em></p>
    </div>

    <script>
        window.print();
    </script>

    <div style="text-align: center; margin-top: 20px;">
        <button onclick="window.print()">🖨️ Cetak Ulang</button>
        <a href="{{ route('kasir.dashboard') }}">
            <button>⬅️ Kembali ke Kasir</button>
        </a>
    </div>
</body>

</html>
