@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0" style="border-radius: 18px;">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <i class="fa-solid fa-lock fa-2x text-danger mb-2"></i>
                        <h4 class="font-display mb-0">Login Admin</h4>
                        <p class="text-muted small">Purely Sweets &mdash; Halaman Pengelolaan Data</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login.attempt') }}">
                        @csrf
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" id="username" name="username" value="{{ old('username') }}"
                                   class="form-control @error('username') is-invalid @enderror" autofocus required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required>
                        </div>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                            <label class="form-check-label" for="remember">Ingat saya</label>
                        </div>
                        <button type="submit" class="btn btn-brand w-100">
                            <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                        </button>
                    </form>

                    <p class="text-center text-muted small mt-4 mb-0">
                        <a href="{{ route('home') }}" class="text-decoration-none">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Halaman Utama
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
