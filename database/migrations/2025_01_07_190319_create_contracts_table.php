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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->string('contract_number');
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('year')->nullable();
            $table->decimal('value', 10, 2)->nullable();
            $table->boolean('recursive');
            $table->enum('type', ['monthly', 'annual', 'usage']);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
