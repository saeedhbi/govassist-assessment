<?php

namespace Packages\URLShortener\Services;

use App\Interfaces\DtoInterface;
use App\Interfaces\ServiceInterface;
use Packages\URLShortener\DTOs\GetURLsListDTO;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;

class GetURLsListService implements ServiceInterface
{
    public function __construct(private readonly URLRepositoryInterface $urlRepository)
    {
    }

    public function process(GetURLsListDTO|DtoInterface $dto = null): GetURLsListDTO
    {
        $list = $this->urlRepository->getAll()->paginate(5);

        foreach ($list as $index => $url) {
            $url->makeVisible(['visits']);
            $list[$index]->shortened_url = $url->shortened_url;
        }

        $dto->response = $list;

        return $dto;
    }
}
