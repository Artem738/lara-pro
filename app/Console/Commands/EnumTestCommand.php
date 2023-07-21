<?php

namespace App\Enum;
namespace App\Console\Commands;

use App\Enum\LangEnum;
use Illuminate\Console\Command;

class EnumTestCommand extends Command
{

    protected $signature = 'etest';


    protected $description = 'ENUM TEST Command';


    public function handle()
    {
        echo "good" . PHP_EOL;

        $values = array_column(LangEnum::cases(), 'value');
       print_r($values).PHP_EOL;

       //echo LangEnum::DE->getValue();
        //echo LangEnum::DE;

        //LangEnum::from($validatedData['lang']);

        // dd(LangEnum::cases().'name'). PHP_EOL;
        $total = 100;
        $this->output->progressStart($total);

        for ($i = 1; $i <= $total; $i++) {
            usleep(1000); //10 ms  // 1s = 1000000
            $this->output->progressAdvance();
        }

        $this->output->progressFinish();
    }
}
