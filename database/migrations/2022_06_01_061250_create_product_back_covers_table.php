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
        Schema::create('product_back_covers', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('color', 7);
            $table->boolean('is_preselected')->default(false);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();

            $table->index(['status', 'sort']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_back_cover');
    }
};
