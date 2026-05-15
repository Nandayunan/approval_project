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
        Schema::table('packaging_forms', function (Blueprint $table) {
            // Add separate PO and Invoice fields; keep existing combined field for compatibility
            $table->string('po_number')->nullable()->after('npwp_number');
            $table->string('invoice_number')->nullable()->after('po_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('packaging_forms', function (Blueprint $table) {
            $table->dropColumn(['po_number', 'invoice_number']);
        });
    }
};
