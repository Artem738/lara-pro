<?php

namespace App\Enum;
namespace App\Console\Commands;

use App\Enum\LangEnum;
use Illuminate\Console\Command;

class HelpMeCommand extends Command
{

    protected $signature = 'helpme';


    protected $description = 'My Artisan Helper Command';


    public function handle()
    {
        echo "good" . PHP_EOL;
//        $this->alert("Alert, Ви скасували виконання команди.");
//        $this->error("error error error lsafas fasdf");
//        $this->info("info info info info info lsafa sfasdf");
//        $this->line("line line line line line line line ");
//        $this->comment("comment comment comment comment ");
        $this->alert("Міграції");
        $this->line("artisan migrate:reset - видалити все");
        $this->line("artisan migrate - накатити все");
        $this->line("artisan migrate:rollback - откат останньої міграції");
        $this->line("");
        $this->info("artisan db:seed - запуск сідера");


    }
}
