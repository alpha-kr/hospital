<?php

namespace Domain\Assignments\DataTransferObjects\Patients;

use Carbon\CarbonImmutable;
use Domain\Assignments\Enums\PatientGenre;
use Spatie\LaravelData\Attributes\Validation\Date;
use Spatie\LaravelData\Attributes\Validation\DateFormat;
use Spatie\LaravelData\Attributes\Validation\Email;
use Spatie\LaravelData\Attributes\Validation\Max;
use Spatie\LaravelData\Attributes\Validation\MaxDigits;
use Spatie\LaravelData\Attributes\Validation\Regex;
use Spatie\LaravelData\Attributes\Validation\Unique;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;
class CreatePatientData extends Data
{
    public function __construct(
        #[MaxDigits(20), Regex('/[0-9]+/'), Unique('patients', 'document')]
        public string $document,
        #[Max(255)]
        public string $first_name,
        #[Max(255)]
        public string $last_name,
        #[Date, DateFormat('Y-m-d'), WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class, format: 'Y-m-d')]
        public CarbonImmutable $birth_date,
        #[Email(), Unique('patients', 'email')]
        public string $email,
        #[Max(20)]
        public string $phone,
        public PatientGenre $genre
    ) {
    }
}
