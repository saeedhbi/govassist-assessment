<?php

namespace Packages\URLShortener\Responders;

use App\Interfaces\DtoInterface;
use App\Interfaces\ResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Packages\URLShortener\DTOs\GetURLShortenDTO;

class GetURLShortenResponder implements ResponseInterface
{
    public function response(GetURLShortenDTO|DtoInterface $dto, $status = 200): RedirectResponse
    {
        return redirect($dto->response)->setStatusCode(301);
    }

    public function error(\Exception $exception): JsonResponse
    {
        return response()->json($exception->getMessage())->setStatusCode(500);
    }
}
