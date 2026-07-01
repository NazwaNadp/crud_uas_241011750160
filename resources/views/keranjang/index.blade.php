@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="container py-5">
    <h2 class="font-display mb-4"><i class="fa-solid fa-cart-shopping me-2"></i>Keranjang Belanja</h2>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (empty($keranjang))
        <div class="text-center py-5">
            <i class="fa-solid fa-cart-shopping fa-3x text-muted mb-3"></i>
            <p class="text-muted">Keranjang kamu masih kosong.</p>
            <a href="{{ route('home') }}" class="btn btn-brand">
                <i class="fa-solid fa-arrow-left me-1"></i> Lihat Menu Dessert
            </a>
        </div>
    @else
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                    <div class="card-body p-0">
                        @foreach ($keranjang as $key => $item)
                            <div class="d-flex align-items-center gap-3 p-3 border-bottom">
                                @if ($item['gambar'])
                                    <img src="{{ asset('storage/' . $item['gambar']) }}" alt="{{ $item['nama_dessert'] }}"
                                         style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                         style="width: 80px; height: 80px; border-radius: 12px;">
                                        <i class="fa-solid fa-image text-muted"></i>
                                    </div>
                                @endif
                                <div class="flex-grow-1">
                                    <h6 class="font-display mb-1">{{ $item['nama_dessert'] }}</h6>
                                    <p class="text-danger fw-semibold mb-0">Rp {{ number_format($item['harga'], 0, ',', '.') }}</p>
                                </div>
                                <div class="d-flex flex-column align-items-end gap-2">
                                    <form action="{{ route('keranjang.update', $key) }}" method="POST" class="d-flex align-items-center gap-1">
                                        @csrf
                                        <div class="input-group input-group-sm" style="width: 110px;">
                                            <span class="input-group-text">Qty</span>
                                            <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" min="1" max="99"
                                                   class="form-control text-center" onchange="this.form.submit()">
                                        </div>
                                    </form>
                                    <p class="mb-0 small text-muted">
                                        Subtotal: <strong class="text-dark">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</strong>
                                    </p>
                                    <form action="{{ route('keranjang.hapus', $key) }}" method="POST" onsubmit="return confirm('Hapus item ini?')">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <form action="{{ route('keranjang.kosongkan') }}" method="POST" onsubmit="return confirm('Kosongkan semua keranjang?')" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">
                        <i class="fa-solid fa-trash me-1"></i> Kosongkan Keranjang
                    </button>
                </form>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="border-radius: 16px; top: 90px;">
                    <div class="card-body p-4">
                        <h5 class="font-display mb-3">Ringkasan Pesanan</h5>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Total Item</span>
                            <span class="fw-semibold">{{ array_sum(array_column($keranjang, 'jumlah')) }} item</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="fw-bold">Total Harga</span>
                            <span class="fw-bold text-danger">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <a href="{{ route('keranjang.checkout') }}" class="btn btn-brand w-100">
                            <i class="fa-solid fa-bag-shopping me-1"></i> Checkout Sekarang
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="fa-solid fa-arrow-left me-1"></i> Lanjut Belanja
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
