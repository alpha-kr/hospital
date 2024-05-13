<?php

namespace Domain\Assignments\Actions\Patients;

use Domain\Assignments\DataTransferObjects\Patients\UpdatePatientData;
use Domain\Assignments\Models\Patient;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdatePatient
{
    use AsAction;

    public function handle(UpdatePatientData $dto, Patient $patient): Patient
    {
        $patient->update($dto->only(
            'document',
            'first_name',
            'last_name',
            'birth_date',
            'email',
            'phone',
            'genre'
        )->toArray());

        return $patient;
    }
}
