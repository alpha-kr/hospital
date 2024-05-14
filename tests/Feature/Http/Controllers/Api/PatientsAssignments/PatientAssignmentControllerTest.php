<?php

use Carbon\CarbonImmutable;
use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Diagnose;
use Domain\Assignments\Models\Patient;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PatientAssignmentControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;


    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Test the index method of PatientAssignmentController.
     */
    public function testStoreResponse()
    {
        $patient = Patient::factory()->create();
        $diagnose = Diagnose::factory()->create();
        $now = CarbonImmutable::now();

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->post('/api/patients/'.$patient->id.'/assignments', [
            'diagnose_id' => $diagnose->id,
            'date' => $now->format('Y-m-d H:i'),
            'observation' => 'Test description'
        ]);

        $response->assertStatus(201);

        //assert database
        $this->assertDatabaseHas('assignments', [
            'patient_id' => $patient->id,
            'diagnose_id' => $diagnose->id,
            'date' => $now->format('Y-m-d H:i'),
            'observation' => 'Test description'
        ]);

        // assert updating assignment
        $response = $this->post('/api/patients/'.$patient->id.'/assignments', [
            'diagnose_id' => $diagnose->id,
            'date' => $now->format('Y-m-d H:i'),
            'observation' => 'Test description updated'
        ]);

        $response->assertStatus(201);

        //assert database
        $this->assertDatabaseHas('assignments', [
            'patient_id' => $patient->id,
            'diagnose_id' => $diagnose->id,
            'date' => $now->format('Y-m-d H:i'),
            'observation' => 'Test description updated'
        ]);
    }

    /**
     * Test the delete method of PatientAssignmentController.
     */
    public function testDeleteResponse()
    {
        $patient = Patient::factory()
        ->has(Assignment::factory()->count(2))
        ->create();

        $assignment = $patient->assignments->first();

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->delete('/api/patients/'.$patient->id.'/assignments/'. $assignment->id);

        $response->assertStatus(200);

        //assert database
        $this->assertDatabaseMissing('assignments', [
            'patient_id' => $patient->id,
            'diagnose_id' => $assignment->diagnose_id,
        ]);

        $this->assertCount(1, $patient->refresh()->assignments);
    }
}
