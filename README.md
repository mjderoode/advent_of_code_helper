
# Clickup API Laravel Package 

This Laravel package simplifies the process of connecting to, manipulating, and requesting data from ClickUp, a powerful project management tool. Designed for developers, it provides an easy-to-use interface for integrating ClickUp’s functionalities into Laravel applications. With this package, you can effortlessly manage tasks, projects, and other resources within ClickUp, streamlining your workflow and enhancing productivity.

**My package is currently in an "WIP" phase, so please keep this in mind when using it.**

## Get your Session Cookie

    1.   Log in to the Advent of Code website: https://adventofcode.com
    2.   Open the developer console in your browser and navigate to the Cookies section
    2.5  - For Chromium-based browsers, go to Application → Storage → Cookies, then click on the Advent of Code website URL.
    3.   Look for the "session" cookie, and copy its value 
    4.   Add the following key to your .env file: ADVENT_OF_CODE_SESSION_COOKIE, and paste your session cookie value here.
    
## Installation

Install `mjderoode/advent_of_code_helper` with composer:

```bash
composer require mjderoode/advent_of_code_helper
```

Add your session cookie value to the .env:
```env
ADVENT_OF_CODE_SESSION_COOKIE="################################"
```

Optionally, you can disable routing by setting the following key in your .env file (must be a boolean; the default is true):
```env
ADVENT_OF_CODE_ROUTING_ENABLED=false
```

## Usage/ Examples

The package includes two commands: `aoc:import` and `aoc:try`. 

The `aoc:import` command is used to download your personal puzzle inputs and prepare the necessary Controller files. This command expects two parameters: the first (year) is mandatory with a default value of 2024, and the second (day) is optional.

To download all of your puzzle inputs from 2023, run:
```bash
php artisan aoc:import 2023
```

By specifying the second argument, you can download the puzzle input for a specific day, for example day 3 of 2016.
```bash
php artisan aoc:import 2016 3
```

The `aoc:try` command is used to test your solutions. This command expects three parameters: year, day, and part (with defaults: year=2024 and part=1).
```bash
php artisan aoc:try 2023 1 1
```

## Try out your solutions 

In this package, you have several options to try out your solutions. The first is through the command line—refer to the `aoc:try` command as explained in the previous section.

The second option is to view your solution in the browser. I’ve prepared a specific route for your Advent of Code controllers (see `php artisan route:list`, specifically `aoc.solution`). For example, to view your solution for “year 2016, day 2, part 2,” go to `{{ YOUR APP URL HERE }}/2016/2/2`.

## Authors

- [@mjderoode (github)](https://github.com/mjderoode)

## License

The MIT License ([MIT](https://choosealicense.com/licenses/mit/)).