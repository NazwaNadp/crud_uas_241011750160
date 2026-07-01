@extends('layouts.admin')

@section('title', 'Kelola Pesanan')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="font-display mb-0">Kelola Pesanan Masuk</h4>
        <p class="text-muted small mb-0">Daftar pesanan dari pelanggan.</p>
    </div>
    <form method="GET" action="{{ route('pesanan.index') }}" class="d-flex gap-2">
        <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
            <option value="">Semua Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="diproses" {{ request('status') == 'diproses' ? 'selected' : '' }}>Diproses</option>
            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
        </select>
    </form>
</div>

<div class="card card-stat">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Menu Dessert</th>
                        <th>Pemesan</th>
                        <th>No HP</th>
                        <th>Jumlah</th>
                        <th>Total</th>
                        <th>Catatan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pesanan as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td class="fw-semibold">{{ $p->dessert->nama_dessert ?? '-' }}</td>
                            <td>{{ $p->nama_pemesan }}</td>
                            <td>{{ $p->no_hp }}</td>
                            <td>{{ $p->jumlah }}</td>
                            <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                            <td class="text-muted small">{{ $p->catatan ?? '-' }}</td>
                            <td>{!! $p->label_status !!}</td>
                            <td>
                                <div class="d-flex gap-1 justify-content-center flex-wrap">
                                    <form action="{{ route('pesanan.updateStatus', $p) }}" method="POST" class="d-flex gap-1">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm" style="width: 110px;">
                                            <option value="pending" {{ $p->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="diproses" {{ $p->status == 'diproses' ? 'selected' : '' }}>Diproses</option>
                                            <option value="selesai" {{ $p->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                            <option value="dibatalkan" {{ $p->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-brand">Ubah</button>
                                    </form>
                                    <form action="{{ route('pesanan.destroy', $p) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">Belum ada pesanan masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $pesanan->links() }}
</div>
@endsection
