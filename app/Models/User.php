<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use MongoDB\Laravel\Auth\User as Authenticatable;

/**
 * @property mixed $id 6 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 6 occurrences
 * @property string|null $current_team_id 6 occurrences
 * @property string|null $email 6 occurrences
 * @property \Illuminate\Support\Carbon|null $email_verified_at 6 occurrences
 * @property string|null $job_title 1 occurrences
 * @property string|null $name 6 occurrences
 * @property string|null $password 6 occurrences
 * @property string|null $remember_token 6 occurrences
 * @property string|null $team_ids 6 occurrences
 * @property \Illuminate\Support\Carbon|null $two_factor_confirmed_at 6 occurrences
 * @property string|null $two_factor_recovery_codes 6 occurrences
 * @property string|null $two_factor_secret 6 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 6 occurrences
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $assignedTasks
 * @property-read int|null $assigned_tasks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Task> $createdTasks
 * @property-read int|null $created_tasks_count
 * @property-read \App\Models\Team|null $currentTeam
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $ownedTeams
 * @property-read int|null $owned_teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Team> $teams
 * @property-read int|null $teams_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TimeEntry> $timeEntries
 * @property-read int|null $time_entries_count
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User aggregate($function = null, $columns = [])
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User newQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereCurrentTeamId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereEmailVerifiedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereJobTitle($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User wherePassword($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereRememberToken($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereTeamIds($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereTwoFactorConfirmedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereTwoFactorRecoveryCodes($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereTwoFactorSecret($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'current_team_id',
        'avatar',
        'phone',
        'job_title',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'two_factor_secret',
        'two_factor_recovery_codes',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'two_factor_confirmed_at' => 'datetime',
        ];
    }

    public function currentTeam(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'current_team_id');
    }

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->withPivot(['role', 'permissions'])
            ->withTimestamps();
    }

    public function ownedTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'owner_id');
    }

    public function timeEntries(): HasMany
    {
        return $this->hasMany(TimeEntry::class);
    }

    public function assignedTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function createdTasks(): HasMany
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }
}
