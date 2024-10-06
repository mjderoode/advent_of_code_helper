<?php

namespace Mjderoode\AdventOfCodeHelper\Jobs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class GenerateControllerLayoutJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected int $year,
        protected int $day,
        private Command $command
    ){}

    public function handle(): void 
    {
        $controllerPath = app_path("Http/Controllers/Year{$this->year}/Day{$this->day}Controller.php");

        if (File::exists($controllerPath)) {
            $this->command->info("- File ($controllerPath) already exists. Skipping...");
            return;
        }
    
        $stub = file_get_contents(__DIR__ . '/../stubs/controller.aoc.stub');
    
        $stub = str_replace('{{ DummyYear }}', $this->year, $stub);
        $stub = str_replace('{{ DummyDay }}', $this->day, $stub);
        $stub = str_replace('{{ namespace }}', "App\Http\Controllers\Year{$this->year}", $stub);
        $stub = str_replace('{{ rootNamespace }}', "App\\", $stub);
        $stub = str_replace('{{ class }}', "Day{$this->day}Controller", $stub);

        if (! File::isDirectory(app_path("Http/Controllers/Year{$this->year}"))) {
            File::makeDirectory(app_path("Http/Controllers/Year{$this->year}"), 0755, true);
        }
    
        File::put($controllerPath, $stub);

        $this->command->info("Controller layout for year {$this->year} day {$this->day} generated");
    }
}