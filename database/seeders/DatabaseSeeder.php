<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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


        // insert hijri days
        // Define Hijri months with their corresponding integer values and days
        $months = [
            5 => ['name' => 'جمادى الأول', 'days' => 29],
            6 => ['name' => 'جمادى الآخر', 'days' => 30],
            7 => ['name' => 'رجب', 'days' => 30],
            8 => ['name' => 'شعبان', 'days' => 29],
            9 => ['name' => 'رمضان', 'days' => 29],
            10 => ['name' => 'شوال', 'days' => 30],
            11 => ['name' => 'ذو القعدة', 'days' => 29],
            12 => ['name' => 'ذو الحجة', 'days' => 29],
        ];

        $start_date = Carbon::create(2024, 11, 3); // Starting Gregorian date
        $hijri_year = '1446'; // Hijri year

        foreach ($months as $month_number => $month_data) {
            $month_name = $month_data['name'];
            $days_in_month = $month_data['days'];

            for ($day = 1; $day <= $days_in_month; $day++) {
                $weekday = $this->getWeekdayInArabic($start_date->dayOfWeek);
                DB::table('hijri_dates')->insert([
                    'gregorian_date' => $start_date->toDateString(),
                    'year' => $hijri_year,
                    'month' => $month_number, // Use integer month value
                    'day' => $day,
                    'weekday' => $weekday,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $start_date->addDay(); // Increment the date by 1
            }
        }
    }

    /**
     * Get the Arabic weekday name.
     */
    private function getWeekdayInArabic($weekdayIndex): string
    {
        $weekdays = [
            'الأحد',
            'الإثنين',
            'الثلاثاء',
            'الأربعاء',
            'الخميس',
            'الجمعة',
            'السبت'
        ];
        return $weekdays[$weekdayIndex];
    }



}
