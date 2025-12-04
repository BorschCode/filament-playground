<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property-read mixed $id
 * @property-read \App\Models\Project|null $project
 * @property-read \App\Models\Task|null $task
 * @property-read \App\Models\Team|null $team
 * @property-read \App\Models\User|null $user
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry aggregate($function = null, $columns = [])
 * @method static \Database\Factories\TimeEntryFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeEntry onlyTrashed()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|TimeEntry vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeEntry withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|TimeEntry withoutTrashed()
 * @mixin \Eloquent
 */
class TimeEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'user_id',
        'project_id',
        'task_id',
        'description',
        'start_time',
        'end_time',
        'duration',
        'hourly_rate',
        'total_cost',
        'billable',
        'invoiced',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration' => 'integer',
        'hourly_rate' => 'decimal:2',
        'total_cost' => 'decimal:2',
        'billable' => 'boolean',
        'invoiced' => 'boolean',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }
}
