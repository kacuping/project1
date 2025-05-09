@extends('layouts.app') <!-- Ganti dengan layout kamu jika berbeda -->

@section('content')
    <div class="container-fluid">
        <h4 class="mb-4">POS System - Tenant</h4>
        <div class="row">
            <!-- Produk Section -->
            <div class="col-md-8">
                <div class="row" id="product-list">
                    @foreach ($produk as $item)
                        <div class="col-md-3 mb-3">
                            <div class="card h-100 border-0 shadow-sm hover-shadow"
                                onclick="addToCart({{ $item->id }}, '{{ $item->nama }}', {{ $item->harga }})"
                                style="cursor:pointer;">
                                <div class="card-body text-center">
                                    <h6 class="fw-semibold">{{ $item->nama }}</h6>
                                    <p class="text-success fw-bold mb-0">
                                        Rp {{ number_format($item->harga, 0, ',', '.') }}
                                    </p>
                                    <small class="text-muted">Klik untuk tambah</small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Cart Section -->
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header fw-bold">Keranjang</div>
                    <div class="card-body p-3" id="cart-body">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-end">Subtotal</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cart-items">
                                <!-- Item akan ditambahkan lewat JS -->
                            </tbody>
                        </table>
                        <hr>
                        <div class="d-flex justify-content-between fw-bold">
                            <span>Total:</span>
                            <span id="cart-total" class="text-success">Rp 0</span>
                        </div>
                        <form id="checkout-form" action="{{ route('tenant.transaksi.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="items" id="cart-data">
                            <button type="button" class="btn btn-success w-100 mt-3" data-bs-toggle="modal"
                                data-bs-target="#confirmModal">
                                <i class="fa fa-shopping-cart me-1"></i> Order
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin melanjutkan transaksi ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" onclick="submitOrder()">Ya, Lanjutkan</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        let cart = {};

        function addToCart(id, name, price) {
            if (cart[id]) {
                cart[id].qty += 1;
            } else {
                cart[id] = {
                    id,
                    name,
                    price,
                    qty: 1
                };
            }
            renderCart();
        }

        function removeItem(id) {
            delete cart[id];
            renderCart();
        }

        function changeQty(id, delta) {
            cart[id].qty += delta;
            if (cart[id].qty <= 0) removeItem(id);
            renderCart();
        }

        function renderCart() {
            const tbody = document.getElementById('cart-items');
            tbody.innerHTML = '';
            let total = 0;

            for (const id in cart) {
                const item = cart[id];
                const subtotal = item.qty * item.price;
                total += subtotal;

                tbody.innerHTML += `
                <tr>
                    <td>${item.name}</td>
                    <td class="text-center">
                        <button type="button" class="qty-btn" onclick="changeQty(${id}, -1)">−</button>
                            <span>${item.qty}</span>
                        <button type="button" class="qty-btn" onclick="changeQty(${id}, 1)">+</button>
                    </td>
                    <td>Rp ${subtotal.toLocaleString('id-ID')}</td>
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeItem(${id})">x</button></td>
                </tr>
            `;
            }

            document.getElementById('cart-total').innerText = `Rp ${total.toLocaleString('id-ID')}`;
        }

        function submitOrder() {
            if (prepareCheckout()) {
                document.getElementById('checkout-form').submit();
            }
        }

        function prepareCheckout() {
            // const confirmOrder = confirm("Apakah Anda yakin ingin melanjutkan transaksi?");
            // if (!confirmOrder) return false; // batal kalau user klik Cancel

            // Menyusun data cart dari objek cart yang aktif
            const cartArray = Object.values(cart).map(item => ({
                id: item.id,
                jumlah: item.qty,
                harga: item.price,
                subtotal: item.qty * item.price
            }));

            if (cartArray.length === 0) {
                alert('Keranjang masih kosong!');
                return false;
            }

            document.getElementById('cart-data').value = JSON.stringify(cartArray);
            return true; // lanjut submit

            // const cartData = JSON.stringify(window.cart || []);
            // document.getElementById('cart-data').value = cartData;
            // return true;
        }
    </script>
@endsection

@push('styles')
    <style>
        .hover-shadow:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            transition: all 0.2s ease-in-out;
        }

        button.qty-btn {
            border: none;
            background: none;
            padding: 0 5px;
            font-weight: bold;
            font-size: 1rem;
            color: #0d6efd;
        }

        button.qty-btn:hover {
            color: #0a58ca;
        }
    </style>
@endpush
