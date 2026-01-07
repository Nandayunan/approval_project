# Workflow Approval System

## Deskripsi Umum
Sistem approval multi-level untuk mengelola persetujuan form dari supplier hingga warehouse.

## Alur Workflow

```
┌─────────────┐
│  SUPPLIER   │
│ Submit Form │
└──────┬──────┘
       │
       ├─ PackagingForm::create() + Approval (level: security)
       ├─ ResinForm::create() + Approval (level: security)
       └─ FilmForm::create() + Approval (level: security)
       │
       ▼
┌──────────────────┐
│    SECURITY      │
│ Pending Approval │ ← Melihat approval dengan level='security' & status='pending'
└──────┬───────────┘
       │
       ├─ Approve → Form status='security_approved' + Create Approval (level: export_import)
       └─ Reject  → Form status='rejected'
       │
       ▼
┌─────────────────────────┐
│   EXPORT-IMPORT         │
│ Pending Approval        │ ← Melihat approval dengan level='export_import' & status='pending'
└──────┬──────────────────┘
       │
       ├─ Approve → Form status='export_import_approved' + Create Approval (level: warehouse)
       └─ Reject  → Form status='rejected'
       │
       ▼
┌──────────────────┐
│    WAREHOUSE     │
│ Pending Approval │ ← Melihat approval dengan level='warehouse' & status='pending'
└──────┬───────────┘
       │
       ├─ Approve → Form status='warehouse_approved' ✅ SELESAI
       └─ Reject  → Form status='rejected'
       │
       ▼
   [COMPLETE]
```

## Database Schema

### Tabel: approvals
```sql
id (PK)
user_id (FK → users, supplier yang submit form)
approver_id (FK → users, role yang approve)
model_type (PackagingForm, ResinForm, FilmForm)
model_id (ID dari form yang di-approve)
approval_level (security, export_import, warehouse)
status (pending, approved, rejected)
notes (keterangan dari approver)
approved_at (timestamp kapan di-approve)
created_at
updated_at
```

## Implementasi Kode

### 1. Supplier Submit Form (SupplierDashboardController)

**packagingFormStore()** - Contoh untuk PackagingForm:
```php
// 1. Validasi dan buat form
$form = PackagingForm::create(array_merge($validated, [
    'user_id' => Auth::id(),
    'status' => 'submitted',
]));

// 2. Buat Approval record untuk security
Approval::create([
    'user_id' => Auth::id(),                    // Supplier
    'model_type' => 'PackagingForm',
    'model_id' => $form->id,
    'approval_level' => 'security',             // Ke level security
    'status' => 'pending',                      // Tunggu approval
]);
```

**Sama untuk resinFormStore() dan filmFormStore()** dengan model_type berbeda.

### 2. Security Dashboard (SecurityDashboardController)

**index()** - Tampilkan pending approvals:
```php
$pendingApprovals = Approval::where('approval_level', 'security')
    ->where('status', 'pending')
    ->get();
```

**approve()** - Saat security setuju:
```php
// 1. Update approval sebagai approved
$approval->update([
    'status' => 'approved',
    'approver_id' => Auth::id(),                // Security user
    'approved_at' => now(),
]);

// 2. Update form status
$form->update(['status' => 'security_approved']);

// 3. Buat approval baru untuk export_import
Approval::create([
    'user_id' => $form->user_id,
    'model_type' => $approval->model_type,
    'model_id' => $approval->model_id,
    'approval_level' => 'export_import',        // Ke level berikutnya
    'status' => 'pending',
]);
```

### 3. Export-Import Dashboard (ExportImportDashboardController)

**index()** - Tampilkan pending approvals:
```php
$pendingApprovals = Approval::where('approval_level', 'export_import')
    ->where('status', 'pending')
    ->get();
```

**approve()** - Saat export-import setuju:
```php
// 1. Update approval sebagai approved
$approval->update([
    'status' => 'approved',
    'approver_id' => Auth::id(),                // Export-Import user
    'approved_at' => now(),
]);

// 2. Update form status
$form->update(['status' => 'export_import_approved']);

// 3. Buat approval baru untuk warehouse
Approval::create([
    'user_id' => $form->user_id,
    'model_type' => $approval->model_type,
    'model_id' => $approval->model_id,
    'approval_level' => 'warehouse',            // Ke level terakhir
    'status' => 'pending',
]);
```

### 4. Warehouse Dashboard (WarehouseDashboardController)

**index()** - Tampilkan pending approvals:
```php
$pendingApprovals = Approval::where('approval_level', 'warehouse')
    ->where('status', 'pending')
    ->get();
```

**approve()** - Saat warehouse setuju (SELESAI):
```php
$approval->update([
    'status' => 'approved',
    'approver_id' => Auth::id(),                // Warehouse user
    'approved_at' => now(),
]);

$form->update(['status' => 'warehouse_approved']);
// ✅ Approval workflow selesai, tidak ada level berikutnya
```

## Form Status Progression

```
submitted 
    ↓
security_approved (setelah security approve)
    ↓
export_import_approved (setelah export-import approve)
    ↓
warehouse_approved (setelah warehouse approve) ✅
```

Jika ditolak di level manapun:
```
rejected (final state)
```

## Testing Checklist

- [ ] Supplier buat packaging form → Check approvals table ada entry dengan level='security'
- [ ] Security dashboard tampil 1 pending approval
- [ ] Security approve → Check form status='security_approved' & new approval created dengan level='export_import'
- [ ] Export-Import dashboard tampil 1 pending approval
- [ ] Export-Import approve → Check form status='export_import_approved' & new approval created dengan level='warehouse'
- [ ] Warehouse dashboard tampil 1 pending approval
- [ ] Warehouse approve → Check form status='warehouse_approved' ✅
- [ ] Reject di security → Form status='rejected' & tidak ada approval baru untuk export-import

## File yang Dimodifikasi

1. **SupplierDashboardController.php** - Added Approval::create() di 3 form methods
2. **Approval Model** - Sudah benar dengan polymorphic relation
3. **SecurityDashboardController.php** - Sudah benar create approval untuk export_import
4. **ExportImportDashboardController.php** - Sudah benar create approval untuk warehouse
5. **WarehouseDashboardController.php** - Sudah benar sebagai final approval level

## Import Statement

Semua controller sudah import Approval model:
```php
use App\Models\Approval;
```

---
**Last Updated**: 7 January 2026
**Status**: ✅ Ready for Testing
