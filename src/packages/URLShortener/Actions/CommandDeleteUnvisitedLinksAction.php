<?php

namespace Packages\URLShortener\Actions;

use Illuminate\Http\Request;
use Packages\URLShortener\DTOs\CommandDeleteUnvisitedLinksDTO;
use Packages\URLShortener\DTOs\PostURLShortenDTO;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;
use Packages\URLShortener\Repositories\URLRepository;
use Packages\URLShortener\Responders\PostURLShortenResponder;
use Packages\URLShortener\Services\CommandDeleteUnvisitedLinksService;
use Packages\URLShortener\Services\PostURLShortenService;

class CommandDeleteUnvisitedLinksAction
{
    /**
     * @return void
     */
    public function execute(CommandDeleteUnvisitedLinksDTO $commandDeleteUnvisitedLinksDTO): void
    {
        $commandDeleteUnvisitedLinksService = app(CommandDeleteUnvisitedLinksService::class);

        $commandDeleteUnvisitedLinksService->process($commandDeleteUnvisitedLinksDTO);
    }
}
