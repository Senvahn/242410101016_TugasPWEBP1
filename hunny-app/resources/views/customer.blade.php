@extends('layouts.customer')

@section('title', 'Customer Portal')

@section('content')
<section class="cust-hero">
    <div class="cust-hero-content">
        <h1>Portal Layanan & Toko</h1>
        <p>Pilih layanan grooming terbaik atau belanja kebutuhan anabul kesayangan Anda.</p>
    </div>
</section>

<div class="cust-container">
    <div class="cust-tabs">
        </div>
</div>
@endsection

@section('scripts')
<script>
    // Masukkan semua logic JavaScript dari customer.html ke sini
    function openCart() {
        console.log('Cart opened');
    }
</script>
@endsection