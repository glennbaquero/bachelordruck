<?php

use Illuminate\Database\Migrations\Migration;
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
        // In local, this will fix the conflict on languages table.
        // In production, it will rename the languages table from the nnjeim/world package.
        if (Schema::hasTable('languages')) {
            Schema::rename('languages', 'world_languages');
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('world_languages')) {
            Schema::rename('world_languages', 'languages');
        }
    }
};
