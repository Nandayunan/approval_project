<?php

namespace App\Http\Controllers;

use App\Models\PackagingForm;
use App\Models\ResinForm;
use App\Models\FilmForm;
use App\Models\Approval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('supplier.dashboard', [
            'packageCount' => PackagingForm::where('user_id', $user->id)->count(),
            'resinCount' => ResinForm::where('user_id', $user->id)->count(),
            'filmCount' => FilmForm::where('user_id', $user->id)->count(),
        ]);
    }

    public function packagingForms()
    {
        $user = Auth::user();
        $forms = PackagingForm::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('supplier.packaging-forms', compact('forms'));
    }

    public function packagingFormCreate()
    {
        return view('supplier.packaging-form-create');
    }

    public function packagingFormStore(Request $request)
    {
        $validated = $request->validate([
            'supplier_name' => 'required|string',
            'npwp_number' => 'required|string',
            'po_invoice_number' => 'required|string',
            'packaging_list' => 'required|string',
            'vehicle_registration_number' => 'required|string',
            'total_packages' => 'required|integer',
            'total_types' => 'required|integer',
            'gross_weight' => 'required|numeric',
            'hs_code' => 'required|string',
            'item_name' => 'required|string',
            'item_code' => 'required|string',
            'quantity' => 'required|integer',
            'type' => 'required|string',
            'packaging_type' => 'required|string',
            'package_quantity' => 'required|integer',
            'net_weight' => 'required|numeric',
            'item_price' => 'required|numeric',
            'arrival_datetime' => 'required|date_format:Y-m-d\TH:i',
            'departure_datetime' => 'required|date_format:Y-m-d\TH:i',
        ]);

        // Convert packaging_list dari text ke JSON array
        $packaging_list = explode(',', $validated['packaging_list']);
        $packaging_list = array_map('trim', $packaging_list);
        $validated['packaging_list'] = json_encode($packaging_list);

        $form = PackagingForm::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'menunggu_persetujuan_security',
        ]));

        // Create approval record for security level
        Approval::create([
            'user_id' => Auth::id(),
            'model_type' => 'PackagingForm',
            'model_id' => $form->id,
            'approval_level' => 'security',
            'status' => 'pending',
        ]);

        return redirect()->route('supplier.packaging-forms')->with('success', 'Formulir pengemasan berhasil dikirimkan!');
    }

    public function resinForms()
    {
        $user = Auth::user();
        $forms = ResinForm::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('supplier.resin-forms', compact('forms'));
    }

    public function resinFormCreate()
    {
        return view('supplier.resin-form-create');
    }

    public function resinFormStore(Request $request)
    {
        $validated = $request->validate([
            'transport_type' => 'required|in:udara,laut',
            'awb_number' => 'required_if:transport_type,udara|string|nullable',
            'bill_of_lading' => 'required_if:transport_type,laut|string|nullable',
            'invoice_number' => 'required|string',
            'packaging_list' => 'required|string',
            'manifest_entry' => 'required|string',
            'noa_number' => 'required|string',
        ]);

        // Convert to JSON arrays
        $packaging_list = explode(',', $validated['packaging_list']);
        $packaging_list = array_map('trim', $packaging_list);
        $manifest_entry = explode(',', $validated['manifest_entry']);
        $manifest_entry = array_map('trim', $manifest_entry);

        $validated['packaging_list'] = json_encode($packaging_list);
        $validated['manifest_entry'] = json_encode($manifest_entry);

        $form = ResinForm::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'menunggu_persetujuan_security',
        ]));

        // Create approval record for security level
        Approval::create([
            'user_id' => Auth::id(),
            'model_type' => 'ResinForm',
            'model_id' => $form->id,
            'approval_level' => 'security',
            'status' => 'pending',
        ]);

        return redirect()->route('supplier.resin-forms')->with('success', 'Formulir resin berhasil dikirimkan!');
    }

    public function filmForms()
    {
        $user = Auth::user();
        $forms = FilmForm::where('user_id', $user->id)->orderBy('created_at', 'desc')->get();
        return view('supplier.film-forms', compact('forms'));
    }

    public function filmFormCreate()
    {
        return view('supplier.film-form-create');
    }

    public function filmFormStore(Request $request)
    {
        $validated = $request->validate([
            'awb_number' => 'required|string',
            'invoice_number' => 'required|string',
            'packaging_list' => 'required|string',
            'manifest_entry' => 'required|string',
            'noa_number' => 'required|string',
        ]);

        // Convert to JSON arrays
        $packaging_list = explode(',', $validated['packaging_list']);
        $packaging_list = array_map('trim', $packaging_list);
        $manifest_entry = explode(',', $validated['manifest_entry']);
        $manifest_entry = array_map('trim', $manifest_entry);

        $validated['packaging_list'] = json_encode($packaging_list);
        $validated['manifest_entry'] = json_encode($manifest_entry);

        $form = FilmForm::create(array_merge($validated, [
            'user_id' => Auth::id(),
            'status' => 'menunggu_persetujuan_security',
        ]));

        // Create approval record for security level
        Approval::create([
            'user_id' => Auth::id(),
            'model_type' => 'FilmForm',
            'model_id' => $form->id,
            'approval_level' => 'security',
            'status' => 'pending',
        ]);

        return redirect()->route('supplier.film-forms')->with('success', 'Formulir film berhasil dikirimkan!');
    }
}
