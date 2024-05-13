<?php

namespace App\Http\Controllers\Api\PatientsAssignments;

use App\Http\Controllers\Controller;
use App\Http\Resources\AssignmentResource;
use Domain\Assignments\Actions\Assignments\DeleteAssignment;
use Domain\Assignments\Actions\Assignments\SaveAssignment;
use Domain\Assignments\DataTransferObjects\Assignments\AssignmentData;
use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Patient;
use Illuminate\Http\Request;

class PatientAssignmentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentData $data, Patient $patient)
    {
      $assignment = SaveAssignment::make()->handle(
            $patient,
            $data
        );

        return $this->apiResponse(
            new AssignmentResource($assignment),
            'Patient created successfully',
            201
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient, Assignment $assignment)
    {
        DeleteAssignment::make()->handle(
            $patient,
            $assignment
        );

        return $this->apiResponse(
            null,
            'Patient deleted successfully',
            200
        );
    }
}
