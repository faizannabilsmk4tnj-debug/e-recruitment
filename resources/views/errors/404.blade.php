@extends('errors.base')

@section('title', 'Halaman Tidak Ditemukan')
@section('code', '404')
@section('headline', 'Halaman Tidak Ditemukan')
@section('description')
    {{ $exception->getMessage() ?: 'Halaman yang Anda cari tidak dapat ditemukan. Kemungkinan salah mengetik alamat URL, halaman telah dipindahkan, atau lowongan pekerjaan sudah dihapus.' }}
@endsection

@section('icon')
    <div class="w-16 h-16 rounded-full bg-amber-50 flex items-center justify-center text-amber-500">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
    </div>
@endsection
