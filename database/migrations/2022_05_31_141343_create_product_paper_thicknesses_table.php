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
        Schema::create('product_paper_thicknesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->string('title');
            $table->string('tooltip');
            $table->integer('max_pages')->nullable();
            $table->integer('price_per_page_bw')->comment('price in [Cents]');
            $table->integer('price_per_page_color')->comment('price in [Cents]');
            $table->boolean('is_preselected')->default(false);
            $table->unsignedSmallInteger('sort')->default(0);
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();

            $table->index(['product_id', 'status', 'sort']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_paper_thicknesses');
    }
};
