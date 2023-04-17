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
        $faker->addProvider(new \Xvladqt\Faker\LoremFlickrProvider($faker));

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
            $name = MAMMALS[$k];
            $photo = $faker->image($dir=public_path().'/animals-images', 300, 200, ["$name"], false);
            $photoPath = asset('zoo-park/public/animals-images/'.$photo);
            DB::table('animals')->insert([
                'name' => $name,
                'specie_id' => 1,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'photo' => rand(0, 3) ? $photoPath : null,
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => DB::table('managers')->select('id')->where('specie_id', 1)->get()[rand(0,2)]->id
            ]);
        }

        foreach(range(1, count(AMPHIBIANS)) as $k => $_) {
            $name = AMPHIBIANS[$k];
            $photo = $faker->image($dir=public_path().'/animals-images', 300, 200, ["$name"], false);
            $photoPath = asset('zoo-park/public/animals-images/'.$photo);
            DB::table('animals')->insert([
                'name' => $name,
                'specie_id' => 2,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'photo' => rand(0, 3) ? $photoPath : null,
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => DB::table('managers')->select('id')->where('specie_id', 2)->get()[rand(0,2)]->id
            ]);
        }

        foreach(range(1, count(BIRDS)) as $k => $_) {
            $name = BIRDS[$k];
            $photo = $faker->image($dir=public_path().'/animals-images', 300, 200, ["$name"], false);
            $photoPath = asset('zoo-park/public/animals-images/'.$photo);
            DB::table('animals')->insert([
                'name' => $name,
                'specie_id' => 3,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'photo' => rand(0, 3) ? $photoPath : null,
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => DB::table('managers')->select('id')->where('specie_id', 3)->get()[rand(0,2)]->id
            ]);
        }

        foreach(range(1, count(REPTILES)) as $k => $_) {
            $name = REPTILES[$k];
            $photo = $faker->image($dir=public_path().'/animals-images', 300, 200, ["$name"], false);
            $photoPath = asset('zoo-park/public/animals-images/'.$photo);
            DB::table('animals')->insert([
                'name' => $name,
                'specie_id' => 4,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'photo' => rand(0, 3) ? $photoPath : null,
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => DB::table('managers')->select('id')->where('specie_id', 4)->get()[rand(0,2)]->id
            ]);
        }

        foreach(range(1, count(FISH)) as $k => $_) {
            $name = FISH[$k];
            $photo = $faker->image($dir=public_path().'/animals-images', 300, 200, ["$name"], false);
            $photoPath = asset('zoo-park/public/animals-images/'.$photo);
            DB::table('animals')->insert([
                'name' => $name,
                'specie_id' => 5,
                'birth_year' => $faker->numberBetween($minYear, $currYear),
                'photo' => rand(0, 3) ? $photoPath : null,
                'animal_book' => $faker->realText(rand(50, 100)),
                'manager_id' => DB::table('managers')->select('id')->where('specie_id', 5)->get()[rand(0,2)]->id
            ]);
        }
    }
}
