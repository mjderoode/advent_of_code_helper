<?php

namespace Mjderoode\AdventOfCodeHelper\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Mjderoode\AdventOfCodeHelper\Jobs\RetrievePuzzleInputJob;
use Mjderoode\AdventOfCodeHelper\Jobs\GenerateControllerLayoutJob;

class AocImportPuzzleInputCommand extends Command
{
    protected $signature = 'aoc:import {year=2024} {day?}';

    protected $description = 'Command to import (all) puzzle input(s)';

    public function handle(): void 
    {
        $this->info("Initialize");

        $year = $this->argument('year');
        $day = $this->argument('day');

        $session_cookie = config()->string('advent_of_code_helper.session_cookie');
        if (blank($session_cookie)) {
            $this->error("No session cookie found, set ADVENT_OF_CODE_SESSION_COOKIE in .env");
            $this->newLine();

            $this->info("Go here to find out how to get your session cookie: https://github.com/mjderoode/advent-of-code-helper#how-to-get-your-session_cookie \n End of command");
            return;
        }

        $response = Http::withCookies([
            'session'    => $session_cookie
        ], 'adventofcode.com')->get("https://adventofcode.com/2015/day/1/input"); 

        if ($response->failed()) {
            $this->error("Session cookie is invalid, please check your session_cookie and check if you are logged in to the Advent of Code website.");
            $this->newLine();

            return;
        }

        if (blank($day)) {
            for ($i = 1; $i <= 25; $i++) {
                (new RetrievePuzzleInputJob($year, $i, $session_cookie, $this))->handle();
                (new GenerateControllerLayoutJob($year, $i, $this))->handle();
            }
        } else {
            (new RetrievePuzzleInputJob($year, $day, $session_cookie, $this))->handle();
            (new GenerateControllerLayoutJob($year, $day, $this))->handle();
        }

        $this->info('Done');
    }
}