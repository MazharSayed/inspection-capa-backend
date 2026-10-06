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
        Schema::create('capa_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained();
            $table->string('tower');
            $table->foreignId('division_id')->constrained();
            $table->foreignId('activity_id')->constrained();
            $table->foreignId('sub_activity_id')->constrained();
            $table->foreignId('inspection_request_id')->nullable()->constrained();
            $table->string('defect_type');
            $table->unsignedInteger('defect_count');
            $table->string('approver');
            $table->enum('status', ['open', 'closed', 'rejected'])->default('open');
            $table->dateTime('capa_created_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('capa_requests');
    }
};
