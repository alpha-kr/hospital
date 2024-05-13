<?php

namespace Domain\Assignments\Models;

use Domain\Assignments\Enums\PatientGenre;
use Domain\Assignments\QueryBuilders\PatientQueryBuilder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patient extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'document',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'phone',
        'genre'
    ];

    protected $casts = [
        'genre' => PatientGenre::class,
        'published_at' => 'immutable_datetime',
    ];

    public function newEloquentBuilder($query): PatientQueryBuilder
    {
        return new PatientQueryBuilder($query);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
