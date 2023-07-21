<?php

namespace App\Enum;

namespace App\Console\Commands;

use App\Enum\LangEnum;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ChunkTest extends Command
{

    protected $signature = 'chunktest';


    protected $description = 'Chunk TEST Command';


    public function handle()
    {
        $total = DB::table('books')->where('lang', 'en')->count();
        $this->output->progressStart($total);

        DB::table('books')
            ->where('lang', 'en')
            ->orderBy('id') // "You must specify an orderBy clause when using this function."
            ->chunk(
                100, function ($books) {
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
