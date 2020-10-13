<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $type
 * @property string $identifier
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Owner extends Model
{
    use HasFactory;

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
    ];
}
