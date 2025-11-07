<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'student_id',
        'course',
        'year_level',
        'address',
        'barangay',
        'city',
        'province',
        'postal_code',
        'birth_date',
        'gender',
        'marital_status',
        'religion',
        'cellphone_number',
        'father_name',
        'mother_name',
        'family_income',
        'study_device',
        'is_solo_parent',
        'solo_parent_id',
        'has_part_time_job',
        'daily_fare',
        'monthly_rental',
        'household_size',
        'transportation_mode',
        'travel_time_minutes',
        'ethnicity',
        'pwd',
        'pwd_id',
        'housing_status'
    ];

    protected $dates = ['birth_date'];

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullAddressAttribute()
    {
        return "{$this->address}, {$this->barangay}, {$this->city}, {$this->province} {$this->postal_code}";
    }
}
