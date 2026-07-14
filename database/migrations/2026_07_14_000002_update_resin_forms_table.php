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
        Schema::table('resin_forms', function (Blueprint $table) {
            $columns = Schema::getColumnListing('resin_forms');
            
            // Drop old columns if they exist
            if (in_array('transport_type', $columns)) {
                $table->dropColumn('transport_type');
            }
            if (in_array('awb_number', $columns)) {
                $table->dropColumn('awb_number');
            }
            if (in_array('bill_of_lading', $columns)) {
                $table->dropColumn('bill_of_lading');
            }
            if (in_array('manifest_entry', $columns)) {
                $table->dropColumn('manifest_entry');
            }
            if (in_array('noa_number', $columns)) {
                $table->dropColumn('noa_number');
            }
        });

        Schema::table('resin_forms', function (Blueprint $table) {
            $columns = Schema::getColumnListing('resin_forms');
            
            // Add new columns like packaging_forms
            if (!in_array('supplier_name', $columns)) {
                $table->string('supplier_name')->nullable();
            }
            if (!in_array('npwp_number', $columns)) {
                $table->string('npwp_number')->nullable();
            }
            if (!in_array('po_number', $columns)) {
                $table->string('po_number')->nullable();
            }
            if (!in_array('vehicle_registration_number', $columns)) {
                $table->string('vehicle_registration_number')->nullable();
            }
            if (!in_array('packaging_list', $columns)) {
                $table->json('packaging_list')->nullable();
            }
            if (!in_array('total_packages', $columns)) {
                $table->integer('total_packages')->nullable();
            }
            if (!in_array('total_types', $columns)) {
                $table->integer('total_types')->nullable();
            }
            if (!in_array('gross_weight', $columns)) {
                $table->decimal('gross_weight', 15, 2)->nullable();
            }
            if (!in_array('hs_code', $columns)) {
                $table->string('hs_code')->nullable();
            }
            if (!in_array('item_name', $columns)) {
                $table->string('item_name')->nullable();
            }
            if (!in_array('item_code', $columns)) {
                $table->string('item_code')->nullable();
            }
            if (!in_array('quantity', $columns)) {
                $table->integer('quantity')->nullable();
            }
            if (!in_array('type', $columns)) {
                $table->string('type')->nullable();
            }
            if (!in_array('packaging_type', $columns)) {
                $table->string('packaging_type')->nullable();
            }
            if (!in_array('package_quantity', $columns)) {
                $table->integer('package_quantity')->nullable();
            }
            if (!in_array('net_weight', $columns)) {
                $table->decimal('net_weight', 15, 2)->nullable();
            }
            if (!in_array('item_price', $columns)) {
                $table->decimal('item_price', 15, 2)->nullable();
            }
            if (!in_array('arrival_datetime', $columns)) {
                $table->dateTime('arrival_datetime')->nullable();
            }
            if (!in_array('departure_datetime', $columns)) {
                $table->dateTime('departure_datetime')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
