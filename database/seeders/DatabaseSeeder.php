<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // seed the week days
        $days = \App\Models\Day::$days;
        foreach ($days as $day) {
            \App\Models\Day::create([
                'name' => $day,
            ]);
        }

        // seed the meals
        $meals = \App\Models\Meal::$meals;
        foreach ($meals as $meal) {
            \App\Models\Meal::create([
                'name' => $meal,
            ]);
        }

        // Admin user
        \App\Models\User::create([
            'name' => 'أستاذ محمد',
            'phone' => '01093033115',
            'rank' => 'مدير',
            'role' => '0',
            'password' => Hash::make('123456'),
        ]);

    }
}
