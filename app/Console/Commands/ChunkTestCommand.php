<?php

namespace App\Enum;

namespace App\Console\Commands;

use App\Enum\LangEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChunkTestCommand extends Command
{

    protected $signature = 'chunktest';


    protected $description = 'Chunk TEST Command';


    public function handle()
    {
        $chunkNumberCount = 100;
        $totalInDb = DB::table('books')->where('lang', 'en')->count();

        $totalRoundedUp = ceil($totalInDb / $chunkNumberCount);

        $this->output->progressStart($totalRoundedUp);

        DB::table('books')
            ->where('lang', 'en')
            ->orderBy('id') // "You must specify an orderBy clause when using this function."
            ->chunk(
                $chunkNumberCount, function ($books) {
                foreach ($books as $book) {
                    $nameWithoutNumbers = preg_replace('/\d/', '', $book->name);
                    $newName = $nameWithoutNumbers . rand(100, 999);
                    DB::table('books')
                        ->where('id', $book->id)
                        ->update(['name' => $newName]);
                }
                $this->output->progressAdvance();
            }
            );


        $this->output->progressFinish();
    }
}
