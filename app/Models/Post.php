<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Laravel\Scout\Searchable;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 30 occurrences
 * @property string|null $category_id 30 occurrences
 * @property string|null $content 30 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 30 occurrences
 * @property string|null $excerpt 30 occurrences
 * @property string|null $featured_image 30 occurrences
 * @property bool|null $is_published 30 occurrences
 * @property \Illuminate\Support\Carbon|null $published_at 30 occurrences
 * @property string|null $slug 30 occurrences
 * @property string|null $tag_ids 30 occurrences
 * @property string|null $title 30 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 30 occurrences
 * @property string|null $user_id 30 occurrences
 * @property-read \App\Models\Category|null $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Tag> $tags
 * @property-read int|null $tags_count
 * @property-read \App\Models\User|null $user
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post aggregate($function = null, $columns = [])
 * @method static \Database\Factories\PostFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereCategoryId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereContent($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereExcerpt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereFeaturedImage($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereIsPublished($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post wherePublishedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereSlug($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereTagIds($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereTitle($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Post whereUserId($value)
 * @mixin \Eloquent
 */
class Post extends Model
{
    /** @use HasFactory<\Database\Factories\PostFactory> */
    use HasFactory, Searchable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'is_published',
        'published_at',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
            'published_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class)->withTimestamps();
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array<string, mixed>
     */
    public function toSearchableArray(): array
    {
        return [
            'title' => $this->title,
            'excerpt' => $this->excerpt,
            'content' => $this->content,
        ];
    }
}
