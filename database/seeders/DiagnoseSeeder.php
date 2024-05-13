<?php

namespace Database\Seeders;

use Domain\Assignments\Models\Diagnose;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiagnoseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //insert the diagnoses into the database
        Diagnose::query()->insert(
            array_map(
                fn($diagnose) => [
                    'name' => $diagnose['diagnosis'],
                    'description' => $diagnose['description'],
                ],
                $this->getDiagnoses()
            )
        );
    }

    public function getDiagnoses() : array{
        return json_decode(file_get_contents(database_path('diagnoses.json')), true);
    }
}
