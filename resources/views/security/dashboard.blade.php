@extends('layouts.app')

@section('title', 'Dashboard Keamanan')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Dashboard Keamanan</h1>
        <p class="text-gray-600 mt-2">Kelola persetujuan keamanan untuk semua formulir</p>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-yellow-600">
            <h3 class="text-gray-600 text-sm font-semibold uppercase">Menunggu Persetujuan</h3>
            <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingApprovals->count() }}</p>
            <p class="text-gray-600 text-sm mt-2">Formulir yang perlu ditinjau</p>
        </div>

        <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-green-600">
            <h3 class="text-gray-600 text-sm font-semibold uppercase">Total Disetujui</h3>
            <p class="text-3xl font-bold text-green-600 mt-2">
                {{ \App\Models\Approval::where('approval_level', 'security')->where('status', 'approved')->count() }}
            </p>
            <p class="text-gray-600 text-sm mt-2">Formulir yang sudah disetujui</p>
        </div>
    </div>

    <!-- Pending Approvals List -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-list text-blue-600"></i>
            Formulir Menunggu Persetujuan
        </h2>

        @if ($pendingApprovals->count() > 0)
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
                        @foreach ($pendingApprovals as $approval)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900 font-medium">
                                    @if ($approval->model_type === 'PackagingForm')
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">
                                            <i class="fas fa-box"></i> Pengemasan
                                        </span>
                                    @elseif($approval->model_type === 'ResinForm')
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                                            <i class="fas fa-flask"></i> Resin
                                        </span>
                                    @elseif($approval->model_type === 'FilmForm')
                                        <span
                                            class="inline-flex items-center gap-2 px-3 py-1 bg-pink-100 text-pink-700 rounded-full text-xs font-semibold">
                                            <i class="fas fa-film"></i> Film
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $approval->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $approval->created_at->format('d M Y H:i') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <button onclick="showModal('approval-modal-{{ $approval->id }}')"
                                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-semibold text-sm px-3 py-2 bg-blue-50 hover:bg-blue-100 rounded transition">
                                        <i class="fas fa-eye"></i> Tinjau
                                    </button>
                                </td>
                            </tr>

                            <!-- Modal -->
                            <div id="approval-modal-{{ $approval->id }}"
                                class="modal-wrapper fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4"
                                style="display: none;">
                                <div class="bg-white rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-xl">
                                    <!-- Header -->
                                    <div
                                        class="sticky top-0 bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4 text-white flex justify-between items-center rounded-t-xl">
                                        <h2 class="text-lg font-bold flex items-center gap-2">
                                            @if ($approval->model_type === 'PackagingForm')
                                                <i class="fas fa-box"></i> Detail Formulir Pengemasan
                                            @elseif($approval->model_type === 'ResinForm')
                                                <i class="fas fa-flask"></i> Detail Formulir Resin
                                            @elseif($approval->model_type === 'FilmForm')
                                                <i class="fas fa-film"></i> Detail Formulir Film
                                            @endif
                                        </h2>
                                        <button onclick="hideModal('approval-modal-{{ $approval->id }}')"
                                            class="text-white hover:bg-white hover:bg-opacity-20 rounded-lg p-2 transition">
                                            <i class="fas fa-times text-xl"></i>
                                        </button>
                                    </div>

                                    <!-- Content -->
                                    <div class="p-6">
                                        @php
                                            $form = $approval->model;
                                        @endphp

                                        <!-- Form Details Grid -->
                                        <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                            <h3 class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide">
                                                Informasi Formulir</h3>
                                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                                <div>
                                                    <p class="text-xs text-gray-600 uppercase font-semibold">Diajukan oleh
                                                    </p>
                                                    <p class="text-sm font-medium text-gray-900">{{ $approval->user->name }}
                                                        ({{ $approval->user->role }})
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-xs text-gray-600 uppercase font-semibold">Tanggal
                                                        Pengajuan</p>
                                                    <p class="text-sm font-medium text-gray-900">
                                                        {{ $approval->created_at->format('d M Y H:i') }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Data -->
                                        <div class="space-y-6 mb-6">
                                            @if ($approval->model_type === 'PackagingForm')
                                                <div class="border-l-4 border-blue-600 pl-4">
                                                    <h3
                                                        class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">
                                                        Data Pemasok</h3>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                        <div>
                                                            <p class="text-gray-600">Nama Pemasok</p>
                                                            <p class="font-medium text-gray-900">{{ $form->supplier_name }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">NPWP</p>
                                                            <p class="font-medium text-gray-900">{{ $form->npwp_number }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">No Faktur PO</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ $form->po_invoice_number }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">No Plat Kendaraan</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ $form->vehicle_registration_number }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="border-l-4 border-purple-600 pl-4">
                                                    <h3
                                                        class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">
                                                        Data Kemasan</h3>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                        <div>
                                                            <p class="text-gray-600">Daftar Kemasan</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ implode(', ', json_decode($form->packaging_list, true) ?? []) }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Total Kemasan</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ $form->total_packages }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Jenis Kemasan</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ $form->packaging_type }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Kuantitas Kemasan</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ $form->package_quantity }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Berat Kotor (Gross)</p>
                                                            <p class="font-medium text-gray-900">{{ $form->gross_weight }}
                                                                kg</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Berat Bersih (Net)</p>
                                                            <p class="font-medium text-gray-900">{{ $form->net_weight }} kg
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="border-l-4 border-green-600 pl-4">
                                                    <h3
                                                        class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">
                                                        Data Barang</h3>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                        <div>
                                                            <p class="text-gray-600">HS Code</p>
                                                            <p class="font-medium text-gray-900">{{ $form->hs_code }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Nama Barang</p>
                                                            <p class="font-medium text-gray-900">{{ $form->item_name }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Kode Barang</p>
                                                            <p class="font-medium text-gray-900">{{ $form->item_code }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Kuantitas</p>
                                                            <p class="font-medium text-gray-900">{{ $form->quantity }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Tipe</p>
                                                            <p class="font-medium text-gray-900">{{ $form->type }}</p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Harga Barang</p>
                                                            <p class="font-medium text-gray-900">Rp
                                                                {{ number_format($form->item_price, 0, ',', '.') }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="border-l-4 border-yellow-600 pl-4">
                                                    <h3
                                                        class="text-sm font-semibold text-gray-700 mb-3 uppercase tracking-wide">
                                                        Jadwal</h3>
                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                        <div>
                                                            <p class="text-gray-600">Tanggal Kedatangan</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ \Carbon\Carbon::parse($form->arrival_datetime)->format('d M Y H:i') }}
                                                            </p>
                                                        </div>
                                                        <div>
                                                            <p class="text-gray-600">Tanggal Keberangkatan</p>
                                                            <p class="font-medium text-gray-900">
                                                                {{ \Carbon\Carbon::parse($form->departure_datetime)->format('d M Y H:i') }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Approval History Section -->
                                        @php
                                            $allApprovals = \App\Models\Approval::where(
                                                'model_type',
                                                $approval->model_type,
                                            )
                                                ->where('model_id', $approval->model_id)
                                                ->where('status', 'approved')
                                                ->orderBy('created_at', 'asc')
                                                ->get();
                                        @endphp

                                        @if ($allApprovals->count() > 0)
                                            <div class="border-t pt-6 mt-6">
                                                <h3
                                                    class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide flex items-center gap-2">
                                                    <i class="fas fa-history text-green-600"></i>
                                                    Riwayat Persetujuan
                                                </h3>

                                                <div class="space-y-4">
                                                    @foreach ($allApprovals as $hist)
                                                        <div
                                                            class="bg-gray-50 rounded-lg p-4 border-l-4 
                                                        @if ($hist->approval_level == 'security') border-blue-600
                                                        @elseif($hist->approval_level == 'export_import') border-purple-600
                                                        @elseif($hist->approval_level == 'warehouse') border-green-600 @endif">

                                                            <div class="flex justify-between items-start mb-2">
                                                                <h4
                                                                    class="font-semibold text-gray-900 flex items-center gap-2">
                                                                    @if ($hist->approval_level == 'security')
                                                                        <i class="fas fa-shield-alt text-blue-600"></i>
                                                                        <span class="text-blue-700">Catatan dari
                                                                            Security</span>
                                                                    @elseif($hist->approval_level == 'export_import')
                                                                        <i class="fas fa-warehouse text-purple-600"></i>
                                                                        <span class="text-purple-700">Catatan dari
                                                                            Export-Import</span>
                                                                    @elseif($hist->approval_level == 'warehouse')
                                                                        <i class="fas fa-boxes text-green-600"></i>
                                                                        <span class="text-green-700">Catatan dari
                                                                            Warehouse</span>
                                                                    @endif
                                                                </h4>
                                                                <span
                                                                    class="text-xs text-gray-600">{{ $hist->approved_at->format('d M Y H:i') }}</span>
                                                            </div>

                                                            <p class="text-sm text-gray-600 mb-2">
                                                                <strong>Disetujui oleh:</strong>
                                                                {{ $hist->approver->name ?? 'Sistem' }}
                                                            </p>

                                                            @if ($hist->notes)
                                                                <div
                                                                    class="bg-white rounded p-3 mt-2 border border-gray-200">
                                                                    <p class="text-sm text-gray-700">{{ $hist->notes }}
                                                                    </p>
                                                                </div>
                                                            @else
                                                                <div
                                                                    class="bg-white rounded p-3 mt-2 border border-gray-200">
                                                                    <p class="text-sm text-gray-500 italic">Tidak ada
                                                                        catatan</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif

                                        <!-- Decision Section -->
                                        <div class="border-t pt-6">
                                            <h3
                                                class="text-sm font-semibold text-gray-700 mb-4 uppercase tracking-wide flex items-center gap-2">
                                                <i class="fas fa-check-circle text-blue-600"></i>
                                                Keputusan Persetujuan
                                            </h3>

                                            <div class="space-y-4">
                                                <div>
                                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan
                                                        (Opsional)</label>
                                                    <textarea id="notes-{{ $approval->id }}"
                                                        class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 transition resize-none"
                                                        rows="3" placeholder="Tambahkan catatan jika ada..."></textarea>
                                                </div>

                                                <div class="flex justify-end gap-3">
                                                    <form action="{{ route('security.reject', $approval->id) }}"
                                                        method="POST" class="inline reject-form"
                                                        data-approval-id="{{ $approval->id }}">
                                                        @csrf
                                                        <input type="hidden" name="notes" class="reject-notes">
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition font-semibold">
                                                            <i class="fas fa-times"></i> Tolak
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('security.approve', $approval->id) }}"
                                                        method="POST" class="inline approve-form"
                                                        data-approval-id="{{ $approval->id }}">
                                                        @csrf
                                                        <input type="hidden" name="notes" class="approve-notes">
                                                        <button type="submit"
                                                            class="inline-flex items-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition font-semibold">
                                                            <i class="fas fa-check"></i> Setujui
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                <p class="text-gray-600 text-lg font-medium">Tidak ada formulir yang menunggu persetujuan</p>
                <p class="text-gray-500 text-sm mt-2">Semua formulir telah diproses</p>
            </div>
        @endif
    </div>

    <script>
        function showModal(id) {
            document.getElementById(id).style.display = 'flex';
        }

        function hideModal(id) {
            document.getElementById(id).style.display = 'none';
        }

        // Handle form submission
        document.addEventListener('click', function(event) {
            const submitBtn = event.target.closest('button[type="submit"]');
            if (!submitBtn) return;

            const form = submitBtn.closest('form');
            if (!form) return;

            // Find the modal that contains this form
            const modal = form.closest('[id^="approval-modal-"]');
            if (!modal) return;

            // Find textarea in the modal
            const textarea = modal.querySelector('textarea[id^="notes-"]');
            if (!textarea) return;

            // Find the hidden notes input in the form
            const notesInput = form.querySelector('input[name="notes"]');
            if (notesInput) {
                notesInput.value = textarea.value;
            }
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            if (event.target.classList && event.target.classList.contains('modal-wrapper')) {
                const id = event.target.id;
                if (id && id.startsWith('approval-modal-')) {
                    hideModal(id);
                }
            }
        });
    </script>
@endsection
