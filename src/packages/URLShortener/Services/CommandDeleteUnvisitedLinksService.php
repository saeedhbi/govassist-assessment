<?php

namespace Packages\URLShortener\Services;

use App\Interfaces\DtoInterface;
use App\Interfaces\ServiceInterface;
use Carbon\Carbon;
use Packages\URLShortener\DTOs\CommandDeleteUnvisitedLinksDTO;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;

class CommandDeleteUnvisitedLinksService implements ServiceInterface
{
    public function __construct(private readonly URLRepositoryInterface $urlRepository)
    {
    }

    public function process(CommandDeleteUnvisitedLinksDTO|DtoInterface $dto): void
    {
        $this->urlRepository->deleteUnvisitedLinksByDate($dto->date);
    }
}
