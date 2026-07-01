@extends('layouts.app')

@section('title', 'Katalog Menu Dessert')

@section('content')
    <section class="hero-section py-5 mb-4">
        <div class="container text-center py-4">
            <h1 class="font-display display-5 mb-3">Selamat Datang di Purely Dessert</h1>
            <p class="lead text-muted mb-0">Jelajahi koleksi menu dessert favorit kami &mdash; manis, lembut, dan menggoda.</p>
        </div>
    </section>

    <div class="container pb-5">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="GET" action="{{ route('home') }}" class="row g-2 mb-4 justify-content-center">
            <div class="col-md-5">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Cari nama dessert...">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach ($kategoriList as $kategori)
                        <option value="{{ $kategori }}" {{ request('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-brand w-100">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                </button>
            </div>
        </form>

        @if ($desserts->isEmpty())
            <div class="text-center py-5">
                <i class="fa-solid fa-cookie-bite fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data menu dessert yang tersedia.</p>
            </div>
        @else
            <div class="row g-4">
                @foreach ($desserts as $dessert)
                    <div class="col-sm-6 col-lg-3">
                        <div class="card dessert-card" style="cursor: pointer;"
                             data-bs-toggle="modal"
                             data-bs-target="#modalDessert"
                             data-id="{{ $dessert->id_dessert }}"
                             data-nama="{{ $dessert->nama_dessert }}"
                             data-kategori="{{ $dessert->kategori }}"
                             data-komposisi="{{ $dessert->komposisi }}"
                             data-harga="{{ $dessert->harga }}"
                             data-harga-format="{{ number_format($dessert->harga, 0, ',', '.') }}"
                             data-gambar="{{ $dessert->gambar ? asset('storage/' . $dessert->gambar) : '' }}">
                            @if ($dessert->gambar)
                                <img src="{{ asset('storage/' . $dessert->gambar) }}" alt="{{ $dessert->nama_dessert }}" class="card-img-top">
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                                    <i class="fa-solid fa-image fa-2x text-muted"></i>
                                </div>
                            @endif
                            <div class="card-body">
                                <span class="badge badge-kategori mb-2">{{ $dessert->kategori }}</span>
                                <h5 class="card-title font-display">{{ $dessert->nama_dessert }}</h5>
                                <p class="card-text text-muted small mb-2" style="min-height: 40px;">
                                    {{ \Illuminate\Support\Str::limit($dessert->komposisi, 60) }}
                                </p>
                                <p class="text-danger small mb-0 fw-semibold">
                                    <i class="fa-solid fa-circle-info me-1"></i> Klik untuk lihat harga
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-5">
                {{ $desserts->links() }}
            </div>
        @endif
    </div>

    {{-- Modal Detail Dessert --}}
    <div class="modal fade" id="modalDessert" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 18px;">
                <div class="modal-header border-0">
                    <h5 class="modal-title font-display" id="modalDessertNama">Nama Dessert</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body pt-0">
                    <img id="modalDessertGambar" src="" alt="" class="img-fluid rounded mb-3 w-100" style="height: 220px; object-fit: cover;">
                    <span class="badge badge-kategori mb-2" id="modalDessertKategori">Kategori</span>
                    <p class="text-muted mb-2" id="modalDessertKomposisi"></p>
                    <h4 class="text-danger fw-bold mb-3" id="modalDessertHarga">Rp 0</h4>

                    <div class="d-flex align-items-center gap-2 mb-3">
                        <label class="fw-semibold mb-0">Jumlah:</label>
                        <div class="input-group" style="width: 130px;">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnKurang">-</button>
                            <input type="number" id="inputJumlah" class="form-control form-control-sm text-center" value="1" min="1" max="99">
                            <button class="btn btn-outline-secondary btn-sm" type="button" id="btnTambah">+</button>
                        </div>
                    </div>

                    <button type="button" id="btnTambahKeranjang" class="btn btn-brand w-100">
                        <i class="fa-solid fa-cart-plus me-1"></i> Tambah ke Keranjang
                    </button>

                    <div id="alertKeranjang" class="alert mt-2 d-none"></div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    var currentDessertId = null;

    document.getElementById('modalDessert').addEventListener('show.bs.modal', function (event) {
        var card = event.relatedTarget;
        currentDessertId = card.getAttribute('data-id');

        document.getElementById('modalDessertNama').textContent = card.getAttribute('data-nama');
        document.getElementById('modalDessertKategori').textContent = card.getAttribute('data-kategori');
        document.getElementById('modalDessertKomposisi').textContent = card.getAttribute('data-komposisi');
        document.getElementById('modalDessertHarga').textContent = 'Rp ' + card.getAttribute('data-harga-format');
        document.getElementById('inputJumlah').value = 1;
        document.getElementById('alertKeranjang').className = 'alert mt-2 d-none';

        var gambar = card.getAttribute('data-gambar');
        var imgEl = document.getElementById('modalDessertGambar');
        if (gambar) {
            imgEl.src = gambar;
            imgEl.style.display = 'block';
        } else {
            imgEl.style.display = 'none';
        }
    });

    document.getElementById('btnKurang').addEventListener('click', function () {
        var input = document.getElementById('inputJumlah');
        if (parseInt(input.value) > 1) input.value = parseInt(input.value) - 1;
    });

    document.getElementById('btnTambah').addEventListener('click', function () {
        var input = document.getElementById('inputJumlah');
        if (parseInt(input.value) < 99) input.value = parseInt(input.value) + 1;
    });

    document.getElementById('btnTambahKeranjang').addEventListener('click', function () {
        var jumlah = document.getElementById('inputJumlah').value;
        var btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> Menambahkan...';

        fetch('{{ route('keranjang.tambah') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ dessert_id: currentDessertId, jumlah: jumlah })
        })
        .then(res => res.json())
        .then(data => {
            var alert = document.getElementById('alertKeranjang');
            alert.className = 'alert mt-2 alert-success';
            alert.innerHTML = '<i class="fa-solid fa-check me-1"></i> ' + data.message;

            var badge = document.getElementById('keranjangBadge');
            if (badge) badge.textContent = data.count;

            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-cart-plus me-1"></i> Tambah ke Keranjang';
        })
        .catch(() => {
            var alert = document.getElementById('alertKeranjang');
            alert.className = 'alert mt-2 alert-danger';
            alert.innerHTML = 'Gagal menambahkan ke keranjang.';
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-cart-plus me-1"></i> Tambah ke Keranjang';
        });
    });
</script>
@endpush
