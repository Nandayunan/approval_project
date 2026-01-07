@extends('layouts.app')

@section('title', 'Dashboard Ekspor-Impor')

@section('content')
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900">Dashboard Ekspor-Impor</h1>
    <p class="text-gray-600 mt-2">Kelola persetujuan ekspor-impor untuk semua formulir</p>
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
            {{ \App\Models\Approval::where('approval_level', 'export_import')->where('status', 'approved')->count() }}
        </p>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 border-t-4 border-red-600">
        <h3 class="text-gray-600 text-sm font-semibold uppercase">Total Ditolak</h3>
        <p class="text-3xl font-bold text-red-600 mt-2">
            {{ \App\Models\Approval::where('approval_level', 'export_import')->where('status', 'rejected')->count() }}
        </p>
    </div>
</div>

<!-- Pending Approvals -->
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-gray-900 mb-4">Formulir Menunggu Persetujuan</h2>
    
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
                                <form action="{{ route('export_import.reject', $approval->id) }}" method="POST" class="inline">
                                    @csrf
                                    <input type="hidden" name="notes" id="reject-notes-{{ $approval->id }}">
                                    <button type="submit" class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded transition" onclick="captureNotes('notes-{{ $approval->id }}', 'reject-notes-{{ $approval->id }}')">Tolak</button>
                                </form>
                                <form action="{{ route('export_import.approve', $approval->id) }}" method="POST" class="inline">
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

<script>
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
    if(event.target.classList && event.target.classList.contains('modal-wrapper') && event.target.id && event.target.id.startsWith('approval-modal-')) {
        hideModal(event.target.id);
    }
});
</script>
@endsection
