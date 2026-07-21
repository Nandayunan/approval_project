@extends('layouts.app')

@section('title', 'Formulir Disetujui Gudang')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Formulir Disetujui Gudang</h1>
        <p class="text-gray-600 mt-2">Lihat semua formulir yang sudah disetujui pada level warehouse.</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-check-double text-green-600"></i>
            Daftar Formulir Disetujui
        </h2>

        @if ($approvals->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tipe Formulir</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Diajukan oleh</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Disetujui pada</th>
                            <th class="px-6 py-4 text-center text-sm font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($approvals as $approval)
                            @php
                                $modelAlias = match ($approval->model_type) {
                                    'PackagingForm', 'App\\Models\\PackagingForm' => 'packaging',
                                    'ResinForm', 'App\\Models\\ResinForm' => 'resin',
                                    'FilmForm', 'App\\Models\\FilmForm' => 'film',
                                    'TegraForm', 'App\\Models\\TegraForm' => 'tegra',
                                    default => null,
                                };
                                $modelLabel = match ($approval->model_type) {
                                    'PackagingForm', 'App\\Models\\PackagingForm' => 'Pengemasan',
                                    'ResinForm', 'App\\Models\\ResinForm' => 'Resin',
                                    'FilmForm', 'App\\Models\\FilmForm' => 'Film',
                                    'TegraForm', 'App\\Models\\TegraForm' => 'Tegra',
                                    default => 'Formulir',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                                        <i class="fas fa-file-alt"></i> {{ $modelLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $approval->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $approval->approved_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-center">
                                    @if ($modelAlias)
                                        <a href="{{ route('warehouse.view-form', [$modelAlias, $approval->model_id]) }}"
                                            class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm px-3 py-2 bg-blue-50 hover:bg-blue-100 rounded transition">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    @else
                                        <span class="text-sm text-gray-500">Tipe tidak dikenal</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-check-circle text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg font-medium">Belum ada formulir yang disetujui</p>
                <p class="text-gray-500 text-sm mt-2">Belum ada persetujuan warehouse yang tercatat.</p>
            </div>
        @endif
    </div>
@endsection
