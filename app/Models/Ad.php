<?php

namespace App\Models;

use Database\Factories\AdFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\Ad
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property int $user_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @method static AdFactory factory(...$parameters)
 * @method static Builder|Ad newModelQuery()
 * @method static Builder|Ad newQuery()
 * @method static Builder|Ad query()
 * @method static Builder|Ad whereCreatedAt($value)
 * @method static Builder|Ad whereDescription($value)
 * @method static Builder|Ad whereId($value)
 * @method static Builder|Ad whereTitle($value)
 * @method static Builder|Ad whereUpdatedAt($value)
 * @method static Builder|Ad whereUserId($value)
 * @mixin Eloquent
 */
class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }
}
