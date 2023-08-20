<?php

namespace Packages\URLShortener\Services;

use App\Interfaces\DtoInterface;
use App\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Packages\URLShortener\DTOs\GetURLShortenDTO;
use Packages\URLShortener\DTOs\PostURLShortenDTO;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GetURLShortenService implements ServiceInterface
{
    public function __construct(private readonly URLRepositoryInterface $urlRepository)
    {
    }

    public function process(GetURLShortenDTO|DtoInterface $dto): GetURLShortenDTO
    {
        $url = $this->urlRepository->findFirstBy(['slug' => $dto->slug]);

        if (empty($url)) {
            throw new NotFoundHttpException("URL not found");
        }

        $dto->response = $url->destination;

        return $dto;
    }
}
