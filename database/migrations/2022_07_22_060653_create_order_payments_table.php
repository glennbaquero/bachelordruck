<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->char('reference', 17)->unique();
            $table->enum('intent', ['CAPTURE', 'AUTHORIZED'])->index();
            $table->enum('status', ['CREATED', 'SAVED', 'APPROVED', 'VOIDED', 'COMPLETED', 'PAYMENT_ACTION_REQUIRED'])->index();
            $table->json('response')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_payments');
    }
};
