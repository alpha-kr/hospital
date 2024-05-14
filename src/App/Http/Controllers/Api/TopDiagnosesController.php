<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TopDiagnoseResource;
use Domain\Assignments\Actions\Assignments\GetTopDiagnoses;
use Illuminate\Http\Request;

class TopDiagnosesController extends Controller
{
    public function __invoke(Request $request)
    {
        $top = $request->input('top') ?? 5;

        $startDate = $request->date('start_date') ?? now()->subMonths(6);
        $endDate = $request->date('end_date') ?? now();

        $topDiagnoses = GetTopDiagnoses::make()
            ->handle($top, $startDate, $endDate);

        return $this->apiResponse(
            TopDiagnoseResource::collection($topDiagnoses),
            'Top diagnoses retrieved successfully.',
            200
        );
    }
}
