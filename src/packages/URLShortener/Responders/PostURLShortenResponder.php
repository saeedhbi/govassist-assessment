<?php

namespace Packages\URLShortener\Responders;

use App\Interfaces\DtoInterface;
use App\Interfaces\ResponseInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;
use Packages\URLShortener\DTOs\PostURLShortenDTO;

class PostURLShortenResponder implements ResponseInterface
{
    /**
     * @param PostURLShortenDTO|DtoInterface $dto
     * @param int $status
     * @return RedirectResponse|JsonResponse
     */
    public function response(PostURLShortenDTO|DtoInterface $dto, int $status = 200): RedirectResponse|JsonResponse
    {
        /**
         * Since the "Inertia" is acting differently from a simple API calling, we don't need to respond JSON,
         * but otherwise, it will be responded as JSON.
         */
        if (boolval(request()->header('X-Inertia')) === true) {
            return back();
        }

        return response()->json($dto->response)->setStatusCode($status);
    }
}
