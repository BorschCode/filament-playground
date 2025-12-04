<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 10 occurrences
 * @property string|null $address 10 occurrences
 * @property string|null $city 10 occurrences
 * @property string|null $company_name 10 occurrences
 * @property string|null $country 10 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 10 occurrences
 * @property string|null $email 10 occurrences
 * @property string|null $industry 10 occurrences
 * @property string|null $name 10 occurrences
 * @property string|null $notes 10 occurrences
 * @property string|null $phone 10 occurrences
 * @property string|null $postal_code 10 occurrences
 * @property string|null $state 10 occurrences
 * @property string|null $status 10 occurrences
 * @property string|null $tax_id 10 occurrences
 * @property string|null $team_id 10 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 10 occurrences
 * @property string|null $website 10 occurrences
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Contact> $contacts
 * @property-read int|null $contacts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Deal> $deals
 * @property-read int|null $deals_count
 * @property-read \App\Models\User|null $owner
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Project> $projects
 * @property-read int|null $projects_count
 * @property-read \App\Models\Team|null $team
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client aggregate($function = null, $columns = [])
 * @method static \Database\Factories\ClientFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client onlyTrashed()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereAddress($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereCity($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereCompanyName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereCountry($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereEmail($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereIndustry($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereName($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereNotes($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client wherePhone($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client wherePostalCode($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereState($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereStatus($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereTaxId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereTeamId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Client whereWebsite($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Client withoutTrashed()
 * @mixin \Eloquent
 */
class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'name',
        'company_name',
        'email',
        'phone',
        'website',
        'industry',
        'address',
        'city',
        'state',
        'country',
        'postal_code',
        'tax_id',
        'status',
        'notes',
        'owner_id',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function contacts(): HasMany
    {
        return $this->hasMany(Contact::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function deals(): HasMany
    {
        return $this->hasMany(Deal::class);
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
