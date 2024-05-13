<?php

namespace Domain\Assignments\Actions\Patients;

use Domain\Assignments\DataTransferObjects\Patients\CreatePatientData;
use Domain\Assignments\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Lorisleiva\Actions\Concerns\AsAction;

class GetPatients
{
    use AsAction;

    public function handle(Collection $filters, int $perPage = 15): LengthAwarePaginator
    {
        return  Patient::query()
            ->with('assignments.diagnose')
            ->whereName($filters->get('name'))
            ->whereDocument($filters->get('document'))
            ->whereLastName($filters->get('last_name'))
            ->paginate($perPage);
    }
}
