<?php

namespace App\Enum;
namespace App\Console\Commands;

use App\Enum\LangEnum;
use Illuminate\Console\Command;

class EnumTest extends Command
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
    }
}
