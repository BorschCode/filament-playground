<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 5 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 5 occurrences
 * @property string|null $description 5 occurrences
 * @property string|null $name 5 occurrences
 * @property string|null $slug 5 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 5 occurrences
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category aggregate($function = null, $columns = [])
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category whereDescription($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category whereSlug($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Category whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Category extends Model
{
    /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
