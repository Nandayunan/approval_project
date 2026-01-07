<?php

namespace App\Http\Controllers;

use App\Models\PackagingForm;
use App\Models\ResinForm;
use App\Models\FilmForm;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WarehouseDashboardController extends Controller
{
    public function index()
    {
        $pendingApprovals = Approval::where('approval_level', 'warehouse')
            ->where('status', 'pending')
            ->get();

        return view('warehouse.dashboard', compact('pendingApprovals'));
    }

    public function pendingApprovals()
    {
        $approvals = Approval::where('approval_level', 'warehouse')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('warehouse.pending-approvals', compact('approvals'));
    }

    public function approvedForms()
    {
        $approvals = Approval::where('approval_level', 'warehouse')
            ->where('status', 'approved')
            ->orderBy('approved_at', 'desc')
            ->get();

        return view('warehouse.approved-forms', compact('approvals'));
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
        return view('warehouse.view-form', compact('form', 'modelType'));
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
        $form->update(['status' => 'approved']);

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

    public function edit($modelType, $modelId)
    {
        $modelClass = match ($modelType) {
            'packaging' => PackagingForm::class,
            'resin' => ResinForm::class,
            'film' => FilmForm::class,
            default => abort(404),
        };

        $form = $modelClass::findOrFail($modelId);
        return view('warehouse.edit-form', compact('form', 'modelType'));
    }

    public function update(Request $request, $modelType, $modelId)
    {
        $modelClass = match ($modelType) {
            'packaging' => PackagingForm::class,
            'resin' => ResinForm::class,
            'film' => FilmForm::class,
            default => abort(404),
        };

        $form = $modelClass::findOrFail($modelId);
        $form->update($request->except(['_token', '_method']));

        return redirect()->back()->with('success', 'Data berhasil diperbarui!');
    }

    public function delete(Request $request, $modelType, $modelId)
    {
        $modelClass = match ($modelType) {
            'packaging' => PackagingForm::class,
            'resin' => ResinForm::class,
            'film' => FilmForm::class,
            default => abort(404),
        };

        $form = $modelClass::findOrFail($modelId);
        $form->delete();

        return redirect()->back()->with('success', 'Data berhasil dihapus!');
    }
}
