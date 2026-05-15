<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->nullable()->after('teacher_id');
        });

        // Populate class_id based on existing classroom name
        DB::statement('
            UPDATE attendances a
            JOIN school_classes sc ON sc.name = a.classroom
            SET a.class_id = sc.id
            WHERE a.classroom IS NOT NULL
        ');
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropColumn('class_id');
        });
    }
};
