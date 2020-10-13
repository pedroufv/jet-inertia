<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property string $id
 * @property integer|null $owner_id
 * @property Owner|null $owner
 * @property string $state
 * @property string $city
 * @property string $neighborhood
 * @property string $street
 * @property integer|null $number
 * @property string|null $details
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Estate extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array|bool
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime',
        'update_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * Handle the model "booted" event.
     *
     * @return void
     */
    public static function booted()
    {
        static::creating(function ($model) {
            $model->id = $model->id ?: (string) Str::orderedUuid();
        });
    }
}
