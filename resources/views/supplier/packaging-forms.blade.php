@extends('layouts.app')

@section('title', 'Formulir Pengemasan')

@section('content')
    <!-- Header with Back Button -->
    <div class="mb-8 flex items-center gap-4 justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('supplier.dashboard') }}"
                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 transition">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali</span>
            </a>
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Formulir Pengemasan</h1>
                <p class="text-gray-600 mt-1">Kelola semua formulir pengemasan Anda</p>
            </div>
        </div>
        <a href="{{ route('supplier.packaging-forms.create') }}" class="btn-primary">
            <i class="fas fa-plus"></i>
            <span>Buat Baru</span>
        </a>
    </div>

    @if ($forms->count() > 0)
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">No NPWP</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">No Faktur PO</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama Barang</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($forms as $form)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $form->npwp_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $form->po_invoice_number }}</td>
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $form->item_name }}</td>
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
                                <td class="px-6 py-4 text-center">
                                    <button onclick="showModal('form-modal-{{ $form->id }}')"
                                        class="text-blue-600 hover:text-blue-700 font-semibold text-sm inline-flex items-center gap-1">
                                        <i class="fas fa-eye"></i> Lihat
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="card p-12 text-center">
            <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
            <p class="text-gray-600 text-lg font-medium">Belum ada formulir pengemasan</p>
            <p class="text-gray-500 text-sm mt-2">Mulai dengan membuat formulir pengemasan baru</p>
            <a href="{{ route('supplier.packaging-forms.create') }}" class="btn-primary mt-6 mx-auto">
                <i class="fas fa-plus"></i>
                <span>Buat Sekarang</span>
            </a>
        </div>
    @endif

    @foreach ($forms as $form)
        <!-- Modal -->
        <div id="form-modal-{{ $form->id }}"
            class="modal-wrapper fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
            style="display: none;">
            <div class="bg-white rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-xl">
                <div
                    class="sticky top-0 bg-linear-to-r from-blue-600 to-blue-700 px-6 py-4 text-white flex justify-between items-center rounded-t-xl">
                    <h2 class="text-lg font-bold flex items-center gap-2">
                        <i class="fas fa-box"></i>
                        Detail Formulir Pengemasan
                    </h2>
                    <button onclick="hideModal('form-modal-{{ $form->id }}')"
                        class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                <div class="p-6 space-y-4">
                    <!-- Form details will be displayed here -->
                    <div class="grid grid-cols-2 gap-4 bg-gray-50 p-4 rounded-lg">
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Nama Pemasok</p>
                            <p class="font-medium text-gray-900">{{ $form->supplier_name }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">No NPWP</p>
                            <p class="font-medium text-gray-900">{{ $form->npwp_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">No Faktur PO</p>
                            <p class="font-medium text-gray-900">{{ $form->po_invoice_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">Nama Barang</p>
                            <p class="font-medium text-gray-900">{{ $form->item_name }}</p>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-between gap-3">
                        <button onclick="hideModal('form-modal-{{ $form->id }}')" class="btn-secondary flex-1">
                            <i class="fas fa-times"></i>
                            <span>Tutup</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <script>
        function showModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function hideModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('modal-wrapper') && event.target.id && event.target.id.startsWith(
                    'form-modal-')) {
                event.target.style.display = 'none';
            }
        });
    </script>
@endsection
