@extends('layouts.app')

@section('content')
    <div class="container">
        <script>
            let cart = [];
            let total = 0;

            function formatRupiah(amount) {
                return new Intl.NumberFormat('id-ID').format(amount);
            }

            function addToCart(id, nama, harga, tenant) {
                const existingItem = cart.find(item => item.id === id);

                if (existingItem) {
                    // existingItem.qty += 1;
                    existingItem.subtotal = existingItem.qty * existingItem.harga;
                } else {
                    cart.push({
                        id: id,
                        nama: nama,
                        harga: harga,
                        qty: 1,
                        subtotal: harga,
                        tenant: tenant
                    });
                }

                updateCart();
            }

            function removeFromCart(id) {
                cart = cart.filter(item => item.id !== id);
                updateCart();
            }

            function updateQty(id, delta) {
                const item = cart.find(item => item.id === id);
                if (item) {
                    item.qty = Math.max(1, item.qty + delta);
                    item.subtotal = item.qty * item.harga;
                    updateCart();
                }
            }

            function updateCart() {
                const cartContainer = document.getElementById('cart-items');
                cartContainer.innerHTML = '';
                total = 0;

                cart.forEach(item => {
                    total += item.subtotal;
                    cartContainer.innerHTML += `
                        <div class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">${item.nama}</h6>
                                    <small class="text-muted">Rp ${formatRupiah(item.harga)}</small>
                                </div>
                                <div class="d-flex align-items-center">
                                    <button class="btn btn-sm btn-outline-danger ms-2" onclick="removeFromCart(${item.id})">×</button>
                                </div>
                            </div>
                        </div>
                    `;
                });

                document.getElementById('cart-subtotal').textContent = `Rp ${formatRupiah(total)}`;
            }

            // function processPayment() {
            //     if (cart.length === 0) {
            //         alert('Cart masih kosong!');
            //         return;
            //     }

            //     const paymentMethod = document.getElementById('payment-method').value;
            //     // Implementasi proses pembayaran di sini
            //     // console.log('Processing payment:', {
            //     //     items: cart,
            //     //     total: total,
            //     //     method: paymentMethod
            //     // });

            //     fetch('/kasir/checkout', {
            //             method: 'POST',
            //             headers: {
            //                 'Content-Type': 'application/json',
            //                 'X-CSRF-TOKEN': '{{ csrf_token() }}'
            //             },
            //             body: JSON.stringify({
            //                 items: cart,
            //                 method: paymentMethod
            //             })
            //         })
            //         .then(response => response.json())
            //         .then(data => {
            //             if (data.success) {
            //                 showReceipt(); // gunakan cart yang sudah ada
            //             } else {
            //                 alert('Gagal menyimpan transaksi');
            //             }
            //         });
            // }

            function processPayment() {
                console.log("Tombol pembayaran diklik!");

                if (cart.length === 0) {
                    alert("Keranjang kosong.");
                    return;
                }

                showModalKonfirmasiPembayaran(cart);
            }

            function showModalKonfirmasiPembayaran(items) {
                const modalBody = document.getElementById('modalItemList');
                modalBody.innerHTML = ''; // bersihkan isi sebelumnya

                let totalBayar = 0;

                items.forEach(item => {
                    totalBayar += item.subtotal;

                    modalBody.innerHTML += `
            <tr>
                <td>${item.nama}</td>
                <td>${item.tenant}</td>
                <td>Rp ${formatRupiah(item.subtotal)}</td>
            </tr>
        `;
                });

                document.getElementById('modalOrderId').textContent = items.map(i => i.id).join(', ');
                document.getElementById('modalTotalBayar').textContent = formatRupiah(totalBayar);

                // document.getElementById('modalTotal').innerText = total;
                document.getElementById('inputTotal').value = total;
                document.getElementById('jumlahBayar').value = '';
                document.getElementById('modalKembalian').innerText = '0';
                document.getElementById('btnSubmitPembayaran').disabled = true;

                // encode cart sebagai JSON string untuk dikirim ke server
                document.getElementById('inputItems').value = JSON.stringify(cart);

                // new bootstrap.Modal(document.getElementById('modalKonfirmasi')).show();

                document.getElementById('jumlahBayar').addEventListener('input', function() {
                    const bayar = parseInt(this.value) || 0;
                    const kembalian = bayar - total;
                    document.getElementById('modalKembalian').innerText = kembalian > 0 ? kembalian : 0;
                    document.getElementById('btnSubmitPembayaran').disabled = bayar < total;
                });

                const modal = new bootstrap.Modal(document.getElementById('konfirmasiModal'));
                modal.show();
            }
        </script>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form class="mb-3" method="GET">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Cari nomor order atau tenant..."
                    value="{{ request('q') }}">
                <button class="btn btn-primary" type="submit">Cari</button>
            </div>
        </form>

        <div class="row">
            <!-- Daftar Produk -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Orders</h5>
                    </div>

                    <div class="card-body p-4">
                        <div class="row g-3">
                            @foreach ($transactions as $order)
                                <div class="col-md-4 mb-3">
                                    <div class="card shadow-sm h-100"
                                        onclick="addToCart({{ $order->id }}, '{{ $order->nomor_order }}', {{ (int) $order->total_harga }}, '{{ $order->tenant->nama }}')"
                                        style="cursor:pointer;">
                                        <div class="card-header bg-primary text-white">
                                            <div class="d-flex justify-content-between">
                                                <span><strong>{{ $order->nomor_order }}</strong></span>
                                                {{-- <span>{{ $order->tenant->nama }}</span> --}}
                                            </div>
                                            <span>{{ $order->tenant->nama }}</span>
                                        </div>

                                        <div class="card-body">
                                            <ul
                                                class="list-group
                                                list-group-flush small">
                                                @foreach ($order->transactionDetails as $item)
                                                    <li class="list-group-item d-flex justify-content-between">
                                                        <span>{{ $item->produk->nama }}</span>
                                                        <span>{{ $item->jumlah }} x Rp
                                                            {{ number_format($item->harga_satuan, 0, ',', '.') }}</span>
                                                    </li>
                                                @endforeach
                                            </ul>
                                            <hr>
                                            <div class="d-flex justify-content-between fw-bold">
                                                <span>Total</span>
                                                <span class="text-success">Rp
                                                    {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal Konfirmasi Pembayaran -->
                                <div class="modal fade" id="konfirmasiModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>Order ID:</strong> <span id="modalOrderId"></span></p>
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>Produk</th>
                                                            <th>Tenant</th>
                                                            {{-- <th>Jumlah</th> --}}
                                                            <th>Subtotal</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="modalItemList">
                                                        <!-- Baris produk di-generate via JavaScript -->
                                                    </tbody>
                                                </table>

                                                <p><strong>Total Pembayaran:</strong> Rp <span id="modalTotalBayar"></span>
                                                </p>

                                                <div class="mb-3">
                                                    <label for="metodePembayaran" class="form-label">Metode
                                                        Pembayaran</label>
                                                    <select class="form-select" id="metodePembayaran">
                                                        <option value="-">-- Pilih Metode Pembayaran --</option>
                                                        <option value="tunai">Tunai</option>
                                                        <option value="qris">QRIS</option>
                                                        <option value="debit">Debit</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="jumlahBayar" class="form-label">Jumlah Bayar (Tunai)</label>
                                                    <input type="text" name="jumlah_bayar" id="jumlahBayar"
                                                        class="form-control" required>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Kembalian</label>
                                                    <p class="form-control-plaintext">Rp<span id="modalKembalian">0 </span>
                                                    </p>
                                                </div>

                                                <input type="hidden" name="total" id="inputTotal">
                                                <input type="hidden" name="items" id="inputItems">

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-success" id="btnSubmitPembayaran"
                                                    disabled>Bayar</button>
                                                {{-- <button class="btn btn-primary mt-3" id="btnBayar">Bayar</button> --}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach



                            <div class="d-flex justify-content-center mt-4">
                                {{ $transactions->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cart -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Cart</h5>
                    </div>
                    <div class="card-body p-0">
                        <div id="cart-items" class="list-group list-group-flush">
                            <!-- Cart items will be inserted here -->
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="d-flex justify-content-between mb-3">
                            <h6 class="mb-0">Subtotal</h6>
                            <h6 class="mb-0" id="cart-subtotal">Rp 0</h6>
                        </div>
                        {{-- <div class="mb-3">
                            <select class="form-select" id="payment-method">
                                <option value="tunai">Tunai</option>
                                <option value="qris">QRIS</option>
                                <option value="kartu">Debit/Kredit</option>
                            </select>
                        </div> --}}
                        <button class="btn btn-success w-100" onclick="processPayment()">Konfirmasi
                            Pembayaran</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
