<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->string('barcode', 50)->nullable();
            $table->string('sku', 50)->nullable();
            $table->string('name', 500);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 4);
            $table->decimal('cost', 10, 4)->nullable();
            $table->decimal('tax_rate', 5, 4)->default(0.08);
            $table->string('category', 100)->nullable();
            $table->string('unit', 50)->default('each');
            $table->string('image_url')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->unique(['tenant_id', 'barcode']);
            $table->index(['tenant_id', 'category']);
            $table->index(['tenant_id', 'is_active']);
            $table->index('sku');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};