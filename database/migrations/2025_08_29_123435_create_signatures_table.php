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
            $table->string('preapproval_plan_id')->nullable();
            $table->string('reason')->nullable()->nullable();
            $table->string('external_reference')->nullable();
            $table->string('payer_email');
            $table->string('card_token_id');
            $table->json('auto_recurring');
            $table->string('back_url');
            $table->string('status');
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
