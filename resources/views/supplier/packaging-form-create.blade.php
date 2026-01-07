@extends('layouts.app')

@section('title', 'Buat Formulir Pengemasan')

@section('content')
    <!-- Header with Back Button -->
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('supplier.packaging-forms') }}"
            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 transition">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali</span>
        </a>
        <div class="flex-1">
            <h1 class="text-3xl font-bold text-gray-900">Buat Formulir Pengemasan</h1>
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
        <form action="{{ route('supplier.packaging-forms.store') }}" method="POST" class="divide-y divide-gray-200">
            @csrf

            <!-- Section 1: Supplier Info -->
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-user text-blue-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Pemasok</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Pemasok <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="supplier_name"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('supplier_name') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor NPWP <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="npwp_number"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('npwp_number') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Faktur PO <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="po_invoice_number"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('po_invoice_number') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Registrasi Kendaraan <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="vehicle_registration_number"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('vehicle_registration_number') }}" required>
                    </div>
                </div>
            </div>

            <!-- Section 2: Package Info -->
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-box text-green-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Kemasan</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar Kemasan <span
                                class="text-red-600">*</span></label>
                        <textarea name="packaging_list"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white resize-none"
                            rows="3" required placeholder='Pisahkan dengan koma, contoh: box, bag, wrapper'>{{ old('packaging_list') }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">💡 Format: pisahkan setiap jenis kemasan dengan koma (,)</p>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Total Paket <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="total_packages"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('total_packages') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Total Jenis <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="total_types"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('total_types') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Berat Kotor (kg) <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="gross_weight" step="0.01"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('gross_weight') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Berat Bersih (kg) <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="net_weight" step="0.01"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('net_weight') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis Kemasan <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="packaging_type"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('packaging_type') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah Paket Kemasan <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="package_quantity"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('package_quantity') }}" required>
                    </div>
                </div>
            </div>

            <!-- Section 3: Item Info -->
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-cubes text-purple-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Informasi Barang</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kode HS <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="hs_code"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('hs_code') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Barang <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="item_name"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('item_name') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kode Barang <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="item_code"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('item_code') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Kuantitas <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="quantity"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('quantity') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Jenis <span
                                class="text-red-600">*</span></label>
                        <input type="text" name="type"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('type') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Barang (Rp) <span
                                class="text-red-600">*</span></label>
                        <input type="number" name="item_price" step="0.01"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('item_price') }}" required>
                    </div>
                </div>
            </div>

            <!-- Section 4: DateTime Info -->
            <div class="p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-calendar text-orange-600"></i>
                    </div>
                    <h2 class="text-xl font-semibold text-gray-900">Jadwal</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal & Waktu Kedatangan <span
                                class="text-red-600">*</span></label>
                        <input type="datetime-local" name="arrival_datetime"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('arrival_datetime') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal & Waktu Keberangkatan <span
                                class="text-red-600">*</span></label>
                        <input type="datetime-local" name="departure_datetime"
                            class="w-full px-4 py-3 border-2 border-gray-400 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition bg-white"
                            value="{{ old('departure_datetime') }}" required>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="p-8 bg-gray-50 flex justify-between gap-4">
                <a href="{{ route('supplier.packaging-forms') }}" class="btn-secondary">
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
