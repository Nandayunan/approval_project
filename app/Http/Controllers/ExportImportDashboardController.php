<?php

namespace App\Http\Controllers;

use App\Models\PackagingForm;
use App\Models\ResinForm;
use App\Models\FilmForm;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExportImportDashboardController extends Controller
{
    public function index()
    {
        $pendingApprovals = Approval::where('approval_level', 'export_import')
            ->where('status', 'pending')
            ->get();

        $approvedForms = Approval::where('approval_level', 'export_import')
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('export_import.dashboard', compact('pendingApprovals', 'approvedForms'));
    }

    public function pendingApprovals()
    {
        $approvals = Approval::where('approval_level', 'export_import')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('export_import.pending-approvals', compact('approvals'));
    }

    public function viewForm($modelType, $modelId)
    {
        $modelClass = match ($modelType) {
            'packaging' => PackagingForm::class,
            'resin' => ResinForm::class,
            'film' => FilmForm::class,
            default => abort(404),
        };

        $form = $modelClass::findOrFail($modelId);
        return view('export_import.view-form', compact('form', 'modelType'));
    }

    public function approve(Request $request, $approvalId)
    {
        $approval = Approval::findOrFail($approvalId);

        $approval->update([
            'status' => 'approved',
            'approver_id' => Auth::id(),
            'notes' => $request->input('notes'),
            'approved_at' => now(),
        ]);

        // Update form status
        $form = $approval->model;
        $form->update(['status' => 'menunggu_persetujuan_warehouse']);

        // Create next approval for warehouse
        Approval::create([
            'user_id' => $form->user_id,
            'model_type' => $approval->model_type,
            'model_id' => $approval->model_id,
            'approval_level' => 'warehouse',
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Formulir telah disetujui!');
    }

    public function reject(Request $request, $approvalId)
    {
        $approval = Approval::findOrFail($approvalId);

        $approval->update([
            'status' => 'rejected',
            'approver_id' => Auth::id(),
            'notes' => $request->input('notes'),
            'approved_at' => now(),
        ]);

        // Update form status
        $form = $approval->model;
        $form->update(['status' => 'rejected']);

        return redirect()->back()->with('success', 'Formulir telah ditolak!');
    }
}
