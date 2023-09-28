<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            'MAT 1',
            'MAT 2',
            'MAT 3',
            'MAT 4',
            'VVO',
            'SMV',
            'NRP',
            'NPP',
            'SLO 1',
            'SLO 2',
            'SLO 3',
            'SLO 4',
            'ANG 1',
            'ANG 2',
            'ANG 3',
            'ANG 4',
            'NEM 1',
            'NEM 2',
            'NEM 3',
            'NEM 4',
            'GEO'
        ];

        shuffle($subjects);

        // Select the first 10 subjects
        $selectedSubjects = array_slice($subjects, 0, 10);

        foreach ($selectedSubjects as $subject) {
            Subject::create(['subject_name' => $subject]);
        }
    }
}
