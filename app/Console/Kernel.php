<?php

namespace App\Console;

use Illuminate\Support\Facades\Http;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\StarWappie;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $wappieRes = Http::get('https://swapi.dev/api/people/');
            if (!$wappieRes->successful()) return;

            $starWappies = $wappieRes->json();

            $length = $starWappies['count'];
            $randomIndex = rand(0, $length - 1);

            $starWappieJSON = $starWappies['results'][$randomIndex];

            $starWappie = StarWappie::where('name', $starWappieJSON['name'])->first();
            if(!$starWappie) {
                $starWappie = new StarWappie();
            }

            $planetRes = Http::get($starWappieJSON['homeworld']);
            if (!$planetRes->successful()) return;

            $starWappie->name = $starWappieJSON['name'];
            $starWappie->planet_name = $planetRes['name'];
        })->daily();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
