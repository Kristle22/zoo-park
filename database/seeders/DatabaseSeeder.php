<?php

namespace Database\Seeders;
require 'animals.php';

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('lt_LT');

        DB::table('users')->insert([
            'name' => 'Kristina',
            'email' => 'crislayn@yahoo.com',
            'password' => Hash::make('kriste22')
        ]);

        $species = ['Mammals', 'Amphibians', 'Birds', 'Reptiles',  'Fish'];

        foreach(range(1, count($species)) as $k => $_) {
            DB::table('species')->insert([
                'name' => $species[$k]
            ]);
        }

        $manCount = 20;
        foreach(range(1, $manCount) as $_) {
            DB::table('managers')->insert([
                'name' => $faker->firstName(),
                'surname' => $faker->lastName(),
                'specie_id' => rand(1, count($species))
            ]);
        }

        $minYear = Carbon::now()->subYears(40)->format('Y');
        $currYear = Carbon::now()->format('Y');

        foreach(range(1, count(MAMMALS)) as $k => $_) {
            DB::table('animals')->insert([
                'name' => MAMMALS[$k],
                'specie_id' => 1,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => rand(1, $manCount)
            ]);
        }

        foreach(range(1, count(AMPHIBIANS)) as $k => $_) {
            DB::table('animals')->insert([
                'name' => AMPHIBIANS[$k],
                'specie_id' => 2,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => rand(1, $manCount)
            ]);
        }

        foreach(range(1, count(BIRDS)) as $k => $_) {
            DB::table('animals')->insert([
                'name' => BIRDS[$k],
                'specie_id' => 3,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => rand(1, $manCount)
            ]);
        }

        foreach(range(1, count(REPTILES)) as $k => $_) {
            DB::table('animals')->insert([
                'name' => REPTILES[$k],
                'specie_id' => 4,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => rand(1, $manCount)
            ]);
        }

        foreach(range(1, count(FISH)) as $k => $_) {
            DB::table('animals')->insert([
                'name' => FISH[$k],
                'specie_id' => 5,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => rand(1, $manCount)
            ]);
        }
    }
}
