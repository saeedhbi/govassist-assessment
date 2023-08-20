<?php

namespace Packages\URLShortener\Services;

use App\Interfaces\DtoInterface;
use App\Interfaces\ServiceInterface;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Packages\URLShortener\DTOs\PostURLShortenDTO;
use Packages\URLShortener\Interfaces\URLRepositoryInterface;

class PostURLShortenService implements ServiceInterface
{
    public function __construct(private readonly URLRepositoryInterface $urlRepository)
    {
    }

    public function process(PostURLShortenDTO|DtoInterface $dto): PostURLShortenDTO
    {
        $dto->response = $this->urlRepository->createEntity([
            'destination' => $dto->destination,
            'slug' => Str::random(5),
            'visits' => 0
        ]);

        $dto->response->shortened_url = $dto->response->getShortenedUrlAttribute();

        return $dto;
    }
}
