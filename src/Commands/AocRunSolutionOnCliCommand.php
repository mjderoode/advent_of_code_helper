<?php

namespace Mjderoode\AdventOfCodeHelper\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Collection;

class AocRunSolutionOnCliCommand extends Command
{
    protected $signature = 'aoc:try {year=2024} {day?} {part=1}';

    protected $description = 'Command to import (all) puzzle input(s)';

    public function handle(): void
    {
        $year = $this->argument('year');
        $day = $this->argument('day');
        $part = $this->argument('part');

        $controllerPath = app_path("Http/Controllers/Year{$year}/Day{$day}Controller.php");

        if (! File::exists($controllerPath)) {
            $this->info("- File ($controllerPath) not found. Ending...");
            return;
        }

        $controller = app()->make("App\Http\Controllers\Year{$year}\Day{$day}Controller");
        $result = $controller->handle($part);

        if (is_string($result) || is_numeric($result)) {
            $this->line((string) $result);
        } elseif (is_array($result) || $result instanceof Collection) {
            $this->line(json_encode($result, JSON_PRETTY_PRINT));
        } elseif (is_object($result)) {
            try {
                $this->line(json_encode($result, JSON_PRETTY_PRINT));
            } catch (\Exception $e) {
                $this->line('Object of class '. get_class($result));
            }
        } else {
            $this->line(var_export($result, true));
        }
    }
}