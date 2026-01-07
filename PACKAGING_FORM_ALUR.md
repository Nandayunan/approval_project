📋 ALUR LENGKAP PACKAGING FORM - PACKAGING FORMS

═══════════════════════════════════════════════════════════════

1️⃣ FORM REQUEST - GET (Menampilkan Form)
────────────────────────────────────────
URL: /supplier/packaging-forms/create
METHOD: GET
CONTROLLER: SupplierDashboardController::packagingFormCreate()
ACTION: Menampilkan halaman form kosong
VIEW: resources/views/supplier/packaging-form-create.blade.php

✅ FORM FIELDS (Input yang dikumpulkan):
   📝 Informasi Pemasok:
      - supplier_name (Text)
      - npwp_number (Text)
      - po_invoice_number (Text)
      - vehicle_registration_number (Text)
      
   📦 Informasi Kemasan:
      - packaging_list (JSON Array - ["box", "bag"])
      - total_packages (Integer)
      - total_types (Integer)
      - gross_weight (Numeric - kg)
      - net_weight (Numeric - kg)
      - packaging_type (Text)
      - package_quantity (Integer)
      
   📄 Informasi Barang:
      - hs_code (Text)
      - item_name (Text)
      - item_code (Text)
      - quantity (Integer)
      - type (Text)
      - item_price (Numeric - Rp)
      
   📅 Jadwal:
      - arrival_datetime (DateTime - format: Y-m-d\TH:i)
      - departure_datetime (DateTime - format: Y-m-d\TH:i)


2️⃣ FORM SUBMISSION - POST (Kirim Formulir)
──────────────────────────────────────────
URL: /supplier/packaging-forms (POST)
ROUTE: supplier.packaging-forms.store
METHOD: POST
CONTROLLER: SupplierDashboardController::packagingFormStore()

✅ VALIDATION RULES (Pemberian status):
   'supplier_name' => 'required|string',
   'npwp_number' => 'required|string',
   'po_invoice_number' => 'required|string',
   'packaging_list' => 'required|json',
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
   'arrival_datetime' => 'required|date_format:Y-m-d\TH:i',  ✅ FIXED
   'departure_datetime' => 'required|date_format:Y-m-d\TH:i',  ✅ FIXED

⚠️ PENTING: Jika validasi GAGAL, form akan redirect kembali dengan error messages


3️⃣ DATABASE INSERTION (Menyimpan ke Database)
──────────────────────────────────────────────
DATABASE: pt_xyz_approval
TABLE: packaging_forms

📊 MODEL: App\Models\PackagingForm
   - Fillable: Semua field di atas + 'status'
   - Casts: 
     * packaging_list => array (JSON)
     * arrival_datetime => datetime
     * departure_datetime => datetime

💾 DATA YANG DISIMPAN:
   {
     user_id: Auth::id(),                    // User yang submit form
     supplier_name: "...",
     npwp_number: "...",
     po_invoice_number: "...",
     packaging_list: {"type": "box", ...},   // Auto di-cast ke JSON
     vehicle_registration_number: "...",
     total_packages: 50,
     total_types: 3,
     gross_weight: 1250.00,
     hs_code: "...",
     item_name: "...",
     item_code: "...",
     quantity: 5000,
     type: "...",
     packaging_type: "...",
     package_quantity: 50,
     net_weight: 1200.00,
     item_price: 50000.00,
     arrival_datetime: "2025-01-06 10:00:00",  // Auto di-cast ke datetime
     departure_datetime: "2025-01-07 15:00:00",
     status: "submitted",                     // Status awal
     created_at: 2025-01-06 11:39:22,
     updated_at: 2025-01-06 11:39:22
   }

✅ CREATE SUCCESSFUL: 
   PackagingForm::create(array_merge($validated, [
       'user_id' => Auth::id(),
       'status' => 'submitted',
   ]));


4️⃣ REDIRECT & RESPONSE (Setelah Berhasil)
────────────────────────────────────────
✅ Jika BERHASIL:
   - Redirect ke: /supplier/packaging-forms (GET)
   - Pesan: "Formulir pengemasan berhasil dikirimkan!"
   - Status: 302 Found

❌ Jika GAGAL (Validasi Error):
   - Redirect ke: form create page
   - Error messages ditampilkan
   - Old input di-preserve dengan old()


5️⃣ VIEW LIST FORMS (Menampilkan Daftar)
──────────────────────────────────────────
URL: /supplier/packaging-forms
METHOD: GET
CONTROLLER: SupplierDashboardController::packagingForms()
QUERY: PackagingForm::where('user_id', $user->id)->orderBy('created_at', 'desc')->get()
VIEW: resources/views/supplier/packaging-forms.blade.php

✅ MENAMPILKAN:
   - Daftar semua form yang user buat
   - Columns: NPWP, PO Number, Item Name, Status, Created Date
   - Action: Lihat detail (Modal)


═══════════════════════════════════════════════════════════════

✅ DATABASE VERIFICATION CHECKLIST:

1. ✅ Database Connection: pt_xyz_approval
2. ✅ Table Exists: packaging_forms
3. ✅ Columns Match:
   - id, user_id, supplier_name, npwp_number
   - po_invoice_number, packaging_list, vehicle_registration_number
   - total_packages, total_types, gross_weight, hs_code
   - item_name, item_code, quantity, type, packaging_type
   - package_quantity, net_weight, item_price
   - arrival_datetime, departure_datetime, status
   - created_at, updated_at
4. ✅ Foreign Key: user_id references users(id)
5. ✅ Model Casts: Correct JSON & DateTime handling

═══════════════════════════════════════════════════════════════

🔧 TROUBLESHOOTING - Jika Ada Masalah:

1. Form tidak bisa di-submit:
   ❌ Check: Browser console (F12) untuk JS errors
   ❌ Check: Validate button type="submit"
   ❌ Check: Form action="{{ route('supplier.packaging-forms.store') }}"

2. Validasi error:
   ❌ Check: Semua field required sudah diisi
   ❌ Check: Format datetime: YYYY-MM-DDTHH:MM
   ❌ Check: packaging_list format JSON: ["box", "bag"]

3. Data tidak masuk database:
   ❌ Check: CREATE permission di table packaging_forms
   ❌ Check: Foreign key user_id ada di users table
   ❌ Check: Laravel logs (storage/logs/)
   ❌ Check: Database connection di .env

4. Error messages:
   - "The supplier name field is required" => Field tidak diisi
   - "The packaging list must be a valid JSON string" => Format JSON salah
   - "The arrival datetime field must be a valid date" => Format datetime salah

═══════════════════════════════════════════════════════════════

ALUR LENGKAP VISUAL:

1. GET /supplier/packaging-forms/create
   ↓
2. Tampil Form HTML
   ↓
3. User mengisi semua field
   ↓
4. Click "Kirim Formulir" button
   ↓
5. POST /supplier/packaging-forms
   ↓
6. Laravel Validation
   ✅ VALID → PackagingForm::create() → Database INSERT
   ❌ INVALID → Redirect back dengan error messages
   ↓
7. Redirect to /supplier/packaging-forms
   ↓
8. Tampil list dengan form baru yang sudah disimpan

═══════════════════════════════════════════════════════════════
