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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('invoice_no');
            $table->string('status');
            $table->string('first_reminder');
            $table->text('first_reminder_desc')->nullable();
            $table->string('second_reminder');
            $table->text('second_reminder_desc')->nullable();
            $table->string('third_reminder');
            $table->text('third_reminder_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
