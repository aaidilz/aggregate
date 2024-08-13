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
        Schema::create('approvals', function (Blueprint $table) {
            $table->uuid('approval_id')->primary();
            $table->uuid('customer_id');
            $table->uuid('service_id');
            $table->string('entry_ticket');
            $table->string('request_date');
            $table->string('approval_date')->nullable();
            $table->string('create_zulu_date')->nullable();
            $table->string('approval_area_remote_date')->nullable();
            $table->enum('email_request', ['Non Area Remote', 'Area Remote'])->nullable();
            $table->enum('status_email_request', ['Passed', 'Need Approval'])->nullable();
            $table->string('reason_description')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('customer_id')->on('customers');
            $table->foreign('service_id')->references('service_id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
