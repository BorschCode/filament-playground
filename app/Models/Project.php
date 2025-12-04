<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 15 occurrences
 * @property numeric|null $actual_cost 15 occurrences
 * @property numeric|null $budget 15 occurrences
 * @property string|null $client_id 15 occurrences
 * @property string|null $code 15 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 15 occurrences
 * @property string|null $description 15 occurrences
 * @property \Illuminate\Support\Carbon|null $due_date 15 occurrences
 * @property string|null $name 15 occurrences
 * @property string|null $priority 15 occurrences
 * @property int|null $progress 15 occurrences
 * @property \Illuminate\Support\Carbon|null $start_date 15 occurrences
 * @property string|null $status 15 occurrences
 * @property string|null $team_id 15 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 15 occurrences
 * @property-read \App\Models\Client|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User|null $manager
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $tasks
 * @property-read int|null $tasks_count
 * @property-read \App\Models\Team|null $team
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TimeEntry> $timeEntries
 * @property-read int|null $time_entries_count
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project aggregate($function = null, $columns = [])
 * @method static \Database\Factories\ProjectFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project onlyTrashed()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereActualCost($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereBudget($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereClientId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereCode($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereDescription($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereDueDate($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project wherePriority($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereProgress($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereStartDate($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereStatus($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereTeamId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Project whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Project withoutTrashed()
 * @mixin \Eloquent
 */
class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'client_id',
        'name',
        'code',
        'description',
        'status',
        'priority',
        'start_date',
        'due_date',
        'completed_at',
        'budget',
        'actual_cost',
        'progress',
        'manager_id',
        'tags',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_at' => 'date',
        'budget' => 'decimal:2',
        'actual_cost' => 'decimal:2',
        'progress' => 'integer',
        'tags' => 'array',
    ];

    protected static function boot(): void
    {
        parent::boot();

        static::creating(function (Project $project) {
            if (empty($project->code)) {
                $project->code = strtoupper(Str::random(6));
            }
        });
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function manager(): BelongsTo
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
