-- PT. XYZ Approval System Database
-- Created: January 6, 2026
-- Database Structure and Sample Data

-- ===================================================
-- CREATE DATABASE
-- ===================================================
CREATE DATABASE IF NOT EXISTS pt_xyz_approval DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE pt_xyz_approval;

-- ===================================================
-- 1. USERS TABLE
-- ===================================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('supplier', 'security', 'export_import', 'warehouse', 'admin') NOT NULL DEFAULT 'supplier',
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_email (email),
    INDEX idx_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 2. PASSWORD_RESET_TOKENS TABLE
-- ===================================================
CREATE TABLE password_reset_tokens (
    email VARCHAR(255) PRIMARY KEY,
    token VARCHAR(255) NOT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 3. SESSIONS TABLE
-- ===================================================
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent LONGTEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT NOT NULL,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_last_activity (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 4. PACKAGING_FORMS TABLE
-- ===================================================
CREATE TABLE packaging_forms (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    supplier_name VARCHAR(255) NOT NULL,
    npwp_number VARCHAR(255) NOT NULL,
    po_invoice_number VARCHAR(255) NOT NULL,
    packaging_list JSON NOT NULL,
    vehicle_registration_number VARCHAR(255) NOT NULL,
    total_packages INT NOT NULL,
    total_types INT NOT NULL,
    gross_weight DECIMAL(15, 2) NOT NULL,
    hs_code VARCHAR(255) NOT NULL,
    item_name VARCHAR(255) NOT NULL,
    item_code VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    type VARCHAR(255) NOT NULL,
    packaging_type VARCHAR(255) NOT NULL,
    package_quantity INT NOT NULL,
    net_weight DECIMAL(15, 2) NOT NULL,
    item_price DECIMAL(15, 2) NOT NULL,
    arrival_datetime DATETIME NOT NULL,
    departure_datetime DATETIME NOT NULL,
    status ENUM('draft', 'submitted', 'security_approved', 'export_import_approved', 'warehouse_approved', 'rejected') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 5. RESIN_FORMS TABLE
-- ===================================================
CREATE TABLE resin_forms (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    transport_type ENUM('udara', 'laut') NOT NULL,
    awb_number VARCHAR(255) NULL,
    bill_of_lading VARCHAR(255) NULL,
    invoice_number VARCHAR(255) NOT NULL,
    packaging_list JSON NOT NULL,
    manifest_entry JSON NOT NULL,
    noa_number VARCHAR(255) NOT NULL,
    status ENUM('draft', 'submitted', 'security_approved', 'export_import_approved', 'warehouse_approved', 'rejected') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 6. FILM_FORMS TABLE
-- ===================================================
CREATE TABLE film_forms (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    awb_number VARCHAR(255) NOT NULL,
    invoice_number VARCHAR(255) NOT NULL,
    packaging_list JSON NOT NULL,
    manifest_entry JSON NOT NULL,
    noa_number VARCHAR(255) NOT NULL,
    status ENUM('draft', 'submitted', 'security_approved', 'export_import_approved', 'warehouse_approved', 'rejected') NOT NULL DEFAULT 'draft',
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 7. APPROVALS TABLE
-- ===================================================
CREATE TABLE approvals (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    approver_id BIGINT UNSIGNED NULL,
    model_type VARCHAR(255) NOT NULL,
    model_id BIGINT UNSIGNED NOT NULL,
    approval_level ENUM('security', 'export_import', 'warehouse') NOT NULL,
    status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
    notes LONGTEXT NULL,
    approved_at TIMESTAMP NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (approver_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX idx_user_id (user_id),
    INDEX idx_approver_id (approver_id),
    INDEX idx_status (status),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 8. CACHE TABLE
-- ===================================================
CREATE TABLE cache (
    key VARCHAR(255) PRIMARY KEY,
    value LONGTEXT NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 9. CACHE_LOCKS TABLE
-- ===================================================
CREATE TABLE cache_locks (
    key VARCHAR(255) PRIMARY KEY,
    owner VARCHAR(255) NOT NULL,
    expiration INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 10. JOBS TABLE
-- ===================================================
CREATE TABLE jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    queue VARCHAR(255) NOT NULL,
    payload LONGTEXT NOT NULL,
    attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    reserved_at INT UNSIGNED NULL,
    available_at INT UNSIGNED NOT NULL,
    created_at INT UNSIGNED NOT NULL,
    INDEX idx_queue (queue),
    INDEX idx_reserved_at (reserved_at),
    INDEX idx_available_at (available_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 11. JOB_BATCHES TABLE
-- ===================================================
CREATE TABLE job_batches (
    id VARCHAR(255) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    total_jobs INT NOT NULL,
    pending_jobs INT NOT NULL,
    failed_jobs INT NOT NULL,
    failed_job_ids LONGTEXT NOT NULL,
    options MEDIUMTEXT NULL,
    cancelled_at INT NULL,
    created_at INT NOT NULL,
    finished_at INT NULL,
    INDEX idx_name (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- 12. FAILED_JOBS TABLE
-- ===================================================
CREATE TABLE failed_jobs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    uuid VARCHAR(255) UNIQUE NOT NULL,
    connection TEXT NOT NULL,
    queue TEXT NOT NULL,
    payload LONGTEXT NOT NULL,
    exception LONGTEXT NOT NULL,
    failed_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_uuid (uuid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ===================================================
-- SAMPLE DATA - USERS (Demo Accounts)
-- ===================================================
INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES
('Supplier Demo', 'supplier@demo.com', '$2y$12$abcdefghijklmnopqrstuvwxyz123456', 'supplier', NOW(), NOW()),
('Security Demo', 'security@demo.com', '$2y$12$abcdefghijklmnopqrstuvwxyz123456', 'security', NOW(), NOW()),
('Export Import Demo', 'exportimport@demo.com', '$2y$12$abcdefghijklmnopqrstuvwxyz123456', 'export_import', NOW(), NOW()),
('Warehouse Demo', 'warehouse@demo.com', '$2y$12$abcdefghijklmnopqrstuvwxyz123456', 'warehouse', NOW(), NOW()),
('Admin Demo', 'admin@demo.com', '$2y$12$abcdefghijklmnopqrstuvwxyz123456', 'admin', NOW(), NOW());

-- ===================================================
-- SAMPLE DATA - PACKAGING_FORMS
-- ===================================================
INSERT INTO packaging_forms 
(user_id, supplier_name, npwp_number, po_invoice_number, packaging_list, vehicle_registration_number, 
 total_packages, total_types, gross_weight, hs_code, item_name, item_code, quantity, type, packaging_type, 
 package_quantity, net_weight, item_price, arrival_datetime, departure_datetime, status, created_at, updated_at) 
VALUES
(1, 'PT. ABC Supplier', '12.345.678.9-101.000', 'PO/2025/001', '[]', 'B1234ABC', 
 50, 3, 1250.00, '8903.30.00', 'Plastic Resin', 'CODE001', 5000, 'kg', 'Box', 50, 
 1200.00, 50000.00, '2025-01-06 10:00:00', '2025-01-07 15:00:00', 'submitted', NOW(), NOW()),

(1, 'PT. ABC Supplier', '12.345.678.9-101.000', 'PO/2025/002', '[]', 'B5678DEF',
 75, 5, 1875.00, '8903.30.00', 'Chemical Resin', 'CODE002', 7500, 'kg', 'Pallet', 75,
 1800.00, 75000.00, '2025-01-08 08:00:00', '2025-01-09 16:00:00', 'security_approved', NOW(), NOW()),

(1, 'PT. ABC Supplier', '12.345.678.9-101.000', 'PO/2025/003', '[]', 'B9012GHI',
 100, 2, 2500.00, '8903.30.00', 'Industrial Resin', 'CODE003', 10000, 'kg', 'Box', 100,
 2400.00, 100000.00, '2025-01-10 09:00:00', '2025-01-11 17:00:00', 'draft', NOW(), NOW());

-- ===================================================
-- SAMPLE DATA - RESIN_FORMS
-- ===================================================
INSERT INTO resin_forms 
(user_id, transport_type, awb_number, bill_of_lading, invoice_number, packaging_list, manifest_entry, noa_number, status, created_at, updated_at)
VALUES
(1, 'udara', 'AWB123456789', NULL, 'INV/2025/001', '[]', '[]', 'NOA/2025/001', 'submitted', NOW(), NOW()),
(1, 'laut', NULL, 'BL/2025/001', 'INV/2025/002', '[]', '[]', 'NOA/2025/002', 'security_approved', NOW(), NOW());

-- ===================================================
-- SAMPLE DATA - FILM_FORMS
-- ===================================================
INSERT INTO film_forms 
(user_id, awb_number, invoice_number, packaging_list, manifest_entry, noa_number, status, created_at, updated_at)
VALUES
(1, 'AWB987654321', 'INV/2025/003', '[]', '[]', 'NOA/2025/003', 'submitted', NOW(), NOW()),
(1, 'AWB111222333', 'INV/2025/004', '[]', '[]', 'NOA/2025/004', 'draft', NOW(), NOW());

-- ===================================================
-- SAMPLE DATA - APPROVALS
-- ===================================================
INSERT INTO approvals 
(user_id, approver_id, model_type, model_id, approval_level, status, notes, approved_at, created_at, updated_at)
VALUES
(1, 2, 'PackagingForm', 2, 'security', 'approved', 'Lolos inspeksi keamanan', NOW(), NOW(), NOW()),
(1, NULL, 'ResinForm', 1, 'security', 'pending', NULL, NULL, NOW(), NOW()),
(1, NULL, 'FilmForm', 1, 'export_import', 'pending', NULL, NULL, NOW(), NOW());

-- ===================================================
-- Create Indexes for Performance
-- ===================================================
CREATE INDEX idx_packaging_forms_npwp ON packaging_forms(npwp_number);
CREATE INDEX idx_packaging_forms_po_number ON packaging_forms(po_invoice_number);
CREATE INDEX idx_resin_forms_noa ON resin_forms(noa_number);
CREATE INDEX idx_film_forms_noa ON film_forms(noa_number);
CREATE INDEX idx_approvals_model ON approvals(model_type, model_id);

-- ===================================================
-- Database Setup Complete
-- ===================================================
-- Login credentials for demo accounts (password: password):
-- - Supplier: supplier@demo.com
-- - Security: security@demo.com
-- - Export Import: exportimport@demo.com
-- - Warehouse: warehouse@demo.com
-- - Admin: admin@demo.com
