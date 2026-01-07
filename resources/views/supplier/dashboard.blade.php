@extends('layouts.app')

@section('title', 'Dashboard Supplier')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Supplier</h1>
        <p class="text-gray-600 mt-2">Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span></p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
        <!-- Packaging Forms Card -->
        <div class="card p-6 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Formulir Pengemasan</p>
                    <p class="text-4xl font-bold text-blue-600 mt-3">{{ $packageCount }}</p>
                    <p class="text-gray-500 text-sm mt-2">Total formulir terdata</p>
                </div>
                <div class="w-14 h-14 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-box text-blue-600 text-2xl"></i>
                </div>
            </div>
            <a href="{{ route('supplier.packaging-forms') }}"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm mt-4">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Resin Forms Card -->
        <div class="card p-6 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Formulir Resin</p>
                    <p class="text-4xl font-bold text-green-600 mt-3">{{ $resinCount }}</p>
                    <p class="text-gray-500 text-sm mt-2">Total formulir terdata</p>
                </div>
                <div class="w-14 h-14 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-flask-vial text-green-600 text-2xl"></i>
                </div>
            </div>
            <a href="{{ route('supplier.resin-forms') }}"
                class="inline-flex items-center gap-2 text-green-600 hover:text-green-700 font-semibold text-sm mt-4">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <!-- Film Forms Card -->
        <div class="card p-6 hover:shadow-lg transform hover:-translate-y-1 transition-all duration-200">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-gray-600 text-sm font-semibold uppercase tracking-wide">Formulir Film</p>
                    <p class="text-4xl font-bold text-purple-600 mt-3">{{ $filmCount }}</p>
                    <p class="text-gray-500 text-sm mt-2">Total formulir terdata</p>
                </div>
                <div class="w-14 h-14 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-film text-purple-600 text-2xl"></i>
                </div>
            </div>
            <a href="{{ route('supplier.film-forms') }}"
                class="inline-flex items-center gap-2 text-purple-600 hover:text-purple-700 font-semibold text-sm mt-4">
                Lihat Detail <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="bg-blue-50 rounded-xl border border-blue-200 p-8 mb-12">
        <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-lightning-bolt text-blue-600"></i>
            Aksi Cepat
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('supplier.packaging-forms.create') }}"
                class="flex items-center gap-3 px-4 py-3 bg-white rounded-lg hover:bg-blue-100 transition border border-blue-200">
                <i class="fas fa-plus-circle text-blue-600 text-lg"></i>
                <span class="font-semibold text-gray-900">Buat Pengemasan</span>
            </a>
            <a href="{{ route('supplier.resin-forms.create') }}"
                class="flex items-center gap-3 px-4 py-3 bg-white rounded-lg hover:bg-blue-100 transition border border-blue-200">
                <i class="fas fa-plus-circle text-blue-600 text-lg"></i>
                <span class="font-semibold text-gray-900">Buat Resin</span>
            </a>
            <a href="{{ route('supplier.film-forms.create') }}"
                class="flex items-center gap-3 px-4 py-3 bg-white rounded-lg hover:bg-blue-100 transition border border-blue-200">
                <i class="fas fa-plus-circle text-blue-600 text-lg"></i>
                <span class="font-semibold text-gray-900">Buat Film</span>
            </a>
        </div>
    </div>

    <!-- Info Section -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Help Card -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-question-circle text-blue-600"></i>
                Bantuan
            </h3>
            <p class="text-gray-600 text-sm mb-3">Untuk membuat formulir baru, silakan klik tombol "Buat" di atas atau pilih
                kategori yang Anda inginkan.</p>
            <p class="text-gray-600 text-sm">Setelah pengajuan, formulir Anda akan melalui proses persetujuan dari berbagai
                departemen.</p>
        </div>

        <!-- Status Information -->
        <div class="card p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-3 flex items-center gap-2">
                <i class="fas fa-info-circle text-green-600"></i>
                Status Persetujuan
            </h3>
            <div class="space-y-2 text-sm text-gray-600">
                <p>📋 Submitted - Formulir menunggu persetujuan</p>
                <p>✅ Approved - Formulir telah disetujui semua pihak</p>
                <p>❌ Rejected - Formulir ditolak</p>
            </div>
        </div>
    </div>
@endsection
