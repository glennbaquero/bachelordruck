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
        Schema::create('containers', function (Blueprint $table) {
            $table->id();
            $table->integer('sort');
            $table->string('title')->nullable()->default(null);
            $table->string('image_alignment')->nullable()->default('right');
            $table->longText('content')->nullable()->default(null);
            $table->string('type');
            $table->text('options')->nullable()->defautl(null);
            $table->foreignId('pages_language_id')->constrained('page_languages');
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
        Schema::dropIfExists('containers');
    }
};
