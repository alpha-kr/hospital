<?php

namespace Domain\Assignments\Actions\Patients;

use Domain\Assignments\DataTransferObjects\Patients\CreatePatientData;
use Domain\Assignments\Models\Patient;
use Lorisleiva\Actions\Concerns\AsAction;

class CreatePatient
{
    use AsAction;

    public function handle(CreatePatientData $dto): Patient
    {
        return Patient::create($dto->only(
            'document',
            'first_name',
            'last_name',
            'birth_date',
            'email',
            'phone',
            'genre'
        )->toArray());
    }
}
