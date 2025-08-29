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
        Schema::create('signatures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id');
            $table->foreignId('plan_id');
            $table->string('gateway_subscription_id')->nullable(); // id da assinatura no gateway
            $table->decimal('price', 10, 2); // valor contratado
            $table->enum('recurrence', ['daily', 'monthly', 'yearly']);
            $table->integer('recurrence_interval')->nullable()->default(1);
            $table->enum('status', ['pending', 'active', 'canceled', 'expired'])->nullable()->default('pending');
            $table->date('started_at')->nullable();
            $table->date('end_at')->nullable();
            $table->decimal('next_price')->nullable();
            $table->date('price_change_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signatures');
    }
};
