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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('gateway_plan_id')->nullable(); // id do plano no gateway
            $table->string('name');
            $table->enum('recurrence', ['daily', 'monthly', 'yearly']);
            $table->integer('recurrence_interval')->default(1); // ex: "a cada 2 meses"
            $table->integer('trial_period_days')->nullable()->default(0);
            $table->decimal('current_price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
