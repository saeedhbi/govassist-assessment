<?php

namespace Packages\URLShortener\Responders;

use App\Interfaces\DtoInterface;
use App\Interfaces\ResponseInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Packages\URLShortener\DTOs\PostURLShortenDTO;

class PostURLShortenResponder implements ResponseInterface
{
    public function response(PostURLShortenDTO|DtoInterface $dto, $status = 200): JsonResponse
    {
        return response()->json($dto->response)->setStatusCode($status);
    }

    public function error(\Exception $exception): JsonResponse
    {
        if ($exception instanceof ValidationException) {
            return response()->json($exception->errors())->setStatusCode(422);
        }

        return response()->json($exception->getMessage())->setStatusCode(500);
    }
}
