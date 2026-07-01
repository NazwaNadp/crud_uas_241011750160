@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container py-5">
    <h2 class="font-display mb-4"><i class="fa-solid fa-bag-shopping me-2"></i>Checkout</h2>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h5 class="font-display mb-3">Data Pemesan</h5>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('keranjang.prosesCheckout') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama_pemesan" value="{{ old('nama_pemesan') }}"
                                   class="form-control @error('nama_pemesan') is-invalid @enderror"
                                   placeholder="Masukkan nama lengkap kamu" required>
                            @error('nama_pemesan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor HP <span class="text-danger">*</span></label>
                            <input type="text" name="no_hp" value="{{ old('no_hp') }}"
                                   class="form-control @error('no_hp') is-invalid @enderror"
                                   placeholder="Contoh: 08123456789" required>
                            @error('no_hp')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Catatan (opsional)</label>
                            <textarea name="catatan" class="form-control" rows="3"
                                      placeholder="Contoh: tanpa gula, antar ke meja 5...">{{ old('catatan') }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-brand w-100">
                            <i class="fa-solid fa-check me-1"></i> Konfirmasi Pesanan
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card border-0 shadow-sm" style="border-radius: 16px;">
                <div class="card-body p-4">
                    <h5 class="font-display mb-3">Ringkasan Pesanan</h5>
                    @foreach ($keranjang as $item)
                        <div class="d-flex justify-content-between mb-2 small">
                            <span>{{ $item['nama_dessert'] }} <span class="text-muted">x{{ $item['jumlah'] }}</span></span>
                            <span>Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                    <hr>
                    <div class="d-flex justify-content-between fw-bold">
                        <span>Total</span>
                        <span class="text-danger">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </div>
                    <a href="{{ route('keranjang.index') }}" class="btn btn-outline-secondary w-100 mt-3 btn-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Keranjang
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
