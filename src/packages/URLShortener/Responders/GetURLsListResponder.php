<?php

namespace Packages\URLShortener\Responders;

use App\Interfaces\DtoInterface;
use App\Interfaces\ResponseInterface;
use Inertia\Inertia;
use Inertia\Response;
use Packages\URLShortener\DTOs\GetURLShortenDTO;

class GetURLsListResponder implements ResponseInterface
{
    public function response(GetURLShortenDTO|DtoInterface $dto, $status = 200): Response
    {
        return Inertia::render('URL/List', [
            'list' => $dto->response,
        ]);
    }
}
