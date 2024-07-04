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
            $table->uuid('ticket_id');
            $table->uuid('part_id');
            $table->uuid('status_id');

            $table->string('entry_ticket');
            $table->string('request_date');
            $table->string('approval_date')->nullable();
            $table->string('create_zulu_date')->nullable();
            $table->string('approval_area_remote_date')->nullable();
            $table->timestamps();

            $table->foreign('ticket_id')->references('ticket_id')->on('tickets')->onDelete('cascade');
            $table->foreign('part_id')->references('part_id')->on('parts')->onDelete('cascade');
            $table->foreign('status_id')->references('status_id')->on('statuses')->onDelete('cascade');
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
