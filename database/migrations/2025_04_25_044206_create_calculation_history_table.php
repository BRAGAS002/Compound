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
        Schema::create('calculation_history', function (Blueprint $table) {
            $table->id();
            $table->decimal('principal', 15, 2);
            $table->decimal('rate', 5, 2);
            $table->decimal('time', 5, 2);
            $table->string('compounding_frequency');
            $table->decimal('final_amount', 15, 2);
            $table->decimal('total_interest', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculation_history');
    }
};
