<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Purely Dessert'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --brand-pink: #d6336c;
            --brand-cream: #fff8f1;
            --brand-dark: #3a2e2e;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: var(--brand-cream);
            color: var(--brand-dark);
        }
        .font-display {
            font-family: 'Playfair Display', serif;
        }
        .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: var(--brand-pink) !important;
        }
        .btn-brand {
            background-color: var(--brand-pink);
            border-color: var(--brand-pink);
            color: #fff;
        }
        .btn-brand:hover {
            background-color: #b32958;
            border-color: #b32958;
            color: #fff;
        }
        .hero-section {
            background: linear-gradient(135deg, #ffe3ec 0%, #fff8f1 100%);
            border-radius: 0 0 40px 40px;
        }
        .dessert-card {
            border: none;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 6px 20px rgba(0,0,0,0.06);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }
        .dessert-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 14px 28px rgba(0,0,0,0.12);
        }
        .dessert-card img {
            height: 200px;
            object-fit: cover;
        }
        .badge-kategori {
            background-color: var(--brand-pink);
            font-weight: 500;
        }
        footer {
            background-color: var(--brand-dark);
            color: #f5f0ea;
        }
        .pagination .page-link {
            color: var(--brand-pink);
        }
        .pagination .page-item.active .page-link {
            background-color: var(--brand-pink);
            border-color: var(--brand-pink);
        }
        .pagination .page-item.disabled .page-link {
            color: #bbb;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="fa-solid fa-cake-candles me-2"></i>Purely Dessert
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navMain">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('home')); ?>">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary btn-sm mt-2 mt-lg-0 position-relative" href="<?php echo e(route('keranjang.index')); ?>">
                            <i class="fa-solid fa-cart-shopping me-1"></i> Keranjang
                            <?php $jumlahKeranjang = count(session('keranjang', [])); ?>
                            <?php if($jumlahKeranjang > 0): ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="keranjangBadge">
                                    <?php echo e($jumlahKeranjang); ?>

                                </span>
                            <?php else: ?>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none" id="keranjangBadge">0</span>
                            <?php endif; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <?php if(auth()->guard()->check()): ?>
                            <a class="btn btn-brand btn-sm mt-2 mt-lg-0" href="<?php echo e(route('dashboard')); ?>">
                                <i class="fa-solid fa-gauge me-1"></i> Dashboard
                            </a>
                        <?php else: ?>
                            <a class="btn btn-outline-secondary btn-sm mt-2 mt-lg-0" href="<?php echo e(route('login')); ?>">
                                <i class="fa-solid fa-right-to-bracket me-1"></i> Login Admin
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    <footer class="py-4 mt-5">
        <div class="container text-center small">
            <p class="mb-0">&copy; <?php echo e(date('Y')); ?> Manis Dessert House &mdash; UAS Rekayasa Web, Universitas Pamulang</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\laragon\www\crud_uas_241011750160\resources\views/layouts/app.blade.php ENDPATH**/ ?>