<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin') | Purely Desserts</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --brand-pink: #d6336c;
            --brand-dark: #2b2230;
            --sidebar-bg: #2b2230;
        }
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f7f5f8;
        }
        .font-display {
            font-family: 'Playfair Display', serif;
        }
        .sidebar {
            min-height: 100vh;
            background-color: var(--sidebar-bg);
            color: #e8e3ee;
        }
        .sidebar .brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            color: #fff;
        }
        .sidebar a.nav-link {
            color: #c9c1d4;
            border-radius: 10px;
            margin-bottom: 4px;
        }
        .sidebar a.nav-link.active,
        .sidebar a.nav-link:hover {
            background-color: var(--brand-pink);
            color: #fff;
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
        .topbar {
            background: #fff;
            border-bottom: 1px solid #eee;
        }
        .card-stat {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05);
        }
        .table-thumb {
            width: 56px;
            height: 56px;
            object-fit: cover;
            border-radius: 8px;
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
    @stack('styles')
</head>
<body>
<div class="d-flex">
    <nav class="sidebar p-3 d-none d-md-block" style="width: 250px;">
        <div class="brand fs-5 mb-4 px-2">
            <i class="fa-solid fa-cake-candles me-2"></i>Dessert Admin
        </div>
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('desserts.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check me-2"></i> Data Menu Dessert
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pesanan.index') }}" class="nav-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bag-shopping me-2"></i> Pesanan Masuk
                    @php $pendingCount = \App\Models\Pesanan::where('status','pending')->count(); @endphp
                    @if ($pendingCount > 0)
                        <span class="badge bg-danger ms-1">{{ $pendingCount }}</span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> Lihat Halaman Publik
                </a>
            </li>
        </ul>
    </nav>

    <div class="flex-grow-1">
        <nav class="topbar d-flex align-items-center justify-content-between px-4 py-3">
            <button class="btn btn-outline-secondary d-md-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar">
                <i class="fa-solid fa-bars"></i>
            </button>
            <h5 class="mb-0 font-display d-none d-md-block">@yield('title', 'Dashboard')</h5>
            <div class="d-flex align-items-center gap-3">
                <span class="text-muted small d-none d-sm-inline">
                    <i class="fa-solid fa-user-circle me-1"></i>{{ auth()->user()->name ?? auth()->user()->username }}
                </span>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-outline-danger">
                        <i class="fa-solid fa-right-from-bracket me-1"></i> Logout
                    </button>
                </form>
            </div>
        </nav>

        <main class="p-4">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fa-solid fa-circle-check me-1"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<!-- Sidebar mobile -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar" style="background-color: var(--sidebar-bg); color: #e8e3ee;">
    <div class="offcanvas-header">
        <h5 class="brand"><i class="fa-solid fa-cake-candles me-2"></i>Dessert Admin</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="nav nav-pills flex-column gap-1">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') || request()->routeIs('desserts.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-list-check me-2"></i> Data Menu Dessert
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('pesanan.index') }}" class="nav-link {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-bag-shopping me-2"></i> Pesanan Masuk
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square me-2"></i> Lihat Halaman Publik
                </a>
            </li>
        </ul>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
@stack('scripts')
</body>
</html>
