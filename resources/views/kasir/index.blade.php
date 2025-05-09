@extends('layouts.app')

@section('content')
    <div class="container">
        <script>
            let cart = [];
            let total = 0;

            function formatRupiah(amount) {
                return new Intl.NumberFormat('id-ID').format(amount);
            }

            function addToCart(id, nama, harga) {
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
                        subtotal: harga
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

            function processPayment() {
                if (cart.length === 0) {
                    alert('Cart masih kosong!');
                    return;
                }

                const paymentMethod = document.getElementById('payment-method').value;
                // Implementasi proses pembayaran di sini
                console.log('Processing payment:', {
                    items: cart,
                    total: total,
                    method: paymentMethod
                });
            }
        </script>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

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
                                        onclick="addToCart({{ $order->id }}, '{{ $order->nomor_order }}', {{ (int) $order->total_harga }})"
                                        style="cursor:pointer;">
                                        <div class="card-header bg-primary text-white">
                                            <div class="d-flex justify-content-between">
                                                <span><strong>{{ $order->nomor_order }}</strong></span>
                                                <span>{{ $order->tenant->name }}</span>
                                            </div>
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
                            @endforeach
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
                        <div class="mb-3">
                            <select class="form-select" id="payment-method">
                                <option value="tunai">Tunai</option>
                                <option value="qris">QRIS</option>
                                <option value="kartu">Debit/Kredit</option>
                            </select>
                        </div>
                        <button class="btn btn-success w-100" onclick="processPayment()">Konfirmasi Pembayaran</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="container mt-4">
            <div class="row">
                @foreach ($transactions as $order)
                    <div class="col-md-6 col-lg-3 mb-4">
                        <div class="card shadow-sm h-100" style="cursor:pointer;">
                            <div class="card-header bg-primary text-white">
                                <div class="d-flex justify-content-between">
                                    <span><strong>{{ $order->nomor_order }}</strong></span>
                                    <span>{{ $order->tenant->name }}</span>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <ul class="list-group
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
                            @if ($order->is_cart)
                                <div class="card-footer bg-light text-center">
                                    <form method="POST" action="{{ route('kasir.proses', $order->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm w-100">Konfirmasi
                                            Pembayaran</button>
                                    </form>
                                    <div class="mt-2">
                                        <label>Pembayaran:</label>
                                        <select class="form-select form-select-sm" name="metode">
                                            <option value="tunai">Tunai</option>
                                            <option value="qris">QRIS</option>
                                            <option value="kartu">Debit/Kredit</option>
                                        </select>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div> --}}




    </div>
@endsection
