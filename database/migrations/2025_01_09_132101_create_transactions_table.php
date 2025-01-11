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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference');
            $table->string('amount');
            $table->string('status');
            $table->string('type');
            $table->string("category");
            $table->string("provider")->nullable();
            $table->string('currency');
            $table->string('description')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string("name")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
