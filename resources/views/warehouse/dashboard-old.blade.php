@extends('layouts.app')

@section('title', 'Dashboard Gudang')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Gudang</h1>
    <p class="text-gray-600 mt-2">Kelola persetujuan gudang dan data kiriman</p>
</div>

<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-yellow-600">
        <h3 class="text-gray-600 text-sm font-semibold uppercase">Menunggu Persetujuan</h3>
        <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $pendingApprovals->count() }}</p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-green-600">
        <h3 class="text-gray-600 text-sm font-semibold uppercase">Total Disetujui</h3>
        <p class="text-3xl font-bold text-green-600 mt-2">
            {{ \App\Models\Approval::where('approval_level', 'warehouse')->where('status', 'approved')->count() }}
        </p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-red-600">
        <h3 class="text-gray-600 text-sm font-semibold uppercase">Total Ditolak</h3>
        <p class="text-3xl font-bold text-red-600 mt-2">
            {{ \App\Models\Approval::where('approval_level', 'warehouse')->where('status', 'rejected')->count() }}
        </p>
    </div>
</div>

<!-- Tabs -->
<div class="bg-white rounded-lg shadow-md">
    <div class="border-b flex">
        <button onclick="switchTab('pending')" id="pending-tab" class="flex-1 px-6 py-4 text-center font-semibold text-blue-600 border-b-2 border-blue-600">
            Menunggu Persetujuan ({{ $pendingApprovals->count() }})
        </button>
        <button onclick="switchTab('approved')" id="approved-tab" class="flex-1 px-6 py-4 text-center font-semibold text-gray-600 border-b-2 border-transparent hover:border-gray-300">
            Data Tersetujui
        </button>
    </div>

    <!-- Pending Tab -->
    <div id="pending-content" class="p-6">
        @if($pendingApprovals->count() > 0)
            <div class="space-y-4">
                @foreach($pendingApprovals as $approval)
                    <div class="border border-gray-200 rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">
                                    @if($approval->model_type === 'App\Models\PackagingForm')
                                        Formulir Pengemasan
                                    @elseif($approval->model_type === 'App\Models\ResinForm')
                                        Formulir Resin
                                    @elseif($approval->model_type === 'App\Models\FilmForm')
                                        Formulir Film
                                    @endif
                                </h3>
                                <p class="text-sm text-gray-600 mt-1">Diajukan oleh: {{ $approval->user->name }}</p>
                                <p class="text-sm text-gray-600">Tanggal: {{ $approval->created_at->format('d M Y H:i') }}</p>
                            </div>
                            <button onclick="showModal('approval-modal-{{ $approval->id }}')" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
                                Tinjau
                            </button>
                        </div>
                    </div>

                    <!-- Modal -->
                    <div id="approval-modal-{{ $approval->id }}" class="modal-wrapper fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4" style="display: none;">
                        <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                            <div class="sticky top-0 bg-gray-100 px-6 py-4 border-b flex justify-between items-center">
                                <h2 class="text-xl font-bold">Tinjau Persetujuan</h2>
                                <button onclick="hideModal('approval-modal-{{ $approval->id }}')" class="text-gray-600 hover:text-gray-900 text-2xl">&times;</button>
                            </div>
                            <div class="p-6 space-y-4">
                                <!-- Decision Form -->
                                <div>
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Catatan (Opsional)</label>
                                    <textarea id="notes-{{ $approval->id }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-600" rows="3" placeholder="Tambahkan catatan jika ada"></textarea>
                                </div>

                                <div class="flex justify-end space-x-3">
                                    <form action="{{ route('warehouse.reject', $approval->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="notes" id="reject-notes-{{ $approval->id }}">
                                        <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition" onclick="captureNotes('notes-{{ $approval->id }}', 'reject-notes-{{ $approval->id }}')">Tolak</button>
                                    </form>
                                    <form action="{{ route('warehouse.approve', $approval->id) }}" method="POST" class="inline">
                                        @csrf
                                        <input type="hidden" name="notes" id="approve-notes-{{ $approval->id }}">
                                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition" onclick="captureNotes('notes-{{ $approval->id }}', 'approve-notes-{{ $approval->id }}')">Setujui</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">Tidak ada formulir yang menunggu persetujuan</p>
            </div>
        @endif
    </div>

    <!-- Approved Tab -->
    <div id="approved-content" class="p-6 hidden">
        @php
            $approvedForms = \App\Models\Approval::where('approval_level', 'warehouse')
                ->where('status', 'approved')
                ->with('user')
                ->get();
        @endphp
        
        @if($approvedForms->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-100 border-b-2 border-gray-300">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tipe Formulir</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Pemasok</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Tanggal Disetujui</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($approvedForms as $approval)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @if($approval->model_type === 'App\Models\PackagingForm')
                                        Pengemasan
                                    @elseif($approval->model_type === 'App\Models\ResinForm')
                                        Resin
                                    @elseif($approval->model_type === 'App\Models\FilmForm')
                                        Film
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">{{ $approval->user->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $approval->approved_at->format('d M Y H:i') }}</td>
                                <td class="px-6 py-4 text-sm space-x-2">
                                    <button onclick="showModal('view-modal-{{ $approval->id }}')" class="text-blue-600 hover:underline">Lihat</button>
                                    <button onclick="showModal('edit-modal-{{ $approval->id }}')" class="text-green-600 hover:underline">Edit</button>
                                    <form action="{{ route('warehouse.delete', [strtolower(str_replace('App\\Models\\', '', $approval->model_type)), $approval->model_id]) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <p class="text-gray-600 text-lg">Tidak ada data yang tersetujui</p>
            </div>
        @endif
    </div>
</div>

<script>
function switchTab(tab) {
    // Hide all contents
    document.getElementById('pending-content').classList.add('hidden');
    document.getElementById('approved-content').classList.add('hidden');
    
    // Remove active state from all tabs
    document.getElementById('pending-tab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
    document.getElementById('pending-tab').classList.add('text-gray-600', 'border-transparent');
    
    document.getElementById('approved-tab').classList.remove('text-blue-600', 'border-b-2', 'border-blue-600');
    document.getElementById('approved-tab').classList.add('text-gray-600', 'border-transparent');

    // Show selected content and mark tab as active
    if(tab === 'pending') {
        document.getElementById('pending-content').classList.remove('hidden');
        document.getElementById('pending-tab').classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        document.getElementById('pending-tab').classList.remove('text-gray-600', 'border-transparent');
    } else if(tab === 'approved') {
        document.getElementById('approved-content').classList.remove('hidden');
        document.getElementById('approved-tab').classList.add('text-blue-600', 'border-b-2', 'border-blue-600');
        document.getElementById('approved-tab').classList.remove('text-gray-600', 'border-transparent');
    }
}

function showModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function hideModal(id) {
    document.getElementById(id).style.display = 'none';
}

function captureNotes(sourceId, targetId) {
    document.getElementById(targetId).value = document.getElementById(sourceId).value;
}

document.addEventListener('click', function(event) {
    if(event.target.classList && (
       (event.target.classList.contains('modal-wrapper') && event.target.id && event.target.id.startsWith('approval-modal-')) ||
       (event.target.classList.contains('modal-wrapper') && event.target.id && event.target.id.startsWith('view-modal-')) ||
       (event.target.classList.contains('modal-wrapper') && event.target.id && event.target.id.startsWith('edit-modal-')))) {
        hideModal(event.target.id);
    }
});
</script>
@endsection
