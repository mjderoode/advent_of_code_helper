<?php

namespace Mjderoode\AdventOfCodeHelper\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class AocRunSolutionOnCliCommand extends Command
{
    protected $signature = 'aoc:try {year=2024} {day?} {part=1}';

    protected $description = 'Command to import (all) puzzle input(s)';

    public function handle(): mixed
    {
        $year = $this->argument('year');
        $day = $this->argument('day');
        $part = $this->argument('part');

        $controllerPath = app_path("Http/Controllers/Year{$year}/Day{$day}Controller.php");

        if (! File::exists($controllerPath)) {
            $this->info("- File ($controllerPath) not found. Ending...");
            return null;
        }

        $controller = app()->make("App\Http\Controllers\Year{$year}\Day{$day}Controller");
        return $controller->handle($part);
    }
}