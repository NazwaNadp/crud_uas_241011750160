@extends('layouts.admin')

@section('title', 'Data Menu Dessert')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <div>
        <h4 class="font-display mb-0">Data Menu Dessert</h4>
        <p class="text-muted small mb-0">Kelola data menu dessert: tambah, ubah, hapus, dan cetak laporan.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('desserts.export-pdf') }}" class="btn btn-outline-danger">
            <i class="fa-solid fa-file-pdf me-1"></i> Export PDF
        </a>
        <a href="{{ route('desserts.create') }}" class="btn btn-brand">
            <i class="fa-solid fa-plus me-1"></i> Tambah Data
        </a>
    </div>
</div>

<div class="card card-stat">
    <div class="card-body">
        <div class="table-responsive">
            <table id="tabelDessert" class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Gambar</th>
                        <th>Nama Dessert</th>
                        <th>Komposisi</th>
                        <th>Harga</th>
                        <th>Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($desserts as $dessert)
                        <tr>
                            <td>{{ $dessert->id_dessert }}</td>
                            <td>
                                @if ($dessert->gambar)
                                    <img src="{{ asset('storage/' . $dessert->gambar) }}" class="table-thumb" alt="{{ $dessert->nama_dessert }}">
                                @else
                                    <div class="table-thumb bg-light d-flex align-items-center justify-content-center">
                                        <i class="fa-solid fa-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td class="fw-semibold">{{ $dessert->nama_dessert }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($dessert->komposisi, 50) }}</td>
                            <td>Rp {{ number_format($dessert->harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-secondary">{{ $dessert->kategori }}</span></td>
                            <td class="text-center">
                                <div class="d-flex gap-1 justify-content-center">
                                    <a href="{{ route('desserts.show', $dessert) }}" class="btn btn-sm btn-outline-info" title="Lihat">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('desserts.edit', $dessert) }}" class="btn btn-sm btn-outline-warning" title="Edit">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form action="{{ route('desserts.destroy', $dessert) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">Belum ada data menu dessert.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $desserts->links() }}
</div>
@endsection

@push('scripts')
<script>
    $(function () {
        $('#tabelDessert').DataTable({
            paging: false,
            searching: true,
            ordering: true,
            info: false,
            language: {
                search: "Cari di halaman ini:",
                zeroRecords: "Data tidak ditemukan",
                emptyTable: "Belum ada data menu dessert."
            }
        });
    });
</script>
@endpush
