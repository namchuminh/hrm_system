<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
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
        Schema::create('system_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed initial values
        DB::table('system_settings')->insert([
            ['key' => 'company_name', 'value' => 'CÔNG TY TNHH PHÁT TRIỂN CÔNG NGHỆ HRM PRO', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'director_name', 'value' => 'VŨ ĐỨC LONG', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'company_address', 'value' => 'Khu đô thị mới Cầu Giấy, Quận Cầu Giấy, TP. Hà Nội', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'company_phone', 'value' => '024.399.8888', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'company_email', 'value' => 'contact@hrmpro.com', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'default_working_time', 'value' => '08 giờ/ngày (48 giờ/tuần)', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('system_settings');
    }
};
