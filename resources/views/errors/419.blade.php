@extends('errors.base')

@section('title', 'Sesi Kedaluwarsa')
@section('code', '419')
@section('headline', 'Halaman Kedaluwarsa')
@section('description')
    Maaf, sesi Anda telah kedaluwarsa karena tidak ada aktivitas dalam waktu yang cukup lama. Silakan segarkan halaman (refresh) atau kembali ke beranda untuk masuk ulang.
@endsection

@section('icon')
    <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center text-blue-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
        </svg>
    </div>
@endsection
