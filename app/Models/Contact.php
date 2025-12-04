<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 18 occurrences
 * @property string|null $client_id 18 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 18 occurrences
 * @property string|null $department 18 occurrences
 * @property string|null $email 18 occurrences
 * @property string|null $first_name 18 occurrences
 * @property bool|null $is_primary 18 occurrences
 * @property string|null $job_title 18 occurrences
 * @property string|null $last_name 18 occurrences
 * @property string|null $mobile 18 occurrences
 * @property string|null $notes 18 occurrences
 * @property string|null $phone 18 occurrences
 * @property string|null $team_id 18 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 18 occurrences
 * @property-read \App\Models\Client|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deal> $deals
 * @property-read int|null $deals_count
 * @property-read string $full_name
 * @property-read \App\Models\Team|null $team
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact aggregate($function = null, $columns = [])
 * @method static \Database\Factories\ContactFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact onlyTrashed()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereClientId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereDepartment($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereEmail($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereFirstName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereIsPrimary($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereJobTitle($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereLastName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereMobile($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereNotes($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact wherePhone($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereTeamId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Contact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Contact withoutTrashed()
 * @mixin \Eloquent
 */
class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'client_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'mobile',
        'job_title',
        'department',
        'is_primary',
        'notes',
        'social_profiles',
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'social_profiles' => 'array',
    ];

    protected $appends = ['full_name'];

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }
}
