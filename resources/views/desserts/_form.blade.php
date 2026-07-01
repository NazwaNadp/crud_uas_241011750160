@csrf
@if (isset($dessert))
    @method('PUT')
@endif

<div class="row g-4">
    <div class="col-md-6">
        <div class="mb-3">
            <label for="nama_dessert" class="form-label">Nama Dessert <span class="text-danger">*</span></label>
            <input type="text" id="nama_dessert" name="nama_dessert"
                   value="{{ old('nama_dessert', $dessert->nama_dessert ?? '') }}"
                   class="form-control @error('nama_dessert') is-invalid @enderror"
                   placeholder="Contoh: Tiramisu Klasik" required>
            @error('nama_dessert')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
            <select id="kategori" name="kategori" class="form-select @error('kategori') is-invalid @enderror" required>
                <option value="">-- Pilih Kategori --</option>
                @foreach ($kategoriList as $kategori)
                    <option value="{{ $kategori }}" {{ old('kategori', $dessert->kategori ?? '') == $kategori ? 'selected' : '' }}>
                        {{ $kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga (Rp) <span class="text-danger">*</span></label>
            <input type="number" step="0.01" min="0" id="harga" name="harga"
                   value="{{ old('harga', $dessert->harga ?? '') }}"
                   class="form-control @error('harga') is-invalid @enderror"
                   placeholder="Contoh: 25000" required>
            @error('harga')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="komposisi" class="form-label">Komposisi <span class="text-danger">*</span></label>
            <textarea id="komposisi" name="komposisi" rows="4"
                      class="form-control @error('komposisi') is-invalid @enderror"
                      placeholder="Contoh: Biskuit ladyfinger, mascarpone, kopi, cokelat bubuk" required>{{ old('komposisi', $dessert->komposisi ?? '') }}</textarea>
            @error('komposisi')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
    </div>

    <div class="col-md-6">
        <div class="mb-3">
            <label for="gambar" class="form-label">
                Gambar Dessert
                @if (!isset($dessert))
                    <span class="text-danger">*</span>
                @endif
            </label>
            <input type="file" id="gambar" name="gambar" accept="image/*"
                   class="form-control @error('gambar') is-invalid @enderror">
            <div class="form-text">Format JPG/PNG/WEBP, maksimal 2MB.</div>
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if (isset($dessert) && $dessert->gambar)
                <div class="mt-3">
                    <p class="small text-muted mb-1">Gambar saat ini:</p>
                    <img src="{{ asset('storage/' . $dessert->gambar) }}" alt="{{ $dessert->nama_dessert }}"
                         class="rounded" style="width: 160px; height: 160px; object-fit: cover;">
                </div>
            @endif
        </div>
    </div>
</div>

<div class="d-flex gap-2 mt-3">
    <button type="submit" class="btn btn-brand">
        <i class="fa-solid fa-floppy-disk me-1"></i> Simpan
    </button>
    <a href="{{ route('desserts.index') }}" class="btn btn-outline-secondary">
        <i class="fa-solid fa-arrow-left me-1"></i> Batal
    </a>
</div>
