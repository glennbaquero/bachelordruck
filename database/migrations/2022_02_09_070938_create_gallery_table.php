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
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable()->comment('html content');
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->mediumInteger('sort');
            $table->index(['status', 'sort']);
            $table->timestamps();

            //One Main Image for the Overview
            //Multiple Images each with an optional short description
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('galleries');
    }
};
