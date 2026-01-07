# Aplikasi Persetujuan PT. XYZ

Sistem manajemen persetujuan dokumen berbasis web dengan 4 level persetujuan untuk PT. XYZ.

## 🎯 Fitur Utama

- **Multi-Level Approval**: Supplier → Security → Export-Import → Warehouse
- **Role-Based Access Control**: Sistem kontrol akses berdasarkan peran pengguna
- **3 Jenis Form**: Packaging Forms, Resin Forms, Film Forms
- **Dashboard yang Intuitif**: Setiap role memiliki dashboard khusus
- **Responsive Design**: Kompatibel dengan desktop dan mobile

## 📋 Peran & Tanggung Jawab

### 1. **Supplier** (👤 supplier@example.com)
- Membuat form persetujuan (Packaging, Resin, Film)
- Melihat status persetujuan form yang dibuat
- Mengedit form dalam status draft

### 2. **Security** (👤 security@example.com)
- Melihat daftar form dari supplier yang menunggu persetujuan
- Melihat detail form
- Menyetujui atau menolak persetujuan dengan catatan

### 3. **Export-Import** (👤 export@example.com)
- Melihat form yang sudah disetujui security
- Melihat detail form
- Menyetujui atau menolak dengan catatan

### 4. **Warehouse** (👤 warehouse@example.com)
- Melihat form yang sudah disetujui export-import
- Melihat detail form
- Menyetujui atau menolak persetujuan final
- **CRUD Operations**: Edit dan hapus form yang sudah disetujui

## 🚀 Quick Start

### Persyaratan
- PHP 8.2+
- Laravel 12
- MySQL/MariaDB (XAMPP)
- Composer

### Instalasi

1. **Clone atau masuk ke direktori proyek:**
```bash
cd D:\TA-sesar\approval-app
```

2. **Install dependencies (jika belum):**
```bash
composer install
```

3. **Setup .env (sudah di-set)**
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=pt_xyz_approval
DB_USERNAME=root
DB_PASSWORD=
```

4. **Jalankan migrations (sudah di-jalankan):**
```bash
php artisan migrate
```

5. **Seed database dengan demo data:**
```bash
php artisan db:seed
```

6. **Jalankan server:**
```bash
php artisan serve --host=localhost --port=8000
```

7. **Akses aplikasi di browser:**
```
http://localhost:8000
```

## 👥 Demo Akun

| Role | Email | Password |
|------|-------|----------|
| Supplier | supplier@example.com | password |
| Security | security@example.com | password |
| Export-Import | export@example.com | password |
| Warehouse | warehouse@example.com | password |

## 📁 Struktur Direktori

```
approval-app/
├── app/
│   ├── Models/              # Database Models
│   │   ├── User.php
│   │   ├── PackagingForm.php
│   │   ├── ResinForm.php
│   │   ├── FilmForm.php
│   │   └── Approval.php
│   └── Http/
│       ├── Controllers/     # Business Logic
│       │   ├── DashboardController.php
│       │   ├── SupplierDashboardController.php
│       │   ├── SecurityDashboardController.php
│       │   ├── ExportImportDashboardController.php
│       │   ├── WarehouseDashboardController.php
│       │   └── Auth/        # Authentication Controllers
│       └── Middleware/      # Middleware
│           └── RoleMiddleware.php
├── database/
│   ├── migrations/          # Database Migrations
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 2024_01_06_000001_create_roles_table.php
│   │   ├── 2024_01_06_000002_create_packaging_forms_table.php
│   │   ├── 2024_01_06_000003_create_resin_forms_table.php
│   │   ├── 2024_01_06_000004_create_film_forms_table.php
│   │   └── 2024_01_06_000005_create_approvals_table.php
│   └── seeders/
│       └── DatabaseSeeder.php
├── resources/
│   └── views/               # Blade Templates
│       ├── auth/            # Login, Register, Password Reset
│       ├── layouts/         # Master Layout
│       ├── supplier/        # Supplier Views
│       ├── security/        # Security Views
│       ├── export_import/   # Export-Import Views
│       └── warehouse/       # Warehouse Views
├── routes/
│   ├── web.php              # Web Routes
│   └── auth.php             # Authentication Routes
├── .env                     # Environment Configuration
└── composer.json            # PHP Dependencies
```

## 🔄 Workflow Persetujuan

### 1. Form Submission (Supplier)
```
Supplier membuat form → Status: submitted
```

### 2. Security Review
```
Security melihat form pending → 
  ✅ Approve → Status: security_approved (next level: Export-Import)
  ❌ Reject → Status: rejected
```

### 3. Export-Import Review
```
Export-Import melihat form approved security → 
  ✅ Approve → Status: export_import_approved (next level: Warehouse)
  ❌ Reject → Status: rejected
```

### 4. Warehouse Review
```
Warehouse melihat form approved export-import → 
  ✅ Approve → Status: warehouse_approved (FINAL)
  ❌ Reject → Status: rejected
  📝 Edit → Modify approved form
  🗑️ Delete → Remove form from system
```

## 📊 Database Schema

### Users Table
- `id` - Primary Key
- `name` - User Name
- `email` - User Email
- `password` - Hashed Password
- `role` - Enum: supplier, security, export_import, warehouse, admin
- `email_verified_at` - Email Verification Timestamp
- `remember_token` - Login Token
- `timestamps` - Created/Updated At

### Packaging Forms Table
- `id` - Primary Key
- `user_id` - Foreign Key (Supplier)
- `supplier_name` - Nama Supplier
- `npwp_number` - Nomor NPWP
- `po_invoice_number` - PO/Invoice
- `vehicle_registration_number` - Nomor Kendaraan
- `hs_code` - HS Code
- `item_name` - Nama Item
- `item_code` - Kode Item
- `quantity` - Kuantitas
- `type` - Jenis Item
- `gross_weight` - Berat Kotor
- `net_weight` - Berat Bersih
- `packaging_details` - Detail Kemasan
- `item_price` - Harga Item
- `arrival_datetime` - Tanggal Kedatangan
- `departure_datetime` - Tanggal Keberangkatan
- `status` - Enum: draft, submitted, security_approved, export_import_approved, warehouse_approved, rejected
- `timestamps` - Created/Updated At

### Resin Forms Table
- `id` - Primary Key
- `user_id` - Foreign Key (Supplier)
- `transport_type` - Enum: udara (air), laut (sea)
- `awb_number` - AWB Number (jika udara)
- `bill_of_lading` - BoL Number (jika laut)
- `invoice_number` - Invoice Number
- `packaging_list` - JSON field for packaging details
- `manifest_entry` - JSON field for manifest data
- `noa_number` - NOA Number
- `status` - Enum: draft, submitted, security_approved, export_import_approved, warehouse_approved, rejected
- `timestamps` - Created/Updated At

### Film Forms Table
- `id` - Primary Key
- `user_id` - Foreign Key (Supplier)
- `awb_number` - AWB Number
- `invoice_number` - Invoice Number
- `packaging_list` - JSON field
- `manifest_entry` - JSON field
- `noa_number` - NOA Number
- `status` - Enum: draft, submitted, security_approved, export_import_approved, warehouse_approved, rejected
- `timestamps` - Created/Updated At

### Approvals Table (Polymorphic)
- `id` - Primary Key
- `user_id` - Foreign Key (Submitter)
- `approver_id` - Foreign Key (Who Approved)
- `model_type` - Class name (App\Models\PackagingForm, etc)
- `model_id` - ID of the model being approved
- `approval_level` - Enum: security, export_import, warehouse
- `status` - Enum: pending, approved, rejected
- `notes` - Approval Notes/Comments
- `approved_at` - Approval Timestamp
- `timestamps` - Created/Updated At

## 🛠️ API Endpoints

### Authentication Routes
- `POST /register` - Register new user
- `POST /login` - Login user
- `POST /logout` - Logout user
- `POST /forgot-password` - Request password reset

### Supplier Routes
- `GET /supplier/dashboard` - Supplier Dashboard
- `GET /supplier/packaging-forms` - List packaging forms
- `GET /supplier/packaging-forms/create` - Create form view
- `POST /supplier/packaging-forms` - Store form
- `GET /supplier/resin-forms` - List resin forms
- `GET /supplier/resin-forms/create` - Create form view
- `POST /supplier/resin-forms` - Store form
- `GET /supplier/film-forms` - List film forms
- `GET /supplier/film-forms/create` - Create form view
- `POST /supplier/film-forms` - Store form

### Security Routes
- `GET /security/dashboard` - Security Dashboard
- `GET /security/pending-approvals` - List pending approvals
- `POST /security/approve/{approvalId}` - Approve form
- `POST /security/reject/{approvalId}` - Reject form

### Export-Import Routes
- `GET /export-import/dashboard` - Export-Import Dashboard
- `GET /export-import/pending-approvals` - List pending approvals
- `POST /export-import/approve/{approvalId}` - Approve form
- `POST /export-import/reject/{approvalId}` - Reject form

### Warehouse Routes
- `GET /warehouse/dashboard` - Warehouse Dashboard
- `GET /warehouse/pending-approvals` - List pending approvals
- `GET /warehouse/approved-forms` - List approved forms
- `GET /warehouse/view-form/{modelType}/{modelId}` - View form
- `GET /warehouse/edit/{modelType}/{modelId}` - Edit form view
- `PUT /warehouse/update/{modelType}/{modelId}` - Update form
- `DELETE /warehouse/delete/{modelType}/{modelId}` - Delete form
- `POST /warehouse/approve/{approvalId}` - Approve form
- `POST /warehouse/reject/{approvalId}` - Reject form

## 🎨 UI/UX Highlights

### Master Layout
- **Navigasi berbasis role**: Menu yang berbeda untuk setiap peran
- **Responsive Design**: Mobile-first dengan Tailwind CSS
- **Flash Messages**: Notifikasi success/error yang jelas
- **User Info**: Display user name dan role di header

### Dashboard Views
- **Stat Cards**: Menampilkan jumlah form/approvals pending
- **Quick Actions**: Tombol untuk membuat form atau lihat pending approvals
- **Modal Views**: View detail form tanpa page refresh
- **Status Badges**: Warna berbeda untuk setiap status

### Forms
- **Validation**: Client-side dan server-side validation
- **Dynamic Fields**: Conditional fields berdasarkan input (e.g., transport type)
- **Date Pickers**: Format tanggal yang jelas dan konsisten
- **JSON Fields**: Support untuk array/object data (packaging list, manifest)

## 🔐 Security Features

- **Authentication**: Laravel's built-in authentication system
- **Authorization**: Role-based middleware untuk kontrol akses
- **Password Hashing**: bcrypt untuk hashing password
- **CSRF Protection**: Built-in CSRF token di form
- **SQL Injection Prevention**: Eloquent ORM dengan parameterized queries

## 📝 Status Definitions

| Status | Deskripsi | Next Action |
|--------|-----------|-------------|
| `draft` | Form dalam proses editing | Submit to security |
| `submitted` | Menunggu approval security | Security review |
| `security_approved` | Sudah disetujui security | Export-Import review |
| `export_import_approved` | Sudah disetujui export-import | Warehouse review |
| `warehouse_approved` | Approval final, approved | Can edit/delete |
| `rejected` | Ditolak pada level manapun | Need revision |

## 🐛 Troubleshooting

### 1. Database Connection Error
- Pastikan XAMPP MySQL sudah running
- Check `.env` database credentials
- Jalankan `php artisan migrate`

### 2. "Class not found" Error
- Jalankan `composer install`
- Clear cache: `php artisan cache:clear`

### 3. Permission Denied pada File
- Jalankan: `php artisan storage:link`
- Check folder permissions

### 4. LDAP Warning
- Non-critical warning dari PHP module
- Tidak mempengaruhi aplikasi

## 📞 Support

Untuk pertanyaan atau issues, silakan hubungi tim development PT. XYZ.

## 📄 License

Proprietary - PT. XYZ

---

**Version**: 1.0  
**Last Updated**: January 6, 2026  
**Framework**: Laravel 12  
**Database**: MySQL
