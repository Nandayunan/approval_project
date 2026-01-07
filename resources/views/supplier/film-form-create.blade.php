@extends('layouts.app')

@section('title', 'Buat Formulir Film')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Buat Formulir Film</h1>
        <p class="text-gray-600 mt-2">Isi semua field yang tersedia dengan lengkap</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md p-8">
        <form action="{{ route('supplier.film-forms.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor AWB *</label>
                        <input type="text" name="awb_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            value="{{ old('awb_number') }}" required>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Invoice *</label>
                        <input type="text" name="invoice_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            value="{{ old('invoice_number') }}" required>
                    </div>
                </div>
            </div>

            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Kiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar Kemasan *</label>
                        <textarea name="packaging_list"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600" rows="3"
                            required placeholder='Masukkan sebagai JSON array'></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Manifes Masuk *</label>
                        <textarea name="manifest_entry"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600" rows="3"
                            required placeholder='Masukkan data manifes masuk'></textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor NOA *</label>
                        <input type="text" name="noa_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            value="{{ old('noa_number') }}" required>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex justify-between pt-6 border-t">
                <a href="{{ route('supplier.film-forms') }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit"
                    class="px-6 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition">Kirim
                    Formulir</button>
            </div>
        </form>
    </div>
@endsection
