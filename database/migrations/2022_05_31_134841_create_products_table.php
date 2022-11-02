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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('tooltip')->comment('short description for list tooltip');
            $table->text('description')->comment('long richtext description for detail page');
            $table->integer('price')->comment('cheapest possible price [Cents]');
            $table->boolean('has_cover_color')->default(false);
            $table->boolean('has_cover_imprint_color')->default(false);
            $table->boolean('has_cover_foil')->default(false);
            $table->boolean('has_back_cover')->default(false);
            $table->boolean('has_book_spine_label')->default(false);
            $table->integer('book_spine_label_surcharge')->comment('Surcharge in [Cents]')->default(0);
            $table->boolean('has_book_corners')->default(false);
            $table->integer('book_corners_surcharge')->comment('Surcharge in [Cents]')->default(0);
            $table->boolean('has_ribbon')->default(false);
            $table->integer('ribbon_surcharge')->comment('Surcharge in [Cents]')->default(0);
            $table->unsignedSmallInteger('sort')->default(0)->comment('field for order by');
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft'); // create a Enum Class for that field
            $table->timestamps();

            $table->index(['status', 'sort']);
            // Media for the Main image for the list and detail
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
