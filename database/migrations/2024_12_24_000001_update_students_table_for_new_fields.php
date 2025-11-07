<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('students', function (Blueprint $table) {
            // Add new parent information fields
            $table->string('father_name')->nullable()->after('postal_code');
            $table->string('mother_name')->nullable()->after('father_name');
            
            // Add PWD ID field
            $table->string('pwd_id')->nullable()->after('pwd');
            
            // Drop old columns
            $table->dropColumn(['family_income_bracket', 'parents_education']);
            
            // Change daily_fare from decimal to string
            $table->string('daily_fare')->nullable()->change();
            
            // Change family_income from decimal to string
            $table->string('family_income')->change();
        });
    }

    public function down()
    {
        // Clear data before changing column types to avoid conversion errors
        DB::table('students')->update([
            'daily_fare' => null,
            'family_income' => null
        ]);
        
        Schema::table('students', function (Blueprint $table) {
            // Remove new columns
            $table->dropColumn(['father_name', 'mother_name', 'pwd_id']);
            
            // Add back old columns
            $table->string('family_income_bracket')->nullable()->after('monthly_rental');
            $table->string('parents_education')->nullable()->after('household_size');
            
            // Change back to decimal
            $table->decimal('daily_fare', 10, 2)->nullable()->change();
            $table->decimal('family_income', 12, 2)->nullable()->change();
        });
    }
};

