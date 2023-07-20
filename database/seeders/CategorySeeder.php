<?php

namespace Database\Seeders;


use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    private int $categoriesNumberToInsert;
    protected int $currentId;
    protected int $duplicatedEntryCount = 0;

    public function __construct()
    {
        $this->categoriesNumberToInsert = DatabaseSeeder::$categoriesNumberToInsert ?? 10;
        $this->currentId = DB::table('categories')->max('id') + 1 ?? 1;
    }

    public function run(): void
    {
        $genres = array(
            1 => 'Action',
            2 => 'Adventure',
            3 => 'Classics',
            4 => 'Historical',
            5 => 'Detective',
            6 => 'Fantasy',
            7 => 'Fiction',
            8 => 'Horror',
            9 => 'Mystery',
            10 => 'Romance',
            11 => 'Science Fiction',
            12 => 'Thriller',
            13 => 'Crime',
            14 => 'Biography',
            15 => 'Autobiography',
        );


        $now = now();

        foreach ($genres as $id => $category) {
            $isException = false;
            try {
                DB::table('categories')->insert(
                    [
                        'id' => $id,
                        'name' => $category,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            } catch (QueryException $exception) {
                $this->duplicatedEntryCount++;
                $isException = true;
                DatabaseSeeder::handleAllEntryErrors($exception);
            }
            if (!$isException) {
                $this->currentId++;
            }
        }

        $this->currentId = DB::table('categories')->max('id') + 1;

        $faker = Faker::create();
        for ($i = 0; $i < $this->categoriesNumberToInsert; $i++) {
            $isException = null;
            $name = ucfirst($faker->word()) . $faker->randomLetter();
            try {
                DB::table('categories')->insert(
                    [
                        'id' => $this->currentId,
                        'name' => $name,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            } catch (QueryException $e) {
                $this->duplicatedEntryCount++;
                $isException = true;
                DatabaseSeeder::handleAllEntryErrors($e);
            }
            if (!$isException) {
                $this->currentId++;
            }
        }
    }


}
