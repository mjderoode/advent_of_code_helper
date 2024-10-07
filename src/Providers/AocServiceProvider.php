<?php

namespace Mjderoode\AdventOfCodeHelper\Providers;

use Illuminate\Support\ServiceProvider;
use Mjderoode\AdventOfCodeHelper\Commands\AocRunSolutionOnCliCommand;
use Mjderoode\AdventOfCodeHelper\Commands\AocImportPuzzleInputCommand;

class AocServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../stubs' => base_path('stubs/vendor/mjderoode/advent_of_code_helper'),
        ], 'stubs-aoc');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/advent_of_code_helper.php', 'advent_of_code_helper'
        );

        if ($this->app->runningInConsole()) {
            $this->commands([
                AocImportPuzzleInputCommand::class,
                AocRunSolutionOnCliCommand::class
            ]);
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }
}