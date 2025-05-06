<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Struk Pembayaran</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .receipt {
            width: 300px;
            margin: auto;
            border: 1px dashed #333;
            padding: 20px;
        }

        .header,
        .footer {
            text-align: center;
        }

        .items {
            margin-top: 20px;
        }

        .items table {
            width: 100%;
            border-collapse: collapse;
        }

        .items td {
            padding: 4px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="receipt">
        <div class="header">
            <h3>{{ $transaction->tenant->nama }}</h3>
            <p>Nomor Order: {{ $transaction->nomor_order }}</p>
            <p>{{ $transaction->created_at->format('d-m-Y H:i') }}</p>
        </div>

        <div class="items">
            <table>
                @foreach ($transaction->transactionDetails as $item)
                    <tr>
                        <td>{{ $item->produk->nama }}</td>
                        <td>x{{ $item->jumlah }}</td>
                        <td align="right">Rp {{ number_format($item->subtotal) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="2"><strong>Total</strong></td>
                    <td align="right"><strong>Rp {{ number_format($transaction->total_harga) }}</strong></td>
                </tr>
                <tr>
                    <td colspan="3" align="center" style="padding-top: 10px;">
                        <span class="badge bg-success">TERBAYAR</span>
                        {{-- <span class="badge bg-success">Struk Copy</span> --}}
                    </td>
                </tr>
            </table>
        </div>

        <div class="footer">
            <p>Terima kasih!</p>
            <p>Struk Copy</p>
        </div>
    </div>
</body>

</html>
