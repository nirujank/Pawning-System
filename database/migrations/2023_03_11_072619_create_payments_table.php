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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('bill_no');
            $table->string('add_date');
            $table->string('maturity_date')->nullable();
            $table->decimal('issued_amount');
            $table->decimal('interest_rate')->nullable();
            $table->decimal('total_interest')->nullable();
            $table->decimal('daily_interest')->nullable();
            $table->decimal('paid_amount');
            $table->decimal('paid_interest');
            $table->decimal('payable_amount')->nullable();
            $table->decimal('payable_interest')->nullable();
            $table->decimal('total_payable')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
