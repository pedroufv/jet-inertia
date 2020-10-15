<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
 *
 * @method static \Illuminate\Database\Eloquent\Model|$this create(array $attributes = [])
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage = null, $columns = ['*'], $pageName = 'page', $page = null)
 * @method static \Illuminate\Database\Query\Builder whereNull($columns, $boolean = 'and', $not = false)
 * @see \Illuminate\Database\Eloquent\Builder
 * @see \Illuminate\Database\Query\Builder
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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'short_address',
        'full_address',
    ];

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner(): BelongsTo
    {
        return $this->belongsTo(Owner::class);
    }

    /**
     * @return string
     */
    public function getShortAddressAttribute(): string
    {
        $address = $this->street . ', ';
        $address .= $this->number ? $this->number . ', ' : '';
        $address .= $this->city . ', ';
        $address .= $this->state;

        return $address;
    }

    /**
     * @return string
     */
    public function getFullAddressAttribute(): string
    {
        $address = $this->street . ', ';
        $address .= $this->number ? $this->number . ', ' : '';
        $address .= $this->details ? $this->details . ', ' : '';
        $address .= $this->neighborhood . ', ';
        $address .= $this->city . ', ';
        $address .= $this->state;

        return $address;
    }
}
