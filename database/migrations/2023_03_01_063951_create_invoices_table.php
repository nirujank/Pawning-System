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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('nic')->unique();
            $table->string('passport')->unique();
            $table->string('customer_name');
            $table->string('address');
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('article_name');
            $table->double('carratage_value');
            $table->double('value_per_gram');
            $table->double('gross_weight');
            $table->double('net_weight');
            $table->double('value');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
