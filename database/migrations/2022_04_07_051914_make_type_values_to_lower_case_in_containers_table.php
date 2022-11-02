<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('containers')->update([
            'type' => DB::raw('LOWER(`type`)'),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('containers')->update([
            'type' => DB::raw('UPPER(`type`)'),
        ]);
    }
};
