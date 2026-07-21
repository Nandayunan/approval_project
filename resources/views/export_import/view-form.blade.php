@extends('layouts.app')

@section('title', 'Detail Formulir')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">
            @if ($modelType === 'packaging')
                Detail Formulir Pengemasan
            @elseif ($modelType === 'resin')
                Detail Formulir Resin
            @elseif ($modelType === 'film')
                Detail Formulir Uncoat
            @elseif ($modelType === 'tegra')
                Detail Formulir Tegra
            @else
                Detail Formulir
            @endif
        </h1>
        <p class="text-gray-600 mt-2">Informasi lengkap formulir dan data yang diajukan oleh supplier.</p>
    </div>

    @php
        $statusLabel = $form->status_label ?? ucfirst(str_replace('_', ' ', $form->status));
    @endphp

    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Status</p>
                <p class="text-lg font-semibold text-gray-900">{{ $statusLabel }}</p>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide">Dibuat pada</p>
                <p class="text-lg font-semibold text-gray-900">{{ $form->created_at->format('d M Y H:i') }}</p>
            </div>
        </div>

        @if (in_array($modelType, ['packaging', 'resin', 'film']))
            <div class="grid grid-cols-1 gap-6">
                <div class="border-l-4 border-blue-600 pl-4 bg-gray-50 rounded-lg p-4">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase mb-3">Informasi Pemasok</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p class="text-gray-600">Nama Pemasok</p>
                            <p class="font-medium">{{ $form->supplier_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">NPWP</p>
                            <p class="font-medium">{{ $form->npwp_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">No PO</p>
                            <p class="font-medium">{{ $form->po_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">No Faktur</p>
                            <p class="font-medium">{{ $form->invoice_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">No Plat Kendaraan</p>
                            <p class="font-medium">{{ $form->vehicle_registration_number }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-l-4 border-purple-600 pl-4 bg-gray-50 rounded-lg p-4">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase mb-3">Data Kemasan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p class="text-gray-600">Daftar Kemasan</p>
                            <p class="font-medium">{{ implode(', ', $form->packaging_list ?? []) }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Total Kemasan</p>
                            <p class="font-medium">{{ $form->total_packages }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Jenis Kemasan</p>
                            <p class="font-medium">{{ $form->packaging_type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Jumlah Paket</p>
                            <p class="font-medium">{{ $form->package_quantity }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Berat Bersih</p>
                            <p class="font-medium">{{ $form->net_weight }} kg</p>
                        </div>
                    </div>
                </div>

                <div class="border-l-4 border-green-600 pl-4 bg-gray-50 rounded-lg p-4">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase mb-3">Data Barang</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p class="text-gray-600">HS Code</p>
                            <p class="font-medium">{{ $form->hs_code }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Nama Barang</p>
                            <p class="font-medium">{{ $form->item_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kode Barang</p>
                            <p class="font-medium">{{ $form->item_code }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kuantitas</p>
                            <p class="font-medium">{{ $form->quantity }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tipe</p>
                            <p class="font-medium">{{ $form->type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Harga Barang</p>
                            <p class="font-medium">Rp {{ number_format($form->item_price, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </div>

                <div class="border-l-4 border-yellow-600 pl-4 bg-gray-50 rounded-lg p-4">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase mb-3">Jadwal</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p class="text-gray-600">Tanggal Kedatangan</p>
                            <p class="font-medium">{{ optional($form->arrival_datetime)->format('d M Y H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tanggal Keberangkatan</p>
                            <p class="font-medium">{{ optional($form->departure_datetime)->format('d M Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @elseif ($modelType === 'tegra')
            <div class="grid grid-cols-1 gap-6">
                <div class="border-l-4 border-red-600 pl-4 bg-gray-50 rounded-lg p-4">
                    <h2 class="text-sm font-semibold text-gray-700 uppercase mb-3">Detail Tegra</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-700">
                        <div>
                            <p class="text-gray-600">No PO</p>
                            <p class="font-medium">{{ $form->po_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">No Faktur</p>
                            <p class="font-medium">{{ $form->invoice_number }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Nama Barang</p>
                            <p class="font-medium">{{ $form->item_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kode Barang</p>
                            <p class="font-medium">{{ $form->item_code }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Kuantitas</p>
                            <p class="font-medium">{{ $form->quantity }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Tipe</p>
                            <p class="font-medium">{{ $form->type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Jenis Kemasan</p>
                            <p class="font-medium">{{ $form->packaging_type }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Jumlah Paket</p>
                            <p class="font-medium">{{ $form->package_quantity }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Berat Bersih</p>
                            <p class="font-medium">{{ $form->net_weight }} kg</p>
                        </div>
                        <div class="md:col-span-2">
                            <p class="text-gray-600">Catatan</p>
                            <p class="font-medium">{{ $form->notes ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="mt-6">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-900 rounded-lg transition">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
@endsection
