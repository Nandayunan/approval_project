@extends('layouts.app')

@section('title', 'Buat Formulir Resin')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Buat Formulir Resin</h1>
        <p class="text-gray-600 mt-2">Pilih tipe transportasi dan isi formulir dengan lengkap</p>
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
        <form action="{{ route('supplier.resin-forms.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Transport Type Selection -->
            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Pilih Tipe Transportasi</h2>
                <div class="space-y-3">
                    <label class="flex items-center space-x-3 cursor-pointer p-4 border rounded-lg hover:bg-gray-50">
                        <input type="radio" name="transport_type" value="udara" class="w-4 h-4" required
                            onchange="showTransportFields()">
                        <span class="font-semibold text-gray-900">Melalui Udara (AWB)</span>
                    </label>
                    <label class="flex items-center space-x-3 cursor-pointer p-4 border rounded-lg hover:bg-gray-50">
                        <input type="radio" name="transport_type" value="laut" class="w-4 h-4" required
                            onchange="showTransportFields()">
                        <span class="font-semibold text-gray-900">Melalui Laut (Bill of Lading)</span>
                    </label>
                </div>
            </div>

            <!-- Transport-Specific Fields -->
            <div id="transport-fields" class="border-b pb-6 hidden">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Informasi Pengiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div id="awb-field" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor AWB *</label>
                        <input type="text" name="awb_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            value="{{ old('awb_number') }}">
                    </div>
                    <div id="bol-field" class="hidden">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Bill of Lading *</label>
                        <input type="text" name="bill_of_lading"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            value="{{ old('bill_of_lading') }}">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Nomor Invoice *</label>
                        <input type="text" name="invoice_number"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600"
                            value="{{ old('invoice_number') }}" required>
                    </div>
                </div>
            </div>

            <!-- Other Fields -->
            <div class="border-b pb-6">
                <h2 class="text-xl font-semibold text-gray-900 mb-4">Detail Kiriman</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">Daftar Kemasan *</label>
                        <textarea name="packaging_list"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600" rows="3"
                            required placeholder='Masukkan sebagai JSON array, contoh: ["box", "bag"]'></textarea>
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
                <a href="{{ route('supplier.resin-forms') }}"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">Batal</a>
                <button type="submit"
                    class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-semibold transition">Kirim
                    Formulir</button>
            </div>
        </form>
    </div>

    <script>
        function showTransportFields() {
            const transportType = document.querySelector('input[name="transport_type"]:checked').value;
            document.getElementById('transport-fields').classList.remove('hidden');

            if (transportType === 'udara') {
                document.getElementById('awb-field').classList.remove('hidden');
                document.getElementById('bol-field').classList.add('hidden');
                document.querySelector('input[name="awb_number"]').required = true;
                document.querySelector('input[name="bill_of_lading"]').required = false;
            } else {
                document.getElementById('awb-field').classList.add('hidden');
                document.getElementById('bol-field').classList.remove('hidden');
                document.querySelector('input[name="awb_number"]').required = false;
                document.querySelector('input[name="bill_of_lading"]').required = true;
            }
        }
    </script>
@endsection
