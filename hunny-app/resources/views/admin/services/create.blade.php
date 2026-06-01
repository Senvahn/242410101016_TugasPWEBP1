@extends('layouts.admin')

@section('title', 'Tambah Jasa Grooming')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Tambah Jasa Grooming</h1>
        <p class="page-subtitle">Masukkan nama layanan dan harga yang dapat dipilih customer saat booking.</p>
    </div>
</div>

<div class="page-content">
    <div class="card shadow-sm">
        <form action="{{ route('admin.services.store') }}" method="POST" class="card-body form-grid">
            @csrf

            <div class="form-group">
                <label for="name">Nama Layanan</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control @error('name') form-error-border @enderror" required>
                @error('name')
                    <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" value="{{ old('price') }}" class="form-control @error('price') form-error-border @enderror" min="0" step="1000" required>
                @error('price')
                    <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-accent">Simpan Layanan</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
