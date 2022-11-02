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
        Schema::create('additional_services', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('tooltip');
            $table->integer('surcharge');
            $table->unsignedSmallInteger('sort')->default(0)->comment('field for order by');
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft'); // create a Enum Class for that field

            $table->index(['status', 'sort']);
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
        Schema::dropIfExists('additional_services');
    }
};
