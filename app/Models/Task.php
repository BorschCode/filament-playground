<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 147 occurrences
 * @property numeric|null $actual_hours 147 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 147 occurrences
 * @property string|null $description 147 occurrences
 * @property \Illuminate\Support\Carbon|null $due_date 147 occurrences
 * @property numeric|null $estimated_hours 147 occurrences
 * @property int|null $order 147 occurrences
 * @property string|null $priority 147 occurrences
 * @property string|null $project_id 147 occurrences
 * @property \Illuminate\Support\Carbon|null $start_date 147 occurrences
 * @property string|null $status 147 occurrences
 * @property string|null $team_id 147 occurrences
 * @property string|null $title 147 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 147 occurrences
 * @property-read \App\Models\User|null $assignee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\User|null $creator
 * @property-read Task|null $parent
 * @property-read \App\Models\Project|null $project
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Task> $subtasks
 * @property-read int|null $subtasks_count
 * @property-read \App\Models\Team|null $team
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TimeEntry> $timeEntries
 * @property-read int|null $time_entries_count
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task aggregate($function = null, $columns = [])
 * @method static \Database\Factories\TaskFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task onlyTrashed()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereActualHours($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereDescription($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereDueDate($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereEstimatedHours($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereOrder($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task wherePriority($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereProjectId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereStartDate($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereStatus($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereTeamId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereTitle($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Task whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Task withoutTrashed()
 * @mixin \Eloquent
 */
class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'project_id',
        'parent_id',
        'title',
        'description',
        'status',
        'priority',
        'start_date',
        'due_date',
        'completed_at',
        'estimated_hours',
        'actual_hours',
        'order',
        'assigned_to',
        'created_by',
        'tags',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'completed_at' => 'date',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'order' => 'integer',
        'tags' => 'array',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }

    public function subtasks(): HasMany
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
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
