<?php

namespace Database\Seeders;

use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public static int $categoriesNumberToInsert = 10; // CATEGORIES  !!
    public static int $booksBatchPacksToInsert = 10;
    public static int $booksBatchSize = 10;

//    public function __construct()
//    {
//        config(['seeder.booksBatchPacksToInsert' => $this->booksBatchPacksToInsert]);
//            use
//        $this->booksBatchPacksToInsert = config('seeder.booksBatchPacksToInsert', 50);
//    }

    public function run(): void
    {
//        $this->call(CategorySeeder::class);
//        $this->call(BookSeeder::class);
        $this->call(
            [
                CategorySeeder::class,
                BookSeeder::class,
            ]
        );
    }

    public static function handleAllEntryErrors(QueryException $exception): void
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
            $message .= ' - ' . $errorMessageKey . ': ' . $key;
        } else {
            $message .= $exception->getMessage();
        }

        echo ($message) . PHP_EOL;
    }
}
