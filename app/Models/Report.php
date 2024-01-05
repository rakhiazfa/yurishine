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
        'patient_name',
        'patient_address',
        'patient_phone',
        'doctor_name',
        'polyclinic_name',
        'description',
        'treatments',
        'inspection_date',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'treatments' => 'array',
    ];
}
