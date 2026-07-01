@extends('layouts.admin')

@section('title', 'Edit Data Dessert')

@section('content')
<div class="mb-4">
    <h4 class="font-display mb-0">Edit Data Menu Dessert</h4>
    <p class="text-muted small mb-0">Perbarui informasi menu dessert: {{ $dessert->nama_dessert }}</p>
</div>

<div class="card card-stat">
    <div class="card-body p-4">
        <form action="{{ route('desserts.update', $dessert) }}" method="POST" enctype="multipart/form-data">
            @include('desserts._form')
        </form>
    </div>
</div>
@endsection
