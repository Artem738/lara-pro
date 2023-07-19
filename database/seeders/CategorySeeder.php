<?php

namespace Database\Seeders;


use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    private int $categoriesNumberToInsert = 250;
    protected int $currentId;
    protected int $duplicatedEntryCount = 0;

    public function __construct()
    {
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
            $e = null;
            try {
                DB::table('categories')->insert(
                    [
                        'id' => $this->currentId,
                        'name' => $category,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );
            } catch (QueryException $e) {
                $this->handleAllEntryErrors($category, $e);
            }
            if (!$e) {
                $this->currentId++;
            }
        }

        $faker = Faker::create();
        for ($i = 1; $i <= $this->categoriesNumberToInsert; $i++) {
            $e = null;
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
                $this->handleAllEntryErrors($name, $e);
            }
            if (!$e) {
                $this->currentId++;
            }
        }
    }

    private function handleAllEntryErrors(string $category, QueryException $exception): void
    {
        $errorPatterns = [
            'categories.PRIMARY' => 'Primary key ID error',
            'categories.categories_name_unique' => 'Duplicate entry',
        ];

        $errorMessage = $exception->getMessage();
        $errorMessageKey = '';

        foreach ($errorPatterns as $key => $pattern) {
            if (str_contains($errorMessage, $key)) {
                $errorMessageKey = $pattern;
                break;
            }
        }

        $message = '';
        if ($errorMessageKey !== '') {
            $message .= '   ' . $this->duplicatedEntryCount . ' - ' . $category . ' - ' . $errorMessageKey . ': ' . $key;
        } else {
            $message .= $exception->getMessage();
        }

        $this->command->getOutput()->writeln($message); //caution, alert, error, warning, writeln, info

        $this->duplicatedEntryCount++;
    }
}