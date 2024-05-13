<?php

namespace Domain\Assignments\DataTransferObjects\Assignments;

use Carbon\CarbonImmutable;
use Domain\Assignments\Models\Diagnose;
use Illuminate\Http\Request;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Attributes\WithoutValidation;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
use Spatie\LaravelData\Optional;

class AssignmentData extends Data
{
    public function __construct(
        public string | Optional $observation,
        #[WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class, format: 'Y-m-d H:i')]
        public CarbonImmutable $date,
        #[WithoutValidation]
        public Diagnose $diagnose,
    )
    {
    }

    public static function fromRequest(Request $request): static{
        return new self(
            observation: $request->input('observation'),
            date: CarbonImmutable::parse($request->date('date','Y-m-d H:i')),
            diagnose: Diagnose::findOrFail($request->input('diagnose_id'))
        );
    }

    public static function rules(): array
    {
        return [
            'observation' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date', 'date_format:Y-m-d H:i'],
            'diagnose_id' => ['required', 'exists:diagnoses,id'],
        ];
    }
}
