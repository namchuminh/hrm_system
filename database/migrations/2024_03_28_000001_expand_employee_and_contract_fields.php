<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->string('identity_number')->nullable()->after('employee_code');
            $table->date('identity_date')->nullable()->after('identity_number');
            $table->string('identity_place')->nullable()->after('identity_date');
            $table->string('nationality')->default('Việt Nam')->after('identity_place');
            $table->string('education')->nullable()->after('nationality');
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->decimal('salary_amount', 15, 2)->nullable()->after('type');
            $table->decimal('probation_salary', 15, 2)->nullable()->after('salary_amount');
            $table->string('working_time')->default('08:00 - 17:00')->after('probation_salary');
            $table->text('allowances_text')->nullable()->after('working_time');
        });
    }

    public function down()
    {
        Schema::table('employees', function (Blueprint $table) {
            $table->dropColumn(['identity_number', 'identity_date', 'identity_place', 'nationality', 'education']);
        });

        Schema::table('contracts', function (Blueprint $table) {
            $table->dropColumn(['salary_amount', 'probation_salary', 'working_time', 'allowances_text']);
        });
    }
};
