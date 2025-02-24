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
        Schema::create('output_product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_action_id')->constrained('repository_actions');
            $table->integer('count');
            $table->decimal('income_price');
            $table->decimal('selling_price');
            $table->decimal('difference');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('output_product_details');
    }
};
