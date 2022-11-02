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
        Schema::table('containers', function (Blueprint $table) {
            $table->foreignId('source_container_id')->index()->nullable()->after('pages_language_id');
            $table->char('status', 15)->index()->default('ready')->after('source_container_id')->comment('ready, copying, translating');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('containers', function (Blueprint $table) {
            $table->dropColumn([
                'source_container_id',
                'status',
            ]);
        });
    }
};
