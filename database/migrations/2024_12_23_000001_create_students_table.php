<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            
            // Basic Information
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('student_id')->unique();
            $table->string('course');
            $table->string('year_level');
            $table->string('gender');
            $table->date('birth_date');
            $table->string('marital_status');
            $table->string('religion');
            $table->string('cellphone_number')->nullable();

            // Address Information
            $table->string('address');
            $table->string('barangay');
            $table->string('city');
            $table->string('province');
            $table->string('postal_code');

            // Academic and Device Information
            $table->string('study_device')->nullable();
            
            // Family Information
            $table->boolean('is_solo_parent')->default(false);
            $table->string('solo_parent_id')->nullable();
            $table->boolean('has_part_time_job')->default(false);
            $table->decimal('daily_fare', 10, 2)->nullable();
            $table->decimal('monthly_rental', 10, 2)->nullable();
            $table->string('family_income_bracket');
            $table->integer('household_size');
            $table->string('parents_education');
            
            // Transportation Information
            $table->string('transportation_mode');
            $table->integer('travel_time_minutes');
            
            // Additional Information
            $table->string('ethnicity');
            $table->boolean('pwd')->default(false);
            $table->string('housing_status');
            $table->decimal('family_income', 12, 2);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};
