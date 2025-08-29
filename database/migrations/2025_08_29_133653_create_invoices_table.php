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
            $table->foreignId('signature_id')->constrained()->cascadeOnDelete();
            $table->string('gateway_invoice_id')->nullable(); // id da fatura no gateway
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'paid', 'failed', 'refunded']);
            $table->date('due_date');
            $table->date('paid_at')->nullable();
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
