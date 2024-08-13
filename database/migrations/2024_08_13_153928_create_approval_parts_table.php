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
        Schema::create('approval_parts', function (Blueprint $table) {
            $table->uuid('approval_id');
            $table->uuid('part_id');
            $table->uuid('status_part_id');

            $table->foreign('approval_id')->references('approval_id')->on('approvals')->onDelete('cascade');
            $table->foreign('part_id')->references('part_id')->on('parts')->onDelete('cascade');
            $table->foreign('status_part_id')->references('status_part_id')->on('status_parts')->onDelete('cascade');

            $table->primary(['approval_id', 'part_id', 'status_part_id']);
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_parts');
    }
};
