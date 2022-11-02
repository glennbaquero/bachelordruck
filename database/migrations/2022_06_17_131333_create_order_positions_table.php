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
        Schema::create('order_positions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreignId('product_id')->constrained();
            $table->unsignedInteger('qty')->default(1);
            $table->json('configuration')->nullable(); // same as bask
            $table->json('product_data')
                  ->nullable()
                  ->comment('all the product data for displaying the position with all details except images. Because products may change or be deleted after the product has been ordered');
            $table->unsignedInteger('price');
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
        Schema::dropIfExists('order_positions');
    }
};
