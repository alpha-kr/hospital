<?php

namespace Domain\Assignments\Actions\Patients;

use Domain\Assignments\Models\Patient;
use Lorisleiva\Actions\Concerns\AsAction;

class DeletePatient
{
    use AsAction;

    public function handle(Patient $patient): void
    {
        $patient->delete();
    }
}
