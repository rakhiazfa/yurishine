<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
        'user_id',
    ];

    public static function generateRegistrasionNumber(): string
    {
        $end = str_pad(self::count() + 1, 5, '0', STR_PAD_LEFT);

        return '7210' . now()->format('dmy') . $end;
    }
}
