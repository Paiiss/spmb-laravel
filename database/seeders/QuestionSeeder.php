<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 30; $i++) {
            DB::table('exam_questions')->insert([
                'exam_id' => 1,
                'question' => $faker->sentence,
                'option_a' => $faker->sentence,
                'option_b' => $faker->sentence,
                'option_c' => $faker->sentence,
                'option_d' => $faker->sentence,
                'option_e' => $faker->sentence,
                'answer' => $faker->randomElement(['a', 'b', 'c', 'd', 'e']),
                'created_at' => $faker->dateTime,
                'updated_at' => $faker->dateTime,
            ]);
        }
    }
}
