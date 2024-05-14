<?php


use Carbon\Carbon;
use Domain\Assignments\Models\Assignment;
use Domain\Assignments\Models\Patient;
use Domain\Auth\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class PatientControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;


    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();
    }

    /**
     * Test the index method of PatientController.
     */
    public function testIndex()
    {
        Patient::factory(5)->create();

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->get('/api/patients');

        $response->assertStatus(200);

        $response->assertJsonCount(5, 'data');
    }

    /**
     * Test the index method of PatientController.
     */
    public function testIndexResponseWithAssignmentsAndDiagnoses()
    {
        $patients = Patient::factory(2)
            ->has(
                Assignment::factory()
            )
            ->create();

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->get('/api/patients');

        $response->assertStatus(200);

        $response->assertJsonCount(2, 'data');

        $response->assertJsonStructure([
            'data' => [
                '*' => [
                    'id',
                    'document',
                    'firstName',
                    'lastName',
                    'birthDate',
                    'email',
                    'phone',
                    'genre',
                    'assignments' => [
                        '*' => [
                            'id',
                            'observation',
                            'date',
                            'diagnose' => [
                                'id',
                                'name',
                                'description',
                            ]
                        ]
                    ]
                ]
            ]
        ]);

        $response->assertJson([
            'data' =>
            $patients->map(function ($patient) {
                return [
                    'id' => $patient->id,
                    'document' => $patient->document,
                    'firstName' => $patient->first_name,
                    'lastName' => $patient->last_name,
                    'birthDate' => $patient->birth_date->format('Y-m-d'),
                    'email' => $patient->email,
                    'phone' => $patient->phone,
                    'genre' => $patient->genre->value,
                    'assignments' => $patient->assignments->map(function ($assignment) {
                        return [
                            'id' => $assignment->id,
                            'observation' => $assignment->observation,
                            'date' => $assignment->date->format('Y-m-d H:i'),
                            'diagnose' => [
                                'id' => $assignment->diagnose->id,
                                'name' => $assignment->diagnose->name,
                                'description' => $assignment->diagnose->description,
                            ]
                        ];
                    })->toArray()
                ];
            })->toArray()
        ]);
    }

    /**
     * Test the index method of PatientController.
     */
    public function testIndexWithFilterByName()
    {
        Patient::factory(2)->create([
            'first_name' => 'andres'
        ]);

        Patient::factory(2)->create([
            'first_name' => 'jhon'
        ]);

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->get('/api/patients?name=jhon');

        $response->assertStatus(200);

        $response->assertJsonCount(2, 'data');

        $response = $this->get('/api/patients?name');

        $response->assertStatus(200);

        $response->assertJsonCount(4, 'data');
    }


    public function testIndexWithFilterByLastName()
    {
        Patient::factory(2)->create([
            'last_name' => 'arias'
        ]);

        Patient::factory()->create([
            'last_name' => 'borja'
        ]);

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->get('/api/patients?last_name=borja');

        $response->assertStatus(200);

        $response->assertJsonCount(1, 'data');

        $response = $this->get('/api/patients?last_name');

        $response->assertStatus(200);

        $response->assertJsonCount(3, 'data');
    }

    public function testIndexWithFilterByDocument()
    {
        Patient::factory()
            ->create(['document' => '123456789']);

        Patient::factory(3)->create();


        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->get('/api/patients?document=123456789');

        $response->assertStatus(200);

        $response->assertJsonCount(1, 'data');
    }

    /**
     * Test the store method of PatientController.
     */
    public function testStore()
    {
        $data = Patient::factory()->make()->toArray();

        $data['birth_date'] = Carbon::parse($data['birth_date'])->format('Y-m-d');

        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $response = $this->post('/api/patients', $data);

        $response->assertStatus(201);

        $this->assertDatabaseHas('patients', $data);
    }

    /**
     * Test the show method of PatientController.
     */
    public function testShow()
    {
        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $patient = Patient::factory()->create();

        $response = $this->get('/api/patients/' . $patient->id);

        $response->assertStatus(200);
    }

    /**
     * Test the update method of PatientController.
     */
    public function testUpdate()
    {
        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $patient = Patient::factory()->create();

        $data = Patient::factory()->make()->toArray();

        $data['birth_date'] = Carbon::parse($data['birth_date'])->format('Y-m-d');

        $response = $this->put('/api/patients/' . $patient->id, $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('patients', $data);
    }

    /**
     * Test the destroy method of PatientController.
     */
    public function testDestroy()
    {
        Sanctum::actingAs(
            $this->user,
            ['*']
        );

        $patient = Patient::factory()->create();

        $response = $this->delete('/api/patients/' . $patient->id);

        $this->assertSoftDeleted($patient);

        $response->assertStatus(200);
    }
}
