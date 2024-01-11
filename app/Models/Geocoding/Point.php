<?php

namespace App\Models\Geocoding;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @class Point
 *
 * @property int $id
 * @property float $lat
 * @property float $lon
 * @property int|null $address_id
 * @property int $user_id
 * @property Carbon|null $created_at,
 * @property Carbon|null $updated_at
 *
 * @property Address $address
 * @property User $user
 * @method static hydrate(array $select)
 */
class Point extends Model
{
    use HasFactory;

    public function address(): BelongsTo
    {
        return $this->belongsTo(Address::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
