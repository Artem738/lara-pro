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
    private int $batchPacksToInsert = 5; // Кількість вставок в базу - 500
    private int $batchSize = 2000; // Розмір пакету пакета вставки
    protected int $duplicatedEntryCount = 0;
    protected int $currentId;
    protected int $categoriesMaxId;

    protected $output;

    public function __construct()
    {
        $this->currentId = DB::table('books')->max('id') + 1 ?? 1;
        $this->categoriesMaxId = DB::table('categories')->max('id') ?? die("No categories!");

        $this->output = new ConsoleOutput();
    }

    public function run(): void
    {
        $faker = Faker::create();
        $now = now();

        $progressBar = new ProgressBar($this->output, $this->batchPacksToInsert);
        $progressBar->start();

        for ($i = 1; $i <= $this->batchPacksToInsert; $i++) {
            $booksPack = [];
            for ($j = 1; $j <= $this->batchSize; $j++) {
                $e = null;
                $name = ucfirst($faker->word()) . $faker->randomLetter();
                try {
                    $booksPack[] = [
                        'id' => $this->currentId,
                        'name' => $faker->sentence(5),
                        'year' => rand(1950, 2023),
                        'lang' => $faker->randomElement(array_column(LangEnum::cases(), 'value')),
                        'pages' => rand(50, 50000),
                        'created_at' => $faker->dateTimeBetween(1991, 'now'),
                        'updated_at' => $now,
                        'category_id' => rand(1, $this->categoriesMaxId),
                    ];
                } catch (QueryException $e) {
                    $this->handleAllEntryErrors($name, $e);
                }
                if (!$e) {
                    $this->currentId++;
                }
            }

            DB::table('books')->insert($booksPack);
            $progressBar->setFormat("   Processing batch - %current% [%bar%] %percent:3s%% Current ID %myVariable% Elapsed: %elapsed:6s%");
            $progressBar->setMessage($this->currentId, 'myVariable');
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->output->writeln('');
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

        $this->output->writeln($message);
        $this->duplicatedEntryCount++;
    }
}
