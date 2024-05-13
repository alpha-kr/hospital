<?php

namespace Domain\Assignments\Actions\Assignments;

use Domain\Assignments\DataTransferObjects\Assignments\AssignmentData;
use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Patient;
use Lorisleiva\Actions\Concerns\AsAction;

class SaveAssignment
{
    use AsAction;

    public function handle(Patient $patient, AssignmentData $data ): Assignment
    {
        return $patient->assignments()->updateOrCreate(
            ['diagnose_id' => $data->diagnose->id],
            [
                'observation' => $data->observation,
                'date' => $data->date
            ]
        )->load('diagnose');
    }
}
