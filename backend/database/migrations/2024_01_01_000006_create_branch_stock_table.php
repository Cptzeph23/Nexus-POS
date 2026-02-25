<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('branch_stock', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('branch_id');
            $table->uuid('product_id');
            $table->integer('quantity')->default(0);
            $table->integer('reorder_point')->default(10);
            $table->integer('max_stock')->nullable();
            $table->timestamps();
            
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->unique(['branch_id', 'product_id']);
            $table->index(['branch_id', 'quantity']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('branch_stock');
    }
};