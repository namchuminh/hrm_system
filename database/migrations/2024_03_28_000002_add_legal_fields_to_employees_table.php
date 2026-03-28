<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('pob')->nullable()->after('dob'); // Nơi sinh / Quê quán
            $table->string('marital_status')->nullable()->after('gender');
            $table->string('social_insurance_number')->nullable()->after('identity_place');
            $table->string('tax_code')->nullable()->after('social_insurance_number');
            $table->string('bank_account')->nullable()->after('tax_code');
            $table->string('bank_name')->nullable()->after('bank_account');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['pob', 'marital_status', 'social_insurance_number', 'tax_code', 'bank_account', 'bank_name']);
        });
    }
};
