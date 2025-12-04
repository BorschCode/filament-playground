<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 15 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 15 occurrences
 * @property string|null $name 15 occurrences
 * @property string|null $post_ids 15 occurrences
 * @property string|null $slug 15 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 15 occurrences
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag aggregate($function = null, $columns = [])
 * @method static \Database\Factories\TagFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag wherePostIds($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag whereSlug($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Tag whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Tag extends Model
{
    /** @use HasFactory<\Database\Factories\TagFactory> */
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class)->withTimestamps();
    }
}
