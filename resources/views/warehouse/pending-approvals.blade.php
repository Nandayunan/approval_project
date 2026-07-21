@extends('layouts.app')

@section('title', 'Menunggu Persetujuan Gudang')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Persetujuan Gudang</h1>
        <p class="text-gray-600 mt-2">Daftar formulir yang menunggu persetujuan gudang dan yang sudah disetujui.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-yellow-600">
            <h3 class="text-gray-600 text-sm font-semibold uppercase">Menunggu Persetujuan</h3>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $approvals->count() }}</p>
            <p class="text-gray-600 text-sm mt-2">Formulir yang perlu diperiksa.</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-green-600">
            <h3 class="text-gray-600 text-sm font-semibold uppercase">Disetujui</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">{{ $approvedApprovals->count() }}</p>
            <p class="text-gray-600 text-sm mt-2">Formulir yang sudah diproses.</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-hourglass-half text-yellow-600"></i>
            Formulir Menunggu Persetujuan
        </h2>

        @if ($approvals->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tipe Formulir</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Diajukan oleh</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal</th>
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
                                    'ResinForm', 'App\\Models\\ResinForm' => 'Continoa',
                                    'FilmForm', 'App\\Models\\FilmForm' => 'Uncoat',
                                    'TegraForm', 'App\\Models\\TegraForm' => 'Tegra',
                                    default => 'Formulir',
                                };
                                $badgeClass = match ($approval->model_type) {
                                    'PackagingForm', 'App\\Models\\PackagingForm' => 'bg-blue-100 text-blue-700',
                                    'ResinForm', 'App\\Models\\ResinForm' => 'bg-purple-100 text-purple-700',
                                    'FilmForm', 'App\\Models\\FilmForm' => 'bg-pink-100 text-pink-700',
                                    'TegraForm', 'App\\Models\\TegraForm' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                                $badgeIcon = match ($approval->model_type) {
                                    'PackagingForm', 'App\\Models\\PackagingForm' => 'fa-box',
                                    'ResinForm', 'App\\Models\\ResinForm' => 'fa-flask',
                                    'FilmForm', 'App\\Models\\FilmForm' => 'fa-film',
                                    'TegraForm', 'App\\Models\\TegraForm' => 'fa-microchip',
                                    default => 'fa-file-alt',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
                                        <i class="fas {{ $badgeIcon }}"></i> {{ $modelLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $approval->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $approval->created_at->format('d M Y H:i') }}
                                </td>
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
                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg font-medium">Tidak ada formulir yang menunggu persetujuan</p>
                <p class="text-gray-500 text-sm mt-2">Semua formulir sudah dikirim ke tim Security atau ditinjau.</p>
            </div>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-check-circle text-green-600"></i>
            Formulir Disetujui
        </h2>

        @if ($approvedApprovals->count() > 0)
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
                        @foreach ($approvedApprovals as $approval)
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
                                    'FilmForm', 'App\\Models\\FilmForm' => 'Uncoat',
                                    'TegraForm', 'App\\Models\\TegraForm' => 'Tegra',
                                    default => 'Formulir',
                                };
                                $badgeClass = match ($approval->model_type) {
                                    'PackagingForm', 'App\\Models\\PackagingForm' => 'bg-blue-100 text-blue-700',
                                    'ResinForm', 'App\\Models\\ResinForm' => 'bg-purple-100 text-purple-700',
                                    'FilmForm', 'App\\Models\\FilmForm' => 'bg-pink-100 text-pink-700',
                                    'TegraForm', 'App\\Models\\TegraForm' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-700',
                                };
                            @endphp
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    <span
                                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold {{ $badgeClass }}">
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
                <i class="fas fa-check-double text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg font-medium">Belum ada formulir yang disetujui</p>
                <p class="text-gray-500 text-sm mt-2">Tunggu hingga tim Warehouse memproses formulir.</p>
            </div>
        @endif
    </div>
@endsection
