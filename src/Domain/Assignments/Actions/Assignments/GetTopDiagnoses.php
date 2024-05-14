<?php

namespace Domain\Assignments\Actions\Assignments;

use Carbon\Carbon;
use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Diagnose;
use Domain\Assignments\Models\Patient;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Lorisleiva\Actions\Concerns\AsAction;

class GetTopDiagnoses
{
    use AsAction;

    public function handle(int $top, Carbon $startDate, Carbon $endDate): Collection
    {
        return Diagnose::query()
            ->select('diagnoses.*', 'assignments.total')
            ->joinSub(
                Assignment::query()
                    ->whereBetween('date', [$startDate, $endDate])
                    ->select('diagnose_id', DB::raw('count(*) as total'))
                    ->groupBy('diagnose_id')
                    ->orderBy('total', 'desc'),
                'assignments',
                function ($join) {
                    $join->on('diagnoses.id', '=', 'assignments.diagnose_id');
                }
            )
            ->take($top)
            ->orderBy('assignments.total', 'desc')
            ->get();
    }
}
