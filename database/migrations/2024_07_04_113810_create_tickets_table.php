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
        Schema::create('tickets', function (Blueprint $table) {
            $table->uuid('ticket_id')->primary();
            $table->uuid('customer_id');
            $table->string('bank_name');
            $table->string('serial_number')->unique();
            $table->string('machine_id');
            $table->string('machine_type');
            $table->string('service_center');
            $table->string('location_name');
            $table->string('partner_code');
            $table->string('spv_name');
            $table->string('fse_name');
            $table->string('fsl_name');
            $table->timestamps();

            $table->foreign(('customer_id'))->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
