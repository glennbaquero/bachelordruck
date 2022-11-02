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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 40)->unique();
            $table->enum('customer_type', ['private', 'company']);
            $table->string('title', 50)->nullable();
            $table->string('firstname', 50);
            $table->string('lastname', 50);

            $table->string('email');
            $table->string('phone')->nullable();

            $table->string('street');
            $table->string('postal_code', 13);
            $table->string('city');

            $table->boolean('is_recipient_different')->default(0);

            $table->string('recipient_title', 50)->nullable();
            $table->string('recipient_firstname', 50)->nullable();
            $table->string('recipient_lastname', 50)->nullable();

            $table->string('recipient_street')->nullable();
            $table->string('recipient_postal_code', 13)->nullable();
            $table->string('recipient_city')->nullable();

            $table->unsignedInteger('total_amount');
            $table->enum('payment', ['paypal', 'cash', 'card', 'bank', 'payment_in_advance']);
            $table->enum('status', ['waiting for payment', 'ready for production', 'in production', 'finished']);

            $table->datetime('completed_at')->nullable()->comment('The time the customer click the complete transfer button.');

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
        Schema::dropIfExists('orders');
    }
};
