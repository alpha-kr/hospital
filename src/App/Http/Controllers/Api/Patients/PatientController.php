<?php

namespace App\Http\Controllers\Api\Patients;

use App\Http\Controllers\Controller;
use App\Http\Resources\PatientResource;
use Domain\Assignments\Actions\Patients\CreatePatient;
use Domain\Assignments\Actions\Patients\DeletePatient;
use Domain\Assignments\Actions\Patients\GetPatients;
use Domain\Assignments\Actions\Patients\UpdatePatient;
use Domain\Assignments\DataTransferObjects\Patients\CreatePatientData;
use Domain\Assignments\DataTransferObjects\Patients\UpdatePatientData;
use Domain\Assignments\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = $request
            ->collect()
            ->only(
                'name',
                'document',
                'last_name'
            );

        $perPage = $request->get('per_page', 15);

        return $this->apiResponse(
            PatientResource::collection(
                GetPatients::make()
                    ->handle(
                        $filters,
                        $perPage
                    )
            ),
            'Patients got successfully',
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePatientData $data)
    {
        $patient =  CreatePatient::make()
            ->handle($data);

        return $this->apiResponse(
            new PatientResource($patient),
            'Patient created successfully',
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(Patient $patient)
    {
        return $this->apiResponse(
            new PatientResource($patient),
            'Patient got successfully',
            200
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientData $data, Patient $patient)
    {
        // update patient
        $patient = UpdatePatient::make()
            ->handle($data, $patient);

        return $this->apiResponse(
            new PatientResource($patient),
            'Patient updated successfully',
            200
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Patient $patient)
    {
        DeletePatient::make()
            ->handle($patient);

        return $this->apiResponse(
            null,
            'Patient deleted successfully',
            200
        );
    }
}
