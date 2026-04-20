@extends('layouts.pelamar-public')

@section('title', 'Lamaran Terkirim')

@section('content')

<section class="bg-white px-16 py-20 flex-1">
    <div class="max-w-lg mx-auto text-center">

        <!-- Success Icon -->
        <div class="w-36 h-36 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-8">
            <div class="w-24 h-24 bg-green-800 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 6 9 17 4 12"/>
                </svg>
            </div>
        </div>

        <!-- Title -->
        <h1 class="text-3xl font-extrabold text-gray-900 mb-4">Lamaran Terkirim!</h1>

        <!-- Description -->
        <p class="text-gray-500 leading-relaxed mb-6">Terima kasih telah melamar di PT Ecogreen Oleochemicals. Kami akan meninjau kualifikasi Anda dan segera memberikan kabar terbaru melalui email atau portal ini.</p>

        <!-- Status Badge -->
        <div class="inline-flex items-center gap-2 bg-green-50 border border-green-200 px-4 py-2 rounded-full mb-10">
            <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
            <span class="text-sm font-semibold text-green-700">Sedang Diproses</span>
        </div>

        <!-- Action Buttons -->
        <div class="flex items-center justify-center gap-4 mb-8">
            <a href="/pelamar/status-lamaran" class="flex items-center gap-2 bg-green-800 hover:bg-green-700 text-white font-semibold px-6 py-3 rounded-lg text-sm transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><rect width="8" height="4" x="8" y="2" rx="1"/><path d="m9 14 2 2 4-4"/></svg>
                Pantau Lamaran
            </a>
            <a href="/pelamar/dashboard" class="flex items-center gap-2 border border-gray-300 text-gray-700 font-semibold px-6 py-3 rounded-lg text-sm hover:bg-gray-50 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                Kembali ke Beranda
            </a>
        </div>

        <!-- Help Link -->
        <p class="text-sm text-gray-400">Ada kendala? <a href="#" class="font-semibold text-green-700 hover:text-green-600 transition-colors">Hubungi Tim Rekrutmen</a></p>

    </div>
</section>

@endsection