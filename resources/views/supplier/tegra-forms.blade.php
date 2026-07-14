@extends('layouts.app')

@section('title', 'Formulir Tegra')

@section('content')
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Formulir Tegra</h1>
            <p class="text-gray-600 mt-2">Kelola semua formulir Tegra Anda</p>
        </div>
        <a href="{{ route('supplier.tegra-forms.create') }}"
            class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition">+ Buat
            Baru</a>
    </div>

    @if ($forms->count() > 0)
        <div class="overflow-x-auto bg-white rounded-lg shadow-md">
            <table class="min-w-full">
                <thead class="bg-gray-100 border-b-2 border-gray-300">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nomor PO</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nomor Invoice</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Nama Item</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($forms as $form)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $form->po_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $form->invoice_number }}</td>
                            <td class="px-6 py-4 text-sm text-gray-900">{{ $form->item_name }}</td>
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
                                        <i class="fas fa-check-circle"></i>
                                        Disetujui
                                    @elseif($form->status == 'rejected')
                                        <i class="fas fa-times-circle"></i>
                                        Ditolak
                                    @else
                                        <i class="fas fa-circle"></i>
                                        {{ ucfirst($form->status) }}
                                    @endif
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $form->created_at->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex gap-2">
                                    <button class="text-blue-600 hover:text-blue-700 font-semibold transition"
                                        onclick="alert('Detail form')">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-lg shadow-md">
            <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak Ada Formulir</h3>
            <p class="text-gray-600 mb-6">Anda belum membuat formulir Tegra apapun</p>
            <a href="{{ route('supplier.tegra-forms.create') }}"
                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold inline-flex items-center gap-2 transition">
                <i class="fas fa-plus"></i>
                Buat Formulir Pertama
            </a>
        </div>
    @endif
@endsection
