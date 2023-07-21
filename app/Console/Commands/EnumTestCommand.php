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
        print_r($values) . PHP_EOL;

        echo LangEnum::DE->value . PHP_EOL;
        echo LangEnum::class . PHP_EOL;
        if (enum_exists(LangEnum::class)) {
            $langClass = LangEnum::DE;
            $langValue = $langClass->value;
            $langName = $langClass->name;
            echo($langName . ' is ' . $langValue . PHP_EOL);
        }
        print_r(LangEnum::from('de')) . PHP_EOL;
        echo (LangEnum::from('de')->name) . PHP_EOL;
        echo (LangEnum::from('de')->value) . PHP_EOL;
        $l = LangEnum::from('de');
        echo (gettype($l)) . PHP_EOL;
        print_r(array_column(LangEnum::cases(), 'value'));

        $value = LangEnum::tryFrom('de')->value ?? 'IS NULL';
        echo $value . PHP_EOL;

        $value = LangEnum::tryFrom('ru')->value ?? 'IS NULL';
        echo $value . PHP_EOL;
        echo $value . PHP_EOL;

 //       $value = LangEnum::tryFrom(null);
//        echo (" >" . $value . "<" . gettype($value)) . PHP_EOL;
//
//
//        $language =  LangEnum::tryFrom('ru')->value ?? null;

//
//        echo (">>>" . (LangEnum::tryFrom(null)) . "<" . gettype(LangEnum::tryFrom(null))) . PHP_EOL;
//        //LangEnum::from($validatedData['lang']);
//
//        // dd(LangEnum::cases().'name'). PHP_EOL;
//        echo(LangEnum::tryFrom(null)); //а так працює

    }
}
