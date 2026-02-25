<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('branch_id');
            $table->uuid('product_id');
            $table->string('type', 30);
            $table->integer('delta');
            $table->integer('quantity_after');
            $table->uuid('reference_id')->nullable();
            $table->text('note')->nullable();
            $table->uuid('created_by')->nullable();
            $table->timestamp('created_at');
            
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            
            $table->index(['branch_id', 'product_id', 'created_at']);
            $table->index(['type', 'created_at']);
            $table->index(['reference_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stock_movements');
    }
};