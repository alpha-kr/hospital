<?php

use Domain\Assignments\Actions\Assignments\GetTopDiagnoses;
use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Diagnose;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TopDiagnosesControllerTest extends TestCase
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
    public function testControllerReturnTopDiagnosesSinceLastSixMonths()
    {
        $diagnose = Diagnose::factory(5)
        ->sequence(
            ['name' => 'Diagnose 1', 'description' => 'Description 1'],
            ['name' => 'Diagnose 2', 'description' => 'Description 2'],
            ['name' => 'Diagnose 3', 'description' => 'Description 3'],
            ['name' => 'Diagnose 4', 'description' => 'Description 4'],
            ['name' => 'Diagnose 5', 'description' => 'Description 5'],
        )
        ->create();

        $diagnose->each(function ($diagnose, $index) {
            $index++;
            Assignment::factory($index)->create([
                'diagnose_id' => $diagnose->id,
                'date' => now()->subMonth($index),
            ]);
        });

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        // assert updating assignment
        $response = $this->get('/api/top-diagnoses')
        ->assertStatus(200);

        $response->assertJsonCount(5, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'diagnose',
                    'description',
                    'totalPatients',
                ]
            ]
        ]);

        $response->assertJson([
            'data' => [
                [
                    'diagnose' => 'Diagnose 5',
                    'description' => 'Description 5',
                    'totalPatients' => 5,
                ],
                [
                    'diagnose' => 'Diagnose 4',
                    'description' => 'Description 4',
                    'totalPatients' => 4,
                ],
                [
                    'diagnose' => 'Diagnose 3',
                    'description' => 'Description 3',
                    'totalPatients' => 3,
                ],
                [
                    'diagnose' => 'Diagnose 2',
                    'description' => 'Description 2',
                    'totalPatients' => 2,
                ],
                [
                    'diagnose' => 'Diagnose 1',
                    'description' => 'Description 1',
                    'totalPatients' => 1,
                ],
            ]
        ]);
    }

    public function testControllerReturnTopDiagnosesTakingIntoAccountStartDateEndDateAndTopQueryParams()
    {
        $diagnose = Diagnose::factory(5)
            ->sequence(
                ['name' => 'Diagnose 1', 'description' => 'Description 1'],
                ['name' => 'Diagnose 2', 'description' => 'Description 2'],
                ['name' => 'Diagnose 3', 'description' => 'Description 3'],
                ['name' => 'Diagnose 4', 'description' => 'Description 4'],
                ['name' => 'Diagnose 5', 'description' => 'Description 5'],
            )
            ->create();

        $diagnose->each(function ($diagnose, $index) {
            $index++;
            Assignment::factory($index)->create([
                'diagnose_id' => $diagnose->id,
                'date' => now()->subMonth($index),
            ]);
        });

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $startDate = now()->subMonths(3);
        $endDate = now();

        $queryParams = [
            'top' => 3,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ];

        // assert updating assignment
        $response = $this->get('/api/top-diagnoses?' . http_build_query($queryParams))
            ->assertStatus(200);

        $response->assertJsonCount(3, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'diagnose',
                    'description',
                    'totalPatients',
                ]
            ]
        ]);

        $response->assertJson([
            'data' => [
                [
                    'diagnose' => 'Diagnose 3',
                    'description' => 'Description 3',
                    'totalPatients' => 3,
                ],
                [
                    'diagnose' => 'Diagnose 2',
                    'description' => 'Description 2',
                    'totalPatients' => 2,
                ],
                [
                    'diagnose' => 'Diagnose 1',
                    'description' => 'Description 1',
                    'totalPatients' => 1,
                ],
            ]
        ]);
    }
}
