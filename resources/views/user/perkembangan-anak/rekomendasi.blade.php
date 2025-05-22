@extends('user.layouts.user')
@section('title', 'Rekomendasi Terapi')

@section('content')
<div class="container mt-4">
    <h4 class="mb-4">Rekomendasi Terapi</h4>

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <strong>Rekomendasi di Rumah Sakit</strong>
        </div>
        <div class="card-body">
            <ul>
                <li>Terapi okupasi intensif di fasilitas kesehatan terdekat.</li>
                <li>Terapi wicara lanjutan dengan ahli logopedi.</li>
                <li>Pendampingan psikolog anak dan observasi rutin tiap bulan.</li>
            </ul>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <strong>Rekomendasi di Rumah</strong>
        </div>
        <div class="card-body">
            <ul>
                <li>Latihan koordinasi motorik halus menggunakan alat bantu sederhana.</li>
                <li>Latihan berbicara dengan media visual/audio.</li>
                <li>Aktivitas rutin seperti menyikat gigi, makan, dan berpakaian mandiri.</li>
            </ul>
        </div>
    </div>

    <a href="{{ route('user.perkembangan-anak.index') }}" class="btn btn-secondary">Kembali ke Riwayat</a>
</div>
@endsection
