<?php

namespace Database\Seeders;

use App\Evaluation\EvaluateWeek;
use App\Evaluation\Evaluation;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class EvaluationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Evaluation::$descriptions as $index => $descriptionAr) {
            Evaluation::create([
                'number' => $index + 1,
                'description' => $descriptionAr,
            ]);
        }

        $start_date = EvaluateWeek::$start_date;
        foreach (EvaluateWeek::$names as $index => $name) {
            EvaluateWeek::create([
                'start_date' => $start_date,
                'name' => $name,
            ]);
            $start_date = date('Y-m-d', strtotime($start_date.' + 7 days'));
        }


        // add the evaluator for every role
        $rolesWithEvaluator = [
            'subsidiary_receiving_committee_president' => 'site_supervisor',
            'group_head' => 'site_supervisor',
            'subsidiary_receiving_committee_member' => 'subsidiary_receiving_committee_president',
            'meal_dispenser' => 'group_head',
            'administrative_affairs_member' => 'site_supervisor',
            'security_member' => 'site_supervisor',
            'assistant_main_receiving_committee_president' => 'main_receiving_committee_president',
            'main_receiving_committee_member' => 'main_receiving_committee_president',
        ];
        foreach ($rolesWithEvaluator as $role => $evaluator) {
            $role = Role::findByName($role);
            $evaluator = Role::findByName($evaluator);
            $role->update(['evaluator_id' => $evaluator->id]);
            $role->save();
        }

    }
}
