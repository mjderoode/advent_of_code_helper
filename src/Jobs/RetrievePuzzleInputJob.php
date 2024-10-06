<?php

namespace Mjderoode\AdventOfCodeHelper\Jobs;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class RetrievePuzzleInputJob implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected int $year,
        protected int $day,
        protected string $sessionCookie = '',
        private Command $command
    ){}

    public function handle(): void 
    {
        $response = Http::withCookies([
            'session'    => $this->sessionCookie
        ], 'adventofcode.com')->get("https://adventofcode.com/{$this->year}/day/{$this->day}/input");

        if ($response->failed()) {
            $this->command->error("- Something went wrong while retrieving the puzzle input for year {$this->year} day {$this->day}");
            return; 
        }

        $content = $response->getBody()->getContents();

        $file = "puzzleInputs/{$this->year}/{$this->day}.txt";

        Storage::disk('public')->put($file, $content);

        $this->command->info("- Puzzle input retrieved for year {$this->year} day {$this->day}");
    }
}