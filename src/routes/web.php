<?php 

use Illuminate\Support\Facades\Route;

if (config()->boolean('advent_of_code_helper.routing_enabled')) {
    Route::get('/{year}/{day}/{part?}', function (int $year, int $day, int $part = 1) {
        $className = "App\\Http\\Controllers\\Year{$year}\\Day{$day}Controller"; 

        if (class_exists($className)) {
            return (new $className)->handle($part);
        }

        return abort(404); 
    })->name("aoc.solution");
}