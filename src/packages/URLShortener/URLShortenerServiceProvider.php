<?php

namespace Packages\URLShortener;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Packages\URLShortener\Console\Commands\DeleteUnvisitedLinks;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;
use Packages\URLShortener\Repositories\URLRepository;

class URLShortenerServiceProvider extends ServiceProvider
{
    protected array $commands = [
        DeleteUnvisitedLinks::class
    ];

    /**
     * Register any URL shortener services.
     */
    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__ . '/routes/api.php');
        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');

        if ($this->app->runningInConsole()) {
            $this->commands($this->commands);
        }

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $this->_scheduleCommands($schedule);
        });
    }

    public function register(): void
    {
        $this->app->bind(URLRepositoryInterface::class, URLRepository::class);
    }

    private function _scheduleCommands(Schedule $schedule): void
    {
        $schedule->command(DeleteUnvisitedLinks::COMMAND)->daily()->withoutOverlapping()->runInBackground();
    }
}
