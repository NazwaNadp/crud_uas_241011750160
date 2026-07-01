<?php $__env->startSection('title', 'Katalog Menu Dessert'); ?>

<?php $__env->startSection('content'); ?>
    <section class="hero-section py-5 mb-4">
        <div class="container text-center py-4">
            <h1 class="font-display display-5 mb-3">Selamat Datang di Purely Dessert</h1>
            <p class="lead text-muted mb-0">Jelajahi koleksi menu dessert favorit kami &mdash; manis, lembut, dan menggoda.</p>
        </div>
    </section>

    <div class="container pb-5">

        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-1"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <form method="GET" action="<?php echo e(route('home')); ?>" class="row g-2 mb-4 justify-content-center">
            <div class="col-md-5">
                <input type="text" name="search" value="<?php echo e(request('search')); ?>" class="form-control" placeholder="Cari nama dessert...">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select">
                    <option value="">Semua Kategori</option>
                    <?php $__currentLoopData = $kategoriList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kategori): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($kategori); ?>" <?php echo e(request('kategori') == $kategori ? 'selected' : ''); ?>>
                            <?php echo e($kategori); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-brand w-100">
                    <i class="fa-solid fa-magnifying-glass me-1"></i> Cari
                </button>
            </div>
        </form>

        <?php if($desserts->isEmpty()): ?>
            <div class="text-center py-5">
                <i class="fa-solid fa-cookie-bite fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data menu dessert yang tersedia.</p>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php $__currentLoopData = $desserts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $dessert): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card dessert-card" style="cursor: pointer;"
                             data-bs-toggle="modal"
                             data-bs-target="#modalDessert"
                             data-id="<?php echo e($dessert->id_dessert); ?>"
                             data-nama="<?php echo e($dessert->nama_dessert); ?>"
                             data-kategori="<?php echo e($dessert->kategori); ?>"
                             data-komposisi="<?php echo e($dessert->komposisi); ?>"
                             data-harga="<?php echo e($dessert->harga); ?>"
                             data-harga-format="<?php echo e(number_format($dessert->harga, 0, ',', '.')); ?>"
                             data-gambar="<?php echo e($dessert->gambar ? asset('storage/' . $dessert->gambar) : ''); ?>">
                            <?php if($dessert->gambar): ?>
                                <img src="<?php echo e(asset('storage/' . $dessert->gambar)); ?>" alt="<?php echo e($dessert->nama_dessert); ?>" class="card-img-top">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center bg-light" style="height:200px;">
                                    <i class="fa-solid fa-image fa-2x text-muted"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <span class="badge badge-kategori mb-2"><?php echo e($dessert->kategori); ?></span>
                                <h5 class="card-title font-display"><?php echo e($dessert->nama_dessert); ?></h5>
                                <p class="card-text text-muted small mb-2" style="min-height: 40px;">
                                    <?php echo e(\Illuminate\Support\Str::limit($dessert->komposisi, 60)); ?>

                                </p>
                                <p class="text-danger small mb-0 fw-semibold">
                                    <i class="fa-solid fa-circle-info me-1"></i> Klik untuk lihat harga
                                </p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <div class="d-flex justify-content-center mt-5">
                <?php echo e($desserts->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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

        fetch('<?php echo e(route('keranjang.tambah')); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\crud_uas_241011750160\resources\views/home.blade.php ENDPATH**/ ?>