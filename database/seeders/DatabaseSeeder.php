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

        // seed the living
        $livings = \App\Living\Living::$livings;
        foreach ($livings as $living) {
            \App\Living\Living::create([
                'title' => $living,
            ]);
        }

        $foodType = ['لحم' , 'مطهو' ,'جاف'];
        foreach ($foodType as $type) {
            \App\Product\FoodType::create([
                'title' => $type,
            ]);
        }

        $foodUnits = ['عبوة صغيرة','عبوة وسط' ,'عبوة كبيرة' , 'عبوة' , 'جرام' ,'لتر'];
        foreach ($foodUnits as $unit) {
            \App\Product\FoodUnit::create([
                'title' => $unit,
            ]);
        }

        // seed the missions
        $missions = \App\Mission\Mission::$missions;
        foreach ($missions as $mission) {
            \App\Mission\Mission::create([
                'title' => $mission,
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
