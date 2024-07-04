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
        Schema::create('statuses', function (Blueprint $table) {
            $table->uuid('status_id')->primary();
            $table->enum('status_part', ['Ready', 'Pending Part CWH', 'SOH', 'Pending Part Kota Terusan'])->nullable();
            $table->enum('email_request', ['Non Area Remote', 'Area Remote'])->nullable();
            $table->enum('status_email_request', ['Passed', 'Need Approval']);
            $table->string('SN_part_good')->nullable();
            $table->string('SN_part_bad')->nullable();
            $table->enum('status_part_used', ['Defective', 'Good', 'DOA', 'Consume'])->nullable();
            $table->string('reason_description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statuses');
    }
};
