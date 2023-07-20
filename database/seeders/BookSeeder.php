<?php

namespace Database\Seeders;

use App\Enum\LangEnum;
use Faker\Factory as Faker;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;


class BookSeeder extends Seeder
{
    //Testing Pool Request
    private bool $useHandleAllEntryErrorsFunction = false;
    private bool $hardBarWithTimeEnabled = false;

    protected int $booksBatchPacksToInsert = 100; // Можна так
    protected int $booksBatchSize = 500;
    protected int $currentId;
    protected int $categoriesMaxId;

    protected ConsoleOutput $output;

    public function __construct()
    {
        $this->booksBatchPacksToInsert = DatabaseSeeder::$booksBatchPacksToInsert ?? 100; //але тут буде останнє.
        $this->booksBatchSize = DatabaseSeeder::$booksBatchSize ?? 500; // якщо не буде у DatabaseSeeder::$booksBatchSize
        $this->currentId = DB::table('books')->max('id') + 1 ?? 1; // якщо не перший раз запускаємо
        $this->categoriesMaxId = DB::table('categories')->max('id') ?? die("No categories table!"); //Підлаштовуємось...

    }

    public function run(): void
    {

        $progressBar = new ProgressBar(new ConsoleOutput, $this->booksBatchPacksToInsert); // BAR
        $progressBar->start(); // BAR
        $startTime = time(); // BAR

        $startId = $this->currentId;
        $faker = Faker::create();

        for ($i = 1; $i <= $this->booksBatchPacksToInsert; $i++) {
            $booksPack = [];
            for ($j = 1; $j <= $this->booksBatchSize; $j++) {
                $e = null;
                $now = now();
                $booksPack[] = [
                    'id' => $this->currentId,
                    'name' => $faker->sentence(5),
                    'year' => rand(1970, 2023),
                    'lang' => $faker->randomElement(array_column(LangEnum::cases(), 'value')),
                    'pages' => rand(50, 50000),
                    'created_at' => $faker->dateTimeBetween(1991, 'now'),
                    'updated_at' => $now,
                    'category_id' => rand(1, $this->categoriesMaxId),
                ];
                $this->currentId++;
            }

            if ($this->useHandleAllEntryErrorsFunction) {
                try {
                    DB::table('books')->insert($booksPack);
                } catch (QueryException $exception) {
                    DatabaseSeeder::handleAllEntryErrors($exception);
                }
            } else {
                //По замовченню не відловлюємо помилки спеціальним методом handleAllEntryErrors()
                DB::table('books')->insert($booksPack);
            }


            if ($this->hardBarWithTimeEnabled) {
                // BAR - лютий код ))
                $processedItems = ($i - 1) * $this->booksBatchSize + $j;
                $totalItems = $this->booksBatchPacksToInsert * $this->booksBatchSize;
                $elapsedTimeInSeconds = time() - $startTime;
                $remainingTimeInSeconds = ($elapsedTimeInSeconds / $processedItems) * ($totalItems - $processedItems);
                $remainingTimeFormatted = gmdate("H:i:s", $remainingTimeInSeconds);
                $progressBar->setMessage($this->currentId, 'currentId'); //Можна так передавати
                $progressBar->setMessage($remainingTimeFormatted, 'remainingTime');
                $progressBar->setFormat(
                    "   Inserted:" . ($this->currentId - $startId) . " Remaining:" . ($totalItems - $processedItems + 1) . // а можно і так прямо у форматі робити...
                    ", Batch-%current% [%bar%] %percent:3s%% Current max ID %currentId% Elapsed: %elapsed:5s% Remain:%remainingTime:6s%"
                );
            } else {
                $progressBar->setFormat(
                    "   Current Id:" . ($this->currentId) .
                    ", Batch-%current% [%bar%] %percent:3s%% %elapsed:5s%"
                );
            }
            $progressBar->advance(); // BAR

        }

        $progressBar->finish(); // BAR
        echo (PHP_EOL . "    Додано " . ($this->currentId - $startId) . " записів у базу данних") . PHP_EOL;
    }
}
