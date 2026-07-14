@extends('layouts.app')

@section('title', 'Buat Formulir Tegra')

@section('content')
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('supplier.tegra-forms') }}"
            class="inline-flex items-center gap-2 text-red-600 hover:text-red-700 transition">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900">Buat Formulir Tegra</h1>
            <p class="text-gray-600 mt-1">Isi semua field yang tersedia dengan lengkap</p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg flex items-start gap-3">
            <i class="fas fa-exclamation-circle text-red-600 mt-0.5 shrink-0"></i>
            <div>
                <h3 class="font-semibold">Terjadi Kesalahan Validasi!</h3>
                <ul class="list-disc list-inside mt-2 space-y-1">
                    @foreach ($errors->all() as $error)
                        <li class="text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-100">
        <form action="{{ route('supplier.tegra-forms.store') }}" method="POST" class="divide-y divide-gray-200">
            @csrf

            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-file-invoice text-blue-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Dokumen</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor PO <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="po_number"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('po_number') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Invoice <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="invoice_number"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('invoice_number') }}" required>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Item</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Item <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="item_name"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('item_name') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Item <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="item_code"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('item_code') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kuantitas <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="quantity"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('quantity') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="type"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('type') }}" required>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-boxes text-purple-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Kemasan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tipe Kemasan <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="packaging_type"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('packaging_type') }}" required placeholder="contoh: box, bag">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Kemasan <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="package_quantity"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('package_quantity') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Berat Bersih (kg) <span
                                class="text-red-600">*</span></label>
                        <input type="number" step="0.01" name="net_weight"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('net_weight') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Item <span
                                class="text-red-600">*</span></label>
                        <input type="number" step="0.01" name="item_price"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white"
                            value="{{ old('item_price') }}" required>
                    </div>
                </div>
            </div>

            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sticky-note text-yellow-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Keterangan Tambahan</h2>
                </div>
                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan</label>
                    <textarea name="notes"
                        class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500 transition bg-white resize-none"
                        rows="4" placeholder="Tambahkan catatan atau informasi tambahan (opsional)">{{ old('notes') }}</textarea>
                </div>
            </div>

            <div class="p-8 bg-gray-50 flex justify-between gap-4">
                <a href="{{ route('supplier.tegra-forms') }}" class="btn-secondary">
                    <i class="fas fa-times"></i>
                    <span>Batal</span>
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirim Formulir</span>
                </button>
            </div>
        </form>
    </div>
@endsection
