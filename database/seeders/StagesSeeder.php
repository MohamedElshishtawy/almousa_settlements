<?php

namespace Database\Seeders;

use App\Task\Stage;
use Illuminate\Database\Seeder;

class StagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Stage::$stages as $stageEn => $stageAr) {
            Stage::create([
                'expression' => $stageEn,
                'ar_expression' => $stageAr,
            ]);
        }
    }
}
