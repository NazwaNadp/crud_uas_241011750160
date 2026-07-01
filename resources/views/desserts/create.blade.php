@extends('layouts.admin')

@section('title', 'Tambah Data Dessert')

@section('content')
<div class="mb-4">
    <h4 class="font-display mb-0">Tambah Data Menu Dessert</h4>
    <p class="text-muted small mb-0">Lengkapi form berikut untuk menambahkan menu dessert baru.</p>
</div>

<div class="card card-stat">
    <div class="card-body p-4">
        <form action="{{ route('desserts.store') }}" method="POST" enctype="multipart/form-data">
            @include('desserts._form')
        </form>
    </div>
</div>
@endsection
