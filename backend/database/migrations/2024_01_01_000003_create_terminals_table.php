<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('terminals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('branch_id');
            $table->string('name', 100);
            $table->string('device_id')->unique();
            $table->timestamp('last_seen')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->index(['branch_id', 'is_active']);
            $table->index('device_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('terminals');
    }
};