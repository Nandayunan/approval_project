<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update packaging_forms table
        Schema::table('packaging_forms', function (Blueprint $table) {
            $table->string('status', 100)->change();
        });

        // Update resin_forms table
        Schema::table('resin_forms', function (Blueprint $table) {
            $table->string('status', 100)->change();
        });

        // Update film_forms table
        Schema::table('film_forms', function (Blueprint $table) {
            $table->string('status', 100)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to enum if needed
        Schema::table('packaging_forms', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'security_approved', 'export_import_approved', 'warehouse_approved', 'rejected'])->default('draft')->change();
        });

        Schema::table('resin_forms', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'security_approved', 'export_import_approved', 'warehouse_approved', 'rejected'])->default('draft')->change();
        });

        Schema::table('film_forms', function (Blueprint $table) {
            $table->enum('status', ['draft', 'submitted', 'security_approved', 'export_import_approved', 'warehouse_approved', 'rejected'])->default('draft')->change();
        });
    }
};
