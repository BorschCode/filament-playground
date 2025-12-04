<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use MongoDB\Laravel\Eloquent\Model;

/**
 * @property mixed $id 9 occurrences
 * @property string|null $client_id 9 occurrences
 * @property \Illuminate\Support\Carbon|null $created_at 9 occurrences
 * @property string|null $currency 9 occurrences
 * @property string|null $description 9 occurrences
 * @property \Illuminate\Support\Carbon|null $expected_close_date 9 occurrences
 * @property string|null $notes 9 occurrences
 * @property int|null $probability 9 occurrences
 * @property string|null $stage 9 occurrences
 * @property string|null $team_id 9 occurrences
 * @property string|null $title 9 occurrences
 * @property \Illuminate\Support\Carbon|null $updated_at 9 occurrences
 * @property numeric|null $value 9 occurrences
 * @property-read \App\Models\Client|null $client
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Comment> $comments
 * @property-read int|null $comments_count
 * @property-read \App\Models\Contact|null $contact
 * @property-read \App\Models\User|null $owner
 * @property-read \App\Models\Team|null $team
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal addHybridHas(\Illuminate\Database\Eloquent\Relations\Relation $relation, string $operator = '>=', string $count = 1, string $boolean = 'and', ?\Closure $callback = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal aggregate($function = null, $columns = [])
 * @method static \Database\Factories\DealFactory factory($count = null, $state = [])
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal getConnection()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal insert(array $values)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal insertGetId(array $values, $sequence = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal newModelQuery()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deal onlyTrashed()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal query()
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal raw($value = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal search(\MongoDB\Builder\Type\SearchOperatorInterface|array $operator, ?string $index = null, ?array $highlight = null, ?bool $concurrent = null, ?string $count = null, ?string $searchAfter = null, ?string $searchBefore = null, ?bool $scoreDetails = null, ?array $sort = null, ?bool $returnStoredSource = null, ?array $tracking = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal vectorSearch(string $index, string $path, array $queryVector, int $limit, bool $exact = false, \MongoDB\Builder\Type\QueryInterface|array $filter = [], ?int $numCandidates = null)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereClientId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereCreatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereCurrency($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereDescription($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereExpectedCloseDate($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereNotes($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereProbability($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereStage($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereTeamId($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereTitle($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereUpdatedAt($value)
 * @method static \MongoDB\Laravel\Eloquent\Builder<static>|Deal whereValue($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deal withTrashed(bool $withTrashed = true)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Deal withoutTrashed()
 * @mixin \Eloquent
 */
class Deal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'team_id',
        'client_id',
        'contact_id',
        'title',
        'value',
        'currency',
        'stage',
        'probability',
        'expected_close_date',
        'actual_close_date',
        'description',
        'notes',
        'owner_id',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'probability' => 'integer',
        'expected_close_date' => 'date',
        'actual_close_date' => 'date',
    ];

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(Contact::class);
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
