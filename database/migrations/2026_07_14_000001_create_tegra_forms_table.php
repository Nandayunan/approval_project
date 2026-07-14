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
        Schema::create('tegra_forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('po_number');
            $table->string('invoice_number');
            $table->string('item_name');
            $table->string('item_code');
            $table->integer('quantity');
            $table->string('type');
            $table->string('packaging_type');
            $table->integer('package_quantity');
            $table->decimal('net_weight', 15, 2);
            $table->decimal('item_price', 15, 2);
            $table->text('notes')->nullable();
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
        Schema::dropIfExists('tegra_forms');
    }
};
