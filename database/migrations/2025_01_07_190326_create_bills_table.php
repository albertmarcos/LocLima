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
        Schema::create('bills', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->decimal('before', 10, 2)->nullable();
            $table->decimal('current', 10, 2)->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->decimal('paid_value', 10, 2)->nullable();
            $table->decimal('discount', 10, 2)->nullable();
            $table->decimal('interest', 10, 2)->nullable();
            $table->decimal('fine', 10, 2)->nullable();
            $table->enum('status', [
                                    'pending', 
                                    'processing', 
                                    'paid', 
                                    'overdue', 
                                    'canceled', 
                                    'refound', 
                                    'partially', 
                                    'negotiated', 
                                    'failed'
                                    ])->nullable();;
            $table->foreignId('contract_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('type', ['monthly', 'annual', 'usage']);
            $table->date('due_date')->nullable();
            $table->date('payment_date')->nullable();
            $table->timestamps();

            // Índices
            $table->index('contract_id');
            $table->index('type');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bills');
    }
};
