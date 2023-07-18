<?php

namespace App\Enum;

namespace App\Console\Commands;

use App\Enum\LangEnum;
use Illuminate\Console\Command;

class CollectionTest extends Command
{

    protected $signature = 'collecttest';


    protected $description = 'Collection TEST Command';


    public function handle()
    {
        echo "Collection TEST Command" . PHP_EOL;

        $numbers = collect([1, 2, 3, 4, 5]);

        $multipliedNumbers = $numbers->map(
            function ($number) {
                return $number * 2;
            }
        );
        print_r($multipliedNumbers.PHP_EOL);

        $data = collect([
                            "one" => 11,
                            "two" => 22,
                            "three" => 33,
                            "four" => 44,
                        ]);

        $filteredNumbers = $data->filter(
            function ($number) {
                return $number % 2 === 0;
            }
        );
        print_r($filteredNumbers.PHP_EOL);


        $numbers = collect([1, 2, 3, 4, 5]);
        $filteredNumbers = $numbers->filter(function ($item) {
            return $item % 2 === 0;
        });
        print_r($filteredNumbers->toArray());


        $students = collect([
                                ['name' => 'Alice', 'grade' => 'A'],
                                ['name' => 'Bob', 'grade' => 'B'],
                                ['name' => 'Charlie', 'grade' => 'A'],
                                ['name' => 'Dave', 'grade' => 'C'],
                            ]);

        $studentsByGrade = $students->groupBy('grade');
        dd($studentsByGrade);

    }
}
