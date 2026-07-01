@extends('layouts.admin')

@section('title', 'Detail Data Dessert')

@section('content')
<div class="mb-4">
    <h4 class="font-display mb-0">Detail Menu Dessert</h4>
    <p class="text-muted small mb-0">Informasi lengkap data menu dessert.</p>
</div>

<div class="card card-stat">
    <div class="card-body p-4">
        <div class="row g-4">
            <div class="col-md-4">
                @if ($dessert->gambar)
                    <img src="{{ asset('storage/' . $dessert->gambar) }}" alt="{{ $dessert->nama_dessert }}"
                         class="img-fluid rounded" style="width: 100%; height: 240px; object-fit: cover;">
                @else
                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 240px;">
                        <i class="fa-solid fa-image fa-2x text-muted"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-8">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 180px;">ID Dessert</th>
                        <td>: {{ $dessert->id_dessert }}</td>
                    </tr>
                    <tr>
                        <th>Nama Dessert</th>
                        <td>: {{ $dessert->nama_dessert }}</td>
                    </tr>
                    <tr>
                        <th>Kategori</th>
                        <td>: <span class="badge bg-secondary">{{ $dessert->kategori }}</span></td>
                    </tr>
                    <tr>
                        <th>Harga</th>
                        <td>: Rp {{ number_format($dessert->harga, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <th>Komposisi</th>
                        <td>: {{ $dessert->komposisi }}</td>
                    </tr>
                    <tr>
                        <th>Ditambahkan</th>
                        <td>: {{ $dessert->created_at->translatedFormat('d F Y, H:i') }}</td>
                    </tr>
                </table>

                <div class="d-flex gap-2 mt-3">
                    <a href="{{ route('desserts.edit', $dessert) }}" class="btn btn-warning">
                        <i class="fa-solid fa-pen me-1"></i> Edit
                    </a>
                    <a href="{{ route('desserts.index') }}" class="btn btn-outline-secondary">
                        <i class="fa-solid fa-arrow-left me-1"></i> Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
