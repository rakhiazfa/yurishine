<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Patient extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $fillable = [
        'registrasion_number',
        'name',
        'age',
        'gender',
        'skin_type',
        'address',
        'phone',
        'is_smoked',
        'using_kb',
        'using_skincare',
        'already_use_mixed_cream',
    ];

    public function membership(): HasOne
    {
        return $this->hasOne(Membership::class, 'patient_id');
    }

    public static function generateRegistrasionNumber(): string
    {
        $end = str_pad(self::count() + 1, 4, '0', STR_PAD_LEFT);

        return '7210' . now()->format('dmyu') . $end;
    }

    public function medicalRecords(): HasMany
    {
        return $this->hasMany(MedicalRecord::class, 'patient_id');
    }
}
