<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tenants', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('domain')->unique()->nullable();
            $table->string('plan', 50)->default('starter');
            $table->jsonb('settings')->default('{}');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('domain');
            $table->index(['is_active', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};