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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->foreignId('language_id')->constrained();
            $table->string('title');
            $table->string('slug');
            $table->string('description');
            $table->string('video_url')->nullable(); // eg. Url to YouTube Video for embedding
            $table->date('news_date');
            // Media Upload one main image for overview
            // Multiples Images for detail view image gallery
            // Multiple PDF Files
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();

            $table->index(['status', 'news_date']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
