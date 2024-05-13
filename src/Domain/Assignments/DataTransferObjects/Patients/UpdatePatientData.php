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
use Spatie\LaravelData\Optional;
use Spatie\LaravelData\Support\Validation\References\RouteParameterReference;

class UpdatePatientData extends Data
{
    public function __construct(
        #[MaxDigits(20), Regex('/[0-9]+/'), Unique('patients', ignore: new RouteParameterReference('patient', 'id'))]
        public string | Optional $document,
        #[Max(255)]
        public string | Optional $first_name,
        #[Max(255)]
        public string | Optional $last_name,
        #[Date, DateFormat('Y-m-d'), WithCast(DateTimeInterfaceCast::class, type: CarbonImmutable::class, format: 'Y-m-d')]
        public CarbonImmutable | Optional $birth_date,
        #[Email(), Unique('patients', 'email', ignore: new RouteParameterReference('patient', 'id'))]
        public string | Optional $email,
        #[MaxDigits(20)]
        public string | Optional $phone,
        public PatientGenre | Optional $genre
    ) {
    }
}
