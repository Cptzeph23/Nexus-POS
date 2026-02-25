<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('tenant_id');
            $table->uuid('branch_id');
            $table->uuid('terminal_id')->nullable();
            $table->uuid('cashier_id');
            $table->uuid('customer_id')->nullable();
            $table->string('type', 20)->default('sale');
            $table->uuid('original_id')->nullable();
            $table->string('receipt_number', 50);
            $table->decimal('subtotal', 12, 4);
            $table->decimal('discount', 12, 4)->default(0);
            $table->decimal('tax', 12, 4)->default(0);
            $table->decimal('total', 12, 4);
            $table->string('payment_method', 50);
            $table->jsonb('payment_data')->nullable();
            $table->text('note')->nullable();
            $table->string('status', 20)->default('completed');
            $table->integer('version')->default(1);
            $table->timestamp('completed_at');
            $table->timestamps();
            
            $table->foreign('tenant_id')->references('id')->on('tenants')->onDelete('cascade');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('terminal_id')->references('id')->on('terminals')->onDelete('set null');
            $table->foreign('cashier_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('set null');
            $table->foreign('original_id')->references('id')->on('transactions')->onDelete('set null');
            
            $table->unique(['branch_id', 'receipt_number']);
            $table->index(['branch_id', 'completed_at']);
            $table->index(['terminal_id', 'completed_at']);
            $table->index(['cashier_id', 'completed_at']);
            $table->index(['customer_id']);
            $table->index(['type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};