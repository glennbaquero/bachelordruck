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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained();
            $table->foreignId('language_id')->nullable()->constrained();
            $table->boolean('transmission')->default(true);

            $table->string('title')->nullable();
            $table->string('description')->nullable();

            $table->string('url')->nullable();
            $table->string('link_text')->nullable();

            $table->mediumInteger('sort');
            $table->enum('status', ['draft', 'active', 'inactive'])->default('draft');
            $table->timestamps();

            $table->index(['status', 'sort']);
            //Media Upload for one banner-image per banner-Entry
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banners');
    }
};
