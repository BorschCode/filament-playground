<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 1 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 1 occurrences
 * @property string|null $description 1 occurrences
 * @property bool|null $is_active 1 occurrences
 * @property string|null $name 1 occurrences
 * @property string|null $owner_id 1 occurrences
 * @property string|null $slug 1 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 1 occurrences
 * @property string|null $user_ids 1 occurrences
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Client> $clients
 * @property-read int|null $clients_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deal> $deals
 * @property-read int|null $deals_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TimeEntry> $timeEntries
 * @property-read int|null $time_entries_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team aggregate($function = null, $columns = [])
 * @method static \Database\Factories\TeamFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team onlyTrashed()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereDescription($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereIsActive($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereOwnerId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereSlug($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Team whereUserIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Team withoutTrashed()
 * @mixin \Eloquent
 */
class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'owner_id',
        'logo',
        'settings',
        'is_active',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Team $team) {
            if (empty($team->slug)) {
                $team->slug = Str::slug($team->name);
            }
        });
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot(['role', 'permissions'])
            ->withTimestamps();
    }

    public function clients(): HasMany
    {
        return $this->hasMany(Client::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
}
