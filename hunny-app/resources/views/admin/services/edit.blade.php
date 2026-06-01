@extends('layouts.admin')

@section('title', 'Edit Jasa Grooming')

@section('content')
<div class="topbar">
    <div class="topbar-left">
        <h1 class="page-title">Edit Jasa Grooming</h1>
        <p class="page-subtitle">Perbarui detail layanan grooming dan simpan perubahan.</p>
    </div>
</div>

<div class="page-content">
    <div class="card shadow-sm">
        <form action="{{ route('admin.services.update', $service) }}" method="POST" class="card-body form-grid">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Nama Layanan</label>
                <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}" class="form-control @error('name') form-error-border @enderror" required>
                @error('name')
                    <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price">Harga</label>
                <input type="number" id="price" name="price" value="{{ old('price', $service->price) }}" class="form-control @error('price') form-error-border @enderror" min="0" step="1000" required>
                @error('price')
                    <p class="form-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
            </div>

            <div class="form-group full-width">
                <label class="checkbox-label">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $service->is_active) ? 'checked' : '' }}>
                    Aktifkan layanan ini
                </label>
            </div>

            <div class="form-actions full-width">
                <button type="submit" class="btn btn-accent">Perbarui Layanan</button>
                <a href="{{ route('admin.services.index') }}" class="btn btn-outline">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
