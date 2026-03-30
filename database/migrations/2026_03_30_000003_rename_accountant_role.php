<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Renaming "Kế toán" to "Accountant" to align with code
        DB::table('roles')->where('name', 'Kế toán')->update(['name' => 'Accountant']);
    }

    public function down()
    {
        DB::table('roles')->where('name', 'Accountant')->update(['name' => 'Kế toán']);
    }
};
