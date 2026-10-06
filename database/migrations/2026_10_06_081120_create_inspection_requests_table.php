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
        Schema::create('inspection_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->foreignId('division_id')->constrained();
            $table->foreignId('sub_division_id')->constrained();
            $table->foreignId('activity_id')->constrained();
            $table->foreignId('sub_activity_id')->nullable()->constrained();
            $table->string('tower')->nullable();
            $table->string('floor');
            $table->string('unit');
            $table->string('technician');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->dateTime('requested_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_requests');
    }
};
