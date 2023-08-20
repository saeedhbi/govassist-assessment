<?php

namespace Packages\URLShortener\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Packages\URLShortener\Actions\CommandDeleteUnvisitedLinksAction;
use Packages\URLShortener\DTOs\CommandDeleteUnvisitedLinksDTO;

class DeleteUnvisitedLinks extends Command
{
    const COMMAND = 'url-shortener:delete-unvisited-links {--days=30}';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    public $signature = DeleteUnvisitedLinks::COMMAND;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete unvisited links older than 30 days';

    /**
     * Execute the console command.
     */
    public function handle(CommandDeleteUnvisitedLinksAction $action): void
    {
        $dto = new CommandDeleteUnvisitedLinksDTO();

        $dto->date = Carbon::now()->subDays(is_numeric($this->option('days')) ? $this->option('days') : 30);

        $action->execute($dto);

        $this->info('Unvisited links older than 30 days have been deleted.');
    }
}
