<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class FormsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userIds = DB::table('users')->pluck('id')->toArray();


        $faker = Faker::create('id_ID');

        foreach ($userIds as $userId) {
            DB::table('forms')->insert([
                'user_id' => $userId,
                'no_exam' => $faker->numberBetween(1, 30),
                'code_registration' => $faker->numberBetween(1, 30),
                'wave_id' => 1,
                'option_id' => 1,
                'is_submitted' => true,
                'is_paid_registration' => $faker->dateTime,
                'status' => 'submitted',
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }
        /* for ($i = 1; $i <= 30; $i++) {
            DB::table('forms')->insert([
                
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        } */
    }
}
