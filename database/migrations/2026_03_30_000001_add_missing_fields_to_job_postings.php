<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            if (!Schema::hasColumn('job_postings', 'department_id')) {
                $table->unsignedBigInteger('department_id')->nullable()->after('description');
            }
            if (!Schema::hasColumn('job_postings', 'experience_required')) {
                $table->string('experience_required')->nullable()->after('deadline');
            }
            if (!Schema::hasColumn('job_postings', 'salary_range')) {
                $table->string('salary_range')->nullable()->after('experience_required');
            }
        });
    }

    public function down()
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropColumn(['department_id', 'experience_required', 'salary_range']);
        });
    }
};
