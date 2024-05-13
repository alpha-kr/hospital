<?php

namespace Domain\Assignments\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'diagnose_id',
        'observation',
        'date'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function patient() : BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function diagnose() : BelongsTo
    {
        return $this->belongsTo(Diagnose::class);
    }
}
