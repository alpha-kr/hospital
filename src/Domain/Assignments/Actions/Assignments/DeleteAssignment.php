<?php

namespace Domain\Assignments\Actions\Assignments;

use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Patient;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteAssignment
{
    use AsAction;

    public function handle(Patient $patient, Assignment $assignment): void
    {
        $patient->assignments()
            ->where('id', $assignment->id)
            ->delete();
    }
}
