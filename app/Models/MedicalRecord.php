<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class MedicalRecord extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'polyclinic_id',
        'description',
        'inspection_date',
        'use_membership',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class, 'doctor_id');
    }

    public function polyclinic(): BelongsTo
    {
        return $this->belongsTo(Polyclinic::class, 'polyclinic_id');
    }

    public function treatments(): BelongsToMany
    {
        return $this->belongsToMany(Treatment::class, 'medical_record_has_treatments', 'medical_record_id', 'treatment_id');
    }

    public function skincares(): BelongsToMany
    {
        return $this->belongsToMany(Skincare::class, 'medical_record_has_skincares', 'medical_record_id', 'skincare_id');
    }
}
