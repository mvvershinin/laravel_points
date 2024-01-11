<?php

namespace App\Models\Geocoding;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @class Address
 *
 * @property int $id
 * @property string $address_string
 * @property string $kind
 * @property Carbon|null $created_at,
 * @property Carbon|null $updated_at
 */
class Address extends Model
{
    const TYPE_FAKE = 'fake';

    use HasFactory;
}
