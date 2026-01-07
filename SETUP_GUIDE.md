# 🚀 Setup Guide - Aplikasi Persetujuan PT. XYZ

## ✅ Status Instalasi

Aplikasi sudah **SIAP DIGUNAKAN**. Semua komponen telah dikonfigurasi:

- ✅ Laravel 12 Framework terinstall
- ✅ MySQL Database dikonfigurasi
- ✅ Database migrations selesai
- ✅ Demo users sudah dibuat
- ✅ Development server berjalan
- ✅ All views dan controllers siap

## 🔧 Persyaratan Sistem

1. **XAMPP** dengan:
   - PHP 8.2+
   - MySQL/MariaDB (running)
   - Apache (jika ingin)

2. **PHP CLI** untuk menjalankan artisan commands

3. **Browser** modern (Chrome, Firefox, Edge, Safari)

## 📝 Langkah Pertama

### 1. Buka Terminal PowerShell

```powershell
cd D:\TA-sesar\approval-app
```

### 2. Jalankan Development Server

```bash
php artisan serve --host=localhost --port=8000
```

**Hasil yang diharapkan:**
```
INFO  Server running on [http://localhost:8000].  
Press Ctrl+C to stop the server
```

### 3. Akses Aplikasi di Browser

```
http://localhost:8000
```

Anda akan melihat **Welcome Page** dengan informasi tentang aplikasi.

## 👤 Login dengan Demo Account

### 4 Demo Account Tersedia:

**A. Supplier Account**
- Email: `supplier@example.com`
- Password: `password`
- Role: Supplier

**B. Security Account**
- Email: `security@example.com`
- Password: `password`
- Role: Security

**C. Export-Import Account**
- Email: `export@example.com`
- Password: `password`
- Role: Export-Import

**D. Warehouse Account**
- Email: `warehouse@example.com`
- Password: `password`
- Role: Warehouse

## 📋 Testing Workflow

### Scenario: Complete Approval Chain

1. **Login sebagai Supplier**
   - Email: `supplier@example.com` / `password`
   - Klik "Packaging Forms"
   - Klik "Buat Form Baru"
   - Isi semua field form
   - Klik "Submit"

2. **Login sebagai Security**
   - Email: `security@example.com` / `password`
   - Lihat form yang pending approval
   - Klik "View" untuk melihat detail
   - Klik "Setujui" dan tambahkan catatan
   - Form akan pindah ke Export-Import queue

3. **Login sebagai Export-Import**
   - Email: `export@example.com` / `password`
   - Lihat form approved dari Security
   - Klik "Setujui" dan tambahkan catatan
   - Form akan pindah ke Warehouse queue

4. **Login sebagai Warehouse**
   - Email: `warehouse@example.com` / `password`
   - Lihat form approved dari Export-Import
   - Klik "Setujui" untuk final approval
   - Atau klik "Edit" untuk modify form
   - Atau klik "Hapus" untuk delete form

## 🛠️ Common Commands

### Jalankan Development Server
```bash
php artisan serve --host=localhost --port=8000
```

### Reset Database (jika diperlukan)
```bash
php artisan migrate:fresh --seed
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:cache
```

### View Logs
```bash
tail -f storage/logs/laravel.log
```

### Jalankan Specific Seeder
```bash
php artisan db:seed --class=DatabaseSeeder
```

## 📊 File Penting

| File | Lokasi | Fungsi |
|------|--------|--------|
| Environment Config | `.env` | Database & App Config |
| Routes | `routes/web.php` | URL Routes |
| Models | `app/Models/` | Database Models |
| Controllers | `app/Http/Controllers/` | Business Logic |
| Views | `resources/views/` | Frontend Templates |
| Migrations | `database/migrations/` | Database Schema |
| Seeder | `database/seeders/DatabaseSeeder.php` | Demo Data |

## 🔍 Checking Setup Status

### Verify Database Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo()
>>> quit
```

### Check if Tables Exist
```bash
php artisan tinker
>>> DB::select('SHOW TABLES')
>>> quit
```

### View All Routes
```bash
php artisan route:list
```

### Check Environment
```bash
php artisan env
```

## ⚙️ Konfigurasi MySQL (XAMPP)

1. **Buka XAMPP Control Panel**
2. **Klik "Start" untuk MySQL**
3. **Verify MySQL running:**
   ```bash
   mysql -u root
   MariaDB> show databases;
   MariaDB> exit
   ```

4. **Database sudah ada:**
   ```
   pt_xyz_approval
   ```

## 🆘 Troubleshooting

### Error: "Port 8000 already in use"
**Solusi:** Gunakan port berbeda
```bash
php artisan serve --host=localhost --port=8001
```

### Error: "Database connection refused"
**Solusi:** 
1. Pastikan XAMPP MySQL sudah running
2. Check `.env` credentials:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pt_xyz_approval
   DB_USERNAME=root
   DB_PASSWORD=
   ```

### Error: "Class not found"
**Solusi:** 
```bash
composer install
php artisan cache:clear
```

### Error: "Permission denied"
**Solusi:** Beri permission folder storage
```bash
php artisan storage:link
```

### Warning: "LDAP module already loaded"
**Status:** Non-critical warning - tidak mempengaruhi aplikasi

## 📈 Performance Tips

1. **Cache Configuration**
   ```bash
   php artisan config:cache
   php artisan route:cache
   ```

2. **Optimize Autoloader**
   ```bash
   composer install --optimize-autoloader --no-dev
   ```

3. **Monitor Logs**
   - Buka `storage/logs/laravel.log`
   - Check untuk errors atau warnings

## 🔐 Security Checklist

- ✅ `.env` file tidak di-version control
- ✅ Password di-hash dengan bcrypt
- ✅ CSRF protection aktif di semua forms
- ✅ Role-based authorization implemented
- ✅ SQL injection prevention dengan Eloquent ORM

## 📞 Quick Reference

| Task | Command |
|------|---------|
| Start Server | `php artisan serve --host=localhost --port=8000` |
| Reset DB | `php artisan migrate:fresh --seed` |
| View Routes | `php artisan route:list` |
| Clear Cache | `php artisan cache:clear` |
| Tinker Shell | `php artisan tinker` |
| Create Migration | `php artisan make:migration` |
| Create Model | `php artisan make:model` |
| Create Controller | `php artisan make:controller` |

## 🎉 Ready to Go!

Aplikasi sudah siap untuk digunakan. Login dengan salah satu demo account dan mulai testing workflow!

```
👉 http://localhost:8000/login
```

---

**Selamat menggunakan Aplikasi Persetujuan PT. XYZ!** 🚀
