<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ContractTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $contractTypes = [
            'تأجير سيارات' => '44',
            'أعمال يدوية' => '33',
            'توريد' => '22',
            'توريد وتركيب' => '11',
        ];
        foreach ($contractTypes as $type => $deduction) {
            \App\Models\ContractType::create([
                'name' => $type,
                'deduction' => $deduction,
            ]);
        }
    }
}
