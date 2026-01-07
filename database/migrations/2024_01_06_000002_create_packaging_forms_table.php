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
        Schema::create('packaging_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('supplier_name');
            $table->string('npwp_number');
            $table->string('po_invoice_number');
            $table->json('packaging_list');
            $table->string('vehicle_registration_number');
            $table->integer('total_packages');
            $table->integer('total_types');
            $table->decimal('gross_weight', 15, 2);
            $table->string('hs_code');
            $table->string('item_name');
            $table->string('item_code');
            $table->integer('quantity');
            $table->string('type');
            $table->string('packaging_type');
            $table->integer('package_quantity');
            $table->decimal('net_weight', 15, 2);
            $table->decimal('item_price', 15, 2);
            $table->dateTime('arrival_datetime');
            $table->dateTime('departure_datetime');
            $table->enum('status', ['draft', 'submitted', 'security_approved', 'export_import_approved', 'warehouse_approved', 'rejected'])->default('draft');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packaging_forms');
    }
};
