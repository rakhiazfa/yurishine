<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'patient_registrasion_number',
        'patient_name',
        'patient_address',
        'patient_phone',
        'doctor_id',
        'doctor_name',
        'polyclinic_name',
        'description',
        'treatments',
        'skincares',
        'inspection_date',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'treatments' => 'array',
        'skincares' => 'array',
    ];
}
