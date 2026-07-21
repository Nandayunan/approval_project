@extends('layouts.app')

@section('title', 'Formulir Film')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Formulir Film</h1>
            <p class="text-gray-600 mt-2">Kelola semua formulir film Anda</p>
        </div>
        <a href="{{ route('supplier.film-forms.create') }}"
            class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-lg font-semibold transition">+ Buat
            Baru</a>
    </div>

    @if ($forms->count() > 0)
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full">
                <thead class="bg-gray-100 border-b-2 border-gray-300">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama Pemasok</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">PO Number</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Invoice Number</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($forms as $form)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $form->supplier_name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $form->po_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $form->invoice_number }}</td>
                            <td class="px-6 py-4 text-sm">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-semibold inline-flex items-center gap-2
                                @if ($form->status == 'menunggu_persetujuan_security') bg-yellow-100 text-yellow-800
                                @elseif($form->status == 'menunggu_persetujuan_exim') bg-blue-100 text-blue-800
                                @elseif($form->status == 'menunggu_persetujuan_warehouse') bg-purple-100 text-purple-800
                                @elseif($form->status == 'approved') bg-green-100 text-green-800
                                @elseif($form->status == 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800 @endif">
                                    @if ($form->status == 'menunggu_persetujuan_security')
                                        <i class="fas fa-hourglass-half"></i>
                                        Menunggu Persetujuan Security
                                    @elseif($form->status == 'menunggu_persetujuan_exim')
                                        <i class="fas fa-hourglass-half"></i>
                                        Menunggu Persetujuan ExIm
                                    @elseif($form->status == 'menunggu_persetujuan_warehouse')
                                        <i class="fas fa-hourglass-half"></i>
                                        Menunggu Persetujuan Warehouse
                                    @elseif($form->status == 'approved')
                                        <i class="fas fa-check-double"></i>
                                        Disetujui
                                    @elseif($form->status == 'rejected')
                                        <i class="fas fa-times-circle"></i>
                                        Ditolak
                                    @else
                                        <i class="fas fa-question-circle"></i>
                                        {{ $form->status }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $form->created_at->format('d M Y') }}</td>
                            <td class="px-6 py-4 text-sm">
                                <button onclick="showModal('form-modal-{{ $form->id }}')"
                                    class="relative inline-flex items-center gap-2 rounded-full border border-blue-200 bg-blue-50 px-3 py-2 text-blue-700 hover:bg-blue-100 transition">
                                    <span
                                        class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-white text-blue-700 shadow-sm">
                                        <i class="fas fa-eye"></i>
                                    </span>
                                    <span class="text-sm font-semibold">Lihat</span>
                                </button>
                            </td>
                        </tr>

                        <div id="form-modal-{{ $form->id }}"
                            class="modal-wrapper hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
                            <div class="bg-white rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-xl">
                                <div
                                    class="sticky top-0 bg-gradient-to-r from-purple-600 to-indigo-700 px-6 py-4 text-white flex justify-between items-center rounded-t-xl">
                                    <h2 class="text-lg font-bold flex items-center gap-2">
                                        <i class="fas fa-file-alt"></i>
                                        Detail Formulir Film
                                    </h2>
                                    <button onclick="hideModal('form-modal-{{ $form->id }}')"
                                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                                        <i class="fas fa-times text-xl"></i>
                                    </button>
                                </div>
                                <div class="p-6 space-y-6">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Nama Pemasok</p>
                                            <p class="font-medium text-gray-900">{{ $form->supplier_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">No NPWP</p>
                                            <p class="font-medium text-gray-900">{{ $form->npwp_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">No PO</p>
                                            <p class="font-medium text-gray-900">{{ $form->po_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">No Faktur</p>
                                            <p class="font-medium text-gray-900">{{ $form->invoice_number }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">No Plat Kendaraan</p>
                                            <p class="font-medium text-gray-900">{{ $form->vehicle_registration_number }}
                                            </p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Daftar Kemasan</p>
                                            <p class="font-medium text-gray-900">
                                                {{ implode(', ', json_decode($form->packaging_list, true) ?? []) }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Total Kemasan</p>
                                            <p class="font-medium text-gray-900">{{ $form->total_packages }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Jenis Kemasan</p>
                                            <p class="font-medium text-gray-900">{{ $form->packaging_type }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Jumlah Paket</p>
                                            <p class="font-medium text-gray-900">{{ $form->package_quantity }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Berat Bersih</p>
                                            <p class="font-medium text-gray-900">{{ $form->net_weight }} kg</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">HS Code</p>
                                            <p class="font-medium text-gray-900">{{ $form->hs_code }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Nama Barang</p>
                                            <p class="font-medium text-gray-900">{{ $form->item_name }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Kode Barang</p>
                                            <p class="font-medium text-gray-900">{{ $form->item_code }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Kuantitas</p>
                                            <p class="font-medium text-gray-900">{{ $form->quantity }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Tipe</p>
                                            <p class="font-medium text-gray-900">{{ $form->type }}</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Tanggal Kedatangan</p>
                                            <p class="font-medium text-gray-900">
                                                {{ $form->arrival_datetime?->format('d M Y H:i') }}</p>
                                        </div>
                                        <div>
                                            <p class="text-sm text-gray-600 font-semibold">Tanggal Keberangkatan</p>
                                            <p class="font-medium text-gray-900">
                                                {{ $form->departure_datetime?->format('d M Y H:i') }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="p-6 border-t border-gray-200 flex justify-end gap-3">
                                    <button onclick="hideModal('form-modal-{{ $form->id }}')"
                                        class="btn-secondary px-4 py-2 rounded-lg">Tutup</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-md">
            <p class="text-gray-600 text-lg">Belum ada formulir film</p>
            <a href="{{ route('supplier.film-forms.create') }}"
                class="inline-block mt-4 bg-purple-600 hover:bg-purple-700 text-white px-6 py-2 rounded transition">Buat
                Sekarang</a>
        </div>
    @endif

    <script>
        function showModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }

        function hideModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
    </script>
@endsection
